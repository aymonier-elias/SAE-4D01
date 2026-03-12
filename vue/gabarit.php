<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title><?= $title ?></title>
  <?= $cssLink ?>
</head>

<body>
  <header class="header">
    <nav class="nav glass">
      <a href="index.php">
        <img src="img/svg/Logo.svg" alt="">
      </a>
      <?= $menu ?>

      <div class="menu_langue" aria-hidden="true">
        <img src="img/svg/fr.svg" alt="" data-lang="fr">
        <img src="img/svg/uk.svg" alt="" data-lang="uk">
      </div>
    </nav>
    <?php
    if (!empty($hero)) {
      echo $hero;
      echo "<style>
        header {
          height: 100vh !important;
        }
      </style>";
    }
    ?>
  </header>
  <main>
    <?= $contenu ?>
  </main>
  <footer class="footer doubleBorder">
      <?= $footer ?>
  </footer>

  <script src="js/script.js"></script>
  <script src="js/traduction.js"></script>
</body>

</html>