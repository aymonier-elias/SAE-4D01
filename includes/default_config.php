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
                <a href='index.php?action=escapes'>Les missions</a>
                <a href='index.php?action=concept'>Le concept</a>
                <a href='index.php?action=contact'>Contact</a>
                <button class='btn_langue'><img src='img/svg/fr.svg' aria-expended='false'></button>
            <div class = 'important'>
                <a href='index.php?action=connexion'>Se connecter</a>
            </div>
        </div>
    ";



//Menu connecté avec un compte utilisateur normal
$conf->menu_connecte = "
    <div class = 'menu'>
        <a href='index.php?action=escapes'>Les missions</a>
        <a href='index.php?action=concept'>Le concept</a>
        <a href='index.php?action=contact'>Contact</a>
        <button class='btn_langue'><img src='img/svg/fr.svg' aria-expended='false'></button>
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
        <a href='index.php?action=escapes'>Les missions</a>
        <a href='index.php?action=concept'>Le concept</a>
        <a href='index.php?action=contact'>Contact</a>
        <button class='btn_langue'><img src='img/svg/fr.svg' aria-expended='false'></button>
        <div class = 'admin-links'>
            <a href='index.php?action=gestion_utilisateurs'>Gestion Utilisateurs</a>
            <a href='index.php?action=gestion_commandes'>Gestion Commandes</a>
            <a href='index.php?action=gestion_escapegame'>Gestion EscapeGame</a>
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
        <h3>Coordonées</h3>
        <a href="#">
          <img src="img/svg/adresse.svg" alt="">
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
        <h3>Protocoles</h3>
        <a href="#">Les missions</a>
        <a href="#">Le concept</a>
        <a href="#">FAQ</a>
        <a href="#">Conatct</a>
        <a href="#">Entreprise</a>
      </div>

      <span class="footer-separator"></span>

      <div class="nav-confidentialite">
        <h3>Protocoles</h3>
        <a href="#">Mentions Légales</a>
        <a href="#">CGV</a>
        <a href="#">Cookies</a>
      </div>
    </nav>

    <div class="reseaux">
      <a href="#"><img src="img/svg/facebook.svg" alt=""></a>
      <a href="#"><img src="img/svg/instagram.svg" alt=""></a>
      <a href="#"><img src="img/svg/x.svg" alt=""></a>
      <a href="#"><img src="img/svg/linkedin.svg" alt=""></a>
      <a href="#"><img src="img/svg/tiktok.svg" alt=""></a>
    </div>

    <p class="legal">Propriété de lAgence Lock Out. Transmission de données cryptée. © 2026</p>';