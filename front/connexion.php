<?php
// Inclure la connexion DB (vérifie que le chemin est correct)
require_once "db.php";

$error = '';

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $matricule = htmlspecialchars($_POST["matricule"]);
    $mot_de_passe = $_POST["mot_de_passe"];

    // 1️⃣ Vérifier si le matricule existe dans la table etudiants
    $sql = "SELECT id, matricule, nom, prenom, photo, mot_de_passe FROM etudiants WHERE matricule = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$matricule]);

    if ($stmt->rowCount() > 0) {
        $etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

        $mdpEtudiant = $etudiant["mot_de_passe"];
        $connexionValide = false;

        // 2️⃣ Vérifier mot de passe de l’étudiant
        if (password_verify($mot_de_passe, $mdpEtudiant)) {
            $connexionValide = true; 
        } else {
            // 3️⃣ Vérifier si le mot de passe correspond à un parent (logique de sécurité initiale conservée)
            $sql2 = "SELECT motdepass FROM parent";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->execute();
            $parents = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            foreach ($parents as $parent) {
                if (password_verify($mot_de_passe, $parent["motdepass"])) {
                    $connexionValide = true;
                    break;
                }
            }
        }

        // 4️⃣ Connexion si mot de passe valide
        if ($connexionValide) {
            $_SESSION["etudiant_id"] = $etudiant["id"];
            $_SESSION["matricule"] = $etudiant["matricule"];
            $_SESSION["nom"] = $etudiant["nom"];
            $_SESSION["prenom"] = $etudiant["prenom"];
            $_SESSION["photo"] = $etudiant["photo"];

            header("Location: tableau_de_bord.php");
            exit();
        } else {
            $error = "Mot de passe incorrect.";
        }

    } else {
        $error = "Matricule introuvable.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Étudiant - ISMT SAINT SALOMON</title>
    <meta name="description" content="Connectez-vous à votre espace étudiant ISMT Saint Salomon">

    <link href="assets/img/LOGO-removebg-preview.png" rel="icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">

    <style>
        :root {
            --primary:    #b81919;
            --primary-dark:#9a1414;
            --secondary:  #1e3a8a;
            --light-bg:   #f8f9fa;
            --card-bg:    rgba(255,255,255,0.96);
            --muted:      #6c757d;
            --radius:     16px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--light-bg) 0%, #e9ecef 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        main { flex: 1; }

        .login-section {
            padding: 4rem 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: var(--radius);
            box-shadow: 0 10px 35px rgba(0,0,0,0.08);
            padding: 2.5rem;
            max-width: 460px;
            width: 100%;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header h2 {
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .form-floating > label {
            color: var(--muted);
        }

        .form-control,
        .form-control:focus {
            border-radius: 10px;
            height: 52px;
            border: 1px solid #dee2e6;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(184, 25, 25, 0.15);
        }

        .btn-primary {
            background: var(--primary);
            border: none;
            border-radius: 50px;
            padding: 0.9rem;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        .alert {
            border-radius: 10px;
        }

        .link-secondary {
            color: var(--secondary);
            font-weight: 500;
        }

        @media (max-width: 576px) {
            .login-card {
                padding: 1.8rem 1.4rem;
                margin: 0 1rem;
            }
        }
    </style>
</head>
<body>

<!-- Header (cohérent avec les autres pages) -->
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
                <li><a href="incrirechoix.php">Inscriptions</a></li>
                <li><a href="connexion.php" class="active">Connexion</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
    </div>
</header>

<main class="main">
    <section class="login-section">
        <div class="login-card">
            <div class="login-header">
                <h2>Connectez-vous</h2>
                <p class="text-muted">Accédez à votre espace personnel</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <?= htmlspecialchars($error) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form method="POST" action="" novalidate>
                <div class="mb-4 form-floating">
                    <input type="text" class="form-control" id="matricule" name="matricule" 
                           placeholder="Matricule" required autofocus value="<?= htmlspecialchars($_POST['matricule'] ?? '') ?>">
                    <label for="matricule">Numéro Matricule</label>
                </div>

                <div class="mb-4 form-floating">
                    <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" 
                           placeholder="Mot de passe" required>
                    <label for="mot_de_passe">Mot de passe</label>
                </div>

                <div class="d-grid mb-4">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Se connecter
                    </button>
                </div>

                <div class="text-center">
                    <p class="mb-2">
                        <a href="incrirechoix.php" class="link-secondary">Créer un compte étudiant</a>
                    </p>
                    <p class="small text-muted">
                        Parent ? <a href="connexion_parent.php" class="link-secondary">Connexion parent</a>
                    </p>
                </div>
            </form>
        </div>
    </section>
</main>
<?php
 require_once 'footer.php';
 ?>
<!-- Footer (à compléter avec ton footer habituel) -->
<footer id="footer" class="footer position-relative dark-background mt-auto">
    <div class="container py-4 text-center text-white-50">
        <p>© <?= date('Y') ?> ISMT SAINT SALOMON - Tous droits réservés</p>
    </div>
</footer>

<a href="#" id="scroll-top" class="scroll-top"><i class="bi bi-arrow-up-short"></i></a>
<div id="preloader"></div>

<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>

</body>
</html>