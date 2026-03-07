<?php
$cssLink = '<link href="style/accueil.css" rel="stylesheet">';

if($_SESSION){
  if($_SESSION['statut'] == 2){
    $menu =  $conf->menu_admin ; 
 }
 else
    $menu =  $conf->menu_connecte;
}
else $menu = $conf->menu ;




$hero = "<div class='hero'>
  <h1>BIENVENUE, " . htmlspecialchars($_SESSION['acces'] ?? '') . "</h1>
  <h3>Vous êtes connecté. Réservez une mission ou consultez votre profil.</h3>
  <a href='index.php?action=escapes' class='cta'>Les missions</a>
  <a href='index.php?action=profil' class='cta'>Mon profil</a>
  <span class='degrader'></span>
</div>";
?>

<section class="infiltration">
  <div class="title">
    <h2>Vos prochaines inflitrations</h2>
    <span class="separator"></span>
  </div>
  <div class="cards">
    <a href="#" class="card">

      <div class="card-hover">
        <span class="cta">Réserver ma mission</span>
      </div>

      <img src="img/card_1.png" alt="L'Horloge du temps suspendu">

      <h3>L'Horloge du temps suspendu</h3>

      <div class="info">
        <div class="difficulte">
          <p>Difficulté :</p>
          <div class="note">
            <img src="img/svg/diff.svg" alt="Difficulté">
            <img src="img/svg/diff.svg" alt="Difficulté">
            <img src="img/svg/diff.svg" alt="Difficulté">
            <img src="img/svg/diff.svg" alt="Difficulté">
            <img src="img/svg/diff.svg" alt="Difficulté">
          </div>
        </div>

        <div class="duree">
          <p>Durée :</p>
          <p>90min</p>
        </div>

      </div>

      <p class="card-desc">Un mécanisme millénaire s’est arrêté au cœur de la Cathédrale. Manipulez les rouages du
        temps et déjouez le
        destin avant que Strasbourg ne soit figée à jamais.</p>
    </a>
    <a href="#" class="card">
      <div class="card-hover">
        <span class="cta">Réserver ma mission</span>
      </div>

      <img src="img/card_1.png" alt="L'Horloge du temps suspendu">

      <h3>L'Horloge du temps suspendu</h3>

      <div class="info">
        <div class="difficulte">
          <p>Difficulté :</p>
          <div class="note">
            <img src="img/svg/diff.svg" alt="Difficulté">
            <img src="img/svg/diff.svg" alt="Difficulté">
            <img src="img/svg/diff.svg" alt="Difficulté">
            <img src="img/svg/diff.svg" alt="Difficulté">
            <img src="img/svg/diff.svg" alt="Difficulté">
          </div>
        </div>

        <div class="duree">
          <p>Durée :</p>
          <p>90min</p>
        </div>

      </div>

      <p class="card-desc">Un mécanisme millénaire s’est arrêté au cœur de la Cathédrale. Manipulez les rouages du
        temps et déjouez le
        destin avant que Strasbourg ne soit figée à jamais.</p>
    </a>
    <a href="#" class="card">


      <div class="card-hover">
        <span class="cta">Réserver ma mission</span>
      </div>

      <img src="img/card_1.png" alt="L'Horloge du temps suspendu">

      <h3>L'Horloge du temps suspendu</h3>

      <div class="info">
        <div class="difficulte">
          <p>Difficulté :</p>
          <div class="note">
            <img src="img/svg/diff.svg" alt="Difficulté">
            <img src="img/svg/diff.svg" alt="Difficulté">
            <img src="img/svg/diff.svg" alt="Difficulté">
            <img src="img/svg/diff.svg" alt="Difficulté">
            <img src="img/svg/diff.svg" alt="Difficulté">
          </div>
        </div>

        <div class="duree">
          <p>Durée :</p>
          <p>90min</p>
        </div>

      </div>

      <p class="card-desc">Un mécanisme millénaire s’est arrêté au cœur de la Cathédrale. Manipulez les rouages du
        temps et déjouez le
        destin avant que Strasbourg ne soit figée à jamais.</p>
    </a>
  </div>
  <a href="" class="cta">Voir toute les missions</a>
</section>

<section class="experience">
  <div class="title">
    <h2>L'EXPÉRIENCE LOCK OUT</h2>
    <span class="separator"></span>
  </div>

  <main class="grid">
    <div class="card_grid-a">
      <span>1</span>
      <div>
        <h3>Choississer votre terrai d'opération</h3>
        <p>Explorez nos dossiers confidentiels et sélectionnez l'intrigue qui mettra vos sens en éveil. Que vous soyez
          attiré par les rouages d'une horloge millénaire ou les secrets d'un manoir industriel, chaque mission est une
          porte ouverte sur l'inconnu.</p>
      </div>
    </div>

    <div class="card_grid-b">
      <span>2</span>
      <div>
        <h3>Choississer votre terrai d'opération</h3>
        <p>Explorez nos dossiers confidentiels et sélectionnez l'intrigue qui mettra vos sens en éveil. Que vous soyez
          attiré par les rouages d'une horloge millénaire ou les secrets d'un manoir industriel, chaque mission est une
          porte ouverte sur l'inconnu.</p>
      </div>
    </div>

    <div class="card_grid-c">
      <span>3</span>
      <div>
        <h3>Choississer votre terrai d'opération</h3>
        <p>Explorez nos dossiers confidentiels et sélectionnez l'intrigue qui mettra vos sens en éveil. Que vous soyez
          attiré par les rouages d'une horloge millénaire ou les secrets d'un manoir industriel, chaque mission est une
          porte ouverte sur l'inconnu.</p>
      </div>
    </div>
  </main>

  <footer>
    <div class="sep">
      <span></span>
      <img src="img/svg/roueDente.svg" alt="1" height="10px" width="10px">
      <span></span>
    </div>
    <p>Aucune connaissance historique préalable n'est requise. Seuls votre esprit d'analyse et votre cohésion d'équipe
      comptent</p>
  </footer>
</section>

<section class="offre">
  <div class="text">
    <h3>Pensez a la carte cadeau lock out</h3>
    <h2>Offrez l'aventure <strong>en héritage</strong></h2>
    <p>Transformez vos proches en complices de légende. Offrez-leur la clé pour déverrouiller les secrets de nos cités et
      vivre une immersion hors du temps.</p>
  </div>
  <img src="img/card_pass-partout.png" alt="">
  <a href="#" class="cta">Offrir une mission</a>
</section>