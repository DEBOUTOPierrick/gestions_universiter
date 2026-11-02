<?php
// Démarrer la session au tout début
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Choisir l'Inscription - ISMT SAINT SALOMON</title>
    <meta name="description" content="Choisissez votre type d'inscription : Étudiant ou Parent.">

    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #b81919;          /* Rouge ISMT Étudiant */
            --primary-dark: #9a1414;
            --secondary: #1e3a8a;         /* Bleu Nuit Parent */
            --secondary-dark: #172c68;
            --light-bg: #f9fafb;
            --card-bg: rgba(255, 255, 255, 0.92);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--light-bg) 0%, #e2e8f0 100%);
            color: #1e293b;
        }

        .choice-card {
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            border: none;
            border-radius: 20px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            position: relative;
            min-height: 340px;
        }

        .choice-card:hover {
            transform: translateY(-12px) scale(1.03);
        }

        /* Effet au survol spécifique selon la couleur */
        .card-student:hover { box-shadow: 0 25px 50px -12px rgba(184, 25, 25, 0.25); }
        .card-parent:hover { box-shadow: 0 25px 50px -12px rgba(30, 58, 138, 0.25); }

        .choice-card .card-body {
            position: relative;
            z-index: 1;
            padding: 3rem 2rem;
        }

        .choice-card i {
            font-size: 5rem;
            margin-bottom: 1.5rem;
            transition: transform 0.5s ease;
        }

        .choice-card:hover i {
            transform: scale(1.15) rotate(8deg);
        }

        .btn-student {
            background-color: var(--primary);
            color: white;
            border: none;
        }
        .btn-student:hover { background-color: var(--primary-dark); color: white; }

        .btn-parent {
            background-color: var(--secondary);
            color: white;
            border: none;
        }
        .btn-parent:hover { background-color: var(--secondary-dark); color: white; }

        .text-blue-ismt { color: var(--secondary) !important; }
        .text-red-ismt { color: var(--primary) !important; }

        /* ... Reste de votre CSS original ... */
    </style>
</head>

<body class="events-page">

<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
        <a href="index.php" class="logo d-flex align-items-center">
            <img src="assets/img/LOGO.png" alt="Logo ISMT">
            <h1 class="sitename">ISMT SAINT SALOMON</h1>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="about.php">À Propos</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="incrirechoix.php" class="active">Inscriptions</a></li>
                <li><a href="connexion.php" >Connexion</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
    </div>
</header>
<main class="main">
    <section id="choice" class="contact section">
        <div class="container py-5">
            <div class="section-header text-center mb-5">
                <span class="badge px-4 py-2 rounded-pill mb-3 fs-6" style="background-color: rgba(184, 25, 25, 0.1); color: var(--primary);">
                    Inscription 2025-2026
                </span>
                <h2>Choisissez votre profil d'inscription</h2>
                <p class="lead text-muted">Sélectionnez si vous êtes un nouvel étudiant ou un parent/tuteur pour commencer le processus rapidement.</p>
            </div>

            <div class="row justify-content-center pt-4 g-5">
                <div class="col-md-6 col-lg-5">
                    <a href="inscrire.php" class="text-decoration-none d-block">
                        <div class="card choice-card card-student text-center shadow-lg">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                <i class="bi bi-mortarboard-fill text-red-ismt"></i>
                                <h3 class="text-red-ismt fw-bold">Inscription Étudiant</h3>
                                <p class="text-muted mb-4">Je suis un nouvel étudiant ou je m'inscris pour la première fois.</p>
                                <span class="btn btn-student btn-lg px-5 rounded-pill">
                                    Continuer <i class="bi bi-arrow-right-circle ms-2"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-6 col-lg-5">
                    <a href="incrireparent.php" class="text-decoration-none d-block">
                        <div class="card choice-card card-parent text-center shadow-lg">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                <i class="bi bi-person-heart text-blue-ismt"></i>
                                <h3 class="text-blue-ismt fw-bold">Inscription Parent</h3>
                                <p class="text-muted mb-4">Je souhaite créer un compte pour suivre le parcours de mon enfant.</p>
                                <span class="btn btn-parent btn-lg px-5 rounded-pill">
                                    Continuer <i class="bi bi-arrow-right-circle ms-2"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>
<?php
 require_once 'footer.php';
 ?>
</body>
</html>