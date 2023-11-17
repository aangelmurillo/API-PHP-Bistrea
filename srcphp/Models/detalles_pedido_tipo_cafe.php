<?php

namespace proyecto\Models;


use PDO;
use proyecto\Auth;
use function json_encode;

class detalles_pedido_tipo_cafe extends Models
{

 public $id_detalles_pedido_tp;
 public $nom_cafe;
 public $id_detalle_pedido;
 public $id_tipo_cafe;

    protected  $table = "detalles_pedido_tipo_cafe";
    /**
     * @var array
     */
    protected $filleable = [
        "nom_cafe","id_detalle_pedido", "id_tipo_cafe"
    ];

}