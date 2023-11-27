<?php

namespace proyecto\Models;


use PDO;
use proyecto\Auth;
use proyecto\Response\Failure;
use proyecto\Response\Response;
use proyecto\Response\Success;
use proyecto\Response\Exception;
use function json_encode;

class User extends Models
{

    public $user = "";
    public $contrasena = "";
    public $nombre = "";
    public $edad = "";
    public $correo = "";
    public $apellido = "";

    public $id = "";

    /**
     * @var array
     */
    protected $filleable = [
        "nombre",
        "edad",
        "correo",
        "apellido",
        "contrasena",
        "user"
    ];
    protected    $table = "usuarios";

    public static function auth($email_usuario, $contrasena_usuario):Response
    {
        $class = get_called_class();
        $c = new $class();
        $stmt = self::$pdo->prepare("select *  from $c->table  where  email_usuaro =:email_usuario  and contrasena_usuario=:contrasena_usuario");
        $stmt->bindParam(":email_usuario", $email_usuario);
        $stmt->bindParam(":contrasena_usuario", $contrasena_usuario);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_CLASS,usuario::class);

        if ($resultados) {
            Auth::setUser($resultados[0]);
            $r=new Success(["usuario"=>$resultados[0],"_token"=>Auth::generateToken([$resultados[0]->id])]);
           return  $r->Send();
        }
        $r=new Failure(401,"Usuario o contraseña incorrectos");
        return $r->Send(); 

    }
    public static function eliminarby($field, $condition, $value)
    {
        $class = get_called_class();
        $c = new $class();
        try {
            $cid = $c->id != "" ? $c->id : "id";
            $stmt = self::$pdo->prepare("delete from   $c->table where $field $condition :value");
            $stmt->bindParam(":value", $value);
            $stmt->execute();
        } catch (Exception $e) {
            return $e;
        }
    }

    public function find_name($name)
    {
        $stmt = self::$pdo->prepare("select *  from $this->table  where  nombre=:name");
        $stmt->bindParam(":name", $name);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_OBJ);
        if ($resultados == null) {
            return json_encode([]);
        }
        return json_encode($resultados[0]);
    }

    public  function reportecitas(){
        $JSONData = file_get_contents("php://input");
        $dataObject = json_decode($JSONData);

        $name=$dataObject->name;
        $d=Table::query("select * from users  where name='".$name."'");
        $r=new Success($d);

    }

}
