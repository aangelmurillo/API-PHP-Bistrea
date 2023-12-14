<?php

namespace proyecto\Models;


use PDO;
use proyecto\Auth;
use function json_encode;

class resena extends Models
{

 public $id;
 public $comentario_resena;
 public $calificacion;
 public $id_usuario;

    protected  $table = "resenas";
    /**
     * @var array
     */
    protected $filleable = [
        "comentario_resena","calificacion","id_usuario"
    ];

}