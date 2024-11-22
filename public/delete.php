<?php

use App\Db\Articulo;

session_start();

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (!$id || $id <= 0) {
    header("Location:articulo.php");
    exit;
}

require __DIR__ . "/../vendor/autoload.php";


// Esto es innecesario ya que no pasa nada si intentan borrar un id que no existe en la base de datos
// $articulos = Articulo::read($id);

// if (count($articulos) == 0) {
//     header("Location:articulo.php");
//     exit;
// }

Articulo::delete($id);
$_SESSION['mensaje'] = "Artículo Borrado Correctamente.";
header("Location: articulo:php");