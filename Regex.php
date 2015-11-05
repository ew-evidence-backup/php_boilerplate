<?php

/**
 * @author Evin Weissenberg
 */
class Regex {

    private $string;
    private $pattern;

    /**
     * @param $string
     * @return Regex
     */
    function setString($string) {

        $this->string = (string)$string;
        return $this;

    }

    /**
     * @return bool
     */
    function findStringBoundary() {

        if (preg_match("/" . $this->pattern . "b/i", $this->string)) {

            return true;

        } else {

            return false;

        }


    }


    /**
     * @return bool
     */
    function findStringCaseInsensitive() {

        if (preg_match("/" . $this->pattern . "/i", $this->string)) {

            return true;

        } else {

            return false;

        }
    }

    /**
     * @return bool
     */
    function findStringCaseSensitive() {

        if (preg_match("/" . $this->pattern . "/", $this->string)) {

            return true;

        } else {

            return false;

        }
    }

    /**
     * @return bool
     */
    function findDomain() {

        if (preg_match('@^(?:http://)?([^/]+)@i', $this->string)) {

            return true;

        } else {

            return false;

        }
    }

    /**
     * @return int
     */
    function checkIfValidIp() {
        return preg_match("/^([1-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])" .
            "(\.([0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])){3}$/", $this->string);
    }
}