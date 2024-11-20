<?php

use App\Db\Articulo;

session_start();

require __DIR__ . "/../vendor/autoload.php";

$articulos = Articulo::read();
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

<body class="bg-teal-200 p-8">
    <h3 class="py-2 text-center text-xl">Listado de Articulos</h3>
    <div class="flex flex-row-reverse mb-2">
        <a href="nuevo.php" class="p-2 rounded-xl bg-green-500 hover:bg-green-700">
            <i class="fas fa-add mr-3"></i>NUEVO
        </a>
    </div>
    <!-- Tabla Artículos -->
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        NOMBRE
                    </th>
                    <th scope="col" class="px-6 py-3">
                        DESCRIPCIÓN
                    </th>
                    <th scope="col" class="px-6 py-3">
                        CATEGORÍA
                    </th>
                    <th scope="col" class="px-6 py-3">
                        DISPONIBLE
                    </th>
                    <th scope="col" class="px-6 py-3">
                        ACCIONES
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($articulos as $item) {
                    echo <<< TXT
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {$item->nombre}
                            </th>
                            <td class="px-6 py-4">
                                {$item->descripcion}
                            </td>
                            <td class="px-6 py-4">
                                {$item->nomcat}
                            </td>
                            <td class="px-6 py-4">
                                {$item->disponible}
                            </td>
                            <td class="px-6 py-4">
                                ACCIONES
                            </td>
                        </tr>
                    TXT;
                }

                ?>
                
            </tbody>
        </table>
        <!-- Fin Tabla Artículos -->
    </div>

</body>

</html>