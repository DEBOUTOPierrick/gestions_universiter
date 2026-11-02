<!DOCTYPE html>
<html lang="fr" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Bibliothèque Numérique | ISMT</title>

    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <style>
        .folder-card { transition: all 0.2s ease-in-out; cursor: pointer; border: 1px solid #eceef1; }
        .folder-card:hover, .folder-card.active { 
            background-color: #f5f5f9; 
            transform: translateY(-3px); 
            border-color: #696cff; 
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        .filter-section { background: #fff; border-radius: 8px; padding: 15px; margin-bottom: 20px; border: 1px solid #eceef1; }
        .icon-box { width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 8px; }
    </style>
    
    <script src="../assets/vendor/js/helpers.js"></script>
    <script src="../assets/js/config.js"></script>
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            
            <?php require_once('navbar.php'); ?>

            <div class="layout-page">
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Académie /</span> Médiathèque</h4>
                            <a href="ajouter_document.php" class="btn btn-primary shadow">
                                <i class="bx bx-plus-circle me-1"></i> Nouveau Document
                            </a>
                        </div>

                        <div class="row mb-4 g-3">
                            <div class="col-md-4">
                                <div class="card folder-card shadow-none category-filter" data-cat="Cours" onclick="toggleCategory('Cours', this)">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="icon-box bg-label-primary me-3"><i class="bx bx-book-open fs-3"></i></div>
                                        <div><h6 class="mb-0">Supports de Cours</h6><small class="text-muted">Filtrer par cours</small></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card folder-card shadow-none category-filter" data-cat="Mémoire" onclick="toggleCategory('Mémoire', this)">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="icon-box bg-label-success me-3"><i class="bx bx-certification fs-3"></i></div>
                                        <div><h6 class="mb-0">Mémoires & Rapports</h6><small class="text-muted">Filtrer par mémoires</small></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card folder-card shadow-none category-filter" data-cat="Examen" onclick="toggleCategory('Examen', this)">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="icon-box bg-label-warning me-3"><i class="bx bx-file fs-3"></i></div>
                                        <div><h6 class="mb-0">Annales d'Examens</h6><small class="text-muted">Filtrer par examens</small></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="filter-section shadow-sm">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label small fw-bold text-uppercase">Niveau</label>
                                    <select id="filterNiveau" class="form-select" onchange="applyAllFilters()">
                                        <option value="">Tous les niveaux</option>
                                        <option value="Licence 1">Licence 1</option>
                                        <option value="Licence 2">Licence 2</option>
                                        <option value="Licence 3">Licence 3</option>
                                        <option value="Master 1">Master 1</option>
                                        <option value="Master 2">Master 2</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small fw-bold text-uppercase">Filière</label>
                                    <select id="filterFiliere" class="form-select" onchange="applyAllFilters()">
                                        <option value="">Toutes les filières</option>
                                        <option value="SIL">SIL</option>
                                        <option value="RIT">RIT</option>
                                        <option value="AGE">AGE</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small fw-bold text-uppercase">Année</label>
                                    <select id="filterAnnee" class="form-select" onchange="applyAllFilters()">
                                        <option value="">Toutes les années</option>
                                        <option value="2025-2026">2025-2026</option>
                                        <option value="2024-2025">2024-2025</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small fw-bold text-uppercase">Recherche rapide</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-search"></i></span>
                                        <input type="text" id="filterText" class="form-control" placeholder="Titre..." onkeyup="applyAllFilters()">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow-sm">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover mb-0" id="docTable">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Document</th>
                                            <th>Niveau</th>
                                            <th>Filière</th>
                                            <th>Année</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        <tr data-category="Cours" data-niveau="Licence 3" data-filiere="SIL" data-annee="2025-2026">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="bx bxs-file-pdf fs-4 text-danger me-2"></i>
                                                    <span class="fw-bold">Architecture PHP-PDO.pdf</span>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-label-info">Licence 3</span></td>
                                            <td>SIL</td>
                                            <td>2025-2026</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-icon btn-outline-primary"><i class="bx bx-download"></i></button>
                                            </td>
                                        </tr>
                                        <tr id="noResultsRow" style="display: none;">
                                            <td colspan="5" class="text-center py-5 text-muted">
                                                <i class="bx bx-search-alt-2 fs-1 d-block mb-2"></i>
                                                Aucun document trouvé pour ces filtres.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    </div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../assets/vendor/js/menu.js"></script>
    <script src="../assets/js/main.js"></script>

    <script>
        let activeCategory = null;

        function toggleCategory(category, element) {
            const folders = document.querySelectorAll('.category-filter');
            if (activeCategory === category) {
                activeCategory = null;
                element.classList.remove('active');
            } else {
                folders.forEach(f => f.classList.remove('active'));
                activeCategory = category;
                element.classList.add('active');
            }
            applyAllFilters();
        }

        function applyAllFilters() {
            const niveau = document.getElementById('filterNiveau').value;
            const filiere = document.getElementById('filterFiliere').value;
            const annee = document.getElementById('filterAnnee').value;
            const searchText = document.getElementById('filterText').value.toLowerCase();
            
            const rows = document.querySelectorAll('#docTable tbody tr:not(#noResultsRow)');
            let visibleCount = 0;

            rows.forEach(row => {
                const matchCat = !activeCategory || row.getAttribute('data-category') === activeCategory;
                const matchNiv = !niveau || row.getAttribute('data-niveau') === niveau;
                const matchFil = !filiere || row.getAttribute('data-filiere') === filiere;
                const matchAnn = !annee || row.getAttribute('data-annee') === annee;
                const matchText = row.innerText.toLowerCase().includes(searchText);

                if (matchCat && matchNiv && matchFil && matchAnn && matchText) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            document.getElementById('noResultsRow').style.display = visibleCount === 0 ? '' : 'none';
        }
    </script>
</body>
</html>