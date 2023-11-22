<?php

namespace proyecto\Models;


use PDO;
use proyecto\Auth;
use function json_encode;

class config_carusel extends Models
{

 public $id;
 public $img_config_carusel;

    protected  $table = "configs_carusel";
    /**
     * @var array
     */
    protected $filleable = [
        "img_config_carusel","id_empleado"
    ];

}
