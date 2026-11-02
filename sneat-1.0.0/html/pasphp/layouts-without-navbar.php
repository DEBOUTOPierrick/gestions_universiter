<!DOCTYPE html>

<!-- =========================================================
* Admin - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/Admin-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Without navbar - Layouts | Admin - Bootstrap 5 HTML Admin Template - Pro</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../assets/js/config.js"></script>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <!-- Menu -->
      
           <?php require_once 'navbar.php'; ?>
        
        <!-- / Menu -->
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                <div class="navbar-nav align-items-center w-100">
                    <div class="nav-item d-flex align-items-center w-100">
                      <i class="bx bx-search fs-4 lh-0 me-2"></i>
                      <input type="text" class="form-control border-0 shadow-none" placeholder="Recherche globale (Nom, Matricule...)" />
                    </div>
                </div>
            </div>
          </nav>

          <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
              
              <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Scolarité /</span> Répertoire des Étudiants</h4>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary"><i class="bx bx-export me-1"></i> Exporter</button>
                    <a href="ajouter_etudiant.php" class="btn btn-primary"><i class="bx bx-plus me-1"></i> Inscrire un étudiant</a>
                </div>
              </div>

              <div class="card mb-4">
                <div class="card-body">
                  <div class="row gx-3 gy-2 align-items-center">
                    <div class="col-md-3">
                      <label class="form-label">Filière</label>
                      <select class="form-select">
                        <option value="">Toutes les filières</option>
                        <option>Génie Logiciel</option>
                        <option>Management</option>
                        <option>Réseaux & Télécoms</option>
                      </select>
                    </div>
                    <div class="col-md-3">
                      <label class="form-label">Statut Paiement</label>
                      <select class="form-select">
                        <option value="">Tous les statuts</option>
                        <option>Soldé</option>
                        <option>Avance</option>
                        <option>Impayé</option>
                      </select>
                    </div>
                    <div class="col-md-2">
                      <label class="form-label d-block">&nbsp;</label>
                      <button class="btn btn-secondary w-100">Filtrer</button>
                    </div>
                  </div>
                </div>
              </div>

              <div class="nav-align-top mb-4">
                <ul class="nav nav-tabs" role="tablist">
                  <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-l1">Licence 1</button>
                  </li>
                  <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-l2">Licence 2</button>
                  </li>
                  <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-l3">Licence 3</button>
                  </li>
                  <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-m1">Master 1</button>
                  </li>
                  <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-m2">Master 2</button>
                  </li>
                </ul>
                
                <div class="tab-content">
                  <div class="tab-pane fade show active" id="navs-l1" role="tabpanel">
                    <div class="table-responsive text-nowrap">
                      <table class="table table-hover">
                        <thead class="table-light">
                          <tr>
                            <th>Étudiant</th>
                            <th>Matricule</th>
                            <th>Filière</th>
                            <th>Contact</th>
                            <th>Scolarité</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>
                              <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm me-3">
                                  <span class="avatar-initial rounded-circle bg-label-primary">JD</span>
                                </div>
                                <div><span class="fw-bold">DOE John</span></div>
                              </div>
                            </td>
                            <td>ISMT-L1-002</td>
                            <td>Génie Logiciel</td>
                            <td>+228 90 00 00 00</td>
                            <td><span class="badge bg-label-success">Soldé</span></td>
                            <td>
                              <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                                <div class="dropdown-menu">
                                  <a class="dropdown-item" href="#"><i class="bx bx-show me-1"></i> Profil</a>
                                  <a class="dropdown-item" href="#"><i class="bx bx-edit-alt me-1"></i> Modifier</a>
                                  <a class="dropdown-item text-danger" href="#"><i class="bx bx-trash me-1"></i> Supprimer</a>
                                </div>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>

                  <div class="tab-pane fade" id="navs-l2" role="tabpanel">
                    <p class="text-center py-4 text-muted">Aucun étudiant inscrit en Licence 2 pour le moment.</p>
                  </div>

                  <div class="tab-pane fade" id="navs-l3" role="tabpanel">
                    <div class="table-responsive text-nowrap">
                      <table class="table table-hover">
                        <thead class="table-light">
                          <tr>
                            <th>Étudiant</th>
                            <th>Matricule</th>
                            <th>Filière</th>
                            <th>Contact</th>
                            <th>Scolarité</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>
                              <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm me-3">
                                  <span class="avatar-initial rounded-circle bg-label-info">KA</span>
                                </div>
                                <div><span class="fw-bold">KOFFI Amen</span></div>
                              </div>
                            </td>
                            <td>ISMT-L3-001</td>
                            <td>Management</td>
                            <td>+228 91 22 33 44</td>
                            <td><span class="badge bg-label-warning">Avance (50%)</span></td>
                            <td>
                                <button class="btn btn-xs btn-outline-primary">Détails</button>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  
                  </div>
              </div>
            </div>

            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl py-2 text-center">© 2026 Administration ISMT</div>
            </footer>
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
