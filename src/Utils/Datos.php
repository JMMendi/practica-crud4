<?php

namespace App\Utils;

require __DIR__."/../../vendor/autoload.php";

class Datos {
    public static function getDisponibles() : array {
        return ['SI', 'NO'];
    }
}