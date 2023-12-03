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
            $pedid = Table::query("SELECT resenas.id AS id, nombre_usuario, apellido_p_usuario, apellido_m_usuario, telefono_usuario AS Telefono, comentario_resena AS Resena
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
}


?>