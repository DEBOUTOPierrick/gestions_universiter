<?php
// 1. Démarrer la session doit être la TOUTE PREMIÈRE instruction PHP
require_once "db.php"; 

// 2. Initialiser les variables de données de l'étudiant
$etudiant_connecte = false;
$etudiant_data = [];

// 3. Si un étudiant est connecté, récupérer ses données
if (isset($_SESSION["etudiant_id"])) {
    $etudiant_connecte = true;
    $etudiant_id = $_SESSION["etudiant_id"];
    
    try {
        $stmt = $conn->prepare("SELECT prenom, nom, photo, matricule FROM etudiants WHERE id = ?");
        $stmt->execute([$etudiant_id]);
        $etudiant_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$etudiant_data) {
            session_unset();
            session_destroy();
            $etudiant_connecte = false;
        }
    } catch (PDOException $e) {
        session_unset();
        session_destroy();
        $etudiant_connecte = false;
    }
}

// 4. Définir les variables pour le menu
if ($etudiant_connecte) {
    $prenom = htmlspecialchars($etudiant_data["prenom"] ?? 'Étudiant');
    if (!empty($etudiant_data["photo"])) {
        $photo_path = 'assets/img/person/' . htmlspecialchars($etudiant_data["photo"]);
    } else {
        $photo_path = 'assets/img/default-avatar.png';
    }
} else {
    $prenom = '';
    $photo_path = ''; 
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Bibliothèque - Informatique de Gestion</title>

  <link href="assets/img/LOGO-removebg-preview.png" rel="icon">
  
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">

  <style>
    :root {
        --primary-ismt: #b81919;
        --secondary-ismt: #1e3a8a;
        --tertiary-ismt: #d4af37;
        --bg-color: #f4f7f9;
    }

    body {
        background-color: var(--bg-color);
        font-family: 'Poppins', sans-serif;
    }

    /* Hero Section Responsive */
    .filiere-hero {
        background: linear-gradient(135deg, var(--secondary-ismt) 0%, #0d1b42 100%);
        color: white;
        padding: 50px 0;
        border-bottom: 5px solid var(--primary-ismt);
    }

    /* Sidebar / Filtres */
    .filter-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        border: none;
    }

    /* Cartes de Documents Adaptatives */
    .document-item {
        background: white;
        border-radius: 12px;
        padding: 15px 20px;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        transition: 0.3s;
        border-left: 5px solid #dee2e6;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }

    .document-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.1);
    }

    .doc-icon-wrapper {
        width: 50px;
        height: 50px;
        min-width: 50px;
        background: #f0f4f8;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: var(--secondary-ismt);
        margin-right: 15px;
    }

    .doc-details h5 {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 4px;
        color: #2d3748;
    }

    /* Responsive Mobile */
    @media (max-width: 768px) {
        .document-item {
            flex-direction: column;
            text-align: center;
        }
        .doc-icon-wrapper {
            margin-right: 0;
            margin-bottom: 10px;
        }
        .btn-action-doc {
            width: 100%;
            margin-top: 15px;
        }
        .doc-meta {
            justify-content: center;
        }
    }

    /* Couleurs spécifiques */
    .border-cours { border-left-color: #3182ce; }
    .border-exam { border-left-color: var(--primary-ismt); }
    .border-memoire { 
        border-left-color: var(--tertiary-ismt); 
        background-color: #fffdf5;
    }

    .section-title {
        font-weight: 700;
        color: var(--secondary-ismt);
        margin: 30px 0 20px;
        padding-left: 10px;
        border-left: 4px solid var(--primary-ismt);
    }

    .btn-action-doc {
        background: var(--primary-ismt);
        color: white;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        font-size: 0.9rem;
    }
  </style>
</head>

<body>

<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
        <a href="index.php" class="logo d-flex align-items-center">
            <img src="assets/img/LOGO.png" alt="Logo ISMT">
            <h1 class="sitename">ISMT SAINT SALOMON</h1>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <?php if ($etudiant_connecte): ?>
                    <li><a href="bibliotheque.php" class="active">Bibliothèque</a></li>
                    <li class="dropdown">
                        <a href="#">
                            <img src="<?= $photo_path ?>" alt="Profil" class="rounded-circle me-1" style="width: 25px; height: 25px; object-fit: cover;">
                            <span><?= $prenom ?></span> <i class="bi bi-chevron-down"></i>
                        </a>
                        <ul>
                            <li><a href="tableau_de_bord.php">Mon Profil</a></li>
                            <li><a href="deconnexion.php">Déconnexion</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li><a href="connexion.php">Connexion</a></li>
                <?php endif; ?>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
    </div>
</header>

<section class="filiere-hero text-center text-md-start">
    <div class="container">
        <h1 class="display-6 fw-bold">Informatique de Gestion</h1>
        <p class="lead opacity-75">Tous vos supports de cours et mémoires en un seul clic.</p>
    </div>
</section>

<main class="container my-5">
    <div class="row">
        <aside class="col-lg-3 mb-4">
            <div class="filter-card">
                <h5 class="fw-bold mb-3"><i class="bi bi-funnel me-2"></i>Filtrer</h5>
                <div class="mb-3">
                    <label class="small fw-bold text-muted text-uppercase">Niveau</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="l1">
                        <label class="form-check-label" for="l1">Licence 1</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="l2">
                        <label class="form-check-label" for="l2">Licence 2</label>
                    </div>
                </div>
                <button class="btn btn-sm btn-outline-danger w-100 rounded-pill">Appliquer</button>
            </div>
        </aside>

        <div class="col-lg-9">
            <div class="input-group mb-4 shadow-sm rounded-pill overflow-hidden bg-white p-1">
                <span class="input-group-text bg-white border-0"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control border-0" placeholder="Rechercher un document...">
            </div>

            <h4 class="section-title">Supports de Cours</h4>
            
            <div class="document-item border-cours">
                <div class="doc-icon-wrapper"><i class="bi bi-file-earmark-pdf"></i></div>
                <div class="doc-details flex-grow-1">
                    <h5>Algorithmique Avancée</h5>
                    <div class="doc-meta small text-muted">
                        <span class="me-2"><i class="bi bi-person"></i> M. SOSSOU</span>
                        <span><i class="bi bi-mortarboard"></i> L2</span>
                    </div>
                </div>
                <a href="#" class="btn-action-doc">Télécharger</a>
            </div>

            <h4 class="section-title text-warning" style="border-left-color: var(--tertiary-ismt);">Mémoires de Licence</h4>

            <div class="document-item border-memoire">
                <div class="doc-icon-wrapper text-warning"><i class="bi bi-mortarboard-fill"></i></div>
                <div class="doc-details flex-grow-1">
                    <h5>Système de gestion de stock en PHP/MySQL</h5>
                    <div class="doc-meta small text-muted">
                        <span class="me-2"><i class="bi bi-person-circle"></i> Par : Koffi Marc</span>
                        <span><i class="bi bi-calendar3"></i> 2023</span>
                    </div>
                </div>
                <a href="#" class="btn-action-doc" style="background: var(--tertiary-ismt);">Consulter</a>
            </div>
        </div>
    </div>
</main>

<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>