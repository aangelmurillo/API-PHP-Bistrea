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
}