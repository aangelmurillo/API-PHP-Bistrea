<?php

namespace proyecto\Models;


use PDO;
use proyecto\Auth;
use function json_encode;

class productos_extra extends Models
{

 public $id_producto_extra;
 public $nombre_pe;
 public $precio_unitario_pe;

    protected  $table = "productos_extra";
    /**
     * @var array
     */
    protected $filleable = [
        "nombre_pe","precio_unitario_pe"
    ];

}
