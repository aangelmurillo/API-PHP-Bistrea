<?php

namespace proyecto\Models;


use PDO;
use proyecto\Auth;
use function json_encode;

class pedidos_clientes extends Models
{

 public $id_pedido_cliente;
 public $id_pedido;
 public $id_usuario;

    protected  $table = "pedidos_clientes";
    /**
     * @var array
     */
    protected $filleable = [
        "id_pedido","id_usuario"
    ];

}