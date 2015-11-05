<?php
/**
 * @author:  Evin Weissenberg
 * @description: Compliant with class 2 games. Pseudo random number
 */
class RNG {

    private $range_from = Null;
    private $range_to = Null;
    private $count = Null;

    function __construct($range_from, $range_to, $count) {

        $this->range_from = (int)$range_from;
        $this->range_to = (int)$range_to;
        $this->count = (int)$count;

    }

    function createSeed() {

        list($usec, $sec) = explode(' ', microtime());
        $raw_seed = (float)$sec + ((float)$usec * 1000000);
        $seed = substr($raw_seed, -6, 3);
        return intval($seed);

    }

    function generate() {

        $numbers = array();

        mt_srand($this->createSeed());

        for ($i = 1; $i <= $this->count*10; $i++) {

            array_push($numbers, mt_rand($this->range_from, $this->range_to));

        }
        return array_slice(array_values(array_unique($numbers)),0,$this->count);
    }
}

//Usage
//$r = (new RNG(1, 50, 10))->generate();
//print_r($r);
