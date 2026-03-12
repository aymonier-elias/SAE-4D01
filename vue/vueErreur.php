<?php
$cssLink = '<link href="style/erreur.css" rel="stylesheet">';
?>
<div class="msg-error">Erreur : <?= htmlspecialchars($message ?? '') ?></div>
