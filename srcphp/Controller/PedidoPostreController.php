<?php

namespace proyecto\Controller;

use PDO;
use proyecto\Models\pedido;
use proyecto\Models\detalle_pedido;
use proyecto\Models\pedido_cliente;
use proyecto\Models\producto;
use proyecto\Response\Success;
use proyecto\Response\Failure;
use proyecto\Models\Table;

class PedidoPostreController
{
    public function verpostres()
    {
        try {
            $productos = Table::query("SELECT * FROM productos WHERE categoria = 'Postres'");
            $productos = new Success($productos);

            $productos->Send();

            return $productos;
        } catch (\Exception $e) {
            $s = new Failure(401, $e->getMessage());
            return $s->Send();
        }
    }


    public function ingresarpedidopostre()
    {
        try {
            $fechaActual = date("Y-m-d");
            $hora_actual = date("H:i:s");

            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $pedidos = new pedido();

            $pedidos->fecha_realizado_pedido = $fechaActual;
            $pedidos->hora_realizado_pedido = $hora_actual;
            $pedidos->hora_entrega_pedido = $dataObject->hora_entrega_pedido;
            $pedidos->info_pedido = $dataObject->info_pedido;
            $pedidos->estado_pedido = "En proceso";
            $pedidos->op_pedido = $dataObject->op_pedido;
            $pedidos->id_empleado = 1;
            $pedidos->nombre_cliente_pedido = $dataObject->nombre_cliente_pedido;
            $pedidos->total_pedido = $dataObject->total_pedido;
            $pedidos->save();

            $pedidos_clientes = new pedido_cliente();
            $pedidos_clientes->id_pedido = $pedidos->id;
            $pedidos_clientes->id_usuario = $dataObject->id_usuario;
            $pedidos_clientes->save();

            $detalles_pedido = new detalle_pedido();
            $detalles_pedido->cantidad_producto = $dataObject->cantidad_producto;
            $detalles_pedido->id_producto = $dataObject->id_producto;
            $detalles_pedido->id_pedido = $pedidos->id;
            $detalles_pedido->tipo_pago_pedido = "Efectivo";
            $detalles_pedido->save();

            $response = array(
                'pedido' => $pedidos,
                'pedidos_clientes' => $pedidos_clientes,
                'detalles_pedido' => $detalles_pedido
            );

            $r = new Success($response);

            $r->Send();
            return $r->Send();
        } catch (\Exception $e) {
            $s = new Failure(401, $e->getMessage());
            return $s->Send();
        }

    }
}