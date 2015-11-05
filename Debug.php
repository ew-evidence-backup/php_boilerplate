<?php

/**
 * @author Evin Weissenberg
 */
class Debug {

    private $variable;
    private $title;

    function setVariable($variable) {

        $this->variable = $variable;
        return $this;

    }

    function setTitle($title) {

        $this->title = (string)$title;
        return $this;
    }

    function debug() {

        print('<pre style="color:green;">');
        print("<h1>" . $this->title . "</h1>");
        print_r($this->variable);
        print('</pre>');

    }

    function __destruct() {

        unset($this->variable);

    }
}
//Usage
//(new Debug())->setTitle('My Var')->setVariable($_REQUEST)->debug();



