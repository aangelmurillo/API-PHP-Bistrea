<?php

namespace proyecto\Models;


use PDO;
use proyecto\Auth;
use proyecto\Response\Failure;
use proyecto\Response\Success;
use proyecto\Response\Response;
use function json_encode;


class usuario extends Models
{

    public $id = "";
    public $nombre_usuario = "";
    public $apellido_p_usuario = "";
    public $apellido_m_usuario = "";
    public $email_usuario = "";
    public $contrasena_usuario = "";
    public $telefono_usuario = "";
    public $status_usuario = "";
    public $creado_en_usuario = "";
    public $id_rol = "";

    /**
     * @var array
     */
    protected $filleable = [
        "nombre_usuario",
        "apellido_p_usuario",
        "apellido_m_usuario",
        "email_usuario",
        "contrasena_usuario",        
        "telefono_usuario",
        "status_usuario",
        "creado_en_usuario",
        "id_rol"
    ];

    protected $table = "usuarios";

    public function usuario()
    {
        try {
            $emp = Table::query("select * from " . $this->table);
            $empl = new Success($emp);
            $empl->Send();
            return $empl;
        } catch (\Exception $e) {
            $errorResponse = ['message' => "Error en el servidor: " . $e->getMessage()];
            header('Content-Type: application/json');
            echo json_encode($errorResponse);
            http_response_code(500);
        }
    }
    public static function auth($email_usuario, $contrasena_usuario): Response
    {
        $class = get_called_class();
        $c = new $class();
        $stmt = self::$pdo->prepare("SELECT * FROM {$c->table} WHERE email_usuario = :email_usuario");
        $stmt->bindParam(":email_usuario", $email_usuario);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_CLASS, usuario::class);

        if ($resultados) {
            $hashedPassword = $resultados[0]->contrasena_usuario;

            if (password_verify($contrasena_usuario, $hashedPassword)) {
                $r = new Success(["usuario" => $resultados[0], "_token" => Auth::generateToken([$resultados[0]->id])]);
                return $r->Send();
            }
        }

        $r = new Failure(401, "Usuario o contrasena incorrectos");
        return $r->Send();
    }


    public function find_name($nombre_usuario)
    {
        $stmt = self::$pdo->prepare("select *  from $this->table  where  nombre_usuario=:nombre_usuario");
        $stmt->bindParam(":nombre_usuario", $nombre_usuario);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_OBJ);
        if ($resultados == null) {
            return json_encode([]);
        }
        return json_encode($resultados[0]);
    }
}
;
