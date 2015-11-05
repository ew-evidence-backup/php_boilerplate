<?php

/**
 * @author: Evin Weissenberg
 * @description: Pixel walk for every random iteration
 */

//Pixel Walk
$x = 500;
$y = 150;
$im = imagecreatetruecolor($x,$y);
for($i = 0; $i < $x; $i++) {
    for($j = 0; $j < $y; $j++) {
        $color = imagecolorallocate($im, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255));
        imagesetpixel($im, $i, $j, $color);
    }
}
header('Content-Type: image/png');
imagepng($im);