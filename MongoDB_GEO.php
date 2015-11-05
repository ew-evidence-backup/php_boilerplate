<?php
/**
 * @author: Evin Weissenberg
 * @package MongoDb Geo Radius
 * @description lets you locate points near by by with radius in miles
 * @copyright 2012
 */


class MongoDB_GEO_Radius {
    /*
     * @params float $lat
     * @params float $long
     * @params int $radius
     * @return array
     */
    public static function get_radius($lat, $long, $radius) {

        try {
            $m = new Mongo();
            $db = $m->selectDB("your_db");
            $collection = $db->your_collection;
            $collection->ensureIndex(array('loc' => '2d'));

            $radiusOfEarth = 3964; //avg radius of earth in miles
            $query = array("loc" => array('$within' => array('$centerSphere' => array(array(floatval($long), floatval($lat)), $radius / $radiusOfEarth))));

            $result = $collection->find($query); //before/changed
            $point_array = array();
            foreach ($result as $point) {
                $point_array[] = $point['point_name'];
                print_r($point);
            }
            return $point_array;
        }
        catch (MongoCursorException $e) {
            echo "error message: " . $e->getMessage() . "\n";
            echo "error code: " . $e->getCode() . "\n";
        }
    }

    public static function add_point($lat, $lon, $point_name) {
        $m = new Mongo();
        $db = $m->selectDB("your_db");
        $collection = $db->your_collection;
        $collection->insert(array("point_name" => $point_name, "loc" => array("lon" => $lon, "lat" => $lat)));
    }
}

//Usage: Add point
MongoDB_GEO_Radius::add_point(35, 36, "My point");
//Usage get points near by
$get_radius = MongoDB_GEO_Radius::get_radius(34.0522342, -118.2436849, 15);
print_r($get_radius);
