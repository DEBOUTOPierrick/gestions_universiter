<?php
require_once "db.php";

if (!isset($_SESSION["etudiant_id"])) {
    header("Location: connexion.php");
    exit();
}

$etudiant_id = $_SESSION["etudiant_id"];
$etudiant_data = [];

try {
    $stmt = $conn->prepare("SELECT * FROM etudiants WHERE id = ?");
    $stmt->execute([$etudiant_id]);
    $etudiant_data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$etudiant_data) {
        session_unset();
        session_destroy();
        header("Location: connexion.php");
        exit();
    }

    // --- CALCUL DYNAMIQUE MOYENNE ---
    $sql_moy = "SELECT ROUND(SUM(n.note_valeur * m.coefficient) / SUM(m.coefficient), 2) as moy 
                FROM notes n JOIN matieres m ON n.matiere_id = m.id WHERE n.etudiant_id = ?";
    $stmt_moy = $conn->prepare($sql_moy);
    $stmt_moy->execute([$etudiant_id]);
    $moy_res = $stmt_moy->fetch();
    $moyenne_generale = $moy_res['moy'] ?? "0.00";

    // --- RÉCUPÉRATION NOTES RÉELLES ---
    $sql_notes = "SELECT m.nom_matiere, n.note_valeur, m.coefficient, n.date_saisie 
                  FROM notes n JOIN matieres m ON n.matiere_id = m.id 
                  WHERE n.etudiant_id = ? ORDER BY n.date_saisie DESC LIMIT 5";
    $stmt_notes = $conn->prepare($sql_notes);
    $stmt_notes->execute([$etudiant_id]);
    $dernieres_notes = $stmt_notes->fetchAll();

} catch (PDOException $e) {
    header("Location: connexion.php");
    exit();
}

