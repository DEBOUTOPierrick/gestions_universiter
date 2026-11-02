<?php
// 1. Démarrer la session doit être la TOUTE PREMIÈRE instruction PHP
// Inclure la connexion à la base de données
// Assurez-vous que le chemin "db.php" est correct
require_once "db.php"; 

// 2. Initialiser les variables de données de l'étudiant
$etudiant_connecte = false;
$etudiant_data = [];

// 3. Si un étudiant est connecté, récupérer ses données
if (isset($_SESSION["etudiant_id"])) {
    $etudiant_connecte = true;
    
    $etudiant_id = $_SESSION["etudiant_id"];
    
    try {
        // CORRECTION MAJEURE : Récupérer les champs nécessaires : prenom, nom, photo, et matricule
        $stmt = $conn->prepare("SELECT prenom, nom, photo, matricule FROM etudiants WHERE id = ?");
        $stmt->execute([$etudiant_id]);
        $etudiant_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$etudiant_data) {
            // Si l'utilisateur n'est plus dans la DB, déconnecter
            session_unset();
            session_destroy();
            $etudiant_connecte = false;
        }
    } catch (PDOException $e) {
        // Gestion des erreurs de base de données
        session_unset();
        session_destroy();
        $etudiant_connecte = false;
        // Optionnel : enregistrer l'erreur : error_log("DB Error: " . $e->getMessage());
    }
}
// Note : Puisque c'est la page d'accueil, on n'ajoute PAS de header("location: connexion.php");
// 4. Définir les variables pour le menu (après la vérification de connexion)
if ($etudiant_connecte) {
    $prenom = htmlspecialchars($etudiant_data["prenom"] ?? 'Étudiant');
    
    // Définir le chemin de la photo, en ajoutant le dossier 'assets/img/person/'
    // (J'ai fait l'hypothèse que les photos sont stockées dans ce dossier)
    if (!empty($etudiant_data["photo"])) {
        $photo_path = 'assets/img/person/' . htmlspecialchars($etudiant_data["photo"]);
    } else {
        $photo_path = 'assets/img/default-avatar.png'; // Chemin par défaut si aucune photo
    }
} else {
    // Si non connecté, initialiser pour éviter les erreurs
    $prenom = '';
    $photo_path = ''; 
}

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
</head>
<style>
        :root {
            --primary: #b81919;
            --secondary: #1e3a8a;
            --accent: #f39c12;
            --bg-light: #f8f9fa;
        }

        body { font-family: 'Poppins', sans-serif; background-color: var(--bg-light); }

        /* Banner Style */
        .library-header {
            padding: 80px 0;
            text-align: center;
            margin-bottom: 40px;
        }

        /* Search Bar */
        .search-container {
            max-width: 600px;
            margin: -30px auto 30px;
            background: white;
            padding: 10px;
            border-radius: 50px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .search-container input { border: none; padding-left: 20px; }
        .search-container input:focus { box-shadow: none; }
        .btn-search { background: var(--primary); color: white; border-radius: 40px; padding: 10px 25px; }

        /* Filière Cards */
        .filiere-card {
            background: white;
            border: none;
            border-radius: 15px;
            transition: all 0.3s ease;
            height: 100%;
            border-bottom: 5px solid transparent;
            text-decoration: none;
            color: inherit;
        }
        .filiere-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
            border-bottom: 5px solid var(--primary);
        }
        .icon-box {
            width: 70px;
            height: 70px;
            background: rgba(30, 58, 138, 0.1);
            color: var(--secondary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 20px;
            transition: 0.3s;
        }
        .filiere-card:hover .icon-box {
            background: var(--primary);
            color: white;
        }
        .filiere-title { font-weight: 700; color: var(--secondary); margin-bottom: 10px; }
        .doc-count { font-size: 0.8rem; color: #6c757d; }

        /* Filter Tabs */
        .nav-pills .nav-link { color: var(--secondary); font-weight: 500; border-radius: 30px; }
        .nav-pills .nav-link.active { background-color: var(--primary); }
    </style>
<body>

<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
        <a href="index.php" class="logo d-flex align-items-center">
            <img src="assets/img/LOGO.png" alt="Logo ISMT">
            <h1 class="sitename">ISMT SAINT SALOMON</h1>
        </a>

        <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="index.php">Acceuil</a></li>
                    <li class="dropdown text-capitalize"><a href="about.php"><span>à propos</span></a>
                    </li>

                    <li><a href="contact.php">Contact</a></li>

                    <?php if ($etudiant_connecte): ?>
                    <li><a href="bibliotheque.php" class="active">Bibliothèque</a></li>

                    <li class="dropdown">
                        <a href="">
                            <img
                                src="<?= htmlspecialchars($photo_path) ?>"
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

<body>
<main class="main">
    <section class="library-header">
        <div class="container">
            <h1 class="display-4 fw-bold">Bibliothèque Numérique</h1>
            <p class="lead">Accédez à vos supports de cours, mémoires et ressources par filière.</p>
        </div>
    </section>

    <div class="container">
        <div class="search-container d-flex">
            <input type="text" class="form-control" placeholder="Rechercher un cours, un livre, un auteur...">
            <button class="btn btn-search px-4"><i class="bi bi-search"></i></button>
        </div>
    </div>

    <section class="py-5">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h2 class="fw-bold" style="color: var(--secondary);">Nos Filières</h2>
                <p class="text-muted">Sélectionnez votre domaine d'étude pour voir les documents disponibles</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <a href="biblio-details.php?filiere=informatique" class="card filiere-card p-4">
                        <div class="icon-box"><i class="bi bi-laptop"></i></div>
                        <h4 class="filiere-title">Informatique de Gestion</h4>
                        <p class="small text-muted">Algorithmes, Bases de données, Développement Web, Réseaux...</p>
                        <span class="doc-count fw-bold"><i class="bi bi-file-earmark-pdf me-1"></i> 124 Documents</span>
                    </a>
                </div>

                <div class="col-lg-4 col-md-6">
                    <a href="biblio-details.php?filiere=commerce" class="card filiere-card p-4">
                        <div class="icon-box"><i class="bi bi-graph-up-arrow"></i></div>
                        <h4 class="filiere-title">Commerce International</h4>
                        <p class="small text-muted">Marketing, Logistique, Douane, Économie mondiale...</p>
                        <span class="doc-count fw-bold"><i class="bi bi-file-earmark-pdf me-1"></i> 85 Documents</span>
                    </a>
                </div>

                <div class="col-lg-4 col-md-6">
                    <a href="biblio-details.php?filiere=droit" class="card filiere-card p-4">
                        <div class="icon-box"><i class="bi bi-bank"></i></div>
                        <h4 class="filiere-title">Sciences Juridiques</h4>
                        <p class="small text-muted">Droit Civil, Droit des Affaires, Constitution, Code du travail...</p>
                        <span class="doc-count fw-bold"><i class="bi bi-file-earmark-pdf me-1"></i> 210 Documents</span>
                    </a>
                </div>

                <div class="col-lg-4 col-md-6">
                    <a href="biblio-details.php?filiere=comptabilite" class="card filiere-card p-4">
                        <div class="icon-box"><i class="bi bi-calculator"></i></div>
                        <h4 class="filiere-title">Comptabilité & Gestion</h4>
                        <p class="small text-muted">Audit, Finance, Gestion de projet, Fiscalité...</p>
                        <span class="doc-count fw-bold"><i class="bi bi-file-earmark-pdf me-1"></i> 142 Documents</span>
                    </a>
                </div>

                <div class="col-lg-4 col-md-6">
                    <a href="biblio-details.php?filiere=journalisme" class="card filiere-card p-4">
                        <div class="icon-box"><i class="bi bi-mic"></i></div>
                        <h4 class="filiere-title">Communication & Journalisme</h4>
                        <p class="small text-muted">Relations publiques, Média, Éthique, Rédaction...</p>
                        <span class="doc-count fw-bold"><i class="bi bi-file-earmark-pdf me-1"></i> 67 Documents</span>
                    </a>
                </div>

                <div class="col-lg-4 col-md-6">
                    <a href="biblio-details.php?filiere=grh" class="card filiere-card p-4">
                        <div class="icon-box"><i class="bi bi-people"></i></div>
                        <h4 class="filiere-title">Ressources Humaines</h4>
                        <p class="small text-muted">Management, Psychologie du travail, Recrutement...</p>
                        <span class="doc-count fw-bold"><i class="bi bi-file-earmark-pdf me-1"></i> 93 Documents</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-5">
        <div class="container">
            <h3 class="fw-bold mb-4 border-start border-4 border-danger ps-3">Dernières Ressources Ajoutées</h3>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Titre du document</th>
                            <th>Filière</th>
                            <th>Auteur</th>
                            <th>Format</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Cours de PHP Avancé</strong></td>
                            <td><span class="badge bg-primary">Informatique</span></td>
                            <td>M. SOSSOU</td>
                            <td><i class="bi bi-file-pdf text-danger"></i> PDF</td>
                            <td><button class="btn btn-sm btn-outline-primary">Télécharger</button></td>
                        </tr>
                        <tr>
                            <td><strong>Introduction au Droit OHADA</strong></td>
                            <td><span class="badge bg-secondary">Droit</span></td>
                            <td>Dr. AHOUANDJINOU</td>
                            <td><i class="bi bi-file-word text-primary"></i> DOCX</td>
                            <td><button class="btn btn-sm btn-outline-primary">Télécharger</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>
<?php
 require_once 'footer.php';
 ?>
</body>
</html>