<?php

namespace proyecto\Models;


use PDO;
use proyecto\Auth;
use function json_encode;

class tipo_cafe extends Models
{

 public $id;
 public $tipo_cafe;

    protected  $table = "tipos_cafe";
    /**
     * @var array
     */
    protected $filleable = [
        "tipo_cafe"
    ];

}
