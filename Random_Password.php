<?php
/**
 * @author Evin Weissenberg
 */
class Random_Password_Generator {

    private $length = 11;
    private $type = 'a-zA-Z0-9';

    /**
     * @param $length
     * @return Random_Password_Generator
     */
    function setLength($length) {

        $this->length = (string)$length;
        return $this;
    }

    /**
     * @param $type
     * @return Random_Password_Generator
     */
    function setType($type) {

        $this->type = (string)$type;
        return $this;
    }

    /**
     * @return null|string
     */
    function generate() {

        $return = $chars = null;

        if (strstr($this->type, 'a-z'))
            $chars .= 'abcdefghijklmnopqrstuvwxyz';
        if (strstr($this->type, 'A-Z'))
            $chars .= 'ABCDEFGHIJKLMNOPRQSTUVWXYZ';
        if (strstr($this->type, '0-9'))
            $chars .= '0123456789';

        for ($i = 0, $sl = strlen($chars) - 1; $i <= $this->length; $i++)

            $return .= $chars[rand(0, $sl)];

        return $return;
    }
}

/** **** Examples ****
--- We need alphanumeric string 5 chars length ---
echo rndstr(5);
--- We need lowercase letters string 10 chars length ---
echo rndstr(10, 'a-z');
--- We need lower and upper case letters string 10 chars length ---
echo rndstr(10, 'A-Za-z');
--- We need numeric string 10 chars length ---
echo rndstr(10, '0-9');
--- ect.. ---
 **/