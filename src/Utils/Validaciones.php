<?php

namespace App\Utils;

use App\Db\Categoria;

class Validaciones {
    public static function sanearCadenas(string $cadena) : string {
        return htmlspecialchars(trim($cadena));
    }

    public static function isLongitudValida(string $nomCampo, string $valor, int $min, int $max) : bool {
        if (strlen($valor) < $min || strlen($valor) > $max) {
            $_SESSION["err_$nomCampo"] = "*** Error, el $nomCampo debe tener entre $min y $max caracteres. ***";
            return false;
        }
        return true;
    }

    public static function disponibleValido(string $valor) : bool {
        if (!in_array($valor, Datos::getDisponibles())) {
            $_SESSION['err_disponible'] = "*** ERROR, disponible solo puede tomar como valores SI o NO. ***";
            return false;
        }
        return true;
    }

    public static function idValido(string $valor) : bool {
        $categorias = Categoria::devolverArrayId();
        if (!in_array($valor, $categorias)) {
            $_SESSION['err_id'] = "*** ERROR, el id proporcionado no se corresponde con ninguna categoría. ***";
            return false;
        }
        return true;
    }

    public static function pintarErrores(string $nomCampo) {
        if (isset($_SESSION[$nomCampo])) {
            echo "<p class='mt-2 text-red-500 text-sm italic'>{$_SESSION[$nomCampo]}</p>";
        }
    }
}