<?php
/** Vue : page d'erreur (message personnalisé affiché à l'utilisateur). */
$cssLink = '<link href="style/erreur.css" rel="stylesheet">';
?>
<div class="msg-error" data-i18n='page-erreur'>Erreur : <?= htmlspecialchars($message ?? '') ?></div>
