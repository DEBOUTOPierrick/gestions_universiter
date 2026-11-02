<!DOCTYPE html>
<html lang="fr" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Gestion des Emplois du Temps | ISMT</title>
    
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <script src="../assets/vendor/js/helpers.js"></script>
    <script src="../assets/js/config.js"></script>
    <style>
        .table-profile-img { width: 35px; height: 35px; object-fit: cover; border-radius: 50%; margin-right: 10px; }
        .hover-actions:hover { background-color: #f8f9fa; }
    </style>
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            
            <?php require_once 'navbar.php'; ?>

            <div class="layout-page">
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                    <div class="navbar-nav align-items-center w-100">
                        <div class="nav-item d-flex align-items-center w-100">
                            <i class="bx bx-search fs-4 lh-0 me-2"></i>
                            <input type="text" class="form-control border-0 shadow-none w-100" placeholder="Rechercher un professeur ou une filière..." />
                        </div>
                    </div>
                </nav>

                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="fw-bold py-3 mb-0">
                                <span class="text-muted fw-light">Administration /</span> Suivi des Programmations
                            </h4>
                            <a href="programmation.php" class="btn btn-primary shadow-sm">
                                <i class="bx bx-plus-circle me-1"></i> Créer une programmation
                            </a>
                        </div>

                        <div class="card shadow-sm">
                            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Planning Hebdomadaire par Enseignant</h5>
                                <div class="btn-group">
                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        Filtre Semaine
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Semaine Actuelle</a></li>
                                        <li><a class="dropdown-item" href="#">Semaine Prochaine</a></li>
                                    </ul>
                                </div>
                            </div>
                            
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Enseignant</th>
                                            <th>Filière & Niveau</th>
                                            <th>Module assigné</th>
                                            <th>Volume Horaire</th>
                                            <th>Aperçu</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        <tr class="hover-actions">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm me-2">
                                                        <span class="avatar-initial rounded-circle bg-label-primary">AH</span>
                                                    </div>
                                                    <div>
                                                        <span class="fw-bold d-block">Dr. AHOMADEGBE</span>
                                                        <small class="text-muted">Expert Cloud</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-label-dark">SIL / Génie Logiciel L3</span></td>
                                            <td>Architecture Microservices</td>
                                            <td><i class="bx bx-time-five me-1"></i> 15h / semaine</td>
                                            <td>
                                                <a href="apercus_programme.php?prof_id=101" class="btn btn-sm btn-label-info">
                                                    <i class="bx bx-show-alt me-1"></i> Voir l'agenda
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-inline-block">
                                                    <button class="btn btn-sm btn-icon item-edit" title="Modifier">
                                                        <i class="bx bx-edit text-primary"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-icon item-delete" title="Supprimer">
                                                        <i class="bx bx-trash text-danger"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr class="hover-actions">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm me-2">
                                                        <span class="avatar-initial rounded-circle bg-label-success">TS</span>
                                                    </div>
                                                    <div>
                                                        <span class="fw-bold d-block">M. TOSSOU</span>
                                                        <small class="text-muted">Réseaux & Télécoms</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-label-dark">RT / Licence 2</span></td>
                                            <td>Sécurité des Infrastructures</td>
                                            <td><i class="bx bx-time-five me-1"></i> 10h / semaine</td>
                                            <td>
                                                <a href="apercus_programme.php?prof_id=102" class="btn btn-sm btn-label-info">
                                                    <i class="bx bx-show-alt me-1"></i> Voir l'agenda
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-inline-block">
                                                    <button class="btn btn-sm btn-icon" title="Modifier"><i class="bx bx-edit text-primary"></i></button>
                                                    <button class="btn btn-sm btn-icon" title="Supprimer"><i class="bx bx-trash text-danger"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    <footer class="content-footer footer bg-footer-theme text-center py-3 border-top">
                        <small class="text-muted">© 2026 ISMT SERVICES - Système de Gestion SIL</small>
                    </footer>
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../assets/vendor/js/menu.js"></script>
    <script src="../assets/js/main.js"></script>
</body>
</html>