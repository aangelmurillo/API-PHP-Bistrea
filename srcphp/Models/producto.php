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
    public function productos() {
        try{
            $produ = Table::query("select * from productos");
            $produ = new Success($produ);
            $produ->Send();
            return $produ;
         } catch (\Exception $e) {
            $s = new Failure(401, $e->getMessage());
            return $s->Send();
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