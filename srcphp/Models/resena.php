<?php

namespace proyecto\Models;


use PDO;
use proyecto\Auth;
use function json_encode;

class resena extends Models
{

 public $id_resena;
 public $comentario_resena;
 public $id_usuario;

    protected  $table = "resenas";
    /**
     * @var array
     */
    protected $filleable = [
        "comentario_resena","id_usuario"
    ];

}