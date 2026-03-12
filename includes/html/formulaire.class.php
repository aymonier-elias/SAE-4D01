<?php
/**
 * Génération de champs de formulaire HTML (inputs, textarea, hidden, submit).
 * Les valeurs par défaut sont fournies via le constructeur pour pré-remplir les champs.
 */
class Formulaire {

    /** Données pré-remplies pour les champs (ex. après erreur de validation) */
    private $values;

    /**
     * @param array $data Valeurs initiales des champs (clé = name, valeur = value)
     */
    public function __construct($data = array()) {
        $this->values = $data;
    }

    /**
     * Retourne la valeur d'un champ à partir du tableau $values.
     */
    private function getValue($key) {
        return $this->values[$key] ?? "";
    }

    /**
     * Génère un champ input générique (text, email, etc.) avec label et option required.
     */
    private function input($type, $name, $label = "", $required = false) {
        $req = $required ? " required" : "";
        $val = htmlspecialchars($this->getValue($name));
        return "<label class='form-group'><span>" . htmlspecialchars($label) . "</span>" .
            "<input type='" . htmlspecialchars($type) . "' class='form-input' name='" . htmlspecialchars($name) . "' value='" . $val . "'" . $req . "></label>";
    }

    /** Génère un champ texte (type="text"). */
    public function inputText($name, $label = "", $required = false) {
        return $this->input("text", $name, $label, $required);
    }

    /** Génère un champ email (type="email"). */
    public function inputEmail($name, $label = "", $required = false) {
        return $this->input("email", $name, $label, $required);
    }

    /** Génère un champ mot de passe (type="password", sans pré-remplissage). */
    public function inputPassword($name, $label = "", $required = false) {
        $req = $required ? " required" : "";
        return "<label class='form-group'><span>" . htmlspecialchars($label) . "</span>" .
            "<input type='password' class='form-input' name='" . htmlspecialchars($name) . "'" . $req . "></label>";
    }

    /** Génère une zone de texte (textarea) avec label. */
    public function textarea($name, $label = "", $required = false) {
        $req = $required ? " required" : "";
        $val = htmlspecialchars($this->getValue($name));
        return "<label class='form-group'><span>" . htmlspecialchars($label) . "</span>" .
            "<textarea class='form-input' name='" . htmlspecialchars($name) . "'" . $req . ">" . $val . "</textarea></label>";
    }

    /** Génère un champ caché (input type="hidden") pour transmettre une valeur. */
    public function hidden($name, $value) {
        return "<input type='hidden' name='" . htmlspecialchars($name) . "' value='" . htmlspecialchars($value) . "'>";
    }

    /** Génère un bouton de soumission du formulaire. */
    public function submit($name, $label = "Valider", $class = "btn-primary") {
        return "<button type='submit' class='" . htmlspecialchars($class) . "' name='" . htmlspecialchars($name) . "'>" . htmlspecialchars($label) . "</button>";
    }
}



