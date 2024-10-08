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


            if ($JSONData === false) {
                throw new \Exception("Error al leer la entrada JSON.");
            }

            $dataObject = json_decode($JSONData);

            if ($dataObject === null) {
                throw new \Exception("Error al decodificar el JSON.");
            }

            // Validar si el correo o teléfono ya están registrados
            $existingEmail = usuario::where('email_usuario', '=', $dataObject->email_usuario);
            $existingPhone = usuario::where('telefono_usuario', '=', $dataObject->telefono_usuario);

            if ($existingEmail) {
                throw new \Exception("El correo electrónico ya está registrado.");
            }

            if ($existingPhone) {
                throw new \Exception("El teléfono ya está registrado.");
            }


            $usuario->nombre_usuario = $dataObject->nombre_usuario;
            $usuario->apellido_p_usuario = $dataObject->apellido_p_usuario;
            $usuario->apellido_m_usuario = $dataObject->apellido_m_usuario;
            $usuario->email_usuario = $dataObject->email_usuario;
            $usuario->contrasena_usuario = password_hash($dataObject->contrasena_usuario, PASSWORD_DEFAULT);

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