<?php

class Formulaire{

    private $values;


    public function __construct($data = array()) {
        $this->values = $data;
    }


     private function getValue($key) {
            return $this->values[$key] ?? "";
        }



    public function inputText($name, $label=""){
        return "
        <label class='form-group'>
            <span>$label</span>
            <input type='text' class='form-input' name='$name' value='{$this->getValue($name)}'>
        </label>";
    }

    
    public function submit($name){
        return "
        <button class='btn-primary' name='$name'>
            Valider
        </button>";
    }
}



