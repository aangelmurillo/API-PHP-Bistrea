<?php

namespace proyecto\Models;

use PDO;
use proyecto\Conexion;
use Dotenv\Dotenv;

class Table
{
    public static $pdo = null;
    public function __construct()
    {

    }
    static function getDataconexion()
    {




    }
    static function query($query)
    {
        // Es la cadena de conexion, nombre de la base de datos, ip, usuario, contraseña
        $cc = new Conexion("cafeteria", "localhost", "Angel", "12345");
        self::$pdo = $cc->getPDO();
        $stmt = self::$pdo->query($query);
        $resultados = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $resultados;
    }
    static function queryParams($query, $params = [])
    {
        $cc = new Conexion("cafeteria", "localhost", "Angel", "12345");
        self::$pdo = $cc->getPDO();

        $stmt = self::$pdo->prepare($query);

        $stmt->execute($params);

        $resultados = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $resultados;
    }

}
