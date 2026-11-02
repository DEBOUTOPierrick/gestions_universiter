
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="index.php" class="app-brand-link">
      <span class="app-brand-text demo menu-text fw-bolder ms-2 text-uppercase">ISMT SERVICES</span>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1" id="main-menu-navigation">
    <li class="menu-item">
      <a href="index.php" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Accueil</div>
      </a>
    </li>

    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Scolarité (Secrétariat)</span>
    </li>
    
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-group"></i>
        <div data-i18n="Layouts">Gestion Étudiants</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="etudiants.php" class="menu-link">
            <div>Répertoire des étudiants</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="ajouter_etudiant.php" class="menu-link">
            <div>Inscrire un étudiant</div>
          </a>
        </li>
      </ul>
    </li>

    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-spreadsheet"></i>
        <div data-i18n="Layouts">Gestion des Notes</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item"><a href="notes.php" class="menu-link"><div>Saisie des notes</div></a></li>
        <li class="menu-item"><a href="bulletins.php" class="menu-link"><div>Bulletins</div></a></li>
        <li class="menu-item"><a href="deliberation.php" class="menu-link"><div>Délibération</div></a></li>
      </ul>
    </li>

    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Finances (Économat)</span>
    </li>
    <li class="menu-item">
      <a href="hub_caisse.php" class="menu-link">
        <i class="menu-icon tf-icons bx bx-wallet"></i>
        <div>Hub de Caisse</div>
      </a>
    </li>
    <li class="menu-item">
      <a href="gestion_scolarite.php" class="menu-link">
        <i class="menu-icon tf-icons bx bx-money"></i>
        <div>Gestion Scolarité</div>
      </a>
    </li>
    <li class="menu-item">
      <a href="journal_caisse.php" class="menu-link">
        <i class="menu-icon tf-icons bx bx-history"></i>
        <div>Journal de Caisse</div>
      </a>
    </li>

    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Scolarité (DE)</span>
    </li>
    <li class="menu-item">
      <a href="emploi_du_temps.php" class="menu-link">
        <i class="menu-icon tf-icons bx bx-calendar-event"></i>
        <div>Emplois du temps</div>
      </a>
    </li>
    <li class="menu-item">
      <a href="programmation.php" class="menu-link">
        <i class="menu-icon tf-icons bx bx-list-check"></i>
        <div>Programmations</div>
      </a>
    </li>
    <li class="menu-item">
      <a href="liste_programmation.php" class="menu-link">
        <i class="menu-icon tf-icons bx bx-list-check"></i>
        <div>Listes des Programmes</div>
      </a>
    </li>

    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Bibliothèque Numérique</span>
    </li>
    <li class="menu-item">
      <a href="bibliotheque.php" class="menu-link">
        <i class="menu-icon tf-icons bx bx-book-reader"></i>
        <div>Médiathèque</div>
      </a>
    </li>
    <li class="menu-item">
      <a href="ajouter_document.php" class="menu-link">
        <i class="menu-icon tf-icons bx bx-cloud-upload"></i>
        <div>Publier un document</div>
      </a>
    </li>
  </ul>
</aside>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    // 1. Récupérer le nom de la page actuelle (ex: etudiants.php)
    var path = window.location.pathname;
    var page = path.split("/").pop();

    // Si on est à la racine, on considère que c'est index.php
    if (page == "") page = "index.php";

    // 2. Trouver tous les liens du menu
    var menuLinks = document.querySelectorAll(".menu-link");

    menuLinks.forEach(function(link) {
      var href = link.getAttribute("href");

      // Si le href correspond à la page actuelle
      if (href === page) {
        // Ajouter la classe 'active' au parent <li>
        var parentLi = link.closest(".menu-item");
        parentLi.classList.add("active");

        // Si c'est un sous-menu, ouvrir aussi le menu parent
        var grandparentLi = parentLi.closest(".menu-sub") ? parentLi.closest(".menu-sub").closest(".menu-item") : null;
        if (grandparentLi) {
          grandparentLi.classList.add("active");
          grandparentLi.classList.add("open"); // Ouvre le menu déroulant
        }
      } else {
        // Retirer la classe active des autres (sécurité)
        link.closest(".menu-item").classList.remove("active");
      }
    });
  });
</script>