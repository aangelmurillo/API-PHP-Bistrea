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

    public function mostrarcarrito()
    {
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            if ($dataObject === null) {
                throw new \Exception("Error decoding JSON data");
            }

            $query = "CALL obtener_pedido_usuario(
                :p_id_usuario
            )";

            $params = ['p_id_usuario' => $dataObject->p_id_usuario];

            $resultado = Table::queryParams($query, $params);

            $r = new Success($resultado);
            return $r->Send();
        } catch (\Exception $e) {
            $s = new Failure(401, $e->getMessage());
            return $s->Send();
        }
    }

}


?>