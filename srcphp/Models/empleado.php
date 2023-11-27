<?php

namespace proyecto\Models;


use PDO;
use proyecto\Auth;
use function json_encode;
use proyecto\Response\Success;
use proyecto\Response\Failure;


class empleado extends Models
{

 public $id;
 public $curp_empleado;
 public $rfc_empleado;
 public $nss_empleado;
 public $salario_mes_empleado;
 public $id_usuario;

 /**
     * @var array
     */
    protected $filleable = [
        "curp_empleado",
        "rfc_empleado",
         "nss_empleado",
        "salario_mes_empleado",
         "id_usuario",
    ];

    protected  $table = "empleados";

    public function emp (){
        try {
         $emp = Table::query("select * from " .$this->table);
        $empl = new Success ($emp);
        $empl->Send();
        return $empl;
        }catch (\Exception $e) {
            $errorResponse = ['message' => "Error en el servidor: " . $e->getMessage()];
            header('Content-Type: application/json');
            echo json_encode($errorResponse);
            http_response_code(500);
        }
    }
}