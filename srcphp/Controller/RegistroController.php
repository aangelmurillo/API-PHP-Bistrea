<?php
namespace proyecto\Controller;

use proyecto\Models\usuario;
use proyecto\Models\Table;
use proyecto\Response\Failure;
use proyecto\Response\Success;

class RegistroController
{

    public function registrarUsuario()
    {
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $nuevoUsuario = new usuario();

            $nuevoUsuario->nombre_usuario = $dataObject->nombre_usuario;
            $nuevoUsuario->apellido_p_usuario = $dataObject->apellido_p_usuario;
            $nuevoUsuario->apellido_m_usuario = $dataObject->apellido_m_usuario;
            $nuevoUsuario->email_usuario = $dataObject->email_usuario;

            // Encriptar la contraseña
            $nuevoUsuario->contrasena_usuario = $dataObject->contrasena_usuario;

            

            // Codigo para recibir la imagen y poderla guardar
            $imagenBase64 = $dataObject->foto_perfil_usuario;
            $imagenData = base64_decode($imagenBase64);

            $finfo = finfo_open();
            $mime_type = finfo_buffer($finfo, $imagenData, FILEINFO_MIME_TYPE);
            finfo_close($finfo);

            // Validar las extensiones permitidas
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

            $nuevoUsuario->imagen_usuario = $rutaImagen;

            $nuevoUsuario->save();

            $r = new Success($nuevoUsuario);
            return $r->Send();
        } catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }


}







?>