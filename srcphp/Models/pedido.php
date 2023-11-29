<?php

namespace proyecto\Models;


use PDO;
use proyecto\Auth;
use function json_encode;
use proyecto\Response\Success;
use proyecto\Response\Failure;
class pedido extends Models
{

 public $id;
 public $fecha_realizado_pedido;
 public $hora_realizado_pedido;
 public $hora_entrega_pedido;
 public $estado_pedido;
 public $info_pedido;
 public $op_pedido;
 public $id_empleado;
 public $nombre_cliente_pedido;
 public $total_pedido;

    protected  $table = "pedidos";
    /**
     * @var array
     */
    protected $filleable = [
        "fecha_realizado_pedido","hora_realizado_pedido", "hora_entrega_pedido",
        "estado_pedido", "info_pedido", "op_pedido", "id_empleado",
        "nombre_cliente_pedido", "total_pedido"
    ];

}