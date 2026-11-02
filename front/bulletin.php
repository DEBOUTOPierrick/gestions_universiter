<?php
require_once "db.php";

// Vérification connexion
if (!isset($_SESSION["etudiant_id"])) {
    header("Location: connexion.php");
    exit();
}

$etudiant_id = $_SESSION["etudiant_id"];
$etudiant_data = [];

try {
    // 1. Infos de l'étudiant
    $stmt = $conn->prepare("SELECT * FROM etudiants WHERE id = ?");
    $stmt->execute([$etudiant_id]);
    $etudiant_data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$etudiant_data) {
        session_unset();
        session_destroy();
        header("Location: connexion.php");
        exit();
    }

    // 2. Calculs de la moyenne et récupération des notes
    // On utilise la même logique que ton tableau de bord pour la cohérence
    $sql_notes = "SELECT m.nom_matiere, n.note_valeur, m.coefficient, (n.note_valeur * m.coefficient) as pondere
                  FROM notes n 
                  JOIN matieres m ON n.matiere_id = m.id 
                  WHERE n.etudiant_id = ? 
                  ORDER BY m.nom_matiere ASC";
    $stmt_notes = $conn->prepare($sql_notes);
    $stmt_notes->execute([$etudiant_id]);
    $notes_reelles = $stmt_notes->fetchAll(PDO::FETCH_ASSOC);

    // Calculs globaux
    $total_pondere = 0;
    $total_coef = 0;
    $credits_valides = 0;

    foreach ($notes_reelles as $n) {
        $total_pondere += $n['pondere'];
        $total_coef += $n['coefficient'];
        if ($n['note_valeur'] >= 10) {
            $credits_valides += 6; // Estimation standard de crédits par matière
        }
    }

    $moyenne_generale = ($total_coef > 0) ? number_format($total_pondere / $total_coef, 2) : "0.00";

    // Mention automatique
    if ($moyenne_generale >= 16) $mention = "Très Bien";
    elseif ($moyenne_generale >= 14) $mention = "Bien";
    elseif ($moyenne_generale >= 12) $mention = "Assez Bien";
    elseif ($moyenne_generale >= 10) $mention = "Passable";
    else $mention = "Ajourné";

} catch (PDOException $e) {
    // En cas d'erreur, on évite de bloquer la page
    $moyenne_generale = "0.00";
    $mention = "—";
    $notes_reelles = [];
}

