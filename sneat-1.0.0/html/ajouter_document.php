<!DOCTYPE html>
<html lang="fr" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Nouveau Document | ISMT</title>

    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="../assets/vendor/css/core.css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <style>
        .form-section-title {
            font-size: 0.85rem;
            letter-spacing: 1px;
            color: #696cff;
            background: rgba(105, 108, 255, 0.05);
            padding: 8px 15px;
            border-radius: 5px;
            display: inline-block;
            margin-bottom: 20px;
        }
        .input-group-text { background-color: #f8f9fa; }
        .card { border: none; box-shadow: 0 0.125rem 0.25rem rgba(161, 172, 184, 0.4); }
        .form-label { font-weight: 600; color: #566a7f; margin-bottom: 0.5rem; }
        .dropzone-area {
            border: 2px dashed #d9dee3;
            border-radius: 0.5rem;
            padding: 20px;
            text-align: center;
            transition: 0.3s;
            background: #fbfbfb;
        }
        .dropzone-area:hover { border-color: #696cff; background: rgba(105, 108, 255, 0.02); }
    </style>
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            
            <?php require_once('navbar.php'); ?>

            <div class="layout-page">
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        
                        <div class="row justify-content-center">
                            <div class="col-lg-10">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h4 class="mb-0 fw-bold"><i class="bx bx-cloud-upload text-primary fs-3 me-2"></i>Publier une ressource</h4>
                                        <a href="bibliotheque.php" class="btn btn-outline-secondary btn-sm"><i class="bx bx-arrow-back me-1"></i> Retour</a>
                                    </div>
                                    <div class="card-body border-top pt-4">
                                        
                                        <form action="save_document.php" method="POST" enctype="multipart/form-data">
                                            
                                            <span class="form-section-title fw-bold text-uppercase">1. Informations Générales</span>
                                            <div class="row mb-4">
                                                <div class="col-md-8">
                                                    <label class="form-label">Titre du document</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bx bx-edit-alt text-primary"></i></span>
                                                        <input type="text" class="form-control" name="titre" placeholder="Ex: TP de Programmation Web Avancée" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Catégorie</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bx bx-category text-primary"></i></span>
                                                        <select class="form-select" name="categorie">
                                                            <option value="Cours">Cours</option>
                                                            <option value="Examen">Examen</option>
                                                            <option value="Mémoire">Mémoire</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <span class="form-section-title fw-bold text-uppercase">2. Cible Académique</span>
                                            <div class="row mb-4 g-3">
                                                <div class="col-md-4">
                                                    <label class="form-label">Niveau d'étude</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bx bx-layer text-info"></i></span>
                                                        <select class="form-select" name="niveau">
                                                            <option value="Licence 1">Licence 1</option>
                                                            <option value="Licence 2">Licence 2</option>
                                                            <option value="Licence 3">Licence 3</option>
                                                            <option value="Master 1">Master 1</option>
                                                            <option value="Master 2">Master 2</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Filière concernée</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bx bx-wrench text-info"></i></span>
                                                        <select class="form-select" name="filiere">
                                                            <option value="SIL">SIL (Info)</option>
                                                            <option value="RIT">RIT (Réseaux)</option>
                                                            <option value="AGE">AGE (Gestion)</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Année Scolaire</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bx bx-calendar text-info"></i></span>
                                                        <select class="form-select" name="annee">
                                                            <option value="2025-2026">2025-2026</option>
                                                            <option value="2024-2025">2024-2025</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <span class="form-section-title fw-bold text-uppercase">3. Fichier Joint</span>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="dropzone-area">
                                                        <i class="bx bx-file-blank fs-1 text-muted mb-2"></i>
                                                        <p class="mb-2 fw-bold">Cliquez pour sélectionner le document</p>
                                                        <input type="file" name="document_file" class="form-control" required>
                                                        <small class="text-muted d-block mt-2">Formats acceptés : PDF, ZIP, DOCX (Max 20Mo)</small>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-5 d-flex justify-content-end gap-3">
                                                <button type="reset" class="btn btn-label-secondary px-4">Réinitialiser</button>
                                                <button type="submit" class="btn btn-primary px-5 shadow">
                                                    <i class="bx bx-check-double me-1"></i> Enregistrer le document
                                                </button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
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
