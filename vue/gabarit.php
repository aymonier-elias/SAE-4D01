<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title><?= $title ?></title>
  <?= $cssLink ?>
</head>

<body>
  <header class="header">
    <nav class="nav">
      <a href="index.php">
        <h1><?= $header ?></h1>
      </a>
      <?= $menu ?>
    </nav>

    <?php
    if (isset($hero)) {
      echo "$hero";
    }
    ?>

  </header>
  <main>
    <?= $contenu ?>
  </main>
  <footer>
    <?= $footer ?>
  </footer>
</body>

</html>