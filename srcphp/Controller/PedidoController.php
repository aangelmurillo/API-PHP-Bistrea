<?php

namespace proyecto\Controller;

use PDO;
use proyecto\Models\pedido;
use proyecto\Models\Table;
use proyecto\Response\Success;
use proyecto\Response\Failure;

class PedidoController
{
    public function verpedido()
    {
        try{
            $pedi = Table::query("select * from pedidos");
            $pedi = new Success($pedi);
            $pedi ->Send();
            return $pedi;
        } catch (\Exception $e) {
            $s = new Failure(401, $e->getMessage());
            return $s->Send();
        }
    }
    
    public function vercortedecaja()
{
    try {
        $caj = Table::query("SELECT
            CASE
                WHEN pedidos.nombre_cliente_pedido IS NOT NULL THEN pedidos.nombre_cliente_pedido
                ELSE CONCAT(usuarios.nombre_usuario, ' ', usuarios.apellido_p_usuario)
            END AS Nombre,
            pedidos.fecha_realizado_pedido AS Fecha,
            pedidos.estado_pedido AS Estado,
            usuarios.telefono_usuario AS Telefono,
            productos.nombre_producto AS Producto,
            detalles_pedido.cantidad_producto AS Cantidad,
            detalles_pedido.subtotal_pedido AS Subtotal,
            (SELECT SUM(subtotal_pedido) FROM detalles_pedido WHERE id_pedido = pedidos.id) AS Total
        FROM pedidos
        LEFT JOIN pedidos_clientes ON pedidos.id = pedidos_clientes.id_pedido
        LEFT JOIN usuarios ON pedidos_clientes.id_usuario = usuarios.id
        INNER JOIN detalles_pedido ON pedidos.id = detalles_pedido.id_pedido
        INNER JOIN productos ON detalles_pedido.id_producto = productos.id
        WHERE pedidos.estado_pedido IN ('Cancelado', 'Entregado');");

        $caj = new Success($caj);
        $caj->Send();
        return $caj;
    } catch (\Exception $e) {
        $s = new Failure(401, $e->getMessage());
        return $s->Send();
    }
}



}