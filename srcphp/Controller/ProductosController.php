<?php

namespace proyecto\Controller;

use PDO;
use proyecto\Models\Table;
use proyecto\Models\producto;
use proyecto\Response\Failure;
use proyecto\Response\Success;
use proyecto\Conexion;

class ProductosController
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new Conexion('cafeteria', 'localhost:3306', 'bistrea', 'bistrea1234');
    }

    public function actualizarstock()
    {
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $resultados = Table::query("CALL actualizar_stock_producto ('{$dataObject->id} ',' {$dataObject->cantidad}')");

            $r = new Success($resultados);
            return $r->Send();

        } catch (\Exception $e) {
            $s = new Failure(401, $e->getMessage());
            return $s->Send();
        }
    }

    public function verproductos()
    {
        try {
            $productos = Table::query("SELECT * FROM productos");
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


    public function Insertarproducto()
    {

        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);
            $prod = new producto();
            $prod->nombre_producto = $dataObject->nombre_producto;
            $prod->descripcion_producto = $dataObject->descripcion_producto;
            $prod->precio_unitario_producto = $dataObject->precio_unitario_producto;
            $prod->stock_producto = $dataObject->stock_producto;

            // Poder guardar imagen
            $imagenBase64 = $dataObject->img_producto;
            $imagenData = base64_decode($imagenBase64);

            $finfo = finfo_open();
            $mime_type = finfo_buffer($finfo, $imagenData, FILEINFO_MIME_TYPE);
            finfo_close($finfo);

            // Validar la extensión permitida
            $extensionMap = [
                'image/jpeg' => 'jpg',
                'image/jpg' => 'jpg',
                'image/png' => 'png',
                'image/svg+xml' => 'svg',
            ];

            if (!array_key_exists($mime_type, $extensionMap)) {
                throw new \Exception('Formato de imagen no permitido');
            }

            $fileExtension = $extensionMap[$mime_type];
            $nombreImagen = uniqid() . '.' . $fileExtension;

            $rutaImagen = '/var/www/html/apiPhp/public/img/perfil/' . $nombreImagen;

            file_put_contents($rutaImagen, $imagenData);

            if (file_put_contents($rutaImagen, $imagenData) === false) {
                throw new \Exception('Error al guardar la imagen: ' . error_get_last()['message']);
            }

            $prod->img_producto = $rutaImagen;


            $prod->slug_producto = $dataObject->slug_producto;
            $prod->categoria = $dataObject->categoria;
            $prod->especialidad_producto = $dataObject->especialidad_producto;
            $prod->estado_producto = $dataObject->estado_producto;
            $prod->medida_producto = $dataObject->medida_producto;
            $prod->unidad_medida = $dataObject->unidad_medida;
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