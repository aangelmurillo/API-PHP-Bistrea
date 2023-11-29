<?php

namespace proyecto\Controller;

use proyecto\Models\usuario;
use proyecto\Models\Table;
use proyecto\Response\Failure;
use proyecto\Response\Success;

class UsuarioController
{
    public function verUsuarios()
    {
        $db = Table::query("SELECT * FROM usuarios");
        $db = new Success($db);

        $db->Send();
    }

    public function verUsuariosAdmin()
    {
        $db = Table::query("SELECT
        CONCAT(usuarios.nombre_usuario, ' ', usuarios.apellido_p_usuario) AS Nombre,
        usuarios.telefono_usuario AS Telefono,
        usuarios.email_usuario AS Email,
        roles.nombre_rol AS Rol,
        COUNT(pedidos_clientes.id_pedido) AS PedidosRealizados
    FROM usuarios
    INNER JOIN roles ON usuarios.id_rol = roles.id
    LEFT JOIN pedidos_clientes ON usuarios.id = pedidos_clientes.id_usuario
    GROUP BY usuarios.id
    ORDER BY Nombre;");
        $db = new Success($db);

        $db->Send();
    }

}


?>