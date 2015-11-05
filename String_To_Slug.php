<?php

/**
 * @author Evin Weissenberg
 */
class String_To_Slug {

    private $string;

    public function setString($string) {

        $this->string = (string)$string;
        return $this;

    }

    function slug() {

        $this->string = strtolower(trim($this->string));
        $this->string = preg_replace('/[^a-z0-9-]/', '-', $this->string);
        $this->string = preg_replace('/-+/', "-", $this->string);

        return $this->string;

    }

    function __destruct() {

        unset($this->string);

    }
}

//Usage
//$s = (new String_To_Slug)->setString('This is my string')->slug();
//print_r($s);