// Variables pour l'affichage
$prenom    = htmlspecialchars($etudiant_data["prenom"] ?? "Étudiant");
$nom       = htmlspecialchars($etudiant_data["nom"] ?? "");
$matricule = htmlspecialchars($etudiant_data["matricule"] ?? "—");
$filiere   = htmlspecialchars($etudiant_data["filiere"] ?? "Non défini");
$niveau    = htmlspecialchars($etudiant_data["niveau"] ?? "Non défini");
$photo     = !empty($etudiant_data["photo"])
             ? "assets/img/person/" . htmlspecialchars($etudiant_data["photo"])
             : "assets/img/default-avatar.png";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Bulletin - ISMT Saint Salomon</title>

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
      --rouge-is:    #b81919;
      --rouge-dark:  #9a1414;
      --bleu-nuit:   #1e3a8a;
      --vert-succes: #198754;
      --jaune:       #ffc107;
      --gris-clair:  #f8f9fc;
      --shadow:      0 6px 20px rgba(0,0,0,0.08);
      --radius:      14px;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: var(--gris-clair);
      color: #1f2937;
    }

    .main-content {
      padding: 1.5rem 1rem 4rem;
      max-width: 1100px;
      margin: 0 auto;
    }

    .bulletin-header {
      background: linear-gradient(135deg, var(--rouge-is) 0%, var(--rouge-dark) 100%);
      color: white;
      border-radius: var(--radius);
      padding: 2rem 1.5rem;
      margin-bottom: 2rem;
      box-shadow: var(--shadow);
      text-align: center;
    }

    .bulletin-header img {
      width: 90px;
      height: 90px;
      border: 4px solid rgba(255,255,255,0.4);
      border-radius: 50%;
      object-fit: cover;
      margin-bottom: 1rem;
    }

    .overview-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 1.2rem;
      margin-bottom: 2.5rem;
    }

    .overview-card {
      background: white;
      border-radius: var(--radius);
      padding: 1.4rem;
      text-align: center;
      box-shadow: var(--shadow);
      transition: transform 0.25s;
    }

    .overview-card:hover {
      transform: translateY(-4px);
    }

    .overview-value {
      font-size: 2.4rem;
      font-weight: 700;
      margin: 0.4rem 0;
    }

    .overview-label {
      color: #4b5563;
      font-size: 0.95rem;
    }

    .table-matiere thead {
      background: var(--rouge-is);
      color: white;
    }

    .table-matiere th, .table-matiere td {
      padding: 1rem 0.9rem;
      vertical-align: middle;
    }

    .note-cell {
      font-weight: 600;
      font-size: 1.1rem;
    }

    .note-vert { color: var(--vert-succes); }
    .note-jaune { color: var(--jaune); }
    .note-rouge { color: var(--rouge-is); }

    /* Boutons avec fonds dégradés */
    .btn-action {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      width: 100%;
      min-height: 110px;
      padding: 1rem;
      border: none;
      border-radius: 14px;
      font-size: 1.05rem;
      font-weight: 600;
      color: white;
      text-decoration: none;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }

    .btn-action:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 24px rgba(0,0,0,0.18);
    }

    .btn-action i {
      font-size: 2.2rem;
      margin-bottom: 0.6rem;
    }

    .btn-download { background: linear-gradient(135deg, #28a745, #218838); }
    .btn-download:hover { background: linear-gradient(135deg, #218838, #1e7e34); }

    .btn-print { background: linear-gradient(135deg, #6c757d, #5a6268); }
    .btn-print:hover { background: linear-gradient(135deg, #5a6268, #495057); }

    .btn-contact { background: linear-gradient(135deg, #1e3a8a, #172c68); }
    .btn-contact:hover { background: linear-gradient(135deg, #172c68, #0f1f4a); }

    .btn-back { background: linear-gradient(135deg, #495057, #343a40); }
    .btn-back:hover { background: linear-gradient(135deg, #343a40, #212529); }

    @media (max-width: 576px) {
      .bulletin-header { padding: 1.6rem 1.2rem; }
      .bulletin-header img { width: 80px; height: 80px; }
      .overview-value { font-size: 2rem; }
      .overview-grid { grid-template-columns: 1fr; }
      .btn-action { min-height: 100px; font-size: 1rem; padding: 1.2rem 0.8rem; }
      .btn-action i { font-size: 2rem; margin-bottom: 0.5rem; }
      .table-matiere { font-size: 0.92rem; }
      .table-matiere th, .table-matiere td { padding: 0.8rem 0.6rem; }
    }
  </style>
</head>
<body>
<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

        <a href="index.php" class="logo d-flex align-items-center">
            <img src="assets/img/LOGO.png" alt="">
            <h1 class="sitename">ISMT SAINT SALOMON</h1>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="index.php">Acceuil</a></li>
                <li class="dropdown text-capitalize"><a href="about.php"><span>à propos</span></a></li>
                <li><a href="contact.php">Contact</a></li>

                <?php if ($etudiant_id): ?>
                <li><a href="bibliotheque.php" class="active">Bibliotheque</a></li>
                <li class="dropdown">
                    <a href="#">
                        <img src="<?= $photo ?>" alt="Photo" class="img-fluid rounded-circle me-1" style="width: 30px; height: 30px; object-fit: cover;">
                        <span>Bonjour, <?= $prenom ?></span>
                        <i class="bi bi-chevron-down toggle-dropdown"></i>
                    </a>
                    <ul>
                        <li><a href="tableau_de_bord.php">Mon Profil</a></li>
                        <li><a href="deconnexion.php">Déconnexion</a></li>
                    </ul>
                </li>
                <?php endif; ?>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
    </div>
</header>

<main class="main">
  <div class="main-content">
  <div class="bulletin-header">
    <img src="<?= $photo ?>" alt="Photo de profil">
    <h3 class="mb-1 text-white fw-bold"><?= $prenom ?> <?= $nom ?></h3>
    <p class="mb-2">Matricule : <?= $matricule ?> • <?= $niveau ?> • <?= $filiere ?></p>
    <h5 class="mb-0 text-white">Bulletin – Semestre 1 – Année universitaire 2025-2026</h5>
  </div>

  <div class="overview-grid">
    <div class="overview-card">
      <div class="overview-value text-success"><?= $moyenne_generale ?></div>
      <div class="overview-label">Moyenne générale</div>
    </div>
    <div class="overview-card">
      <div class="overview-value text-primary">--</div>
      <div class="overview-label">Rang / --</div>
    </div>
    <div class="overview-card">
      <div class="overview-value text-warning"><?= $mention ?></div>
      <div class="overview-label">Mention</div>
    </div>
    <div class="overview-card">
      <div class="overview-value text-info"><?= $credits_valides ?> / 60</div>
      <div class="overview-label">Crédits validés</div>
    </div>
  </div>

  <div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
      <h5 class="mb-0 text-white fw-bold"> <i class="bi bi-journal-text me-2 "></i> Détail par matière</h5>
    </div>
    <div class="table-responsive">
      <table class="table table-matiere mb-0">
        <thead>
          <tr>
            <th>Matière</th>
            <th>Moyenne</th>
            <th>Coef</th>
            <th>Note pondérée</th>
          </tr>
        </thead>
        <tbody>
          <?php if(empty($notes_reelles)): ?>
            <tr><td colspan="4" class="text-center p-4">Aucune note enregistrée.</td></tr>
          <?php else: ?>
            <?php foreach($notes_reelles as $row): 
              // Logique de couleur identique à ton dashboard
              $colorClass = ($row['note_valeur'] >= 14) ? 'note-vert' : (($row['note_valeur'] >= 10) ? 'note-jaune' : 'note-rouge');
            ?>
            <tr>
              <td><?= htmlspecialchars($row['nom_matiere']) ?></td>
              <td class="note-cell <?= $colorClass ?>"><?= number_format($row['note_valeur'], 2) ?></td>
              <td><?= $row['coefficient'] ?></td>
              <td class="note-cell <?= $colorClass ?>"><strong><?= number_format($row['pondere'], 2) ?></strong></td>
            </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="container text-center my-5">
    <div class="row justify-content-center g-4">

      <div class="col-12 col-sm-6 col-md-3">
        <a href="#" class="btn-action btn-download"><i class="bi bi-download"></i>Télécharger PDF</a>
      </div>

      <div class="col-12 col-sm-6 col-md-3">
        <a href="#" class="btn-action btn-print"><i class="bi bi-printer"></i>Imprimer</a>
      </div>

      <div class="col-12 col-sm-6 col-md-3">
        <a href="contact.php" class="btn-action btn-contact"><i class="bi bi-envelope"></i>Contacter Secrétariat</a>
      </div>

      <div class="col-12 col-sm-6 col-md-3">
        <a href="tableau_de_bord.php" class="btn-action btn-back"><i class="bi bi-arrow-left-circle"></i>Retour au tableau</a>
      </div>

    </div>
  </div>

  </div>
</main>
<?php require_once 'footer.php'; ?>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>