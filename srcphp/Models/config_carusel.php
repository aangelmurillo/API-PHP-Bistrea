<?php

namespace proyecto\Models;


use PDO;
use proyecto\Auth;
use function json_encode;

class config_carusel extends Models
{

 public $id;
 public $img_uno;
 public $img_dos;
 public $img_tres;
 public $img_cuatro;

    protected  $table = "configs_carusel";
    /**
     * @var array
     */
    protected $filleable = [
        "img_uno", "img_dos", "img_tres", "img_cuatro"
    ];

}
