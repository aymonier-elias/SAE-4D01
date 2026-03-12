<?php
$cssLink = '<link href="style/utilisateurs.css" rel="stylesheet">';

$utilisateurs = $utilisateurs ?? array();
$estAdmin = isset($_SESSION['statut']) && $_SESSION['statut'] == 2;
?>
<section class="content gestion-utilisateurs">
    <div class="titre_page">
        <h2>Gestion des utilisateurs</h2>
        <span class="separator"></span>
    </div>

    <?php if (empty($utilisateurs)): ?>
        <p class="msg-empty">Aucun utilisateur.</p>
    <?php else: ?>
        <table class="table-utilisateurs">
            <thead>
                <tr>
                    <?php foreach (array_keys($utilisateurs[0]) as $cle): ?>
                        <th><?= htmlspecialchars($cle) ?></th>
                    <?php endforeach; ?>
                    <?php if ($estAdmin): ?>
                        <th>Actions</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($utilisateurs as $u): ?>
                    <tr>
                        <?php foreach ($u as $cle => $valeur): ?>
                            <td><?= htmlspecialchars($valeur ?? '') ?></td>
                        <?php endforeach; ?>
                        <?php if ($estAdmin): ?>
                            <td>
                                <?php
                                $id = $u['N° Utilisateur'] ?? '';
                                if ($id !== '' && $id != ($_SESSION['id_utilisateur'] ?? 0)):
                                ?>
                                    <a href="index.php?action=supprimerUtilisateur&amp;id_utilisateur=<?= (int)$id ?>" class="btn-supprimer" onclick="return confirm('Supprimer cet utilisateur ?');">Supprimer</a>
                                <?php else: ?>
                                    <span class="vous">Vous</span>
                                <?php endif; ?>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>
