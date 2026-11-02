<!DOCTYPE html>
<html lang="fr" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Emploi du Temps Organisé - ISMT</title>

    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="../assets/vendor/css/core.css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />
    
    <style>
      .table th { background-color: #696cff !important; color: #fff !important; text-transform: uppercase; text-align: center; border: none !important; }
      .time-slot { background-color: #f8f9fa; font-weight: bold; width: 120px; text-align: center; vertical-align: middle; border-right: 2px solid #e7e7ff !important; color: #566a7f; }
      
      .course-card { 
        padding: 12px; 
        border-radius: 10px; 
        min-height: 100px; 
        display: flex; 
        flex-direction: column; 
        justify-content: center;
        position: relative;
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.05);
      }
      
      .course-card:hover { transform: translateY(-3px); box-shadow: 0 4px 12px rgba(105, 108, 255, 0.15); }
      
      .matiere-title { font-size: 0.95rem; font-weight: 800; display: block; margin-bottom: 4px; }
      .prof-name { font-size: 0.8rem; font-weight: 600; opacity: 0.8; }
      .room-info { font-size: 0.75rem; font-style: italic; margin-top: 5px; }
      
      .pause-row { 
        background-color: #f2f2ff !important; 
        color: #696cff; 
        font-weight: bold; 
        text-align: center; 
        letter-spacing: 3px;
        text-transform: uppercase;
        font-size: 0.85rem;
        padding: 10px !important;
      }

      .btn-edit-slot { position: absolute; top: 8px; right: 8px; opacity: 0; transition: 0.3s; }
      .course-card:hover .btn-edit-slot { opacity: 1; }
      
      /* Couleurs par type de cours */
      .bg-label-tp { background-color: #e7e7ff !important; color: #696cff !important; } /* Travaux Pratiques */
      .bg-label-exam { background-color: #ffe5e5 !important; color: #ff3e1d !important; } /* Examens */
    </style>
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">

            <div class="layout-page">
                <?php require_once 'navbar.php'; ?>

                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h4 class="fw-bold mb-0"><span class="text-muted fw-light">Scolarité /</span> Emplois du Temps</h4>
                                <small class="text-muted">Gestion et consultation des plannings hebdomadaires</small>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-danger"><i class="bx bxs-file-pdf me-1"></i> PDF</button>
                                <button class="btn btn-primary"><i class="bx bx-printer me-1"></i> Imprimer</button>
                            </div>
                        </div>

                        <div class="card mb-4 shadow-sm border-top border-primary border-3">
                            <div class="card-body">
                                <form class="row align-items-end g-3">
                                    <div class="col-md-5">
                                        <label class="form-label fw-bold">Filière & Spécialité</label>
                                        <select class="form-select border-primary shadow-none">
                                            <option value="GL">Génie Logiciel (GL)</option>
                                            <option value="RT">Réseaux & Télécoms (RT)</option>
                                            <option value="FC">Finance Comptabilité (FC)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Choisir la Semaine</label>
                                        <input type="week" class="form-control" value="2026-W16">
                                    </div>
                                    <div class="col-md-3">
                                        <a href="programmation.php" class="btn btn-success w-100"><i class="bx bx-plus me-1"></i>Nouvelle Programmation</a>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="nav-align-top mb-4">
                            <ul class="nav nav-tabs nav-fill shadow-sm" role="tablist">
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-l1"><i class="bx bx-book me-1"></i> Licence 1</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-l2"><i class="bx bx-book-open me-1"></i> Licence 2</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-l3"><i class="bx bx-graduation me-1"></i> Licence 3</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-m1"><i class="bx bx-medal me-1"></i> Master</button>
                                </li>
                            </ul>

                            <div class="tab-content px-0 shadow-none bg-transparent">
                                <div class="tab-pane fade show active" id="tab-l3">
                                    <div class="card p-0 border-0 shadow-sm overflow-hidden">
                                        <div class="table-responsive text-nowrap">
                                            <table class="table table-bordered m-0">
                                                <thead>
                                                    <tr>
                                                        <th class="time-slot">HEURES</th>
                                                        <th>Lundi</th>
                                                        <th>Mardi</th>
                                                        <th>Mercredi</th>
                                                        <th>Jeudi</th>
                                                        <th>Vendredi</th>
                                                        <th>Samedi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="time-slot">
                                                            <span class="d-block text-primary">08H - 13H</span>
                                                            <span class="badge bg-label-secondary small">MATIN</span>
                                                        </td>
                                                        <td>
                                                            <div class="course-card bg-label-primary">
                                                                <span class="matiere-title">PHP & FRAMEWORKS</span>
                                                                <span class="prof-name"><i class="bx bx-user-circle me-1"></i>Dr. KONE</span>
                                                                <span class="room-info"><i class="bx bx-map-pin me-1"></i>LABO INFORMATIQUE</span>
                                                                <button class="btn btn-xs btn-primary btn-edit-slot"><i class="bx bx-edit-alt"></i></button>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="course-card bg-label-primary">
                                                                <span class="matiere-title">PHP & FRAMEWORKS</span>
                                                                <span class="prof-name">Dr. KONE</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="course-card bg-label-primary text-center">
                                                                <span class="matiere-title">PHP & FRAMEWORKS</span>
                                                                <span class="badge bg-primary mt-2">COURS INTENSIF</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="course-card bg-label-primary">
                                                                <span class="matiere-title">PHP & FRAMEWORKS</span>
                                                                <span class="prof-name">Dr. KONE</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="course-card bg-label-primary">
                                                                <span class="matiere-title">PHP & FRAMEWORKS</span>
                                                                <span class="prof-name">Dr. KONE</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="course-card bg-label-danger">
                                                                <span class="matiere-title text-center">ÉVALUATION FINALE</span>
                                                                <span class="small text-center">Module PHP</span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td colspan="7" class="pause-row">
                                                            <i class="bx bx-time bx-spin me-2"></i> Pause Déjeuner (13H00 - 14H00)
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="time-slot">
                                                            <span class="d-block text-primary">14H - 17H</span>
                                                            <span class="badge bg-label-secondary small">SOIR</span>
                                                        </td>
                                                        <td colspan="3">
                                                            <div class="course-card bg-label-info text-center">
                                                                <span class="matiere-title">PROJET TUTORÉ (Soutenance)</span>
                                                                <span class="prof-name">Encadrement Technique</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="course-card bg-label-success">
                                                                <span class="matiere-title">SÉCURITÉ INF.</span>
                                                                <span class="prof-name">M. TRAORÉ</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-center text-muted small">---</td>
                                                        <td class="text-center text-muted small">---</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                </div>
                        </div>

                    </div>

                    <footer class="content-footer footer bg-footer-theme text-center py-3 border-top">
                        <div class="container-xxl">
                            <span class="text-muted small">© 2026 ISMT SERVICES - Système de Programmation Académique</span>
                        </div>
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