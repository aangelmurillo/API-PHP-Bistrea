<?php

namespace proyecto\Controller;

use proyecto\Models\Table;
use proyecto\Models\Telefono;
use proyecto\Models\empleado;
use proyecto\Response\Failure;
use proyecto\Response\Success;

class AgendaController
{
    public function construct($conexion)
   {
    $this->conexion = $conexion;
    }

    public function Insertaremplead()
    {
        try{
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);
            $user = new empleado();
            $user->curp_empleado = $dataObject->curp_empleado;
            $user->rfc_empleado = $dataObject->rfc_empleado;
            $user->nss_empleado = $dataObject->nss_empleado;
            $user->salario_mes_empleado = $dataObject->salario_mes_empleado;
            $user->id_usuario = $dataObject->id_usuario;
            $user->save();
            $r = new Success($user);
            
        


            return $r->Send();
        }catch (\Exception $e){
            $r = new Failure(401,$e->getMessage());
            return $r->Send();
        }
    }

}

/*function registrarTelefono(){
         $t=new Telefono();
         $t->numero="123456789";
            $t->usuarios_id=12;
            $t->save();
            $r= new Success($t);
            return $r->Send();
    }
    function buscartelefono($id){
        $t=Telefono::find($id);
        if($t){
            $r= new Success($t);
            return $r->Send();
        }else
        {
            $r=new Failure(404,"No se encontro el telefono");
            return $r->Send();
        }
    }

    function mostrartelefonos(){
//        $t=Telefono::where("usuarios_id","=",12);
//        $r= new Success($t);
//        return $r->Send();

        $t=Table::query("select * from telefonos where usuarios_id=12");
        $r= new Success($t);
        return $r->Send();

    }
}
*/