<?php

namespace proyecto\Models;


use PDO;
use proyecto\Auth;
use function json_encode;
use proyecto\Response\Success;
use proyecto\Response\Failure;

class producto extends Models
{

 public $id;
 public $nombre_producto;
 public $descripcion_producto;
 public $precio_unitario_producto;
 public $stock_producto;
 public $img_producto;
 public $slug_producto;
 public $id_categoria;
 public $especialidad_producto;
 public $estado_producto;
 public $medida_producto;
 public $id_medida;

    protected  $table = "productos";
    public function getproductos() {
        try {
            $prod = Table::query("SELECT * FROM productos");
            $successResponse = new Success($prod);
            $successResponse->send(); // Suponiendo que el método send realiza la acción de envío
    
            return $successResponse;
        } catch (\Exception $e) {
            // En lugar de crear un objeto Failure, simplemente retorna un mensaje de error
            return new Failure(401, $e->getMessage());
        }
    }
    /**
     * @var array
     */
    protected $filleable = [
        "nombre_producto",
         "descripcion_producto",
          "precio_unitario_producto",
        "stock_producto",
         "img_producto",
          "slug_producto",
        "id_categoria",
         "especialidad_producto",
          "estado_producto",
        "medida_producto", 
        "id_medida"
    ];

}