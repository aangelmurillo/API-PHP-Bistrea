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

    public function prod (){
        try {
         $prod = Table::query("select * from " .$this->table);
        $prods = new Success ($prod);
        $prods->Send();
        return $prods;

        $r = new Success($prods);
        return $r->Send();
    }catch (\Exception $e){
        $r = new Failure(401, $e->getMessage());
        return $r->Send();
    }
        // Ruta para obtener los datos de los productos
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['endpoint']) && $_GET['endpoint'] === 'productos') {
            $query = 'SELECT * FROM productos';
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Devolver los datos de los productos en formato JSON
            header('Content-Type: application/json');
            echo json_encode($productos);
            exit;
        }
    }
    /**
     * @var array
     */
    protected $filleable = [
        "nombre_producto", "descripcion_producto", "precio_unitario_producto",
        "stock_producto", "img_producto", "slug_producto",
        "id_categoria", "especialidad_producto", "estado_producto",
        "medida_producto", "id_medida"
    ];

}