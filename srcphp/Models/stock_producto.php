<?php

namespace proyecto\Models;


use PDO;
use proyecto\Auth;
use function json_encode;

class stock_producto extends Models
{

 public $id;
 public $ingreso_stock;
 public $fecha_ingreso_stock;
 public $id_producto;

    protected  $table = "stock_productos";
    /**
     * @var array
     */
    protected $filleable = [
        "ingreso_stock","fecha_ingreso_stock", "id_producto"
    ];

}