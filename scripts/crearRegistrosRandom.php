<?php

use App\Db\Categoria;
use App\Db\Articulo;

$cantidad = 0;

do {
    $cantidad = readline("Indique el número de artículos a crear: (Escriba 0 para salir) ");
    if ($cantidad == 0) {
        echo "Saliendo.";
        break;
    }
    if ($cantidad < 5 || $cantidad > 50) {
        echo "Error, tiene que crear entre 5 y 30 artículos. Recuerde, 0 para salir.";
    }
} while (($cantidad < 5 || $cantidad > 50) && ($salir = false));

if($cantidad != 0) {
    require __DIR__."/../vendor/autoload.php";
    Categoria::crearRegistrosRandom();
    Articulo::crearArticulosRandom($cantidad);
    echo "Se han creado $cantidad artículos.".PHP_EOL;
}
