<?php

class Formulaire {

    private $values;

    public function __construct($data = array()) {
        $this->values = $data;
    }

    private function getValue($key) {
        return $this->values[$key] ?? "";
    }

    private function input($type, $name, $label = "", $required = false) {
        $req = $required ? " required" : "";
        $val = htmlspecialchars($this->getValue($name));
        return "<label class='form-group'><span>" . htmlspecialchars($label) . "</span>" .
            "<input type='" . htmlspecialchars($type) . "' class='form-input' name='" . htmlspecialchars($name) . "' value='" . $val . "'" . $req . "></label>";
    }

    public function inputText($name, $label = "", $required = false) {
        return $this->input("text", $name, $label, $required);
    }

    public function inputEmail($name, $label = "", $required = false) {
        return $this->input("email", $name, $label, $required);
    }

    public function inputPassword($name, $label = "", $required = false) {
        $req = $required ? " required" : "";
        return "<label class='form-group'><span>" . htmlspecialchars($label) . "</span>" .
            "<input type='password' class='form-input' name='" . htmlspecialchars($name) . "'" . $req . "></label>";
    }

    public function textarea($name, $label = "", $required = false) {
        $req = $required ? " required" : "";
        $val = htmlspecialchars($this->getValue($name));
        return "<label class='form-group'><span>" . htmlspecialchars($label) . "</span>" .
            "<textarea class='form-input' name='" . htmlspecialchars($name) . "'" . $req . ">" . $val . "</textarea></label>";
    }

    public function hidden($name, $value) {
        return "<input type='hidden' name='" . htmlspecialchars($name) . "' value='" . htmlspecialchars($value) . "'>";
    }

    public function submit($name, $label = "Valider", $class = "btn-primary") {
        return "<button type='submit' class='" . htmlspecialchars($class) . "' name='" . htmlspecialchars($name) . "'>" . htmlspecialchars($label) . "</button>";
    }
}



