<!DOCTYPE html>
<html lang="fr" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Hub de Contrôle Financier | ISMT</title>
    
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <script src="../assets/vendor/js/helpers.js"></script>
    <script src="../assets/js/config.js"></script>
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            
            <?php require_once 'navbar.php'; ?>

            <div class="layout-page">
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                    <div class="navbar-nav align-items-center">
                        <div class="nav-item d-flex align-items-center">
                            <i class="bx bx-search fs-4 lh-0 me-2"></i>
                            <input type="text" class="form-control border-0 shadow-none" placeholder="Rechercher une transaction..." />
                        </div>
                    </div>
                </nav>

                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Caisse /</span> Hub de Monitoring & Encaissement</h4>

                        <div class="row">
                            <div class="col-xl-8 col-lg-7 col-md-12 order-1 order-lg-0">
                                <div class="card mb-4 border-2 border-primary shadow-sm">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <h5 class="card-title m-0 fw-bold text-primary">
                                            <i class="bx bx-broadcast bx-tada me-2"></i> Transactions KKiaPay en direct
                                        </h5>
                                        <button class="btn btn-sm btn-outline-primary" onclick="window.location.reload();"><i class="bx bx-refresh"></i></button>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-hover border-top">
                                            <thead>
                                                <tr>
                                                    <th>Date/Heure</th>
                                                    <th>Étudiant</th>
                                                    <th>Montant</th>
                                                    <th>Statut</th>
                                                    <th>Reçu</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><small>Aujourd'hui, 14:20</small></td>
                                                    <td><strong>ADAMOU Moussa</strong><br><small class="text-muted">Master 1 GL</small></td>
                                                    <td class="fw-bold text-dark">250.000 FCFA</td>
                                                    <td><span class="badge bg-label-success">PAYÉ (LIGNE)</span></td>
                                                    <td><button class="btn btn-sm btn-icon btn-primary"><i class="bx bx-printer"></i></button></td>
                                                </tr>
                                                <tr>
                                                    <td><small>Aujourd'hui, 11:05</small></td>
                                                    <td><strong>SOGLO Jean</strong><br><small class="text-muted">Licence 1 RT</small></td>
                                                    <td class="fw-bold text-dark">50.000 FCFA</td>
                                                    <td><span class="badge bg-label-warning">EN ATTENTE</span></td>
                                                    <td><button class="btn btn-sm btn-icon btn-secondary" disabled><i class="bx bx-printer"></i></button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-5 col-md-12 order-0 order-lg-1">
                                <div class="card mb-4 bg-primary text-white">
                                    <div class="card-body">
                                        <h5 class="card-title text-white fw-bold"><i class="bx bx-money-withdraw me-2"></i> Nouveau Reçu Guichet</h5>
                                        <p class="card-text">Enregistrez ici les paiements cash, chèques ou virements bancaires.</p>
                                        <button class="btn btn-white w-100 fw-bold" data-bs-toggle="modal" data-bs-target="#modalEncaissement">
                                            <i class="bx bx-plus me-1"></i> ENREGISTRER UN PAIEMENT
                                        </button>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-3">
                                            <span class="fw-semibold">Caisse du jour :</span>
                                            <span class="h5 mb-0 fw-bold">300.000 FCFA</span>
                                        </div>
                                        <div class="progress" style="height: 10px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <small class="text-muted mt-2 d-block">Objectif journalier atteint à 70%</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modalEncaissement" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form action="traitement_paiement.php" method="POST">
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold">Enregistrement Paiement Physique</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label for="studentName" class="form-label">Étudiant</label>
                                                <input type="text" id="studentName" name="etudiant" class="form-control" placeholder="Nom ou matricule" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="amount" class="form-label">Montant Versé</label>
                                                <input type="number" id="amount" name="montant" class="form-control" placeholder="FCFA" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="method" class="form-label">Mode</label>
                                                <select id="method" name="mode" class="form-select">
                                                    <option value="especes">Espèces</option>
                                                    <option value="cheque">Chèque</option>
                                                    <option value="virement">Virement</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label for="motif" class="form-label">Motif du versement</label>
                                                <select id="motif" name="motif" class="form-select">
                                                    <option>Scolarité (Tranche)</option>
                                                    <option>Inscription / Réinscription</option>
                                                    <option>Diplôme / Attestation</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                                        <button type="submit" class="btn btn-primary">Valider & Générer le reçu</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <footer class="content-footer footer bg-footer-theme text-center py-2 text-muted small border-top">
                        © 2026 ISMT SERVICES - Hub de Caisse Centralisé
                    </footer>
                    
                    <div class="content-backdrop fade"></div>
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
</body>
</html>