// Variables d'affichage
$nom       = htmlspecialchars($etudiant_data["nom"] ?? '');
$prenom    = htmlspecialchars($etudiant_data["prenom"] ?? '');
$matricule = htmlspecialchars($etudiant_data["matricule"] ?? '');
$filiere   = htmlspecialchars($etudiant_data["filiere"] ?? 'Non défini');
$niveau    = htmlspecialchars($etudiant_data["niveau"] ?? 'Non défini');
$photo     = !empty($etudiant_data["photo"]) 
             ? "assets/img/person/" . htmlspecialchars($etudiant_data["photo"]) 
             : "assets/img/default-avatar.png";
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Mon Suivi Étudiant - ISMT Saint Salomon</title>
    <meta name="description" content="Tableau de bord de suivi étudiant.">
    <meta name="keywords" content="étudiant, suivi, notes, paiement, profil">

    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

    <link href="assets/css/main.css" rel="stylesheet">
    
     <style>
        :root {
            --primary:    #b81919;
            --primary-dark: #9a1414;
            --secondary:  #1e3a8a;
            --light:      #f8f9fa;
            --muted:      #6c757d;
            --success:    #198754;
            --warning:    #ffc107;
            --info:       #0dcaf0;
            --radius:     16px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            color: #212529;
        }

        .main { padding: 2rem 0 4rem; }

        .profile-card {
            background: white;
            border-radius: var(--radius);
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            overflow: hidden;
            transition: transform 0.3s;
        }

        .profile-card:hover { transform: translateY(-6px); }

        .profile-header {
            background: linear-gradient(135deg, var(--primary) 0%, #d41a1a 100%);
            color: white;
            padding: 2.5rem 1.5rem;
            text-align: center;
        }

        .profile-img {
            width: 110px;
            height: 110px;
            border: 5px solid white;
            object-fit: cover;
            border-radius: 50%;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            margin-top: -60px;
        }

        .action-btn {
            border-radius: 12px;
            padding: 1.1rem;
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .action-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        }

        .stat-card {
            background: white;
            border-radius: var(--radius);
            padding: 1.8rem;
            box-shadow: 0 6px 20px rgba(0,0,0,0.06);
            transition: transform 0.3s;
        }

        .stat-card:hover { transform: translateY(-5px); }

        .stat-icon { font-size: 2.8rem; opacity: 0.9; }

        .table-notes th, .table-notes td {
            vertical-align: middle;
            padding: 1rem;
        }

        .table-notes thead {
            background: var(--primary);
            color: white;
        }

        @media (max-width: 992px) {
            .profile-header { padding: 2rem 1rem; }
            .profile-img { width: 90px; height: 90px; margin-top: -45px; }
        }
    </style>

</head>

<body class="events-page">

    <header id="header" class="header d-flex align-items-center sticky-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

            <a href="index.php" class="logo d-flex align-items-center">
                <img src="assets/img/LOGO.png" alt="">
                <h1 class="sitename">ISMT SAINT SALOMON</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="index.php">Acceuil</a></li>
                    <li class="dropdown text-capitalize"><a href="about.php"><span>à propos</span></a>
                    </li>

                    <li><a href="contact.php">Contact</a></li>

                    <?php if ($etudiant_id): ?>
                    <li><a href="bibliotheque.php" class="active">Bibliotheque</a></li>

                    <li class="dropdown">
                        <a href="#">
                            <img
                                src="<?= $photo ?>" alt="Photo de <?= $prenom ?>"
                                alt="Photo de profil"
                                class="img-fluid rounded-circle me-1"
                                style="width: 30px; height: 30px; object-fit: cover; vertical-align: middle; border: 1px solid #eee;"
                            >
                            <span>Bonjour, <?= htmlspecialchars($prenom) ?></span>
                            <i class="bi bi-chevron-down toggle-dropdown"></i>
                        </a>
                        <ul>
                            <li><a href="tableau_de_bord.php">Mon Profil</a></li>
                            <li><a href="deconnexion.php">Déconnexion</a></li>
                        </ul>
                    </li>
                    <?php else: ?>
                    <li><a href="incrirechoix.php" >Inscriptions</a></li>
                    <li><a href="connexion.php">Connexion</a></li>
                    <?php endif; ?>

                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

        </div>
    </header>
<main class="main">
    <div class="container">

        <div class="row gy-4">
            <div class="col-lg-4">
                <div class="profile-card text-center">
                    <div class="profile-header">
                        <h4 class="mb-4 text-white fw-bold">Bienvenue<?= $prenom ? " $prenom" : "" ?> !</h4>
                    </div>
                    <img src="<?= $photo ?>" alt="Photo de <?= $prenom ?>" class="profile-img">
                    <div class="p-4">
                        <h5 class="fw-bold mb-1"><?= $prenom ?> <?= $nom ?></h5>
                        <p class="text-muted mb-3"><?= $matricule ?></p>
                        <div class="d-grid gap-3">
                            <a href="bulletin.php" class="btn btn-primary action-btn">
                                <i class="bi bi-file-earmark-text me-2"></i> Bulletin de notes
                            </a>
                            <a href="paiement.php" class="btn btn-success action-btn">
                                <i class="bi bi-credit-card-2-front me-2"></i> Paiement en ligne
                            </a>
                            <a href="emploi.php" class="btn btn-outline-secondary action-btn">
                                <i class="bi bi-calendar-event me-2"></i> Emploi du temps
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="row gy-4">

                    <div class="col-md-6">
                        <div class="stat-card text-center">
                            <i class="bi bi-graph-up-arrow stat-icon text-info mb-3 d-block"></i>
                            <h5 class="mb-1 fw-semibold">Moyenne générale</h5>
                            <p class="display-5 fw-bold text-info mb-1"><?= $moyenne_generale ?></p>
                            <small class="text-muted">Dernier semestre</small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="stat-card text-center">
                            <i class="bi bi-wallet2 stat-icon text-warning mb-3 d-block"></i>
                            <h5 class="mb-1 fw-semibold">Solde restant</h5>
                            <p class="display-5 fw-bold text-warning mb-1">45 000 XOF</p>
                            <small class="text-muted">À payer avant le 15/03/2026</small>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 text-white fw-bold"><i class="bi bi-journal-text me-2 "></i>Dernières notes</h5>
                                <a href="bulletin.php" class="btn btn-sm btn-light">Voir tout</a>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover table-notes mb-0">
                                        <thead>
                                            <tr>
                                                <th>Matière</th>
                                                <th>Note</th>
                                                <th>Coef</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(empty($dernieres_notes)): ?>
                                                <tr><td colspan="4" class="text-center">Aucune note disponible</td></tr>
                                            <?php else: ?>
                                                <?php foreach($dernieres_notes as $n): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($n['nom_matiere']) ?></td>
                                                    <td><strong><?= number_format($n['note_valeur'], 2) ?> / 20</strong></td>
                                                    <td><?= $n['coefficient'] ?></td>
                                                    <td><?= date('d M. Y', strtotime($n['date_saisie'])) ?></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
    
    <?php
 require_once 'footer.php';
 ?>

    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <div id="preloader"></div>

    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>

    <script src="assets/js/main.js"></script>

</body>

</html>