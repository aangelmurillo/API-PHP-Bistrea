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

}
?>