<?php

namespace proyecto\Controller;

use proyecto\Models\usuario;
use proyecto\Models\Table;
use proyecto\Response\Failure;
use proyecto\Response\Success;

class UsuarioController
{
    public function verusuario (){
        try {
         $emp = Table::query("select * from usuarios");
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
    public function verUsuarios()
    {
        $db = Table::query("SELECT * FROM usuarios");
        $db = new Success($db);

        $db->Send();
    }

    public function verUsuariosAdmin()
    {
        $db = Table::query("
        SELECT
        CONCAT(usuarios.nombre_usuario, ' ', usuarios.apellido_p_usuario) AS Nombre,
        usuarios.telefono_usuario AS Telefono,
        usuarios.email_usuario AS Email,
        roles.nombre_rol AS Rol,
        SUM(pedidos.estado_pedido = 'Entregado') AS PedidosRealizados FROM usuarios INNER JOIN roles ON usuarios.id_rol = roles.id LEFT JOIN pedidos_clientes ON usuarios.id = pedidos_clientes.id_usuario LEFT JOIN pedidos ON pedidos.id = pedidos_clientes.id_pedido GROUP BY usuarios.id ORDER BY Nombre;");
        $db = new Success($db);

        $db->Send();
    }

}


?>