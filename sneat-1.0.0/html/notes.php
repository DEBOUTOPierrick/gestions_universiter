<?php
require_once 'db.php';

// Récupération des filtres
$filiere_selected = $_GET['filiere'] ?? '';
$niveau_selected = $_GET['niveau'] ?? '';
$matiere_selected = $_GET['matiere'] ?? '';

$etudiants = [];
$matieres = [];

// 1. Charger les matières (Spécifiques à la filière + Tronc Commun)
if ($filiere_selected && $niveau_selected) {
    $stmt_m = $pdo->prepare("SELECT * FROM matieres WHERE (filiere = ? OR filiere = 'Tronc Commun') AND niveau = ? ORDER BY nom_matiere");
    $stmt_m->execute([$filiere_selected, $niveau_selected]);
    $matieres = $stmt_m->fetchAll();
}

// 2. Charger les étudiants et leurs notes existantes
if ($filiere_selected && $niveau_selected && $matiere_selected) {
    $sql = "SELECT e.id, e.matricule, e.nom, e.prenom, n.note_valeur 
            FROM etudiants e 
            LEFT JOIN notes n ON e.id = n.etudiant_id AND n.matiere_id = ?
            WHERE e.filiere = ? AND e.niveau = ? 
            ORDER BY e.nom ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$matiere_selected, $filiere_selected, $niveau_selected]);
    $etudiants = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="fr" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Saisie des Notes | ISMT Administration</title>

    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="../assets/vendor/css/core.css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <script src="../assets/vendor/js/helpers.js"></script>
    <script src="../assets/js/config.js"></script>

    <style>
        /* CORRECTIF SCROLL : On force l'affichage de la barre de défilement */
        html, body {
            overflow-y: auto !important;
            height: auto !important;
        }
        .layout-wrapper, .layout-container {
            overflow: visible !important;
        }
        /* Votre style original conservé */
        .menu-inner::-webkit-scrollbar, body::-webkit-scrollbar { display: none; }
        .menu-inner, body { -ms-overflow-style: none; scrollbar-width: none; }
        .note-input { font-weight: bold; text-align: center; }
        .is-invalid-note { border: 2px solid #ff3e1d !important; color: #ff3e1d !important; background-color: #fff5f4 !important; }
    </style>
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            
            <?php require_once 'navbar.php'; ?>

            <div class="layout-page">
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                    <div class="navbar-nav align-items-center"><span class="fw-bold">Système de Saisie des Notes</span></div>
                </nav>

                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        
                        <?php if(isset($_GET['msg']) && $_GET['msg'] == 'success'): ?>
                            <div class="alert alert-success alert-dismissible" role="alert">
                                Les notes ont été enregistrées avec succès !
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Scolarité /</span> Saisie des Notes</h4>

                        <div class="card mb-4 border-top border-primary">
                            <div class="card-body">
                                <form action="" method="GET" class="row gx-3 gy-2 align-items-end">
                                    <div class="col-md-3">
                                        <label class="form-label">Filière</label>
                                        <select class="form-select" name="filiere" onchange="this.form.submit()">
                                            <option value="">Choisir...</option>
                                            <option <?= $filiere_selected == 'Génie Logiciel' ? 'selected' : '' ?>>Génie Logiciel</option>
                                            <option <?= $filiere_selected == 'Réseaux & Télécoms' ? 'selected' : '' ?>>Réseaux & Télécoms</option>
                                            <option <?= $filiere_selected == 'Management' ? 'selected' : '' ?>>Management</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Niveau</label>
                                        <select class="form-select" name="niveau" onchange="this.form.submit()">
                                            <option value="">Niveau...</option>
                                            <option value="L1" <?= $niveau_selected == 'L1' ? 'selected' : '' ?>>Licence 1</option>
                                            <option value="L2" <?= $niveau_selected == 'L2' ? 'selected' : '' ?>>Licence 2</option>
                                            <option value="L3" <?= $niveau_selected == 'L3' ? 'selected' : '' ?>>Licence 3</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Matière / UE (Inclut Tronc Commun)</label>
                                        <select class="form-select" name="matiere" required>
                                            <option value="">Sélectionner une UE...</option>
                                            <?php foreach($matieres as $m): ?>
                                                <option value="<?= $m['id'] ?>" <?= $matiere_selected == $m['id'] ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($m['nom_matiere']) ?> <?= $m['filiere'] == 'Tronc Commun' ? '(TC)' : '' ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-primary w-100">Afficher la liste</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <?php if ($matiere_selected && !empty($etudiants)): ?>
                        <div class="card shadow">
                            <form id="form-notes" action="sauvegarder_notes.php" method="POST">
                                <input type="hidden" name="matiere_id" value="<?= $matiere_selected ?>">
                                <input type="hidden" name="filiere_hidden" value="<?= $filiere_selected ?>">
                                <input type="hidden" name="niveau_hidden" value="<?= $niveau_selected ?>">
                                
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Matricule</th>
                                                <th>Nom & Prénoms</th>
                                                <th class="text-center" style="width: 150px;">Note / 20</th>
                                                <th>Observation</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($etudiants as $e): ?>
                                            <tr>
                                                <td><strong><?= $e['matricule'] ?></strong></td>
                                                <td><?= htmlspecialchars($e['nom'] . ' ' . $e['prenom']) ?></td>
                                                <td>
                                                    <input type="number" name="notes[<?= $e['id'] ?>]" 
                                                           class="form-control note-input input-check-limit" 
                                                           step="0.25" min="0" max="20" 
                                                           value="<?= $e['note_valeur'] ?>" placeholder="--">
                                                </td>
                                                <td>
                                                    <?php if($e['note_valeur'] >= 10): ?>
                                                        <span class="badge bg-label-success">Validé</span>
                                                    <?php elseif($e['note_valeur'] !== null): ?>
                                                        <span class="badge bg-label-danger">Ajourné</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-label-secondary">À saisir</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="card-footer d-flex justify-content-end py-3">
                                    <button type="submit" class="btn btn-primary" id="btn-submit-notes">
                                        <i class="bx bx-save me-1"></i> Enregistrer les notes
                                    </button>
                                </div>
                            </form>
                        </div>
                        <?php endif; ?>

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
    // Sécurité : Interdiction de dépasser 20
    document.querySelectorAll('.input-check-limit').forEach(input => {
        input.addEventListener('input', function() {
            const val = parseFloat(this.value);
            const btn = document.getElementById('btn-submit-notes');
            if (val > 20) {
                this.classList.add('is-invalid-note');
                btn.disabled = true;
            } else {
                this.classList.remove('is-invalid-note');
                btn.disabled = document.querySelectorAll('.is-invalid-note').length > 0;
            }
        });
        input.addEventListener('blur', function() {
            if (parseFloat(this.value) > 20) {
                alert("La note ne peut pas être supérieure à 20 !");
                this.value = "";
                this.classList.remove('is-invalid-note');
                document.getElementById('btn-submit-notes').disabled = false;
            }
        });
    });
    </script>
</body>
</html>