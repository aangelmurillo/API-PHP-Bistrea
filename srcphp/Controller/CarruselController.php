<?php

namespace proyecto\Controller;

use proyecto\Models\config_carusel;
use proyecto\Models\Table;
use proyecto\Response\Failure;
use proyecto\Response\Success;

class CarruselController
{
    public function verImagenes()
    {
        $db = Table::query("SELECT * FROM configs_carusel");
        $db = new Success($db);

        $db->Send();
    }

    public function insertarImagenesCarrusel()
    {
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $carrusel = new config_carusel();

            // Crear un array para almacenar las imágenes
            $imagenes = [];

            // Manejar cada imagen por separado
            foreach (['img_uno', 'img_dos', 'img_tres', 'img_cuatro'] as $imagenKey) {
                $imagenBase64 = $dataObject->$imagenKey;
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

                $rutaImagen = '/var/www/html/apiPhp/public/img/carrusel/' . $nombreImagen;

                file_put_contents($rutaImagen, $imagenData);

                // Almacenar la ruta de la imagen en el array
                $imagenes[$imagenKey] = $rutaImagen;
            }

            // Asignar las rutas de las imágenes al objeto $carrusel
            $carrusel->img_uno = $imagenes['img_uno'];
            $carrusel->img_dos = $imagenes['img_dos'];
            $carrusel->img_tres = $imagenes['img_tres'];
            $carrusel->img_cuatro = $imagenes['img_cuatro'];

            // Guardar el objeto $carrusel en la base de datos
            $carrusel->save();

            // Devolver una respuesta de éxito
            $r = new Success($carrusel);
            return $r->Send();
        } catch (\Exception $e) {
            // Devolver una respuesta de error en caso de excepción
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }



}