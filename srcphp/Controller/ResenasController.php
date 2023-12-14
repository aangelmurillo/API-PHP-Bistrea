<?php

namespace proyecto\Controller;

use POD;
use proyecto\Models\resena;
use proyecto\Models\Table;
use proyecto\Response\Success;
use proyecto\Response\Failure;

class ResenasController
{
    public function verresenas()
    {
        try {
            $pedid = Table::query("SELECT resenas.id AS id, nombre_usuario, apellido_p_usuario, apellido_m_usuario, telefono_usuario AS Telefono, comentario_resena AS Resena, calificacion
            FROM usuarios
            INNER JOIN resenas
            ON resenas.id_usuario=usuarios.id;");

            $pedid = new Success($pedid);
            $pedid->Send();

            return $pedid;

        } catch (\Exception $e) {
            $s = new Failure(401, $e->getMessage());
            return $s->Send();
        }
    }

    public function hacerresena()
    {
        try {
            $JSONData = file_get_contents("php://input");
            $dataobject = json_decode($JSONData);
            $resen = new resena();
            $resen->comentario_resena = $dataobject->comentario_resena;
            $resen->calificacion = $dataobject->calificacion;
            $resen->id_usuario = $dataobject->id_usuario;
            $resen->save();
            $r = new Success();
            return $r->Send();
        } catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }
}


?>