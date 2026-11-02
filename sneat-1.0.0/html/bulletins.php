<?php
require_once 'db.php';

// Récupération des filtres
$filiere_selected = $_GET['filiere'] ?? '';
$niveau_selected = $_GET['niveau'] ?? '';
$annee_selected = $_GET['annee'] ?? '2025-2026';

$resultats = [];

// Calcul des moyennes et classement par rang
if ($filiere_selected && $niveau_selected) {
    $sql = "SELECT 
                e.id, 
                e.matricule, 
                e.nom, 
                e.prenom,
                ROUND(SUM(n.note_valeur * m.coefficient) / SUM(m.coefficient), 2) as moyenne
            FROM etudiants e
            JOIN notes n ON e.id = n.etudiant_id
            JOIN matieres m ON n.matiere_id = m.id
            WHERE e.filiere = ? AND e.niveau = ?
            GROUP BY e.id
            ORDER BY moyenne DESC";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$filiere_selected, $niveau_selected]);
    $resultats = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="fr" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Gestion des Bulletins | ISMT Administration</title>
    
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="../assets/vendor/css/core.css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    
    <script src="../assets/vendor/js/helpers.js"></script>
    <script src="../assets/js/config.js"></script>
    
    <style>
        /* --- CORRECTIF SCROLL NAVBAR --- */
        html, body {
            overflow-y: auto !important;
            height: auto !important;
        }
        .layout-wrapper, .layout-container {
            overflow: visible !important;
        }
        /* Style original conservé */
        .menu-inner::-webkit-scrollbar, body::-webkit-scrollbar { display: none; }
        .menu-inner, body { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            
            <?php require_once 'navbar.php'; ?>

            <div class="layout-page">
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Scolarité /</span> Bulletins de Notes</h4>
                            <button class="btn btn-primary" onclick="window.print()">
                                <i class="bx bx-printer me-1"></i> Impression de masse
                            </button>
                        </div>

                        <div class="card mb-4 border-top border-primary">
                            <div class="card-body">
                                <form class="row g-3" method="GET">
                                    <div class="col-md-3">
                                        <label class="form-label">Année Académique</label>
                                        <select name="annee" class="form-select fw-bold text-primary">
                                            <option value="2025-2026" <?= $annee_selected == '2025-2026' ? 'selected' : '' ?>>2025-2026</option>
                                            <option value="2024-2025" <?= $annee_selected == '2024-2025' ? 'selected' : '' ?>>2024-2025</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Filière</label>
                                        <select name="filiere" class="form-select" required>
                                            <option value="">Choisir...</option>
                                            <option value="Génie Logiciel" <?= $filiere_selected == 'Génie Logiciel' ? 'selected' : '' ?>>Génie Logiciel</option>
                                            <option value="Réseaux & Télécoms" <?= $filiere_selected == 'Réseaux & Télécoms' ? 'selected' : '' ?>>Réseaux & Télécoms</option>
                                            <option value="Management" <?= $filiere_selected == 'Management' ? 'selected' : '' ?>>Management</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Niveau</label>
                                        <select name="niveau" class="form-select" required>
                                            <option value="">Choisir...</option>
                                            <?php foreach(['L1', 'L2', 'L3', 'M1', 'M2'] as $niv): ?>
                                                <option value="<?= $niv ?>" <?= $niveau_selected == $niv ? 'selected' : '' ?>><?= $niv ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-end">
                                        <button type="submit" class="btn btn-outline-primary w-100">
                                            <i class="bx bx-refresh me-1"></i> Actualiser
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card shadow">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Rang</th>
                                            <th>Étudiant</th>
                                            <th>Moyenne</th>
                                            <th>Statut</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($resultats)): ?>
                                            <tr><td colspan="5" class="text-center p-4">Aucun résultat trouvé.</td></tr>
                                        <?php else: ?>
                                            <?php $rang = 1; foreach ($resultats as $res): ?>
                                            <tr>
                                                <td><span class="badge badge-center rounded-pill <?= ($rang == 1) ? 'bg-warning' : 'bg-label-primary' ?>"><?= $rang ?></span></td>
                                                <td><strong><?= htmlspecialchars($res['nom'] . ' ' . $res['prenom']) ?></strong><br><small class="text-muted"><?= $res['matricule'] ?></small></td>
                                                <td><span class="fw-bold text-primary"><?= number_format($res['moyenne'], 2) ?></span></td>
                                                <td>
                                                    <?php if ($res['moyenne'] >= 10): ?>
                                                        <span class="badge bg-label-success">Admis</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-label-danger">Ajourné</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a href="get_bulletin_data.php?id=<?= $res['id'] ?>&rang=<?= $rang ?>&print=true" 
                                                       target="_blank" 
                                                    class="btn btn-sm btn-icon btn-outline-info">
                                                        <i class="bx bx-show"></i>
                                                    </a>
                                                    <a href="generer_pdf.php?id=<?= $res['id'] ?>" class="btn btn-sm btn-icon btn-outline-primary">
                                                        <i class="bx bx-download"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php $rang++; endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="previewBulletin" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                            <div class="modal-content border-0 shadow-lg">
                                <div class="modal-header border-bottom">
                                    <h5 class="modal-title fw-bold"><i class="bx bx-file me-2"></i>Aperçu du Bulletin</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" id="contenu-aperçu">
                                    <div class="text-center p-5">
                                        <div class="spinner-border text-primary" role="status"></div>
                                        <p class="mt-2 text-muted">Récupération des données...</p>
                                    </div>
                                </div>
                                <div class="modal-footer border-top bg-light">
                                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Fermer</button>
                                    <button type="button" class="btn btn-primary" onclick="imprimerContenu()">
                                        <i class="bx bx-printer me-1"></i> Imprimer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../assets/vendor/js/menu.js"></script>
    <script src="../assets/js/main.js"></script>

    <script>
    /**
     * --- CORRECTIF FONCTION APERCU ---
     * Utilisation d'une fonction simple pour éviter les erreurs d'initialisation
     */

    function imprimerContenu() {
        const area = document.getElementById('printable-area');
        if (!area) return;

        const printFrame = document.createElement('iframe');
        printFrame.style.display = 'none';
        document.body.appendChild(printFrame);
        
        const frameDoc = printFrame.contentWindow.document;
        frameDoc.write(`
            <html>
                <head>
                    <link rel="stylesheet" href="../assets/vendor/css/core.css">
                    <style>
                        body { padding: 20px; margin: 0; background: white; color: black; }
                        #printable-area { border: none !important; }
                    </style>
                </head>
                <body>${area.innerHTML}</body>
            </html>
        `);
        frameDoc.close();

        setTimeout(() => {
            printFrame.contentWindow.focus();
            printFrame.contentWindow.print();
            document.body.removeChild(printFrame);
        }, 500);
    }
    </script>
</body>
</html>