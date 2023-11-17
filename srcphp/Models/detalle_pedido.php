<?php

namespace proyecto\Models;


use PDO;
use proyecto\Auth;
use function json_encode;

class detalle_pedido extends Models
{

 public $id_detalle_pedido;
 public $cantidad_producto;
 public $precio_unitario;
 public $id_producto;
 public $tipo_pago_pedido;
 public $subtotal_pedido;
 public $id_pedido;

    protected  $table = "detalles_pedido";
    /**
     * @var array
     */
    protected $filleable = [
        "cantidad_producto","precio_unitario", "id_producto",
        "tipo_pago_pedido", "subtotal_pedido", "id_pedido"
    ];

}