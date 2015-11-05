<?php
/**
 * @author Evin Weissenberg
 */
class Serialize {

    private $subject; //object or array
    private $utf8;

    const CHARSET = 'default_charset';
    const ENCODING = 'UTF-8';

    private function __constructor() {

        $this->utf8 = ini_set(self::CHARSET, self::ENCODING);

    }

    public function setSubject($subject) {

        $this->subject = $subject;
        return $this;

    }

    public function serialize() {

        $serialize = base64_encode(serialize($this->subject));
        return $serialize;

    }


    public function unSerialize() {

        $un_serialize = base64_decode(unserialize($this->subject));
        return $un_serialize;

    }

    private function __destructor() {

        unset($this->subject);
        unset($this->utf8);

    }
}
//Usage
//$array=array('Car','red','Boat'=>'white');
//$obj = new Serialize();
//$serialize = $obj->setSubject($array)->serialize();
//print_r($serialize);