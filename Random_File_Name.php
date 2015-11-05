<?php

/**
 * @author Evin Weissenberg
 */

class Random_File_Name_Generator {

    private $salt='o00o';

    /**
     * @return string
     */
    function generate() {

        $date_time = date('Y-m-d-H:i:s');
        $random = rand(1, 1000);
        $salt_and_pepper = $this->salt;
        $combo = $date_time . $random . $salt_and_pepper;
        $hash = md5($combo);

        return $hash;
    }

}
