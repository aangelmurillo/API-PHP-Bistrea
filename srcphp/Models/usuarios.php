<?php

namespace proyecto\Models;


use PDO;
use proyecto\Auth;
use function json_encode;

class usuarios extends Models
{

 public $id_usuario;
 public $nombre_usuario;
 public $apellido_p_usuario;
 public $apellido_m_usuario;
 public $email_usuario;
 public $contrasena_usuario;
 public $foto_perfil_usuario;
 public $telefono_usuario;
 public $status_usuario;
 public $creado_en_usuario;
 public $id_rol;

    protected  $table = "usuarios";
    /**
     * @var array
     */
    protected $filleable = [
        "nombre_usuario","apellido_p_usuario", "apellido_m_usuario",
        "email_usuario", "contrasena_usuario", "foto_perfil_usuario",
        "telefono_usuario", "status_usuario", "creado_en_usuario",
        "id_rol"
    ];

}
