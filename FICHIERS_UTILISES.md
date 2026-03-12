# Fichiers utilisés / non utilisés — SAE Lock Out

## Fichiers PHP utilisés par l'application

### Contrôleurs (tous utilisés)
- `controleur/Routeur.class.php` — point d'entrée des actions
- `controleur/CtlEscape.class.php` — missions, détail, gestion admin
- `controleur/CtlReservation.class.php` — panier, commandes, favoris
- `controleur/CtlUtilisateur.class.php` — connexion, profil, gestion users
- `controleur/CtlPage.class.php` — accueil, concept, contact, erreur

### Vues utilisées (appelées via Vue("Nom"))
- `vue/vueAccueil.php`
- `vue/vueConcept.php`
- `vue/vueContact.php`
- `vue/vueConnexion.php`
- `vue/vueInscription.php`
- `vue/vueErreur.php`
- `vue/vueProfil.php`
- `vue/vueUtilisateurs.php`
- `vue/vueEscapes.php`
- `vue/vueEscape.php`
- `vue/vueGestionEscapes.php`
- `vue/vueFormulaireAjoutEscape.php`
- `vue/vueFormulaireModifierEscape.php`
- `vue/vueReservations.php` — liste panier / favoris / gestion commandes
- `vue/vueReservation.php` — détail d'une commande ou réservation
- `vue/vueRecapCommande.php`
- `vue/vueConfirmationCommande.php`

### Vues supprimées (doublons)
- `vue/vueCommande.php` et `vue/vueCommandes.php` ont été supprimées (remplacées par vueReservation.php et vueReservations.php).

### Modèles (tous utilisés)
- `modele/database.class.php`
- `modele/escape.class.php`
- `modele/reservation.class.php`
- `modele/utilisateur.class.php`
- `modele/favori.class.php`
- `modele/avis.class.php`

### Includes
- `vue/vue.class.php` — chargement des vues
- `vue/gabarit.php` — layout commun
- `includes/default_config.php` — menus, config
- `config/config.class.php` — paramètres BDD, constantes
- `includes/html/tableau.class.php` — utilisé dans vueEscapes.php
- `includes/html/formulaire.class.php` — **non utilisé** dans le projet actuel

### Point d'entrée
- `index.php` — charge config + Routeur
