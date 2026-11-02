<?php
// 1. Configuration et Connexion
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'db.php';

$message = "";
$messageClass = "";

// 2. Récupération de l'étudiant
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: etudiants.php");
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM etudiants WHERE id = ?");
$stmt->execute([$id]);
$etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$etudiant) {
    header("Location: etudiants.php");
    exit;
}

// 3. Traitement de la mise à jour
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $matricule = $_POST['matricule'];
    $date_naissance = $_POST['date_naissance'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $filiere = $_POST['filiere'];
    $niveau = $_POST['niveau'];
    
    $photo_name = $etudiant['photo']; // Garder l'ancienne photo par défaut

    // Gestion de la nouvelle photo si uploadée
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $target_dir = "uploads/";
        $file_extension = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
        $photo_name = "IMG_" . str_replace('-', '_', $matricule) . "_" . time() . "." . $file_extension;
        
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_dir . $photo_name)) {
            // Optionnel : supprimer l'ancienne photo du serveur si ce n'est pas default.png
            if ($etudiant['photo'] != 'default.png' && file_exists($target_dir . $etudiant['photo'])) {
                unlink($target_dir . $etudiant['photo']);
            }
        }
    }

    try {
        $sql = "UPDATE etudiants SET matricule=?, nom=?, prenom=?, date_naissance=?, email=?, telephone=?, filiere=?, niveau=?, photo=? WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$matricule, $nom, $prenom, $date_naissance, $email, $telephone, $filiere, $niveau, $photo_name, $id]);
        
        $message = "La fiche de l'étudiant a été mise à jour !";
        $messageClass = "alert-success";
        
        // Rafraîchir les données locales
        $stmt = $pdo->prepare("SELECT * FROM etudiants WHERE id = ?");
        $stmt->execute([$id]);
        $etudiant = $stmt->fetch(PDO::FETCH_ASSOC);
        
    } catch (PDOException $e) {
        $message = "Erreur lors de la modification : " . $e->getMessage();
        $messageClass = "alert-danger";
    }
}
?>

<!DOCTYPE html>
<html lang="fr" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Modifier Étudiant | ISMT Administration</title>

    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="../assets/vendor/css/core.css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <script src="../assets/vendor/js/helpers.js"></script>
    <script src="../assets/js/config.js"></script>

    <style>
        /* Masquer la barre de scroll tout en gardant le défilement */
        .menu-inner::-webkit-scrollbar, body::-webkit-scrollbar { display: none; }
        .menu-inner, body { -ms-overflow-style: none; scrollbar-width: none; }

        .layout-menu .menu-inner { overflow-y: auto !important; }
        #uploadedAvatar { object-fit: cover; border: 3px solid #ffab00; }
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
                        <span class="fw-bold">Modification de : <?= htmlspecialchars($etudiant['nom'] . ' ' . $etudiant['prenom']) ?></span>
                    </div>
                </nav>

                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Scolarité /</span> Modifier la fiche étudiant</h4>

                        <?php if ($message != ""): ?>
                            <div class="alert <?= $messageClass ?> alert-dismissible" role="alert">
                                <?= $message ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <div class="card mb-4">
                            <div class="card-body">
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-12 mb-4 text-center">
                                            <div class="d-flex align-items-center justify-content-center gap-4">
                                                <img src="<?= !empty($etudiant['photo']) ? 'uploads/'.$etudiant['photo'] : '../assets/img/avatars/1.png' ?>" 
                                                     alt="avatar" class="rounded" height="100" width="100" id="uploadedAvatar" />
                                                <div class="text-start">
                                                    <label for="upload" class="btn btn-warning me-2">
                                                        <i class="bx bx-refresh"></i> Changer la photo
                                                        <input type="file" id="upload" name="photo" hidden accept="image/png, image/jpeg" />
                                                    </label>
                                                    <p class="text-muted mb-0 small">JPG ou PNG acceptés.</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Matricule</label>
                                            <input type="text" name="matricule" class="form-control" value="<?= htmlspecialchars($etudiant['matricule']) ?>" required />
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Nom</label>
                                            <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($etudiant['nom']) ?>" required />
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Prénoms</label>
                                            <input type="text" name="prenom" class="form-control" value="<?= htmlspecialchars($etudiant['prenom']) ?>" required />
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Date de Naissance</label>
                                            <input type="date" name="date_naissance" class="form-control" value="<?= $etudiant['date_naissance'] ?>" required />
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($etudiant['email']) ?>" required />
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Téléphone</label>
                                            <input type="text" name="telephone" class="form-control" value="<?= htmlspecialchars($etudiant['telephone']) ?>" required />
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Filière</label>
                                            <select name="filiere" class="form-select" required>
                                                <?php 
                                                $filieres = ["Génie Logiciel", "Réseaux & Télécoms", "Management", "Comptabilité"];
                                                foreach($filieres as $f): ?>
                                                    <option value="<?= $f ?>" <?= $etudiant['filiere'] == $f ? 'selected' : '' ?>><?= $f ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Niveau</label>
                                            <select name="niveau" class="form-select" required>
                                                <?php 
                                                $nivs = ["L1", "L2", "L3", "M1", "M2"];
                                                foreach($nivs as $n): ?>
                                                    <option value="<?= $n ?>" <?= $etudiant['niveau'] == $n ? 'selected' : '' ?>><?= $n ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-warning me-2">Enregistrer les modifications</button>
                                        <a href="etudiants.php" class="btn btn-outline-secondary">Annuler</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../assets/vendor/js/menu.js"></script>
    <script src="../assets/js/main.js"></script>

    <script>
        document.getElementById('upload').onchange = function (evt) {
            const [file] = this.files
            if (file) {
                document.getElementById('uploadedAvatar').src = URL.createObjectURL(file)
            }
        }
    </script>
</body>
</html>