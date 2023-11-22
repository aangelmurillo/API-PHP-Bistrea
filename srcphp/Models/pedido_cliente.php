<?php

namespace proyecto\Models;


use PDO;
use proyecto\Auth;
use function json_encode;

class pedido_cliente extends Models
{

 public $id;
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