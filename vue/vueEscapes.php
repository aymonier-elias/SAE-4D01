<?php
$cssLink = '<link href="style/escapes.css" rel="stylesheet">';
$hero = "<div class='hero'>
    <h1>ARCHIVES DES MISSIONS</h1>
    <h3>Sélectionnez votre zone d'intervention. Chaque cité cache un mécanisme unique, chaque porte une nouvelle énigme.
    </h3>
  <span class='degrader'></span>
</div>";

if (isset($_SESSION) && !empty($_SESSION)) {
    $menu = $_SESSION['statut'] == 2 ? $conf->menu_admin : $conf->menu_connecte;
} else {
    $menu = $conf->menu;
}
?>

<section class="escapes">
    <div class="filtre">
        <button class="cta">Ville ></button>
        <button class="cta">Difficulté ></button>
        <button class="cta">Type ></button>
    </div>

    <div class="missions">
        <a href="#" class="mission">
            <div class="img">
                <img src="img/mission/1.png" alt="">
                <span></span>
            </div>
            <h2>LE BAL MASQUÉ DES INSURGÉS</h2>
        </a>
        <a href="#" class="mission">
            <div class="img">
                <img src="img/mission/1.png" alt="">
                <span></span>
            </div>
            <h2>LE BAL MASQUÉ DES INSURGÉS</h2>
        </a>
        <a href="#" class="mission">
            <div class="img">
                <img src="img/mission/1.png" alt="">
                <span></span>
            </div>
            <h2>LE BAL MASQUÉ DES INSURGÉS</h2>
        </a>
    </div>
</section>