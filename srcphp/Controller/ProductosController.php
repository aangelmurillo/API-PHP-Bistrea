<?php

namespace proyecto\Controller;

use PDO;
use proyecto\Models\Table;
use proyecto\Models\producto;
use proyecto\Response\Failure;
use proyecto\Response\Success;

class ProductosController
{

    public function verproductos()
    {
        try {
            $productos = Table::query("SELECT id, nombre_producto, descripcion_producto, precio_unitario_producto, stock_producto, img_producto FROM productos");
            $productos = new Success($productos);
            $productos->Send();
            return $productos;
        } catch (\Exception $e) {
            $s = new Failure(401, $e->getMessage());
            return $s->Send();
        }
    }

    public function verproductosvendidos()
    {
        try {
            $pedid = Table::query("SELECT
        pedidos.fecha_realizado_pedido AS Fecha,
        productos.nombre_producto AS Producto,
        productos.precio_unitario_producto AS PrecioUnitario,
        SUM(detalles_pedido.cantidad_producto) AS Piezas,
        SUM(detalles_pedido.cantidad_producto * productos.precio_unitario_producto) AS Total
    FROM pedidos
    INNER JOIN detalles_pedido ON pedidos.id = detalles_pedido.id_pedido
    INNER JOIN productos ON detalles_pedido.id_producto = productos.id
    GROUP BY pedidos.fecha_realizado_pedido, productos.nombre_producto
    ORDER BY pedidos.fecha_realizado_pedido;");
            $pedid = new Success($pedid);
            $pedid->Send();
            return $pedid;
        } catch (\Exception $e) {
            $s = new Failure(401, $e->getMessage());
            return $s->Send();
        }
    }


    public function Insertarprod()
    {

        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $prod = new producto();
            $prod->id = $dataObject->id;
            $prod->nombre_producto = $dataObject->producto;
            $prod->descripcion_producto = $dataObject->descripcion_producto;
            $prod->precio_unitario_producto = $dataObject->precio_unitario_producto;
            $prod->stock_producto = $dataObject->stock_producto;
            $prod->img_producto = $dataObject->img_producto;
            $prod->slug_producto = $dataObject->slug_producto;
            $prod->id_categoria = $dataObject->id_categoria;
            $prod->especialidad_producto = $dataObject->especialidad_producto;
            $prod->estado_producto = $dataObject->estado_producto;
            $prod->medida_producto = $dataObject->medida_producto;
            $prod->id_medida = $dataObject->id_medida;
            $prod->save();

            $s = new Success($prod);
            return $s->Send();
        } catch (\Exception $e) {
            $s = new Failure(401, $e->getMessage());
            return $s->Send();
        }
    }
    public function actualizarProd()
    {

        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            // Checking if id is provided
            if (!property_exists($dataObject, 'id')) {
                throw new \Exception("Debe proporcionar el ID del producto para actualizar");
            }

            $id = $dataObject->id;

            $sql = "UPDATE productos SET ";
            $values = [];

            if (property_exists($dataObject, 'producto')) {
                $sql .= "producto = :producto, ";
                $values[':producto'] = $dataObject->producto;
            }
            if (property_exists($dataObject, 'categoria')) {
                $sql .= "categoria = :categoria, ";
                $values[':categoria'] = $dataObject->categoria;
            }
            if (property_exists($dataObject, 'existencias')) {
                $sql .= "existencias = :existencias, ";
                $values[':existencias'] = $dataObject->existencias;
            }

            // Remove trailing comma and add WHERE clause
            $sql = rtrim($sql, ', ') . " WHERE id = :id";
            $values[':id'] = $id;

            $stmt = $this->conexion->getPDO()->prepare($sql);
            $stmt->execute($values);

            $rowsAffected = $stmt->rowCount();

            if ($rowsAffected === 0) {
                throw new \Exception("No se encontró el producto con el ID proporcionado");
            }

            header('Content-Type: application/json');
            echo json_encode(['message' => 'Producto actualizado exitosamente.']);
            http_response_code(200);

        } catch (\Exception $e) {
            $errorResponse = ['message' => "Error en el servidor: " . $e->getMessage()];
            header('Content-Type: application/json');
            echo json_encode($errorResponse);
            http_response_code(500);
        }
    }
}