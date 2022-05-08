<?php

namespace App\Helpers;

class DataManipulationHelper {

    public static function turnArraytoJson($array)
    {
        return json_decode(json_encode($array));
    }
}
