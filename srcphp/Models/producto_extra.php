<?php

namespace proyecto\Models;


use PDO;
use proyecto\Auth;
use function json_encode;

class producto_extra extends Models
{

 public $id;
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
