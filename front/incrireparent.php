<?php
if (session_status() === PHP_SESSION_NONE) {
    require_once "db.php"; 
}

$errors = []; 
$form_data = ['nom' => '', 'prenom' => '', 'email' => '', 'telephone' => ''];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $form_data['nom'] = htmlspecialchars($_POST["nom"] ?? '');
    $form_data['prenom'] = htmlspecialchars($_POST["prenom"] ?? '');
    $form_data['email'] = htmlspecialchars($_POST["email"] ?? '');
    $form_data['telephone'] = htmlspecialchars($_POST["telephone"] ?? '');
    $mot_de_passe = $_POST["mot_de_passe"] ?? '';
    $mot_de_passe_conf = $_POST["mot_de_passe_conf"] ?? '';

    if (empty($form_data['nom'])) $errors['nom'] = "Le nom est requis.";
    if (!filter_var($form_data['email'], FILTER_VALIDATE_EMAIL)) $errors['email'] = "Email invalide.";
    if (empty($mot_de_passe)) $errors['password'] = "Mot de passe requis.";
    if ($mot_de_passe !== $mot_de_passe_conf) $errors['password_conf'] = "Les mots de passe ne correspondent pas.";

    if (empty($errors)) {
        $check = $conn->prepare("SELECT id_par FROM parent WHERE email = ?");
        $check->execute([$form_data['email']]);
        if ($check->rowCount() > 0) {
            $errors['email'] = "Cet email est déjà utilisé.";
        } else {
            $hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);
            try {
                $sql = "INSERT INTO parent (nom, prenom, email, tel, motdepass) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$form_data['nom'], $form_data['prenom'], $form_data['email'], $form_data['telephone'], $hash]);
                header("Location: connexion.php?status=success");
                exit();
            } catch (PDOException $e) {
                $errors['global'] = "Erreur technique, réessayez plus tard.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Inscription Parent - ISMT SAINT SALOMON</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet"> <style>
        :root {
            --primary-ismt: #b81919;
            --secondary-ismt: #1e3a8a;
        }
        body { background-color: #f8f9fa; font-family: 'Poppins', sans-serif; }

        /* Style de la carte d'inscription */
        .register-section { padding: 60px 0; }
        .register-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
            border: none;
            overflow: hidden;
        }
        .card-banner {            
            padding: 40px;
            text-align: center;
        }
        .card-banner h2 { color: var(--secondary-ismt); }
        
        .form-label { font-weight: 600; color: #444; font-size: 0.9rem; }
        .form-control {
            border-radius: 10px;
            padding: 12px;
            border: 1px solid #dee2e6;
        }
        .form-control:focus {
            border-color: var(--primary-ismt);
            box-shadow: 0 0 0 0.25rem rgba(184, 25, 25, 0.1);
        }
        .error-msg { color: #dc3545; font-size: 0.8rem; margin-top: 5px; font-weight: 500; }
        .btn-register {
            background: var(--primary-ismt);
            border: none;
            padding: 15px;
            border-radius: 10px;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-register:hover { background: var(--secondary-ismt); transform: translateY(-2px); }
    </style>
</head>

<body>

<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
        <a href="index.php" class="logo d-flex align-items-center text-decoration-none">
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
    <section class="register-section">
        <div class="container">
            <div class="register-card mx-auto" style="max-width: 850px;">
                <div class="card-banner">
                    <h2 class="fw-bold mb-2">Inscription Parent</h2>
                    <p class="mb-0 opacity-75">Suivez le parcours académique de vos enfants en temps réel.</p>
                </div>

                <div class="p-4 p-md-5">
                    <?php if(isset($errors['global'])): ?>
                        <div class="alert alert-danger text-center border-0 rounded-3 mb-4">
                            <i class="bi bi-exclamation-triangle me-2"></i> <?= $errors['global'] ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Nom de famille</label>
                                <input type="text" name="nom" class="form-control <?= isset($errors['nom']) ? 'is-invalid' : '' ?>" 
                                       value="<?= $form_data['nom'] ?>" placeholder="Ex: DOSSOU">
                                <?php if(isset($errors['nom'])): ?>
                                    <div class="error-msg"><i class="bi bi-x-circle me-1"></i> <?= $errors['nom'] ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Prénom(s)</label>
                                <input type="text" name="prenom" class="form-control" value="<?= $form_data['prenom'] ?>" placeholder="Ex: Jean">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Adresse Email</label>
                                <input type="email" name="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" 
                                       value="<?= $form_data['email'] ?>" placeholder="parent@mail.com">
                                <?php if(isset($errors['email'])): ?>
                                    <div class="error-msg"><i class="bi bi-x-circle me-1"></i> <?= $errors['email'] ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Téléphone</label>
                                <input type="tel" name="telephone" class="form-control" value="<?= $form_data['telephone'] ?>" placeholder="97000000">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Mot de passe</label>
                                <input type="password" name="mot_de_passe" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" placeholder="">
                                <?php if(isset($errors['password'])): ?>
                                    <div class="error-msg"><i class="bi bi-x-circle me-1"></i> <?= $errors['password'] ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Confirmer le mot de passe</label>
                                <input type="password" name="mot_de_passe_conf" class="form-control <?= isset($errors['password_conf']) ? 'is-invalid' : '' ?>" placeholder="">
                                <?php if(isset($errors['password_conf'])): ?>
                                    <div class="error-msg"><i class="bi bi-x-circle me-1"></i> <?= $errors['password_conf'] ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="d-grid mt-5">
                            <button type="submit" class="btn btn-primary btn-register text-white">
                                CRÉER MON COMPTE <i class="bi bi-check-circle ms-2"></i>
                            </button>
                        </div>

                        <div class="text-center mt-4">
                            <p class="text-muted">Déjà inscrit ? <a href="connexion.php" class="text-primary fw-bold text-decoration-none">Connectez-vous ici</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

<footer id="footer" class="footer dark-background py-5 mt-auto">
    <div class="container text-center">
        <h3 class="sitename">ISMT SAINT SALOMON</h3>
        <p>L'excellence académique à votre portée.</p>
        <div class="social-links d-flex justify-content-center mt-3">
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
        </div>
        <div class="container mt-4 border-top pt-3">
            <div class="copyright">
                &copy; Copyright <strong><span>ISMT SAINT SALOMON</span></strong>. Tous droits réservés
            </div>
        </div>
    </div>
</footer>

<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>

</body>
</html>