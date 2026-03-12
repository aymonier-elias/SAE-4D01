<?php
$cssLink = '<link href="style/erreur.css" rel="stylesheet">';
?>
<div class="msg-error" data-i18n='page-erreur'>Erreur : <?= htmlspecialchars($message ?? '') ?></div>
