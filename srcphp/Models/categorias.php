<?php

namespace proyecto\Models;


use PDO;
use proyecto\Auth;
use function json_encode;

class categorias extends Models
{

 public $id_categoria;
 public $nom_categoria;
 public $img_categoria;

    protected  $table = "categorias";
    /**
     * @var array
     */
    protected $filleable = [
        "nom_categoria","img_categoria"
    ];

}
