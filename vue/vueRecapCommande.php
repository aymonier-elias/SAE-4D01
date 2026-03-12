<?php
/** Vue : récapitulatif du panier avant paiement (tunnel de commande). */
$cssLink = '<link href="style/style.css" rel="stylesheet"><link href="style/escapes.css" rel="stylesheet">';
$panier = $panier ?? array();
$total = (int)($total ?? 0);
$client = $client ?? array();
$titre = "Récapitulatif de la commande";
$fil_ariane = array(
    array('label' => 'Accueil', 'url' => 'index.php'),
    array('label' => 'Mon panier', 'url' => 'index.php?action=panier'),
    array('label' => 'Récapitulatif'),
);
?>
<?php require_once __DIR__ . '/../includes/html/fil_ariane.php'; ?>
<section class="content recap-commande">
    <h2><?= htmlspecialchars($titre) ?></h2>
    <?php
    if (empty($panier)) {
        echo '<p class="msg-empty">Votre panier est vide. <a href="index.php?action=escapes">Choisir une mission</a></p>';
        echo '<p><a href="index.php?action=panier" class="btn-retour">← Retour au panier</a></p>';
    } else {
        ?>
        <div class="block-recap-client">
            <h3>Coordonnées</h3>
            <p><strong><?= htmlspecialchars($client['prenom'] ?? '') ?> <?= htmlspecialchars($client['nom'] ?? '') ?></strong></p>
            <p><?= htmlspecialchars($client['mail'] ?? '') ?></p>
            <?php
            if (!empty($client['adresse']) || !empty($client['ville'])) {
                echo '<p>' . htmlspecialchars($client['adresse'] ?? '') . ' ' . htmlspecialchars($client['ville'] ?? '') . '</p>';
            }
            ?>
        </div>
        <?php
            require_once __DIR__ . '/../includes/html/tableau.class.php';
            $entetes = array('Escape', 'Pack', 'Date', 'Heure', 'Participants', 'Durée', 'Prix unitaire', 'Sous-total');
            $lignes = array();
            foreach ($panier as $ligne) {
                $dur = $ligne['durée'] ?? '';
                $lignes[] = array(
                    htmlspecialchars($ligne['Escape'] ?? ''),
                    htmlspecialchars($ligne['Pack'] ?? ''),
                    htmlspecialchars($ligne['Date'] ?? ''),
                    htmlspecialchars($ligne['Heure'] ?? ''),
                    (int)($ligne['Nombre de participants'] ?? 0),
                    htmlspecialchars($dur),
                    (int)($ligne['prix'] ?? 0) . ' €',
                    (int)($ligne['total_ligne'] ?? 0) . ' €'
                );
            }
            echo Tableau::head($entetes, 'table-recap');
            echo Tableau::body($lignes);
            echo '<tfoot><tr><td colspan="7"><strong>Total</strong></td><td><strong>' . (int)$total . ' €</strong></td></tr></tfoot></table>';
        ?>
        <p class="aide-paiement">Paiement fictif : en cliquant sur « Payer », votre commande sera enregistrée.</p>
        <form method="post" action="index.php?action=confirmer_paiement" class="form-paiement">
            <div class="block-carte">
                <h3>Carte bancaire</h3>
                <div class="champs-carte">
                    <label for="carte-numero">Numéro de carte
                        <input type="text" id="carte-numero" name="carte_numero" placeholder="1234 5678 9012 3456" maxlength="19" pattern="[0-9\s]*" inputmode="numeric" autocomplete="cc-number">
                    </label>
                    <label for="carte-expiration">Date d'expiration (MM/AA)
                        <input type="text" id="carte-expiration" name="carte_expiration" placeholder="MM/AA" maxlength="5" pattern="[0-9/]*" inputmode="numeric" autocomplete="cc-exp">
                    </label>
                    <label for="carte-cvv">CVV
                        <input type="text" id="carte-cvv" name="carte_cvv" placeholder="123" maxlength="4" pattern="[0-9]*" inputmode="numeric" autocomplete="cc-csc">
                    </label>
                    <label for="carte-titulaire">Titulaire de la carte
                        <input type="text" id="carte-titulaire" name="carte_titulaire" placeholder="Nom sur la carte" autocomplete="cc-name">
                    </label>
                </div>
            </div>
            <button type="submit" class="btn-payer">Payer (fictif)</button>
        </form>
        <p><a href="index.php?action=panier" class="btn-retour">← Retour au panier</a></p>
    <?php
    }
    ?>
</section>
