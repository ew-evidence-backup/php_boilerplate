<?php

/**
 * @author Evin Weissenberg
 */
class Dates {

    public $days; //Example 1
    /**
     * @return string
     */
    function todayDateDashes() {

        $date = date('m-d-Y');

        return $date;

    }

    /**
     * @return string
     */
    function todayDateBackSlash() {

        $date = date('m/d/Y');

        return $date;

    }

    /**
     * @return string
     */
    function dateInTheFuture() {

        $date = date('l jS F (m/d/Y)', strtotime("$this->days days"));

        return $date;

    }

    /**
     * @return string
     */
    function dateInThePast() {

        $date = date('l jS F (m/d/Y)', strtotime("-$this->days days"));

        return $date;

    }

    /**
     * @return string
     */
    function dateTomorrow() {

        $date = date('l jS F (m/d/Y)', strtotime("tomorrow"));

        return $date;

    }

    /**
     * @return string
     */
    function dateYesterday() {

        $date = date('l jS F (m/d/Y)', strtotime("yesterday"));

        return $date;

    }
}