<?php

namespace proyecto\Controller;

use PDO;
use proyecto\Models\pedido;
use proyecto\Models\detalle_pedido;
use proyecto\Models\producto;
use proyecto\Response\Success;
use proyecto\Response\Failure;
use proyecto\Models\Table;

class PedidoCafeController
{
    public function verpedidos()
    {
        try {
            $pedidos = Table::query("SELECT * FROM pedidos");
            $pedidos = new Success($pedidos);

            $pedidos->Send();

            return $pedidos;
        } catch (\Exception $e) {
            $s = new Failure(401, $e->getMessage());
            return $s->Send();
        }
    }

    public function verdetallespedido()
    {
        try {
            $detallesPedido = Table::query("SELECT * FROM detalles_pedido");
            $detallesPedido = new Success($detallesPedido);

            $detallesPedido->Send();

            return $detallesPedido;
        } catch (\Exception $e) {
            $s = new Failure(401, $e->getMessage());
            return $s->Send();
        }
    }

    public function detallespepidotipocafe()
    {
        try {
            $detallepedido = Table::query("SELECT * FROM detalles_pedido_tipo_cafe");
            $detallepedido = new Success($detallepedido);

            $detallepedido->Send();

            return $detallepedido;
        } catch (\Exception $e) {
            $s = new Failure(401, $e->getMessage());
            return $s->Send();
        }
    }

    public function detallespedidope()
    {
        try {
            $detallepedidope = Table::query("SELECT * FROM detalles_pedido_pe");
            $detallepedidope = new Success($detallepedidope);

            $detallepedidope->Send();
            return $detallepedidope;
        } catch (\Exception $e) {
            $s = new Failure(401, $e->getMessage());
            return $s->Send();
        }
    }

    public function ingresarpedido()
    {
        try {
            $fechaActual = date("Y-m-d H:i:s");
            $hora_actual =  date("H:i:s");


            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $pedidos = new pedido();
            $pedidos->fecha_realizado_pedido = $fechaActual;
            $pedidos->hora_entrega_pedido = $hora_actual;
            $pedidos->hora_entrega_pedido = $dataObject->hora_entrega_pedido;
            $pedidos->info_pedido = $dataObject->info_pedido;
            $pedidos->estado_pedido = "En proceso";
            $pedidos->op_pedido = $dataObject->op_pedido;
            $pedidos->id_empleado = 1;
            $pedidos->nombre_cliente_pedido = $dataObject->nombre_cliente_pedido;
            $pedidos->total_pedido = $dataObject->total_pedido;

            $pedidos->save();

            $r = new Success($pedidos);
            return $r->Send();
        } catch (\Exception $e) {
            $s = new Failure(401, $e->getMessage());
            return $s->Send();
        }
    }

}
?>