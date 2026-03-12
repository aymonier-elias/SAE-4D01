<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title><?= $title ?></title>
  <?= $cssLink ?>

  <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96" />
  <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
  <link rel="shortcut icon" href="/favicon.ico" />
  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
  <link rel="manifest" href="/site.webmanifest" />
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
        <img src="img/svg/de.svg" alt="" data-lang="de">
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