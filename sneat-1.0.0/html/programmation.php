<!DOCTYPE html>
<html lang="fr" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Programmation Hebdomadaire | ISMT Administration</title>

    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <style>
        .bg-lighter { background-color: #f8f9fa; }
        .prof-header {
            background: linear-gradient(135deg, #696cff 0%, #30336b 100%);
            color: white;
            padding: 20px;
            border-radius: 8px 8px 0 0;
        }
        .day-card {
            border-left: 5px solid #696cff;
            background: #fff;
            margin-bottom: 15px;
            padding: 20px;
            box-shadow: 0 2px 6px 0 rgba(67, 89, 113, 0.12);
            border-radius: 4px 8px 8px 4px;
        }
        .duplicate-alert {
            display: none;
            background-color: #fff3cd;
            color: #856404;
            padding: 10px;
            border-radius: 5px;
            font-size: 0.85rem;
            margin-top: 10px;
            border: 1px solid #ffeeba;
        }
        .btn-xs { padding: 0.25rem 0.5rem; font-size: 0.7rem; }
        .is-invalid-custom { border-color: #ffab00 !important; background-color: #fffcf5 !important; }
    </style>

    <script src="../assets/vendor/js/helpers.js"></script>
    <script src="../assets/js/config.js"></script>
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            
            <?php require_once 'navbar.php'; ?>

            <div class="layout-page">
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <div class="navbar-nav align-items-center w-100">
                            <div class="nav-item d-flex align-items-center w-100">
                                <i class="bx bx-search fs-4 lh-0 me-2"></i>
                                <input type="text" class="form-control border-0 shadow-none" placeholder="Chercher une programmation..." />
                            </div>
                        </div>
                    </div>
                </nav>

                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="fw-bold py-3 mb-0">
                                <span class="text-muted fw-light">Scolarité /</span> Programmation Hebdomadaire
                            </h4>
                            <button type="submit" form="formScolarite" class="btn btn-primary shadow">
                                <i class="bx bx-save me-1"></i> Enregistrer le planning
                            </button>
                        </div>

                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row gx-3 gy-2 align-items-center">
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold text-uppercase small">Filière concernée</label>
                                        <select class="form-select border-primary" name="filiere" form="formScolarite" required>
                                            <option value="">Choisir la filière...</option>
                                            <option>Génie Logiciel (GL)</option>
                                            <option>Réseaux & Télécoms (RT)</option>
                                            <option>Management des SI (MSI)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold text-uppercase small">Niveau d'étude</label>
                                        <select class="form-select border-primary" name="niveau" form="formScolarite" required>
                                            <option>Licence 1</option>
                                            <option>Licence 2</option>
                                            <option>Licence 3</option>
                                            <option>Master 1</option>
                                            <option>Master 2</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold text-uppercase small">Semaine du (Lundi)</label>
                                        <input type="date" class="form-control" name="date_semaine" form="formScolarite" required />
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <span class="badge bg-label-info w-100 p-2"><i class="bx bx-info-circle me-1"></i> Session 2026</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow-lg border-0">
                            <div class="prof-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 text-white"><i class="bx bx-calendar-check me-2"></i>PREPARATION DE L'EMPLOI DU TEMPS</h5>
                            </div>
                            
                            <div class="card-body mt-4">
                                <form id="formScolarite" action="save_programmation.php" method="POST">
                                    <div class="row g-3 mb-4 border-bottom pb-4">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold text-primary">Professeur / Intervenant</label>
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i class="bx bx-user-voice"></i></span>
                                                <input type="text" class="form-control" name="prof_nom" placeholder="Nom complet de l'enseignant" required />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold text-primary">Unité d'Enseignement (UE)</label>
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i class="bx bx-book-content"></i></span>
                                                <input type="text" class="form-control" name="module_nom" placeholder="Ex: Développement Web Avancé" required />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="bg-lighter p-4 rounded mb-4">
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <h6 class="mb-0 fw-bold text-muted text-uppercase small">Répartition des charges horaires</h6>
                                            <button type="button" class="btn btn-outline-primary btn-sm" id="addDay">
                                                <i class="bx bx-plus me-1"></i> Ajouter une plage
                                            </button>
                                        </div>

                                        <div id="scheduleContainer">
                                            <div class="row g-3 day-card align-items-end mx-0">
                                                <div class="col-md-4">
                                                    <label class="form-label small fw-bold">Jour de la semaine</label>
                                                    <select class="form-select select-day" name="jours[]" required>
                                                        <option value="Lundi">Lundi</option>
                                                        <option value="Mardi">Mardi</option>
                                                        <option value="Mercredi">Mercredi</option>
                                                        <option value="Jeudi">Jeudi</option>
                                                        <option value="Vendredi">Vendredi</option>
                                                        <option value="Samedi">Samedi</option>
                                                    </select>
                                                    <div class="duplicate-alert">
                                                        <span><i class="bx bx-error me-1"></i>Doublon détecté. Garder ?</span><br>
                                                        <button type="button" class="btn btn-xs btn-success confirm-yes mt-2">OUI</button>
                                                        <button type="button" class="btn btn-xs btn-danger confirm-no mt-2">NON</button>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label small fw-bold">Heure Début</label>
                                                    <input type="time" class="form-control" name="h_debut[]" value="08:00" required />
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label small fw-bold">Heure Fin</label>
                                                    <input type="time" class="form-control" name="h_fin[]" value="13:00" required />
                                                </div>
                                                <div class="col-md-2 text-end">
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div> <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl py-2 text-center text-muted text-small border-top">
                            © 2026 ISMT SERVICES - Système de Planification Académique
                        </div>
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

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('scheduleContainer');
        const addBtn = document.getElementById('addDay');

        function verifierDoublons() {
            const selects = document.querySelectorAll('.select-day');
            const vus = {};
            selects.forEach(sel => {
                const val = sel.value;
                const alert = sel.parentElement.querySelector('.duplicate-alert');
                if (val !== "" && vus[val] !== undefined && !sel.dataset.confirmed) {
                    sel.classList.add('is-invalid-custom');
                    alert.style.display = 'block';
                } else {
                    if (val !== "") vus[val] = true;
                    if (!sel.dataset.confirmed) {
                        sel.classList.remove('is-invalid-custom');
                        alert.style.display = 'none';
                    }
                }
            });
        }

        addBtn.addEventListener('click', function() {
            const row = document.createElement('div');
            row.className = 'row g-3 day-card align-items-end mx-0 animate__animated animate__fadeIn';
            row.innerHTML = `
                <div class="col-md-4">
                    <select class="form-select select-day" name="jours[]" required>
                        <option value="Lundi">Lundi</option><option value="Mardi">Mardi</option>
                        <option value="Mercredi">Mercredi</option><option value="Jeudi">Jeudi</option>
                        <option value="Vendredi">Vendredi</option><option value="Samedi">Samedi</option>
                    </select>
                    <div class="duplicate-alert">
                        <span><i class="bx bx-error me-1"></i>Doublon détecté. Garder ?</span><br>
                        <button type="button" class="btn btn-xs btn-success confirm-yes mt-2">OUI</button>
                        <button type="button" class="btn btn-xs btn-danger confirm-no mt-2">NON</button>
                    </div>
                </div>
                <div class="col-md-3"><input type="time" class="form-control" name="h_debut[]" value="08:00" required /></div>
                <div class="col-md-3"><input type="time" class="form-control" name="h_fin[]" value="13:00" required /></div>
                <div class="col-md-2 text-end">
                    <button type="button" class="btn btn-icon btn-outline-danger delete-row"><i class="bx bx-trash"></i></button>
                </div>
            `;
            container.appendChild(row);
            verifierDoublons();
        });

        container.addEventListener('change', (e) => {
            if (e.target.classList.contains('select-day')) {
                delete e.target.dataset.confirmed;
                verifierDoublons();
            }
        });

        container.addEventListener('click', (e) => {
            const line = e.target.closest('.day-card');
            if(!line) return;
            const selectElement = line.querySelector('.select-day');

            if (e.target.classList.contains('confirm-yes')) {
                selectElement.dataset.confirmed = "true";
                selectElement.classList.remove('is-invalid-custom');
                line.querySelector('.duplicate-alert').style.display = 'none';
            }
            if (e.target.classList.contains('confirm-no')) {
                selectElement.value = "";
                verifierDoublons();
            }
            if (e.target.closest('.delete-row')) {
                line.remove();
                verifierDoublons();
            }
        });
    });
    </script>
</body>
</html>