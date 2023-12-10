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
            // Suponiendo que estás recibiendo datos JSON a través de una solicitud HTTP
            $datosJSON = file_get_contents("php://input");
            $objetoDatos = json_decode($datosJSON);

            if ($objetoDatos === null || !isset($objetoDatos->p_id_usuario)) {
                throw new \Exception("ID de usuario inválido o ausente en los datos JSON");
            }

            $idUsuario = $objetoDatos->p_id_usuario;

            // Llama al método para obtener datos del carrito de compras para el usuario
            $resultado = $this->obtenerPedidoUsuario($idUsuario);

            // Suponiendo que las clases Success y Failure están definidas en otro lugar
            $respuesta = new Success($resultado);
            return $respuesta->Send();
        } catch (\Exception $e) {
            $respuestaError = new Failure(401, $e->getMessage());
            return $respuestaError->send();
        }
    }

    // Método para obtener datos del carrito de compras para un usuario
    private function obtenerPedidoUsuario($idUsuario)
    {
        try {
            $consulta = "CALL obtener_pedido_usuario(:p_id_usuario)";
            $parametros = ['p_id_usuario' => $idUsuario];

            // Suponiendo que la clase Table tiene un método queryParams para ejecutar consultas
            $resultado = Table::queryParams($consulta, $parametros);

            return $resultado;
        } catch (\Exception $e) {
            // Maneja cualquier excepción específica relacionada con la obtención de datos
            throw new \Exception("Error al obtener datos del carrito de compras: " . $e->getMessage());
        }
    }

}


?>