<?php
// 1. Configuration des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 2. Connexion à la base de données
require_once 'db.php';

// 3. Récupération des données
try {
    $query = $pdo->query("SELECT * FROM etudiants ORDER BY nom ASC");
    $all_etudiants = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur SQL : " . $e->getMessage());
}

// 4. Organisation par niveau pour les onglets
$niveaux = ['L1' => [], 'L2' => [], 'L3' => [], 'M1' => [], 'M2' => []];
foreach ($all_etudiants as $e) {
    $niv = trim($e['niveau']);
    if (array_key_exists($niv, $niveaux)) {
        $niveaux[$niv][] = $e;
    } else {
        $niveaux['L1'][] = $e;
    }
}
?>

<!DOCTYPE html>
<html lang="fr" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Répertoire Étudiants | ISMT Administration</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

    <link rel="stylesheet" href="../assets/vendor/css/core.css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <script src="../assets/vendor/js/helpers.js"></script>
    <script src="../assets/js/config.js"></script>

    <style>
        .avatar-img { width: 45px; height: 45px; object-fit: cover; border-radius: 50%; border: 2px solid #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .table th { text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px; }
        
        /* Correction forcée du scroll du menu */
        .layout-menu .menu-inner {
            overflow-y: auto !important;
        }
    /* Ta configuration existante */
    .layout-menu .menu-inner {
        overflow-y: auto !important;
    }

    /* --- NOUVEAU : Rendre le scroll invisible --- */
    /* Pour le menu latéral */
    .menu-inner::-webkit-scrollbar { display: none; }
    .menu-inner { -ms-overflow-style: none; scrollbar-width: none; }

    /* Pour la page entière (si nécessaire) */
    body::-webkit-scrollbar { display: none; }
    body { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            
            <?php require_once 'navbar.php'; ?>

            <div class="layout-page">
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav align-items-center w-100">
                        <div class="nav-item d-flex align-items-center w-100">
                            <i class="bx bx-search fs-4 lh-0 me-2"></i>
                            <input type="text" class="form-control border-0 shadow-none" placeholder="Rechercher un étudiant..." id="searchEtudiant" />
                        </div>
                    </div>
                </nav>

                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Scolarité /</span> Liste des Étudiants</h4>
                            <a href="ajouter_etudiant.php" class="btn btn-primary shadow">
                                <i class="bx bx-user-plus me-1"></i> Nouvel Étudiant
                            </a>
                        </div>

                        <div class="nav-align-top mb-4">
                            <ul class="nav nav-tabs" role="tablist">
                                <?php 
                                $labels = ['L1' => 'Licence 1', 'L2' => 'Licence 2', 'L3' => 'Licence 3', 'M1' => 'Master 1', 'M2' => 'Master 2'];
                                $i = 0;
                                foreach($labels as $key => $val): 
                                ?>
                                    <li class="nav-item">
                                        <button type="button" class="nav-link <?= $i==0?'active':'' ?>" data-bs-toggle="tab" data-bs-target="#tab-<?= $key ?>"><?= $val ?></button>
                                    </li>
                                <?php $i++; endforeach; ?>
                            </ul>

                            <div class="tab-content">
                                <?php 
                                $i = 0;
                                foreach($niveaux as $nivKey => $liste): 
                                ?>
                                <div class="tab-pane fade <?= $i==0?'show active':'' ?>" id="tab-<?= $nivKey ?>" role="tabpanel">
                                    <div class="table-responsive text-nowrap">
                                        <table class="table table-hover align-middle">
                                            <thead>
                                                <tr>
                                                    <th>Profil</th>
                                                    <th>Matricule</th>
                                                    <th>Nom & Prénoms</th>
                                                    <th>Contact</th>
                                                    <th>Filière</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(empty($liste)): ?>
                                                    <tr><td colspan="6" class="text-center py-5">Aucun étudiant inscrit en <?= $nivKey ?></td></tr>
                                                <?php else: ?>
                                                    <?php foreach($liste as $etud): ?>
                                                    <tr>
                                                        <td>
                                                            <img src="<?= !empty($etud['photo']) ? 'uploads/'.$etud['photo'] : '../assets/img/avatars/1.png' ?>" class="avatar-img" />
                                                        </td>
                                                        <td><span class="fw-bold text-primary"><?= htmlspecialchars($etud['matricule']) ?></span></td>
                                                        <td>
                                                            <div class="d-flex flex-column">
                                                                <span class="fw-semibold text-dark"><?= strtoupper(htmlspecialchars($etud['nom'])) ?></span>
                                                                <small class="text-muted"><?= htmlspecialchars($etud['prenom']) ?></small>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="small">
                                                                <i class="bx bx-envelope me-1"></i> <?= htmlspecialchars($etud['email']) ?><br>
                                                                <i class="bx bx-phone me-1"></i> <?= htmlspecialchars($etud['telephone']) ?>
                                                            </div>
                                                        </td>
                                                        <td><span class="badge bg-label-info"><?= htmlspecialchars($etud['filiere']) ?></span></td>
                                                        <td class="text-center">
                                                            <div class="d-flex justify-content-center gap-2">
                                                                <button class="btn btn-sm btn-icon btn-outline-warning" 
                                                                        onclick="confirmAction('modifier', 'modifier_etudiant.php?id=<?= $etud['id'] ?>')">
                                                                    <i class="bx bx-edit-alt"></i>
                                                                </button>
                                                                <button class="btn btn-sm btn-icon btn-outline-danger" 
                                                                        onclick="confirmAction('supprimer', 'supprimer_etudiant.php?id=<?= $etud['id'] ?>')">
                                                                    <i class="bx bx-trash"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php $i++; endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    <div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title" id="modalTitle">Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i id="modalIcon" class="bx bx-help-circle fs-1 mb-3"></i>
                    <p id="modalText" class="mb-0">Action ?</p>
                </div>
                <div class="modal-footer justify-content-center border-top">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                    <a id="confirmBtn" href="#" class="btn btn-primary">Confirmer</a>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../assets/vendor/js/menu.js"></script>
    <script src="../assets/js/main.js"></script>

    <script>
    function confirmAction(type, url) {
        const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
        const title = document.getElementById('modalTitle');
        const text = document.getElementById('modalText');
        const btn = document.getElementById('confirmBtn');
        const icon = document.getElementById('modalIcon');

        if(type === 'supprimer') {
            title.innerText = "Suppression";
            text.innerText = "Supprimer définitivement cet étudiant ?";
            btn.className = "btn btn-danger";
            icon.className = "bx bx-trash fs-1 mb-3 text-danger";
        } else {
            title.innerText = "Modification";
            text.innerText = "Ouvrir la fiche de modification ?";
            btn.className = "btn btn-warning";
            icon.className = "bx bx-edit-alt fs-1 mb-3 text-warning";
        }
        btn.href = url;
        modal.show();
    }

    $(document).ready(function(){
        $("#searchEtudiant").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
    </script>
</body>
</html>