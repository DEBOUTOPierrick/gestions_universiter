<!DOCTYPE html>
<html lang="fr" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Gestion Scolarité Intégrale | ISMT Administration</title>
    
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
                            <h4 class="fw-bold py-3 mb-0">
                                <span class="text-muted fw-light">Économat /</span> Suivi Financier Global
                            </h4>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-label-primary p-2"><i class="bx bx-calendar me-1"></i> Année Scolaire</span>
                                <select class="form-select border-primary fw-bold" style="width: 160px;">
                                    <option selected>2025-2026</option>
                                    <option>2024-2025</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="card shadow-none border-start border-primary border-3 bg-label-primary">
                                    <div class="card-body">
                                        <small class="d-block mb-1 text-uppercase fw-semibold">Prévisions Totales</small>
                                        <h4 class="card-title mb-0">45.000.000 FCFA</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card shadow-none border-start border-success border-3 bg-label-success">
                                    <div class="card-body">
                                        <small class="d-block mb-1 text-uppercase fw-semibold">Total Encaissé</small>
                                        <h4 class="card-title mb-0 text-success">32.500.000 FCFA</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card shadow-none border-start border-danger border-3 bg-label-danger">
                                    <div class="card-body">
                                        <small class="d-block mb-1 text-uppercase fw-semibold">Restant à Recouvrer</small>
                                        <h4 class="card-title mb-0 text-danger">12.500.000 FCFA</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-search"></i></span>
                                            <input type="text" class="form-control" placeholder="Rechercher (Nom ou Matricule)..." />
                                        </div>
                                    </div>
                                    <div class="col-md-8 text-md-end">
                                        <div class="btn-group" role="group">
                                            <input type="radio" class="btn-check" name="status" id="all" checked>
                                            <label class="btn btn-outline-secondary" for="all">Tous</label>

                                            <input type="radio" class="btn-check" name="status" id="solde">
                                            <label class="btn btn-outline-success" for="solde">Soldés</label>

                                            <input type="radio" class="btn-check" name="status" id="avance">
                                            <label class="btn btn-outline-warning" for="avance">Avances</label>

                                            <input type="radio" class="btn-check" name="status" id="impayer">
                                            <label class="btn btn-outline-danger" for="impayer">Impayés</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="nav-align-top mb-4">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#l1">Licence 1</button></li>
                                <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#l2">Licence 2</button></li>
                                <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#l3">Licence 3</button></li>
                                <li class="nav-item"><button class="nav-link fw-bold text-primary" data-bs-toggle="tab" data-bs-target="#master">Masters</button></li>
                            </ul>
                            
                            <div class="tab-content px-0">
                                <div class="tab-pane fade show active" id="l1">
                                    <div class="table-responsive text-nowrap">
                                        <table class="table table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Étudiant</th>
                                                    <th>Filière</th>
                                                    <th>Total Dû</th>
                                                    <th>Versé</th>
                                                    <th>Statut</th>
                                                    <th>Progression</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><strong>ADAMOU Moussa</strong><br><small>ISMT-L1-001</small></td>
                                                    <td>Génie Logiciel</td>
                                                    <td>450.000</td>
                                                    <td class="text-success fw-bold">450.000</td>
                                                    <td><span class="badge bg-label-success">SOLDÉ</span></td>
                                                    <td style="width:120px">
                                                        <div class="progress" style="height: 6px;"><div class="progress-bar bg-success" style="width: 100%"></div></div>
                                                    </td>
                                                    <td><button class="btn btn-sm btn-icon btn-outline-primary"><i class="bx bx-list-ul"></i></button></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>SOGLO Jean</strong><br><small>ISMT-L1-024</small></td>
                                                    <td>Réseaux & Télécoms</td>
                                                    <td>350.000</td>
                                                    <td class="text-danger fw-bold">0</td>
                                                    <td><span class="badge bg-label-danger">IMPAYÉ</span></td>
                                                    <td>
                                                        <div class="progress" style="height: 6px;"><div class="progress-bar bg-danger" style="width: 0%"></div></div>
                                                    </td>
                                                    <td><button class="btn btn-sm btn-icon btn-outline-primary"><i class="bx bx-list-ul"></i></button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="l2"><p class="p-4 text-center">Chargement des données Licence 2...</p></div>
                                <div class="tab-pane fade" id="l3"><p class="p-4 text-center">Chargement des données Licence 3...</p></div>
                                <div class="tab-pane fade" id="master"><p class="p-4 text-center">Chargement des données Masters...</p></div>
                            </div>
                        </div>

                    </div>
                    <footer class="content-footer footer bg-footer-theme text-center py-2 text-muted small">
                        © 2026 ISMT SERVICES - Administration Financière
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