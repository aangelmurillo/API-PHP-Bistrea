<?php

namespace proyecto\Models;


use PDO;
use proyecto\Auth;
use function json_encode;

class rol extends Models
{

 public $id="";
 public $nombre_rol="";

    protected  $table = "roles";
    /**
     * @var
     *  array
     */
    protected $filleable = [
        "nombre_rol"
    ];

}
