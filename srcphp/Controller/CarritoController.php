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
            $carro = Table::query("SELECT * FROM carrito");

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