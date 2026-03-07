<?php
$reservations = $reservations ?? array();
$titre = "Liste des réservations / achats";
?>
<div class="content">
  <?php if (empty($reservations)): ?>
    <div class="msg-empty">Aucune réservation enregistrée.</div>
  <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>Date</th>
          <th>Heure</th>
          <th>Participants</th>
          <th>Escape</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($reservations as $r): ?>
          <tr>
            <td><?= htmlspecialchars($r['Date'] ?? '') ?></td>
            <td><?= htmlspecialchars($r['Heure'] ?? '') ?></td>
            <td><?= (int)($r['Nombre de participants'] ?? 0) ?></td>
            <td><?= htmlspecialchars($r['Escape'] ?? '') ?></td>
            <td>
              <a href="index.php?action=commande&amp;id_client=<?= (int)($r['id_client'] ?? 0) ?>&amp;id_version=<?= (int)($r['id_version'] ?? 0) ?>&amp;date=<?= urlencode($r['Date'] ?? '') ?>&amp;heure=<?= urlencode($r['Heure'] ?? '') ?>">Afficher</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>
