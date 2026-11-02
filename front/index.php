<?php
// 1. Démarrer la session doit être la TOUTE PREMIÈRE instruction PHP
// Inclure la connexion à la base de données
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
  <title>Accueil ISMT Salomon</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/LOGO-removebg-preview.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&family=Poppins:ital,wght@0,100;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=Raleway:ital,wght@0,100;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">


</head>

<body class="index-page">

  <!-- ══════════════════ HEADER ══════════════════ -->
  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="index.php" class="logo d-flex align-items-center">
        <img src="assets/img/LOGO.png" alt="Logo ISMT">
        <h1 class="sitename fw-semibold">ISMT SAINT SALOMON</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php">Accueil</a></li>
          <li class="dropdown text-capitalize"><a href="about.php"><span>À propos</span></a></li>
          <li><a href="contact.php">Contact</a></li>

          <?php if ($etudiant_connecte): ?>
            <li><a href="bibliotheque.php" class="active">Bibliothèque</a></li>
            <li class="dropdown">
              <a href="">
                <img src="<?= htmlspecialchars($photo_path) ?>"
                     alt="Photo de profil"
                     class="img-fluid rounded-circle me-1"
                     style="width:30px;height:30px;object-fit:cover;vertical-align:middle;border:1px solid #eee;">
                <span>Bonjour, <?= htmlspecialchars($prenom) ?></span>
                <i class="bi bi-chevron-down toggle-dropdown"></i>
              </a>
              <ul>
                <li><a href="tableau_de_bord.php">Mon Profil</a></li>
                <li><a href="deconnexion.php">Déconnexion</a></li>
              </ul>
            </li>
          <?php else: ?>
            <li><a href="incrirechoix.php">Inscriptions</a></li>
            <li><a href="connexion.php">Connexion</a></li>
          <?php endif; ?>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
  </header>

  <!-- ══════════════════ MAIN ══════════════════ -->
  <main class="main">

    <!-- ══ Hero Section ══════════════════════════════════════════ -->
    <section id="hero" class="hero section">

      <!-- ╔══════════════════════════════════════════════════════╗
           ║  CARROUSEL HERO – Bootstrap 5 – Auto-slide 5s       ║
           ║  3 slides, responsive mobile & desktop              ║
           ║  Fade + captions + indicateurs + flèches            ║
           ╚══════════════════════════════════════════════════════╝ -->
      <div id="heroCarousel"
           class="carousel carousel-fade slide"
           data-bs-ride="carousel"
           data-bs-interval="5000"
           data-bs-pause="hover">

        <!-- ── Indicateurs (points de navigation) ── -->
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0"
                  class="active" aria-current="true" aria-label="Diapositive 1"></button>
          <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"
                  aria-label="Diapositive 2"></button>
          <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"
                  aria-label="Diapositive 3"></button>
        </div>

          <div class="carousel-inner">
            <div class="carousel-overlay"></div>

          <!-- SLIDE 1 : L'Établissement -->
          <div class="carousel-item active">
            <img src="assets/img/hero/1.webp"
                 alt="Campus ISMT Saint Salomon"
                 loading="eager">
            <div class="carousel-caption">
              <span class="badge-label">Bienvenue à l'ISMT</span>
              <h2>Votre avenir commence ici</h2>
              <p>Un établissement d'excellence accrédité par le Ministère de l'Enseignement Supérieur du Bénin.</p>
              <a href="about.php" class="btn-hero">Découvrir l'université</a>
            </div>
          </div>

          <!-- SLIDE 2 : Étudiants / Vie campus -->
          <div class="carousel-item">
            <img src="assets/img/hero/2.webp"
                 alt="Étudiants ISMT Saint Salomon"
                 loading="lazy">
            <div class="carousel-caption">
              <span class="badge-label">Vie Étudiante</span>
              <h2>Un campus vivant & inspirant</h2>
              <p>Des milliers d'étudiants passionnés, des clubs, des événements et un encadrement d'exception.</p>
              <a href="incrirechoix.php" class="btn-hero">S'inscrire maintenant</a>
            </div>
          </div>

          <!-- SLIDE 3 : Site Godomey / Infrastructure -->
          <div class="carousel-item">
            <img src="assets/img/hero/4.webp"
                 alt="Site Godomey – ISMT Saint Salomon"
                 loading="lazy">
            <div class="carousel-caption">
              <span class="badge-label">Nos Campus</span>
              <h2>Des infrastructures modernes</h2>
              <p>Trois sites à Cotonou — Godomey, Hévier & Akpakpa — pour un apprentissage de qualité.</p>
              <a href="contact.php" class="btn-hero">Nous contacter</a>
            </div>
          </div>

        </div><!-- /carousel-inner -->

        <!-- ── Flèche Précédent ── -->
        <button class="carousel-control-prev" type="button"
                data-bs-target="#heroCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Précédent</span>
        </button>

        <!-- ── Flèche Suivant ── -->
        <button class="carousel-control-next" type="button"
                data-bs-target="#heroCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Suivant</span>
        </button>

      </div><!-- /heroCarousel -->
      <!-- ── Fin Carrousel Hero ── -->


      <!-- ── Highlights (statistiques) ── -->
      <div class="highlights-container container">
        <div class="row gy-4">
          <div class="col-md-4">
            <div class="highlight-item">
              <div class="icon"><i class="bi bi-mortarboard-fill"></i></div>
              <h3>98 % de réussite des diplômés</h3>
              <p>Un taux d'excellence qui témoigne de la qualité de notre formation et de l'encadrement de nos étudiants.</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="highlight-item">
              <div class="icon"><i class="bi bi-people-fill"></i></div>
              <h3>Un encadrement d'excellence</h3>
              <p>Bénéficiez d'un suivi personnalisé et d'un mentorat direct avec des professeurs leaders dans leur domaine.</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="highlight-item">
              <div class="icon"><i class="bi bi-globe-americas"></i></div>
              <h3>Une Communauté mondiale</h3>
              <p>Rejoignez un réseau international qui ouvre les portes des plus grandes carrières à travers le monde.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- ── Bannière événement ── -->
      <div class="event-banner">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-md-2">
              <div class="event-date">
                <span class="month">SEPT</span>
                <span class="day">29</span>
              </div>
            </div>
            <div class="col-md-8">
              <h3>Date de reprise des cours</h3>
              <p>L'apprentissage, l'innovation et l'épanouissement personnel.</p>
            </div>
            <div class="col-md-2">
              <a href="incrirechoix.php" class="btn-register">Inscrire maintenant</a>
            </div>
          </div>
        </div>
      </div>

    </section><!-- /Hero Section -->


    <!-- ══ About Section ════════════════════════════════════════ -->
    <section id="about" class="about section">
      <div class="container">
        <div class="row gy-5">
          <div class="col-lg-6">
            <div class="content">
              <h3>Université ISMT ST SALOMON</h3>
              <p>L'ISMT ST SALOMON est un établissement d'enseignement supérieur bilingue accrédité par le ministère de
                l'Enseignement supérieur et de la Recherche scientifique de la République du Bénin, situé à Cotonou. Il
                offre des opportunités académiques dans divers domaines avec une approche technologique. L'Université
                ISMT ST SALOMON est l'une des meilleures universités d'enseignement et de recherche du Bénin. Elle jouit
                d'une réputation internationale d'excellence dans les domaines des sciences humaines, des sciences, des
                arts, du commerce et de l'ingénierie.</p>

              <div class="stats-row">
                <div class="stat-item">
                  <div class="number">100+</div>
                  <div class="label">Étudiants inscrits</div>
                </div>
                <div class="stat-item">
                  <div class="number">98%</div>
                  <div class="label">Taux d'obtention de diplôme</div>
                </div>
                <div class="stat-item">
                  <div class="number">250+</div>
                  <div class="label">Faculté d'experts</div>
                </div>
              </div>

              <div class="mission-statement">
                <p><em>"Obtenez un certificat d'une université réputée et reconnue dans le monde entier."</em></p>
              </div>

              <a href="about.php" class="btn-learn-more">
                En savoir plus sur nous <i class="bi bi-arrow-right"></i>
              </a>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="image-wrapper">
              <img src="assets/img/education/etab.jpg" alt="Campus Overview" class="img-fluid">
              <div class="experience-badge">
                <div class="years">10+</div>
                <div class="text">Des années d'excellence</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section><!-- /About Section -->


    <!-- ══ Featured Programs Section ════════════════════════════ -->
    <section id="featured-programs" class="featured-programs section">
      <div class="container section-title">
        <h2>Formations phares</h2>
      </div>

      <div class="container">
        <div class="featured-programs-wrapper">
          <div class="programs-overview">
            <div class="overview-content">
              <h2>Découvrez nos formations phares,</h2>
              <p>soigneusement conçues pour répondre aux exigences du marché et aux ambitions de nos étudiants. Chaque programme combine excellence académique, innovation technologique et pratique professionnelle.</p>
              <div class="overview-stats">
                <div class="stat-item">
                  <span class="stat-number">2 500+</span>
                  <span class="stat-label">Étudiants actifs</span>
                </div>
                <div class="stat-item">
                  <span class="stat-number">98%</span>
                  <span class="stat-label">Taux de diplômés</span>
                </div>
                <div class="stat-item">
                  <span class="stat-number">50+</span>
                  <span class="stat-label">Programmes offerts</span>
                </div>
              </div>
            </div>
            <div class="overview-image">
              <img src="assets/img/education/etudiant2.jpg" alt="Education" class="img-fluid">
            </div>
          </div>

          <div class="programs-showcase">

            <div class="program-card featured-program">
              <div class="card-image">
                <img src="assets/img/education/courses-8.webp" alt="Program" class="img-fluid">
                <div class="program-badge">
                  <i class="bi bi-star-fill"></i>
                </div>
              </div>
              <div class="card-content">
                <div class="program-category">Sciences et Technologies</div>
                <h4>Systèmes Informatiques & Logiciel</h4>
                <p>Développement de site web (formation complémentaire)</p>
                <div class="card-footer">
                  <a href="#" class="learn-more">Apprendre encore plus</a>
                  <div class="enrollment">
                    <i class="bi bi-people"></i>
                    <span>320 inscrits</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="programs-list">
              <div class="program-item">
                <div class="item-visual">
                  <img src="assets/img/education/courses-12.webp" alt="Program" class="img-fluid">
                </div>
                <div class="item-details">
                  <div class="item-category">Sciences Économiques, Financières et de Gestion</div>
                  <ul>
                    <li>Finance, Comptabilité et Audit</li>
                    <li>Banque, Finance et Assurance</li>
                    <li>Gestion des Ressources Humaines</li>
                    <li>Transports & Logistiques</li>
                    <li>Entrepreneuriat & Gestion des Projets</li>
                    <li>Marketing Communication et Commerce</li>
                  </ul>
                </div>
                <div class="item-action"><i class="bi bi-arrow-right-circle"></i></div>
              </div>

              <div class="program-item">
                <div class="item-visual">
                  <img src="assets/img/education/courses-5.webp" alt="Program" class="img-fluid">
                </div>
                <div class="item-details">
                  <div class="item-category">Tourisme, Hôtellerie et Métiers de Service</div>
                  <ul>
                    <li>Tourisme – Hôtellerie & Restauration</li>
                    <li>Cuisine & Restauration (formation complémentaire)</li>
                    <li>Pâtisserie & Crèmerie (formation complémentaire)</li>
                  </ul>
                </div>
                <div class="item-action"><i class="bi bi-arrow-right-circle"></i></div>
              </div>

              <div class="program-item">
                <div class="item-visual">
                  <img src="assets/img/education/courses-15.webp" alt="Program" class="img-fluid">
                </div>
                <div class="item-details">
                  <div class="item-category">Sciences Sociales, Communication et Développement Personnel</div>
                  <ul>
                    <li>Administration Publique</li>
                    <li>Journalisme Audiovisuel</li>
                    <li>Sociologie</li>
                    <li>Coaching en Anglais (formation complémentaire)</li>
                    <li>Développement personnel (formation complémentaire)</li>
                  </ul>
                </div>
                <div class="item-action"><i class="bi bi-arrow-right-circle"></i></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section><!-- /Featured Programs Section -->


    <!-- ══ Students Life Block Section ═════════════════════════ -->
    <section id="students-life-block" class="students-life-block section">
      <div class="container section-title">
        <h2>Campus et Vie Étudiante</h2>
      </div>

      <div class="container">
        <div class="row align-items-center g-5">
          <div class="col-lg-6">
            <div class="content-wrapper">
              <div class="section-tag">Vie sur le Campus</div>
              <h2>L'ISMT ST SALOMON</h2>
              <p class="description">offre un cadre structuré, sécurisé et propice à l'épanouissement de ses étudiants. La vie sur le campus combine excellence académique, activités enrichissantes et accompagnement personnalisé.</p>
              <div class="stats-row">
                <div class="stat-item">
                  <span class="stat-number">85+</span>
                  <span class="stat-label">Organisations étudiantes</span>
                </div>
                <div class="stat-item">
                  <span class="stat-number">150+</span>
                  <span class="stat-label">Événements annuels</span>
                </div>
              </div>
              <div class="action-links">
                <a href="student-life.html" class="primary-link">Découvrez la vie étudiante</a>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="visual-grid">
              <div class="main-visual">
                <img src="assets/img/education/godomey.jpg" alt="Campus Life" class="img-fluid">
                <div class="overlay-badge">
                  <i class="bi bi-heart-fill"></i>
                  <span>Site Godomey</span>
                </div>
              </div>
              <div class="secondary-visuals">
                <div class="small-visual">
                  <img src="assets/img/education/hevier.jpg" alt="Student Activities" class="img-fluid">
                  <div class="visual-caption"><span>Hévier</span></div>
                </div>
                <div class="small-visual">
                  <img src="assets/img/education/akpapa.jpg" alt="Akpakpa" class="img-fluid">
                  <div class="visual-caption"><span>Akpakpa</span></div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="highlights-section">
          <div class="row g-4">
            <div class="col-lg-4">
              <div class="highlight-card">
                <div class="highlight-image">
                  <img src="assets/img/education/etud.jpg" alt="Leadership Programs" class="img-fluid">
                </div>
                <div class="highlight-content">
                  <h5>Vie académique et accompagnement</h5>
                  <p>Un encadrement de qualité avec des clubs étudiants actifs, des programmes de tutorat, du mentorat et des ressources pédagogiques.</p>
                </div>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="highlight-card">
                <div class="highlight-image">
                  <img src="assets/img/education/cult.jpg" alt="Cultural Events" class="img-fluid">
                </div>
                <div class="highlight-content">
                  <h5>Activités culturelles et sportives</h5>
                  <p>Des événements artistiques, des tournois sportifs et des ateliers créatifs qui valorisent le talent et renforcent la cohésion.</p>
                </div>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="highlight-card">
                <div class="highlight-image">
                  <img src="assets/img/education/oportum.jpg" alt="Innovation Hub" class="img-fluid">
                </div>
                <div class="highlight-content">
                  <h5>Opportunités et développement personnel</h5>
                  <p>Des stages, séminaires, projets innovants et programmes d'échange permettant aux étudiants de développer leurs compétences.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </section><!-- /Students Life Block Section -->

  </main>



  <!-- Scroll Top -->
  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>


  <!-- ============================================================
       INITIALISATION BOOTSTRAP CARROUSEL (sécurité si main.js
       ne l'initialise pas automatiquement)
       ============================================================ -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var heroCarouselEl = document.getElementById('heroCarousel');
      if (heroCarouselEl) {
        // Bootstrap 5 : l'attribut data-bs-ride="carousel" suffit,
        // mais on force l'init ici au cas où le JS serait chargé en defer
        var heroCarousel = new bootstrap.Carousel(heroCarouselEl, {
          interval: 5000,   // délai entre chaque slide (ms)
          ride: 'carousel', // démarre automatiquement
          pause: 'hover',   // pause au survol souris
          wrap: true        // boucle infinie
        });
      }
    });
  </script>
</body>

</html>
</html>
