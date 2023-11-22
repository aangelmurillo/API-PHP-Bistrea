<?php

namespace proyecto\Models;


use PDO;
use proyecto\Auth;
use function json_encode;

class medida extends Models
{

 public $id;
 public $nom_medida;
 public $uni_medida;

    protected  $table = "medidas";
    /**
     * @var array
     */
    protected $filleable = [
        "nom_medida","uni_medida"
    ];

}


