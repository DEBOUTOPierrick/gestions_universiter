<!DOCTYPE html>
<html lang="fr" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Aperçu du Programme - ISMT</title>

    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <style>
        /* Style pour la fiche d'identité du prof */
        .card-prof-info { 
            background: linear-gradient(135deg, #696cff 0%, #8e91ff 100%); 
            color: white; 
            border: none;
        }
        
        /* Style de la ligne de temps (Timeline) */
        .timeline-container { padding: 10px 0; }
        .timeline-item { 
            border-left: 2px dashed #696cff; 
            padding-left: 25px; 
            position: relative; 
            padding-bottom: 25px; 
        }
        .timeline-item::before { 
            content: ''; 
            position: absolute; 
            left: -9px; 
            top: 0; 
            width: 16px; 
            height: 16px; 
            background: #696cff; 
            border-radius: 50%; 
            border: 3px solid #fff;
            box-shadow: 0 0 0 2px #696cff;
        }

        /* Optimisation pour l'impression */
        @media print { 
            .btn-print-hide, .layout-menu, .layout-navbar, .content-footer { display: none !important; } 
            .content-wrapper { margin: 0 !important; padding: 0 !important; }
            .card { border: 1px solid #eee !important; box-shadow: none !important; }
            .layout-page { padding: 0 !important; }
            body { background: white !important; }
        }
    </style>
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            
             <?php require_once 'navbar.php'; ?>

            <div class="layout-page">
                
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme btn-print-hide" id="layout-navbar">
                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <div class="navbar-nav align-items-center flex-grow-1">
                            <div class="nav-item d-flex align-items-center w-75">
                                <i class="bx bx-chevron-right fs-4 lh-0 text-muted"></i>
                                <span class="fw-bold ms-2">Dossier Hebdomadaire de l'Intervenant</span>
                            </div>
                        </div>
                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <li>
                                <button class="btn btn-sm btn-label-secondary" onclick="window.history.back()">
                                    <i class="bx bx-arrow-back me-1"></i>Retour
                                </button>
                            </li>
                        </ul>
                    </div>
                </nav>

                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        
                        <div class="card mb-4 btn-print-hide shadow-none border">
                            <div class="card-body py-2">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <p class="mb-0 small text-muted text-uppercase fw-bold">Sélectionner un intervenant :</p>
                                        <select class="form-select border-0 shadow-none ps-0 fw-bold text-primary fs-5">
                                            <option selected>Dr. Koné Mamadou (PHP & MySQL)</option>
                                            <option>M. Traoré Issouf (Sécurité)</option>
                                            <option>Mme. Agossou (React Native)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 text-end border-start">
                                        <button class="btn btn-primary" onclick="window.print()">
                                            <i class="bx bx-printer me-2"></i>Imprimer la Fiche
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="card card-prof-info mb-4 shadow-sm text-center p-4">
                                    <div class="avatar avatar-xl mx-auto mb-3 border border-3 border-white shadow">
                                        <span class="avatar-initial rounded-circle bg-white text-primary fs-2">KM</span>
                                    </div>
                                    <h4 class="text-white mb-1 fw-bold">Dr. Koné Mamadou</h4>
                                    <p class="mb-3 opacity-75">Expert Développement Web</p>
                                    <div class="d-flex justify-content-around border-top pt-3 mt-2">
                                        <div><h5 class="text-white mb-0 fw-bold">25h</h5><small class="opacity-75">Charge/Sem</small></div>
                                        <div><h5 class="text-white mb-0 fw-bold">04</h5><small class="opacity-75">Modules</small></div>
                                    </div>
                                </div>

                                <div class="card mb-4 border-start border-primary border-3">
                                    <div class="card-body">
                                        <h6 class="text-uppercase text-muted small fw-bold mb-3">Informations de Session</h6>
                                        <div class="d-flex mb-3">
                                            <div class="avatar flex-shrink-0 me-3"><span class="avatar-initial rounded bg-label-primary"><i class="bx bx-book"></i></span></div>
                                            <div><small class="d-block mb-1 text-muted">Module Actuel</small><span class="fw-bold">PHP & Architecture MySQL</span></div>
                                        </div>
                                        <div class="d-flex mb-3">
                                            <div class="avatar flex-shrink-0 me-3"><span class="avatar-initial rounded bg-label-primary"><i class="bx bx-group"></i></span></div>
                                            <div><small class="d-block mb-1 text-muted">Niveau Ciblé</small><span class="fw-bold">Licence 3 - SIL</span></div>
                                        </div>
                                        <div class="d-flex">
                                            <div class="avatar flex-shrink-0 me-3"><span class="avatar-initial rounded bg-label-primary"><i class="bx bx-calendar"></i></span></div>
                                            <div><small class="d-block mb-1 text-muted">Semaine</small><span class="fw-bold text-primary">du 20 au 25 Avril 2026</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="card shadow-sm border-0">
                                    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0 fw-bold text-primary"><i class="bx bx-list-check me-2"></i>Agenda des Cours</h5>
                                        <span class="badge bg-label-info">Semaine 16</span>
                                    </div>
                                    
                                    <div class="card-body mt-4">
                                        <div class="timeline-container">
                                            
                                            <div class="timeline-item">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <h6 class="fw-bold text-dark mb-0">LUNDI 20 AVRIL</h6>
                                                    <span class="badge bg-label-success px-3">08:00 - 13:00</span>
                                                </div>
                                                <div class="p-3 bg-light rounded border-start border-primary border-3">
                                                     <p class="mb-1 fw-bold text-primary">Gestion des Sessions & Superglobales</p>
                                                     <small class="text-muted"><i class="bx bx-map-pin me-1"></i>Salle : Labo Informatique 1</small>
                                                </div>
                                            </div>

                                            <div class="timeline-item">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <h6 class="fw-bold text-dark mb-0">MARDI 21 AVRIL</h6>
                                                    <span class="badge bg-label-success px-3">08:00 - 13:00</span>
                                                </div>
                                                <div class="p-3 bg-light rounded">
                                                     <p class="mb-1 fw-bold text-primary">Sécurité : Injections SQL & XSS</p>
                                                     <small class="text-muted"><i class="bx bx-map-pin me-1"></i>Salle : Labo Informatique 1</small>
                                                </div>
                                            </div>

                                            <div class="timeline-item" style="border-left-color: #ffab00;">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <h6 class="fw-bold text-warning mb-0">JEUDI 23 AVRIL</h6>
                                                    <span class="badge bg-label-warning px-3 text-uppercase">Réunion DE</span>
                                                </div>
                                                <div class="p-2 bg-label-warning rounded px-3">
                                                     <small class="fw-bold">Séance de coordination des examens du second semestre.</small>
                                                </div>
                                            </div>

                                            <div class="timeline-item" style="border-left: none;">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <h6 class="fw-bold text-dark mb-0">VENDREDI 24 AVRIL</h6>
                                                    <span class="badge bg-label-danger px-3">08:00 - 12:00</span>
                                                </div>
                                                <div class="p-3 bg-label-danger rounded shadow-sm">
                                                     <p class="mb-1 fw-bold text-white text-uppercase">Contrôle Continu n°1</p>
                                                     <small class="text-white opacity-75"><i class="bx bx-time me-1"></i>Durée : 4 heures</small>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="card-footer bg-lighter border-top py-4">
                                        <div class="row text-center">
                                            <div class="col-6">
                                                <p class="small text-muted mb-4">Signature Intervenant</p>
                                                <div class="mt-4 mx-auto" style="width: 150px; border-bottom: 1px dashed #ccc;"></div>
                                            </div>
                                            <div class="col-6 border-start">
                                                <p class="small text-muted mb-4">Sceau de la Direction (ISMT)</p>
                                                <div class="mt-4 mx-auto" style="width: 150px; border-bottom: 1px dashed #ccc;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    
                    <footer class="content-footer footer bg-footer-theme py-3 text-center border-top">
                        <small class="text-muted">© 2026 ISMT SERVICES - Portail Administratif SIL</small>
                    </footer>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/js/menu.js"></script>
    <script src="../assets/js/main.js"></script>
</body>
</html>