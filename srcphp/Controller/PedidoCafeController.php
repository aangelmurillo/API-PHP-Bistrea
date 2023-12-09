<?php

namespace proyecto\Controller;

use PDO;
use proyecto\Models\pedido;
use proyecto\Models\detalle_pedido;
use proyecto\Models\pedido_cliente;
use proyecto\Models\detalle_pedido_pe;
use proyecto\Models\detalle_pedido_tipo_cafe;
use proyecto\Models\producto;
use proyecto\Response\Success;
use proyecto\Response\Failure;
use proyecto\Models\Table;

class PedidoCafeController {

    public function vercafes() {
        try {
            $productos = Table::query("SELECT * FROM productos WHERE categoria = 'Cafes'");
            $productos = new Success($productos);

            $productos->Send();

            return $productos;
        } catch (\Exception $e) {
            $s = new Failure(401, $e->getMessage());
            return $s->Send();
        }
    }

    public function verpedidos() {
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

    public function verdetallespedido() {
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

    public function detallespepidotipocafe() {
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

    public function detallespedidope() {
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

    public function ingresarpedidocafe() {
        try {
            $fechaActual = date("Y-m-d");
            $hora_actual = date("H:i:s");

            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $pedidos = new pedido();

            $pedidos->fecha_realizado_pedido = $fechaActual;
            $pedidos->hora_realizado_pedido = $hora_actual;
            $pedidos->info_pedido = $dataObject->info_pedido;
            $pedidos->op_pedido = $dataObject->op_pedido;
            $pedidos->estado_pedido = "En proceso";
            $pedidos->id_empleado = 1;
            $pedidos->nombre_cliente_pedido = $dataObject->nombre_cliente_pedido;
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

            $detalles_pedido_pe = new detalle_pedido_pe();
            $detalles_pedido_pe->id_detalle_pedido = $detalles_pedido->id;
            $detalles_pedido_pe->id_producto_extra = $dataObject->id_producto_extra;
            $detalles_pedido_pe->save();

            $respone = array(
                'pedido' => $pedidos,
                'pedidos_clientes' => $pedidos_clientes,
                'detalles_pedido' => $detalles_pedido,
                'detalles_pedido_pe' => $detalles_pedido_pe
            );

            $r = new Success($respone);
            $r->Send();
            sleep(10);
            $pedidos->estado_pedido = "En proceso";
            $pedidos->save();
            $response['status'] = 'procesing';
            $r = new Success($response);
            $r->Send();
            return $r->Send();
        } catch (\Exception $e) {
            $s = new Failure(401, $e->getMessage());
            return $s->Send();
        }
    }

    public function ingresarpedido() {
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

            $detalle_pedido = new detalle_pedido();
            $detalle_pedido->cantidad_producto = $dataObject->cantidad_producto;
            $detalle_pedido->precio_unitario = $dataObject->precio_unitario;
            $detalle_pedido->nombre_producto = $dataObject->nombre_producto;
            $detalle_pedido->id_producto = $dataObject->id_producto;
            $detalle_pedido->subtotal_pedido = $dataObject->subtotal_pedido;
            $detalle_pedido->id_pedido = $pedidos->id;
            $detalle_pedido->tipo_pago_pedido = "Efectivo";
            $detalle_pedido->save();

            $detalles_pedido_tipo_cafe = new detalle_pedido_tipo_cafe();
            $detalles_pedido_tipo_cafe->nom_cafe = $dataObject->nom_cafe;
            $detalles_pedido_tipo_cafe->id_detalle_pedido = $detalle_pedido->id;
            $detalles_pedido_tipo_cafe->id_tipo_cafe = $dataObject->id_tipo_cafe;
            $detalles_pedido_tipo_cafe->save();

            $detalles_pedido_pe = new detalle_pedido_pe();
            $detalles_pedido_pe->precio_pe = $dataObject->precio_pe;
            $detalles_pedido_pe->id_detalle_pedido = $detalle_pedido->id;
            $detalles_pedido_pe->id_producto_extra = $dataObject->id_producto_extra;
            $detalles_pedido_pe->save();

            $respone = array(
                'pedido' => $pedidos,
                'detalle_pedido' => $detalle_pedido,
                'detalles_pedido_tipo_cafe' => $detalles_pedido_tipo_cafe,
                'detalles_pedido' => $detalles_pedido_pe,
            );

            $r = new Success($respone);
            return $r->Send();
        } catch (\Exception $e) {
            $s = new Failure(401, $e->getMessage());
            return $s->Send();
        }
    }

    public function comprarpedido() {
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            if($dataObject === null) {
                throw new \Exception("Error decoding JSON data");
            }

            $query = "CALL estado_ensolicitud(
                :pedido_id,
                :cambio_estado
            )";

            $params = ['pedido_id' => $dataObject->pedido_id, 'cambio_estado' => $dataObject->estado_pedido];

            $resultado = Table::queryParams($query, $params);

            $r = new Success($resultado);
            return $r->send();
        } catch (\Exception $e) {
            $s = new Failure(401, $e->getMessage());
            return $s->Send();
        }
    }

}
?>