<?php

use App\Db\Categoria;
use App\Utils\Validaciones;

session_start();
require __DIR__ . "/../vendor/autoload.php";

$categorias = Categoria::read();

if (isset($_POST['nombre'])) {
    // A sanear campos
    $nombre = Validaciones::sanearCadenas($_POST['nombre']);
    $descripcion = Validaciones::sanearCadenas($_POST['descripcion']);
    $categoria_id = Validaciones::sanearCadenas($_POST['categoria_id']);
    
    // Estas dos opciones son válidas, usaremos la segunda.
    // $disponible = (isset($_POST['disponible'])) ? Validaciones::sanearCadenas($_POST['disponible']) : -1;
    
    $disponible = ($_POST['disponible']) ?? -1; // Esto es como el operador ternario pero más corto
    Validaciones::sanearCadenas($disponible);

    $errores = false;

    $ids = Categoria::devolverArrayId();
    if (!Validaciones::isLongitudValida('nombre', $nombre, 3, 40)) {
        $errores = true;
    }
    if (!Validaciones::isLongitudValida('descripcion', $descripcion, 3, 100)) {
        $errores = true;
    }
    if (!Validaciones::disponibleValido($disponible)) {
        $errores = true;
    }
    if (!Validaciones::idValido($categoria_id)) {
        $errores = true;
    }

    if ($errores) {
        header("Location: nuevo.php");
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <!-- CDN sweetalert2 -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- CDN Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- CDN FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body class="bg-purple-200 p-8">
    <h3 class="py-2 text-center text-xl">Añadir Nuevo Articulo</h3>
    <div class="w-1/2 mx-auto border-2 rounded-xl p-4 shadow-xl border-black">
        <form method="POST" action="nuevo.php">
            <div class="mb-4">
                <label for="nombre" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre del Artículo</label>
                <input type="text" id="nombre" name="nombre" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <?php Validaciones::pintarErrores('err_nombre') ?>
            </div>
            <div class="mb-4">
                <label for="descripcion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción del Artículo</label>
                <textarea id="descripcion" name="descripcion" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                <?php Validaciones::pintarErrores('err_descripcion') ?>

            </div>
            <div class="mb-4">
                <label for="categoria_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Categoría del Artículo</label>
                <select id="categoria_id" name="categoria_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option>___ ELIGE UNA CATEGORÍA ___</option>
                    <?php
                    foreach ($categorias as $item) {
                        echo <<< TXT
                                <option value="{$item->id}">{$item->nombre}</option>
                            TXT;
                    }
                    ?>
                </select>
                <?php Validaciones::pintarErrores('err_id') ?>

            </div>
            <div class="mb-4">
                Disponibilidad del Artículo
            </div>
            <div class="flex">

                <div class="flex items-center me-4">
                    <input id="si" type="radio" value="SI" name="disponible" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="si" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">SI</label>
                </div>
                <div class="flex items-center me-4">
                    <input id="no" type="radio" value="NO" name="disponible" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="no" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">NO</label>
                </div>
            </div>
            <?php Validaciones::pintarErrores('err_disponible') ?>

            <div class="flex flex-row-reverse mb-2">
                <button type="submit" class="font-bold text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <i class="fas fa-save mr-2"></i>GUARDAR
                </button>
                <button type="reset" class="mr-2 font-bold text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <i class="fas fa-paintbrush mr-2"></i>RESET
                </button>
                <a href="articulos.php" class="mr-2 font-bold text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <i class="fas fa-home mr-2"></i>VOLVER
                </a>
            </div>
        </form>

    </div>
</body>

</html>