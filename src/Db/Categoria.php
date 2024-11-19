<?php

namespace App\Db;

use PDO;
use PDOException;

require __DIR__."/../../vendor/autoload.php";

class Categoria extends Conexion {
    private int $id;
    private string $nombre;
    
    public function create() : void {
        $q = "insert into categorias(nombre) values (:n)";
        $stmt = parent::getConexion()->prepare($q);

        try {
            $stmt->execute([
                ':n' => $this->nombre
            ]);
        } catch (PDOException $ex) {
            throw new PDOException("Error en el create: " . $ex->getMessage(), -1);
        } finally {
            parent::cerrarConexion();
        }
    }

    public static function crearRegistrosRandom() : void {
        $categorias=['Bazar', 'Alimentación', 'Miscelanea', 'Limpieza', 'Informática'];
        sort($categorias);
        foreach($categorias as $item) {
            (new Categoria)
            ->setNombre($item)
            ->create();
        }
    }

    public static function devolverArrayId() : array {
        $q = "select id from categorias";
        $stmt = parent::getConexion()->prepare($q);

        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            throw new PDOException("Error en el devolverArrayId: " . $ex->getMessage(), -1);
        } finally {
            parent::cerrarConexion();
        }

        $ids = [];
        while ($fila = $stmt->fetch(PDO::FETCH_OBJ)) {
            $ids[] = $fila->id;
        }

        return $ids;
    }

    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nombre
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     */
    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }
}