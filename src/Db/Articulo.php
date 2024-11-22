<?php

namespace App\Db;

use App\Utils\Datos;
use PDO;
use PDOException;
use stdClass;

class Articulo extends Conexion {
    private int $id;
    private string $nombre;
    private string $descripcion;
    private string $disponible;
    private int $categoria_id;

    public function create() : void {
        $q = "insert into articulos(nombre, descripcion, disponible, categoria_id) values (:n, :d, :di, :c)";
        $stmt = parent::getConexion()->prepare($q);

        try {
            $stmt->execute([
                ':n' => $this->nombre,
                ':d' => $this->descripcion,
                ':di' => $this->disponible,
                ':c' => $this->categoria_id
            ]);
        } catch (PDOException $ex) {
            throw new PDOException("Error en el create: " .$ex->getMessage(), -1);
        } finally {
            parent::cerrarConexion();
        }
    }

    public static function read(?int $id = null) : array {
        $q = ($id === null) ? "select articulos.*, categorias.nombre as nomcat from articulos, categorias where (categoria_id = categorias.id) order by nomcat"
        : "select * from articulos where (id = :i)";
        $stmt = parent::getConexion()->prepare($q);

        try {
            ($id === null) ? $stmt->execute() : $stmt->execute([':i' => $id]);
        } catch (PDOException $ex) {
            throw new PDOException("Error en el read: " .$ex->getMessage(), -1);
        } finally {
            parent::cerrarConexion();
        }

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function delete(int $id) : void {
        $q = "delete from articulos where id = :i";
        $stmt = parent::getConexion()->prepare($q);

        try {
            $stmt->execute([
                ':i' => $id
            ]);
        } catch (PDOException $ex) {
            throw new PDOException("Error en el delete: " . $ex->getMessage(), -1);
        } finally {
            parent::cerrarConexion();
        }
    }

    public function update(int $id) : void {
        $q = "update articulos set nombre=:n, descripcion=:d, disponible=:di, categoria_id=:c where id=:i";
        $stmt = parent::getConexion()->prepare($q);

        try {
            $stmt->execute([
                ':n' => $this->nombre,
                ':d' => $this->descripcion,
                ':di' => $this->disponible,
                ':c' => $this->categoria_id,
                ':i' => $id
            ]);
        } catch (PDOException $ex) {
            throw new PDOException("Error en el create: " .$ex->getMessage(), -1);
        } finally {
            parent::cerrarConexion();
        }
    }

    public static function getArticuloById(int $id) : false|stdClass {
        $q = "select * from articulos where (id = :i)";
        $stmt = parent::getConexion()->prepare($q);

        try {
            $stmt->execute([':i' => $id]);
        } catch (PDOException $ex) {
            throw new PDOException("Error en el getArticuloById: " .$ex->getMessage(), -1);
        } finally {
            parent::cerrarConexion();
        }

        $articulo = $stmt->fetch(PDO::FETCH_OBJ);
        return $articulo;
    }



    public static function existeNombre(string $nombre, ?int $id = null) : bool {
        $q = ($id === null) ? "select count(*) as total from articulos where nombre=:n" : "select count(*) as total from articulos where nombre=:n AND id <> :i";
        $stmt = parent::getConexion()->prepare($q);

        try {
            ($id === null) ? $stmt->execute([
                ':n' => $nombre
            ]) :
            $stmt->execute([
                ':n' => $nombre,
                ":i" => $id
            ])
            ;
        } catch (PDOException $ex) {
            throw new PDOException("Error en el existeNombre: " . $ex->getMessage(), -1);
        } finally {
            parent::cerrarConexion();
        }

        $filas = $stmt->fetchAll(PDO::FETCH_OBJ)[0]->total;
        return $filas; // En php 0 lo interpreta como false y lo demás, como true.
    }

    public static function crearArticulosRandom(int $cantidad) : void {
        $faker = \Faker\Factory::create("es_ES");
        $categoriasID = Categoria::devolverArrayId();

        for ($i = 0 ; $i < $cantidad ; $i++) {
            $nombre = ucwords($faker->unique()->words(random_int(2,3), true));
            $descripcion = $faker->text();
            $disponible = $faker->randomElement(Datos::getDisponibles());
            $categoria_id = $faker->randomElement($categoriasID);

            (new Articulo)
            ->setNombre($nombre)
            ->setDescripcion($descripcion)
            ->setDisponible($disponible)
            ->setCategoriaId($categoria_id)
            ->create();
        }
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

    /**
     * Get the value of descripcion
     */
    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    /**
     * Set the value of descripcion
     */
    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get the value of categorio_id
     */
    public function getCategoriaId(): int
    {
        return $this->categoria_id;
    }

    /**
     * Set the value of categorio_id
     */
    public function setCategoriaId(int $categoria_id): self
    {
        $this->categoria_id = $categoria_id;

        return $this;
    }

    /**
     * Get the value of disponible
     */
    public function getDisponible(): string
    {
        return $this->disponible;
    }

    /**
     * Set the value of disponible
     */
    public function setDisponible(string $disponible): self
    {
        $this->disponible = $disponible;

        return $this;
    }
}