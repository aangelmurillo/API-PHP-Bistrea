<?php

namespace proyecto\Models;


use PDO;
use proyecto\Auth;
use function json_encode;

class empleado extends Models
{

 public $id;
 public $curp_empleado;
 public $rfc_empleado;
 public $nss_empleado;
 public $salario_mes_empleado;
 public $id_usuario;

    protected  $table = "empleados";
    /**
     * @var array
     */
    protected $filleable = [
        "curp_empleado","rfc_empleado", "nss_empleado",
        "salario_mes_empleado", "id_usuario"
    ];

}