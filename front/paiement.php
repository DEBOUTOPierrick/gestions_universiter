<?php
require_once "db.php";

if (session_status() === PHP_SESSION_NONE) { session_start(); }

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
        session_destroy();
        header("Location: connexion.php");
        exit();
    }
} catch (PDOException $e) {
    header("Location: connexion.php");
    exit();
}

$prenom    = htmlspecialchars($etudiant_data["prenom"] ?? "Étudiant");
$nom       = htmlspecialchars($etudiant_data["nom"] ?? "");
$email     = htmlspecialchars($etudiant_data["email"] ?? "");
$matricule = htmlspecialchars($etudiant_data["matricule"] ?? "—");
$photo     = htmlspecialchars($etudiant_data["photo"] ?? "assets/img/default-profile.png");

$KKIAPAY_PUBLIC_KEY = "95479fa0ab5e11f088425701ad7ad9d3";
$CALLBACK_URL       = "http://localhost/ismt/callback.php"; 

$show_widget = false;
$error_message = '';
$montant = $_POST['montant'] ?? 50000;
$montant_precedent = $montant;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $montant = max(100, floatval($_POST['montant'] ?? 0));
    $email_input = filter_var($_POST['email'] ?? $email, FILTER_VALIDATE_EMAIL);

    if ($email_input && $montant >= 100) {
        $data_transaction = json_encode([
            'etudiant_id' => $etudiant_id,
            'matricule'   => $matricule,
            'email'       => $email_input,
            'montant'     => $montant
        ]);
        $show_widget = true;
    } else {
        $error_message = "Veuillez entrer un montant valide (minimum 100 XOF).";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement Scolarité - ISMT</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.kkiapay.me/k.js"></script>

    <style>
        :root { --ismt-red: #b81919; --ismt-blue: #1c75b9; }
        body { font-family: 'Poppins', sans-serif; background: #f9fafb; }
        .card { border-radius: 16px; border: none; box-shadow: 0 8px 32px rgba(0,0,0,0.08); }
        .card-header { background: var(--ismt-red); color: white; border-radius: 16px 16px 0 0 !important; padding: 1.5rem; }
        .btn-pay { background: var(--ismt-blue); color: white; border-radius: 50px; padding: 12px; font-weight: 600; transition: 0.3s; border:none; }
        .btn-pay:hover { background: #155a8a; transform: translateY(-2px); color: white; }
        .btn-ann { background: var(--ismt-red); color: white; border-radius: 50px; padding: 12px; font-weight: 600; transition: 0.3s; border:none; }
        .btn-ann:hover { background: #640b0b; transform: translateY(-2px); color: white; }
        .btn-confirm-final { background: var(--ismt-red); color: white; font-weight: 700; padding: 15px; border-radius: 12px; border:none; width: 100%; }
        .btn-confirm-final:hover { background: #9a1414; color: white; }
    </style>
</head>
<body>

<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card">
                <div class="card-header text-center">
                    <h3 class="h5 mb-0">Payer mes frais de scolarité</h3>
                </div>
                <div class="card-body">
                    <?php if ($error_message): ?>
                        <div class="alert alert-danger small"><?= $error_message ?></div>
                    <?php endif; ?>

                    <div class="alert alert-info small text-center">
                        <strong>Étudiant :</strong> <?= $prenom ?> <?= $nom ?><br>
                        <strong>Matricule :</strong> <?= $matricule ?>
                    </div>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Montant (XOF)</label>
                            <input type="number" class="form-control form-control-lg fw-bold" name="montant" value="<?= $montant ?>" required min="100">
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold">Email de confirmation</label>
                            <input type="email" class="form-control" name="email" value="<?= $email ?>" required>
                        </div>
                        <button type="submit" class="btn btn-pay w-100 shadow">
                            Continuer vers le paiement <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                        <a href="tableau_de_bord.php" class="btn btn-ann my-2 w-100 shadow">
                            Annuler le paiement <i class="bi bi-x-circle ms-2"></i>
                        </a >
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 20px;">
            <div class="modal-header border-0">
                <h5 class="fw-bold">Confirmation finale</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-4">
                <p class="text-muted mb-1">Montant à débiter pour <?= $prenom ?> :</p>
                <h2 class="fw-bold text-dark mb-4"><?= number_format($montant, 0, ',', ' ') ?> XOF</h2>
                
                <?php if ($show_widget): ?>
    <kkiapay-widget
        amount="<?= $montant ?>"
        key="<?= $KKIAPAY_PUBLIC_KEY ?>"
        url="assets/img/LOGO.png" 
        position="center"
        sandbox="true"
        data='<?= $data_transaction ?>'
        callback="<?= $CALLBACK_URL ?>"
    ></kkiapay-widget>

    <script>
        // On affiche la modale dès que la page recharge après validation du formulaire
        document.addEventListener("DOMContentLoaded", function() {
            var myModal = new bootstrap.Modal(document.getElementById('confirmModal'));
            myModal.show();
        });

        function lancerKkiapay() {
            // Fermer la modale
            const modalEl = document.getElementById('confirmModal');
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            modalInstance.hide();

            // Lancer le widget
            const widget = document.querySelector('kkiapay-widget');
            if (widget) {
                widget.openWidget();
            }
        }
    </script>
<?php endif; ?>
                <p class="mt-3 small text-muted text-decoration-underline" style="cursor:pointer" data-bs-dismiss="modal">Annuler / Modifier</p>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>