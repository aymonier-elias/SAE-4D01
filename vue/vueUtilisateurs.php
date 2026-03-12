<?php
/** Vue : liste des utilisateurs (admin) avec suppression. */
$cssLink = '<link href="style/utilisateurs.css" rel="stylesheet">';
$utilisateurs = $utilisateurs ?? array();
$estAdmin = isset($_SESSION['statut']) && $_SESSION['statut'] == 2;
$fil_ariane = array(
    array('label' => 'Accueil', 'url' => 'index.php'),
    array('label' => 'Gestion des utilisateurs'),
);
?>
<?php require_once __DIR__ . '/../includes/html/fil_ariane.php'; ?>
<section class="content gestion-utilisateurs">
    <div class="titre_page">
        <h2 data-i18n="page-gestion-utilisateur.titre">Gestion des utilisateurs</h2>
        <span class="separator"></span>
    </div>
    <?php
    if (empty($utilisateurs)) {
        echo '<p class="msg-empty" data-i18n="page-gestion-utilisateur.pas-utilisateur">Aucun utilisateur.</p>';
    } else {
        require_once __DIR__ . '/../includes/html/tableau.class.php';
        $entetes = array_keys($utilisateurs[0]);
        if ($estAdmin) {
            $entetes[] = 'Actions';
        }
        $lignes = array();
        foreach ($utilisateurs as $u) {
            $row = array();
            foreach ($u as $valeur) {
                $row[] = htmlspecialchars($valeur ?? '');
            }
            if ($estAdmin) {
                $id = $u['N° Utilisateur'] ?? '';
                if ($id !== '' && $id != ($_SESSION['id_utilisateur'] ?? 0)) {
                    $row[] = '<a href="index.php?action=supprimerUtilisateur&amp;id_utilisateur=' . (int)$id . '" class="btn-supprimer" onclick="return confirm(\'Supprimer cet utilisateur ?\');" data-i18n="page-gestion-utilisateur.suppr">Supprimer</a>';
                } else {
                    $row[] = '<span class="vous" data-i18n="page-gestion-utilisateur.vous">Vous</span>';
                }
            }
            $lignes[] = $row;
        }
        echo Tableau::head($entetes, 'table-utilisateurs');
        echo Tableau::body($lignes);
        echo Tableau::foot();
    }
    ?>
</section>
