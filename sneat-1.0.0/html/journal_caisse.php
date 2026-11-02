<!DOCTYPE html>
<html lang="fr" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Journal de Caisse | ISMT Administration</title>
    
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="../assets/vendor/css/core.css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" />
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
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Économat /</span> Journal de Caisse</h4>
                            <div class="d-flex gap-2">
                                <input type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                <button class="btn btn-primary"><i class="bx bx-export me-1"></i> Imprimer le Journal</button>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-8">
                                <div class="card h-100">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <h5 class="card-title m-0 me-2">Transactions Récentes</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="p-0 m-0">
                                            <li class="d-flex mb-4 pb-1 border-bottom">
                                                <div class="avatar flex-shrink-0 me-3">
                                                    <span class="avatar-initial rounded bg-label-success"><i class="bx bx-mobile-alt"></i></span>
                                                </div>
                                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                    <div class="me-2">
                                                        <small class="text-muted d-block mb-1 text-uppercase">KKiaPay - Mobile Money</small>
                                                        <h6 class="mb-0">ADAMOU Moussa (Scolarité M1)</h6>
                                                    </div>
                                                    <div class="user-progress d-flex align-items-center gap-1">
                                                        <h6 class="mb-0 text-success">+ 150.000</h6>
                                                        <span class="text-muted">FCFA</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="d-flex mb-4 pb-1 border-bottom">
                                                <div class="avatar flex-shrink-0 me-3">
                                                    <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-wallet"></i></span>
                                                </div>
                                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                    <div class="me-2">
                                                        <small class="text-muted d-block mb-1 text-uppercase">Espèces (Guichet)</small>
                                                        <h6 class="mb-0">SOGLO Jean (Frais d'inscription)</h6>
                                                    </div>
                                                    <div class="user-progress d-flex align-items-center gap-1">
                                                        <h6 class="mb-0 text-primary">+ 25.000</h6>
                                                        <span class="text-muted">FCFA</span>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-4">
                                <div class="card bg-primary text-white mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title text-white">Recette du Jour</h5>
                                        <h2 class="fw-bold mb-2">175.000 FCFA</h2>
                                        <p class="mb-0"><i class="bx bx-trending-up"></i> +12% par rapport à hier</p>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Paiements en Ligne</span>
                                            <span class="fw-bold text-success">150.000 FCFA</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span>Paiements Physique</span>
                                            <span class="fw-bold text-primary">25.000 FCFA</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <h5 class="card-header fw-bold">Détails des flux de trésorerie</h5>
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Heure</th>
                                            <th>Référence</th>
                                            <th>Libellé</th>
                                            <th>Mode</th>
                                            <th>Montant</th>
                                            <th>Caissier</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        <tr>
                                            <td>10:45</td>
                                            <td><span class="badge bg-label-info">TRX-9921</span></td>
                                            <td>Versement Scolarité Tranche 2</td>
                                            <td><i class="bx bx-credit-card me-1"></i> KKiaPay</td>
                                            <td><strong>150.000</strong></td>
                                            <td>Système (Auto)</td>
                                        </tr>
                                        <tr>
                                            <td>09:12</td>
                                            <td><span class="badge bg-label-secondary">REC-0042</span></td>
                                            <td>Frais de dossier Inscription</td>
                                            <td><i class="bx bx-money me-1"></i> Espèces</td>
                                            <td><strong>25.000</strong></td>
                                            <td>Secrétariat 1</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <footer class="content-footer footer bg-footer-theme text-center py-2 text-muted small">
                        © 2026 ISMT SERVICES - Journal de Caisse Officiel
                    </footer>
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