<?php

namespace proyecto\Controller;

use proyecto\Response\Success;
use proyecto\Response\Failure;
use proyecto\Models\Table;


class CarritoController
{
    public function carrito()
    {
        try {
            $carro = Table::query("SELECT *
            FROM pedidos
            JOIN pedidos_clientes ON pedidos.id = pedidos_clientes.id_pedido
            JOIN usuarios ON pedidos_clientes.id_usuario = usuarios.id
            WHERE usuarios.id = id_usuario;");

            $carro = new Success($carro);

            $carro->Send();

            return $carro;
        } catch (\Exception $e) {
            $s = new Failure(401, $e->getMessage());
            return $s->Send();
        }
    }
}


?>