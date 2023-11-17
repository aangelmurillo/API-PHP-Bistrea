<?php

namespace proyecto\Models;


use PDO;
use proyecto\Auth;
use function json_encode;

class stock_productos extends Models
{

 public $id_stock;
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