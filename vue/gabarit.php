<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title><?= $title ?></title>
  <link href="style/style.css" rel="stylesheet">
</head>
<body>
  <header>
    <div><a href="index.php"><h1><?= $header ?></h1></a></div>
    <div class="menu"><?= $menu ?></div>
  </header>
  <main>
    <h2><?= $titre ?></h2>
    <?= $contenu ?>
  </main>
  <footer>
    <?= $footer ?>
  </footer>  
</body>
</html>