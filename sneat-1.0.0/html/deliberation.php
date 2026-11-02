<?php
require_once 'db.php';

// 1. Récupération des filtres
$filiere_selected = $_GET['filiere'] ?? ''; // Peut être vide pour "Tous"
$niveau_selected = $_GET['niveau'] ?? '';
$annee_selected = $_GET['annee'] ?? '2025-2026';
$semestre_selected = $_GET['semestre'] ?? '';

$resultats = [];

// On n'exécute la requête que si au moins le niveau est choisi
if ($niveau_selected) {
    $params = [$niveau_selected];
    $where_filiere = "";
    
    // Si une filière spécifique est choisie, on l'ajoute à la requête
    if ($filiere_selected !== "" && $filiere_selected !== "TOUS") {
        $where_filiere = " AND e.filiere = ? ";
        $params[] = $filiere_selected;
    }

    $semestre_condition = ($semestre_selected != "") ? " AND m.semestre = " . (int)$semestre_selected : "";

    $sql = "SELECT 
                e.id, e.matricule, e.nom, e.prenom, e.filiere, e.niveau,
                ROUND(SUM(CASE WHEN m.semestre = 1 THEN n.note_valeur * m.coefficient ELSE 0 END) / 
                      NULLIF(SUM(CASE WHEN m.semestre = 1 THEN m.coefficient ELSE 0 END), 0), 2) as moy_s1,
                ROUND(SUM(CASE WHEN m.semestre = 2 THEN n.note_valeur * m.coefficient ELSE 0 END) / 
                      NULLIF(SUM(CASE WHEN m.semestre = 2 THEN m.coefficient ELSE 0 END), 0), 2) as moy_s2,
                ROUND(SUM(n.note_valeur * m.coefficient) / SUM(m.coefficient), 2) as moy_annuelle
            FROM etudiants e
            JOIN notes n ON e.id = n.etudiant_id
            JOIN matieres m ON n.matiere_id = m.id
            WHERE e.niveau = ? $where_filiere $semestre_condition
            GROUP BY e.id
            ORDER BY moy_annuelle DESC, e.nom ASC"; // Trié par mérite (moyenne)
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $resultats = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="fr" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <title>Délibération Globale | ISMT</title>
    
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="../assets/vendor/css/core.css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <style>
        #layout-menu .menu-inner { overflow-y: auto !important; }
        .layout-menu { height: 100vh !important; }
        .table-dark-header { background-color: #233446 !important; color: white !important; }
        .sticky-col { position: sticky; left: 0; background: white; z-index: 5; border-right: 2px solid #eee !important; }
        .moyenne-badge { font-weight: 800; font-size: 1rem; width: 50px; }
        @media print { .no-print { display: none; } }
    </style>

    <script src="../assets/vendor/js/helpers.js"></script>
    <script src="../assets/js/config.js"></script>
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            
            <?php require_once 'navbar.php'; ?>

            <div class="layout-page">
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        
                        <h4 class="fw-bold py-3 mb-4">Procès-Verbal de Délibération</h4>

                        <div class="card mb-4 no-print shadow-sm">
                            <div class="card-body">
                                <form class="row g-3" method="GET">
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold">Filière</label>
                                        <select name="filiere" class="form-select border-info">
                                            <option value="TOUS" <?= $filiere_selected == 'TOUS' ? 'selected' : '' ?>>Toutes les filières</option>
                                            <option value="Génie Logiciel" <?= $filiere_selected == 'Génie Logiciel' ? 'selected' : '' ?>>Génie Logiciel</option>
                                            <option value="Réseaux & Télécoms" <?= $filiere_selected == 'Réseaux & Télécoms' ? 'selected' : '' ?>>Réseaux & Télécoms</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold">Niveau</label>
                                        <select name="niveau" class="form-select" required>
                                            <option value="">Choisir niveau...</option>
                                            <?php foreach(['L1', 'L2', 'L3', 'M1', 'M2'] as $niv) echo "<option value='$niv' ".($niveau_selected==$niv?'selected':'').">$niv</option>"; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold">Période</label>
                                        <select name="semestre" class="form-select">
                                            <option value="">Annuelle</option>
                                            <option value="1" <?= $semestre_selected == '1' ? 'selected' : '' ?>>Semestre 1</option>
                                            <option value="2" <?= $semestre_selected == '2' ? 'selected' : '' ?>>Semestre 2</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-end">
                                        <button type="submit" class="btn btn-info w-100"><i class="bx bx-search"></i> Afficher</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <?php if ($niveau_selected): ?>
                        <div class="card shadow">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-bordered align-middle mb-0" id="table-deliberation">
                                    <thead class="table-dark-header text-center">
                                        <tr>
                                            <th class="sticky-col align-middle">Étudiant</th>
                                            <th>Filière</th>
                                            <?php if($semestre_selected == '' || $semestre_selected == '1'): ?><th>S1</th><?php endif; ?>
                                            <?php if($semestre_selected == '' || $semestre_selected == '2'): ?><th>S2</th><?php endif; ?>
                                            <th class="bg-dark text-white">MOY.</th>
                                            <th width="200">DÉCISION AUTOMATIQUE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($resultats as $res): ?>
                                        <tr class="text-center row-etudiant" data-moyenne="<?= $res['moy_annuelle'] ?>">
                                            <td class="text-start sticky-col">
                                                <strong><?= htmlspecialchars(strtoupper($res['nom'])) ?></strong> <?= htmlspecialchars($res['prenom']) ?>
                                            </td>
                                            <td><span class="badge bg-label-info"><?= $res['filiere'] ?></span></td>
                                            <?php if($semestre_selected == '' || $semestre_selected == '1'): ?><td><?= number_format($res['moy_s1'], 2) ?></td><?php endif; ?>
                                            <?php if($semestre_selected == '' || $semestre_selected == '2'): ?><td><?= number_format($res['moy_s2'], 2) ?></td><?php endif; ?>
                                            <td><span class="badge bg-secondary moyenne-badge"><?= number_format($res['moy_annuelle'], 2) ?></span></td>
                                            <td>
                                                <select class="form-select form-select-sm fw-bold select-decision">
                                                    <option value="ADMIS">ADMIS (A)</option>
                                                    <option value="RACHAT">RACHAT (RC)</option>
                                                    <option value="AJOURNE">AJOURNÉ (AJ)</option>
                                                    <option value="REDOUBLE">REDOUBLE (R)</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../assets/vendor/js/menu.js"></script>
    <script src="../assets/js/main.js"></script>

    <script>
    function appliquerAutomatisme() {
        $('.row-etudiant').each(function() {
            const moy = parseFloat($(this).attr('data-moyenne'));
            const select = $(this).find('.select-decision');
            const badge = $(this).find('.moyenne-badge');
            
            $(this).removeClass('table-success table-warning table-danger');
            badge.removeClass('bg-success bg-warning bg-danger bg-secondary');

            let suggestion = "";
            if (moy >= 10) {
                suggestion = "ADMIS";
                $(this).addClass('table-success');
                badge.addClass('bg-success');
            } else if (moy >= 9.5) {
                suggestion = "RACHAT";
                $(this).addClass('table-warning');
                badge.addClass('bg-warning text-dark');
            } else {
                suggestion = "AJOURNE";
                $(this).addClass('table-danger');
                badge.addClass('bg-danger');
            }
            select.val(suggestion).attr('data-system-suggestion', suggestion);
        });
    }

    // SÉCURITÉ CONTRE LES ERREURS DE SAISIE
    $(document).on('change', '.select-decision', function() {
        const selected = $(this).val();
        const suggestion = $(this).attr('data-system-suggestion');
        const moyenne = $(this).closest('.row-etudiant').attr('data-moyenne');

        if (suggestion === "ADMIS" && selected !== "ADMIS") {
            if (!confirm("⚠️ L'étudiant a la moyenne (" + moyenne + "). Confirmez-vous cette décision négative ?")) {
                $(this).val("ADMIS");
                return;
            }
        }
        if (suggestion === "AJOURNE" && selected === "ADMIS") {
            alert("❌ Action impossible : Un étudiant sous 9.50 de moyenne (" + moyenne + ") ne peut pas être déclaré ADMIS directement.");
            $(this).val("AJOURNE");
        }
    });

    $(document).ready(function() {
        appliquerAutomatisme();
    });
    </script>
</body>
</html>