<?php

namespace proyecto\Models;


use PDO;
use proyecto\Auth;
use function json_encode;

class detalle_pedido_pe extends Models
{

 public $id_detalle_pedido_pe;
 public $precio_pe;
 public $id_detalle_pedido;
 public $id_producto_extra;

    protected  $table = "detalles_pedido_pe";
    /**
     * @var array
     */
    protected $filleable = [
        "precio_pe","id_detalle_pedido", "id_producto_extra"
    ];

}