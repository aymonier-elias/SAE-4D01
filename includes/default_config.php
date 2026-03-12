<?php

require_once "config/config.class.php";


$conf = new stdClass(); // Objet vide 

$conf->DBHost = Config::$DB_host ?? "localhost";
$conf->DBName = Config::$DB_name ?? "mydatabse";
$conf->DBUser = Config::$DB_user ?? "root";
$conf->DBPwd = Config::$DB_pwd ?? "";


$conf->titreOnglet = Config::TITREONGLET;
$conf->nomSite = Config::NOMSITE;


//Menu par défaut de la page
$conf->menu = "
        <div class = 'menu'>
                <a href='index.php?action=escapes' data-i18n='header.missions'>Les missions</a>
                <a href='index.php?action=concept' data-i18n='header.concept'>Le concept</a>
                <a href='index.php?action=contact' data-i18n='header.contact'>Contact</a>
                <button class='btn_langue'><img src='img/svg/fr.svg' aria-expanded='false'></button>
            <div class = 'important'>
                <a href='index.php?action=connexion' data-i18n='header.connecter'>Se connecter</a>
            </div>
        </div>
    ";



//Menu connecté avec un compte utilisateur normal
$conf->menu_connecte = "
    <div class = 'menu'>
        <a href='index.php?action=escapes' data-i18n='header.missions'>Les missions</a>
        <a href='index.php?action=concept' data-i18n='header.concept'>Le concept</a>
        <a href='index.php?action=contact' data-i18n='header.contact'>Contact</a>
        <button class='btn_langue'><img src='img/svg/fr.svg' aria-expanded='false'></button>
        <div class = 'important'>
            <a href='index.php?action=panier'><img src='img/svg/panier.svg'></a>
            <a href='index.php?action=favoris'><img src='img/svg/fav.svg'></a>
            <a href='index.php?action=profil'><img src='img/svg/compt.svg'></a>
            <a href='index.php?action=deconnexion'><img src='img/svg/deconnexion.svg'></a>
        </div>
    </div>
    ";

//Menu admin connecté 
$conf->menu_admin = "
    <div class = 'menu'>
        <a href='index.php?action=escapes' data-i18n='header.missions'>Les missions</a>
        <a href='index.php?action=concept' data-i18n='header.concept'>Le concept</a>
        <a href='index.php?action=contact' data-i18n='header.contact'>Contact</a>
        <button class='btn_langue'><img src='img/svg/fr.svg' aria-expanded='false'></button>
        <div class = 'admin-links'>
            <a href='index.php?action=gestion_utilisateurs' data-i18n='header.gestion-ut'>Utilisateurs</a>
            <a href='index.php?action=gestion_commandes' data-i18n='header.gestion-com'>Commandes</a>
            <a href='index.php?action=gestion_escapegame' data-i18n='header.gestion-esc'>EscapeGame</a>
        </div>

        <div class = 'important'>
            <a href='index.php?action=panier'><img src='img/svg/panier.svg'></a>
            <a href='index.php?action=favoris'><img src='img/svg/fav.svg'></a>
            <a href='index.php?action=profil'><img src='img/svg/compt.svg'></a>
            <a href='index.php?action=deconnexion'><img src='img/svg/deconnexion.svg'></a>
        </div>
    </div>";

// Footer
$conf->footer = '<nav class="footer-nav">
      <a href="#" class="logo"><img src="img/svg/Logo.svg" alt=""></a>

      <div class="nav-coordonees">
        <h3 data-i18n="footer.coordonnees.titre">Coordonées</h3>
        <a href="#">
          <img src="img/svg/adresse.svg" alt="" data-i18n="footer.coordonnees.adresse">
          55 rue de Pfastatt, 68200 MULHOUSE
        </a>
        <a href="#">
          <img src="img/svg/tel.svg" alt="">
          07 69 82 64 71
        </a>
        <a href="#">
          <img src="img/svg/mail.svg" alt="">
          contact@lockout-escape.com
        </a>
      </div>

      <span class="footer-separator"></span>

      <div class="nav-protocoles">
        <h3 data-i18n="footer.protocoles.titre">Protocoles</h3>
        <a href="#" data-i18n="footer.protocoles.missions">Les missions</a>
        <a href="index.php?action=concept" data-i18n="footer.protocoles.concept">Le concept</a>
        <a href="#" data-i18n="footer.protocoles.faq">FAQ</a>
        <a href="#" data-i18n="footer.protocoles.contact">Conatct</a>
        <a href="#" data-i18n="footer.protocoles.entreprise">Entreprise</a>
      </div>

      <span class="footer-separator"></span>

      <div class="nav-confidentialite">
        <h3 data-i18n="footer.confidentialite.titre">Confidentialité</h3>
        <a href="#" data-i18n="footer.confidentialite.mentions">Mentions Légales</a>
        <a href="#" data-i18n="footer.confidentialite.cvg">CGV</a>
        <a href="#" data-i18n="footer.confidentialite.cookies">Cookies</a>
      </div>
    </nav>

    <div class="reseaux">
      <a href="#"><img src="img/svg/facebook.svg" alt=""></a>
      <a href="#"><img src="img/svg/instagram.svg" alt=""></a>
      <a href="#"><img src="img/svg/x.svg" alt=""></a>
      <a href="#"><img src="img/svg/linkedin.svg" alt=""></a>
      <a href="#"><img src="img/svg/tiktok.svg" alt=""></a>
    </div>

    <p class="legal" data-i18n="footer.copyright">Propriété de lAgence Lock Out. Transmission de données cryptée. © 2026</p>';