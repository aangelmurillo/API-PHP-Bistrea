<?php

namespace proyecto\Controller;

use proyecto\Models\Table;
use proyecto\Models\empleado;
use proyecto\Models\usuario;
use proyecto\Response\Failure;
use proyecto\Response\Success;

class EmpleadoController
{
    public function verempleados()
    {
        try {
            $emp = Table::query("select * from empleados");
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

    public function altaempleado()
    {
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $usuario = new usuario();
            $usuario->nombre_usuario = $dataObject->nombre_usuario;
            $usuario->apellido_p_usuario = $dataObject->apellido_p_usuario;
            $usuario->apellido_m_usuario = $dataObject->apellido_m_usuario;
            $usuario->email_usuario = $dataObject->email_usuario;
            $usuario->contrasena_usuario = password_hash($dataObject->contrasena_usuario, PASSWORD_DEFAULT);

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

            $rutaImagen = '/var/www/html/apiPhp/public/img/empleado/' . $nombreImagen;

            file_put_contents($rutaImagen, $imagenData);

            if (file_put_contents($rutaImagen, $imagenData) === false) {
                throw new \Exception('Error al guardar la imagen: ' . error_get_last()['message']);
            }

            $usuario->foto_perfil_usuario = $rutaImagen;

            $usuario->telefono_usuario = $dataObject->telefono_usuario;
            $usuario->status_usuario = 0;
            $usuario->creado_en_usuario = $dataObject->creado_en_usuario;
            $usuario->id_rol = $dataObject->id_rol;
            $usuario->save();

            $empleado = new empleado();
            $empleado->curp_empleado = $dataObject->curp_empleado;
            $empleado->rfc_empleado = $dataObject->rfc_empleado;
            $empleado->nss_empleado = $dataObject->nss_empleado;
            $empleado->salario_mes_empleado = $dataObject->salario_mes_empleado;
            $empleado->id_usuario = $usuario->id;
            $empleado->save();

            $r = new Success($empleado);
            return $r->Send();
        } catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }

}

?>