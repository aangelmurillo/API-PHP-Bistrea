<?php

namespace proyecto\Controller;

use proyecto\Auth;
use proyecto\Response\Failure;
use proyecto\Response\Success;
use proyecto\Models\usuario;
use proyecto\Models\Table;
use proyecto\Models\Models;
use PDO;

class UserController
{

    function registrousuario()
    {
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);
            $user = new usuario();
            $user->nombre_usuario = $dataObject->nombre_usuario;
            $user->apellido_p_usuario = $dataObject->apellido_p_usuario;
            $user->apellido_m_usuario = $dataObject->apellido_m_usuario;
            $user->email_usuario = $dataObject->email_usuario;
            $user->contrasena_usuario = password_hash($dataObject->contrasena_usuario, PASSWORD_DEFAULT);

            // Poder guardar imagen
            $imagenBase64 = $dataObject->foto_perfil_usuario;
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

            $rutaImagen = '/var/www/html/apiPhp/public/img/perfil' . $nombreImagen;

            file_put_contents($rutaImagen, $imagenData);

            $user->foto_perfil_usuario = $rutaImagen;

            $user->telefono_usuario = $dataObject->telefono_usuario;
            $user->status_usuario = 1;
            $user->creado_en_usuario = null;
            $user->id_rol = 3;
            $user->save();
            $r = new Success($user);
            return $r->Send();
        } catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }


    }


    public function verificar()
    {
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $email_usuario = $dataObject->email_usuario;
            $contrasena_usuario = $dataObject->contrasena_usuario;

            $resultado = $this->verificarUsuario($email_usuario, $contrasena_usuario);


            if ($resultado) {

                $response = array(
                    "message" => "Inicio de sesión exitoso",
                    "data" => $resultado
                );
                $r = new Success($response);
                return $r->send();
            } else {

                $r = new Failure(401, "No se encontró el usuario o la contraseña es incorrecta");
                return $r->send();
            }
        } catch (\Exception $e) {

            $r = new Failure(500, "Error en el servidor: " . $e->getMessage());
            return $r->Send();
        }
    }

    function verificarUsuario($email_usuario, $contrasena_usuario)
    {
        $resultados = Table::queryParams("SELECT * FROM usuarios WHERE email_usuario = :email_usuario", ['email_usuario' => $email_usuario]);

        if (count($resultados) > 0) {
            $usuario = $resultados[0];
            if ($usuario->contrasena_usuario === $contrasena_usuario) {
                return $resultados;
            }
        }

        return false;
    }

    function buscar()
    {
        $JSONData = file_get_contents("php://input");
        $dataObject = json_decode($JSONData);
        if (property_exists($dataObject, 'nombre_usuario')) {

            $alluser = usuario::where("nombre_usuario", "=", $dataObject->nombre_usuario)->get();
            if ($alluser) {
                $r = new Success($alluser);
                return $r->Send();
            }
            return json_encode(['success' => false, 'message' => 'No se encontraron usuarios']);

        }


    }
    public function login()
    {
        $JSONData = file_get_contents("php://input");
        $dataObject = json_decode($JSONData);

        $email_usuario = $dataObject->email_usuario;
        $contrasena_usuario = $dataObject->contrasena_usuario;

        // Verificar credenciales y generar token si es exitoso
        $response = $this->verifyCredentials($email_usuario, $contrasena_usuario);

        // Enviar la respuesta al cliente
        echo json_encode($response);
    }

    private function verifyCredentials($email_usuario, $contrasena_usuario)
    {
        try {
            // Buscar un usuario por correo electrónico
            $user = Usuario::where('email_usuario', '=', $email_usuario);

            if ($user) {
                // Verificar la contraseña almacenada en la base de datos
                $storedPassword = $user[0]->contrasena_usuario;

                if (password_verify($contrasena_usuario, $storedPassword)) {
                    $token = Auth::generateToken([$user[0]->id]); // Asegúrate de que sea la clave primaria correcta
                    return ['success' => true, 'token' => $token];
                } else {
                    return ['success' => false, 'message' => 'Credenciales incorrectas'];
                }
            } else {
                return ['success' => false, 'message' => 'Credenciales incorrectas'];
            }
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Error en el servidor: ' . $e->getMessage()];
        }
    }



    /*private function generateSessionToken($userId)
    {
        $tokenData = [
            'id' => $userId,
            'expires' => time() + (180 * 180) // Token válido por 1 hora
        ];
    
        // Codificar el token como base64
        $encodedToken = base64_encode(json_encode($tokenData));
    
        return $encodedToken;
    }*/

    public function getpassword(Request $request)
    {
        $email_usuario = $request->ínput('email_usuario');
        $user = usuario::where('email_usuario', $email_usuario)->first();

        if ($user) {
            return response()->json(['encryptedPassword' => $user->contrasena_usuario]);
        } else {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
    }
    function listar()
    {
        $alluser = usuario::all();
        $r = new Success($alluser);
        return $r->Send();
    }


    function eliminarAllUsers()
    {
        usuario::deleteAll();
    }

    function eliminarUsersbyId($id)
    {
        usuario::delete($id);
    }
}

/*
        $email_usuario = $dataObject->email_usuario;
        $contrasena_usuario = $dataObject->contrasena_usuario;

        if ($user && password_verify($contrasena_usuario, $user->contrasena_usuario)) {
            $token = $this->generateSessionToken($user->id);
            return json_encode(['success' => true, 'token' => $token]);
        } else {
            return json_encode(['success' => false, 'message' => 'Credenciales incorrectas']);
        }*/