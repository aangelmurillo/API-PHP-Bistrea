<?php

namespace proyecto\Models;


use PDO;
use proyecto\Auth;
use function json_encode;

class configs_carusel extends Models
{

 public $id_config_carusel;
 public $img_config_carusel;
 public $id_empleado;

    protected  $table = "configs_carusel";
    /**
     * @var array
     */
    protected $filleable = [
        "img_config_carusel","id_empleado"
    ];

}