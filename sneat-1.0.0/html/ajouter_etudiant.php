<?php
// 1. Configuration et Connexion
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'db.php';

$message = "";
$messageClass = "";

// 2. Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $matricule = $_POST['matricule'];
    $date_naissance = $_POST['date_naissance'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $filiere = $_POST['filiere'];
    $niveau = $_POST['niveau'];
    // Mot de passe par défaut : matricule
    $password = password_hash($matricule, PASSWORD_DEFAULT);

    // Gestion de la Photo
    $photo_name = "default.png"; 
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        
        $file_extension = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
        $photo_name = "IMG_" . str_replace('-', '_', $matricule) . "." . $file_extension;
        $target_file = $target_dir . $photo_name;

        if (!move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            $photo_name = "default.png";
            $message = "Erreur lors de l'upload de la photo.";
        }
    }

    try {
        $sql = "INSERT INTO etudiants (matricule, nom, prenom, date_naissance, email, telephone, mot_de_passe, filiere, niveau, photo) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$matricule, $nom, $prenom, $date_naissance, $email, $telephone, $password, $filiere, $niveau, $photo_name]);
        
        $message = "L'étudiant a été inscrit avec succès !";
        $messageClass = "alert-success";
    } catch (PDOException $e) {
        $message = "Erreur lors de l'inscription : " . $e->getMessage();
        $messageClass = "alert-danger";
    }
}
?>

<!DOCTYPE html>
<html lang="fr" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Inscrire un étudiant | ISMT Administration</title>

    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="../assets/vendor/css/core.css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <script src="../assets/vendor/js/helpers.js"></script>
    <script src="../assets/js/config.js"></script>

    <style>
        /* Correction du scroll pour le menu latéral */
        .layout-menu .menu-inner {
            overflow-y: auto !important;
        }
        #uploadedAvatar { object-fit: cover; border: 3px solid #696cff; }
    </style>
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            
            <?php require_once 'navbar.php'; ?>

            <div class="layout-page">
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav align-items-center">
                        <div class="nav-item d-flex align-items-center">
                            <span class="fw-bold text-uppercase">ISMT - Gestion Administrative</span>
                        </div>
                    </div>
                </nav>

                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Scolarité /</span> Inscrire un nouvel étudiant</h4>

                        <?php if ($message != ""): ?>
                            <div class="alert <?= $messageClass ?> alert-dismissible" role="alert">
                                <?= $message ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <div class="row">
                            <div class="col-xl">
                                <div class="card mb-4">
                                    <div class="card-header d-flex justify-content-between align-items-center border-bottom mb-3">
                                        <h5 class="mb-0">Informations Académiques & Personnelles</h5>
                                        <small class="text-muted float-end">Tous les champs sont obligatoires</small>
                                    </div>
                                    <div class="card-body">
                                        <form action="ajouter_etudiant.php" method="POST" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-md-12 mb-4 text-center">
                                                    <div class="d-flex align-items-start align-items-sm-center justify-content-center gap-4">
                                                        <img src="../assets/img/avatars/1.png" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                                                        <div class="button-wrapper text-start">
                                                            <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                                                <span class="d-none d-sm-block">Téléverser la photo</span>
                                                                <i class="bx bx-upload d-block d-sm-none"></i>
                                                                <input type="file" id="upload" name="photo" class="account-file-input" hidden accept="image/png, image/jpeg" />
                                                            </label>
                                                            <p class="text-muted mb-0">Format : JPG, PNG. Max 800 Ko</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label" for="matricule">Matricule</label>
                                                    <div class="input-group input-group-merge">
                                                        <span class="input-group-text"><i class="bx bx-id-card"></i></span>
                                                        <input type="text" id="matricule" name="matricule" class="form-control" placeholder="ISMT-2026-XXX" required />
                                                    </div>
                                                </div>
                                                
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label" for="nom">Nom de famille</label>
                                                    <input type="text" id="nom" name="nom" class="form-control" placeholder="Entrez le nom" required />
                                                </div>

                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label" for="prenom">Prénoms</label>
                                                    <input type="text" id="prenom" name="prenom" class="form-control" placeholder="Entrez les prénoms" required />
                                                </div>

                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label" for="date_naissance">Date de Naissance</label>
                                                    <input type="date" id="date_naissance" name="date_naissance" class="form-control" required />
                                                </div>

                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label" for="email">Email Académique</label>
                                                    <input type="email" id="email" name="email" class="form-control" placeholder="nom@exemple.com" required />
                                                </div>

                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label" for="telephone">Téléphone</label>
                                                    <input type="text" id="telephone" name="telephone" class="form-control" placeholder="+228 90 00 00 00" required />
                                                </div>

                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label" for="filiere">Filière</label>
                                                    <select id="filiere" name="filiere" class="form-select" required>
                                                        <option value="">Sélectionner une filière</option>
                                                        <option value="Génie Logiciel">Génie Logiciel (GL)</option>
                                                        <option value="Réseaux & Télécoms">Réseaux & Télécoms (RT)</option>
                                                        <option value="Management">Management (MGT)</option>
                                                        <option value="Comptabilité">Comptabilité (CCA)</option>
                                                    </select>
                                                </div>

                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label" for="niveau">Niveau d'étude</label>
                                                    <select id="niveau" name="niveau" class="form-select" required>
                                                        <option value="">Sélectionner le niveau</option>
                                                        <option value="L1">Licence 1</option>
                                                        <option value="L2">Licence 2</option>
                                                        <option value="L3">Licence 3</option>
                                                        <option value="M1">Master 1</option>
                                                        <option value="M2">Master 2</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="mt-4">
                                                <button type="submit" class="btn btn-primary me-2">Confirmer l'inscription</button>
                                                <a href="etudiants.php" class="btn btn-outline-secondary">Retour à la liste</a>
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
        
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../assets/vendor/js/menu.js"></script>
    <script src="../assets/js/main.js"></script>

    <script>
        // Aperçu en temps réel de la photo téléversée
        document.getElementById('upload').onchange = function (evt) {
            const [file] = this.files
            if (file) {
                document.getElementById('uploadedAvatar').src = URL.createObjectURL(file)
            }
        }
    </script>
</body>
</html>