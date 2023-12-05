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
        try {
            $pedi = Table::query("select * from pedidos");
            $pedi = new Success($pedi);
            $pedi->Send();
            return $pedi;
        } catch (\Exception $e) {
            $s = new Failure(401, $e->getMessage());
            return $s->Send();
        }
    }
    public function hacerpedido()
    {
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);
            $pedid = new pedido();
            $pedid->fecha_realizado_pedido = $dataObject->fecha_realizado_pedido;
            $pedid->hora_realizado_pedido = $dataObject->hora_realizado_pedido;
            $pedid->hora_entrega_pedido = $dataObject->hora_entrega_pedido;
            $pedid->estado_pedido = $dataObject->estado_pedido;
            $pedid->info_pedido = $dataObject->info_pedido;
            $pedid->op_pedido = $dataObject->id_empleado;
            $pedid->id_empleado = $dataObject->id_empleado;
            $pedid->nombre_cliente_pedido = $dataObject->nombre_cliente_pedido;
            $pedid->total_pedido = $dataObject->total_pedido;
            $pedid->save();
            $r = new Success($pedid);
            return $r->Send();
        } catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }
    public function vercortedecaja()
    {
        try {
            $caj = Table::query("SELECT pedidos.id AS Pedido_ID,
            CASE
                WHEN pedidos.nombre_cliente_pedido IS NOT NULL THEN pedidos.nombre_cliente_pedido
                ELSE CONCAT(usuarios.nombre_usuario, ' ', usuarios.apellido_p_usuario)
            END AS Nombre, pedidos.fecha_realizado_pedido AS Fecha, pedidos.estado_pedido AS Estado, usuarios.telefono_usuario AS Telefono,
            detalles_pedido.nombre_producto AS Producto, detalles_pedido.cantidad_producto AS Cantidad, detalles_pedido.subtotal_pedido AS Subtotal,
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


    public function verresumenpedidospendientes()
    {
        try {
            $productos = Table::query("SELECT * FROM barista_resumen_barista");

            $productos = new Success($productos);
            $productos->Send();

            return $productos;
        } catch (\Exception $e) {
            $s = new Failure(401, $e->getMessage());
            return $s->Send();
        }
    }

    public function verpedidospendientes()
    {
        try {
            $pedidospendientes = Table::query("SELECT * FROM barista_pendiente_barista");
            $pedidospendientes = new Success($pedidospendientes);
            $pedidospendientes->Send();
            return $pedidospendientes;
        } catch (\Exception $e) {
            $s = new Failure(0, $e->getMessage());
            return $s->Send();
        }
    }


    public function liberarcancelarpedidos()
    {
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $query = "CALL (
                :pedido_id, 
                :cambio_estado
            )";

            $params = ['pedido_id' => $dataObject->id, 'cambio_estado' => $dataObject->cambio];

            $resultados = Table::queryParams($query, $params);

            $r = new Success($resultados);
            return $r->Send();
        } catch (\Exception $e) {
            $s = new Failure(0, $e->getMessage());
            return $s->Send();
        }
    }

    /*public function cancelarpedidos()
    {
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);
            $cancelarPedido = new pedido();
        } catch (\Exception $e) {
            $s = new Failure(0, $e->getMessage());
            return $s->Send();
        }
    }*/


}