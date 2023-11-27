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
        $db = Table::query("SELECT * FROM config_carusel");
        $db = new Success($db);

        $db->Send();
    }

    public function insertarImagenesCarrusel()
    {
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $carrusel = new config_carusel();

            // Asumiendo que tienes cuatro imágenes (img_uno, img_dos, img_tres, img_cuatro)
            $imagenBase64_1 = $dataObject->img_uno;
            $imagenBase64_2 = $dataObject->img_dos;
            $imagenBase64_3 = $dataObject->img_tres;
            $imagenBase64_4 = $dataObject->img_cuatro;

            // Puedes repetir esta lógica para cada imagen
            $rutaImagen_1 = $this->guardarImagen($imagenBase64_1);
            $rutaImagen_2 = $this->guardarImagen($imagenBase64_2);
            $rutaImagen_3 = $this->guardarImagen($imagenBase64_3);
            $rutaImagen_4 = $this->guardarImagen($imagenBase64_4);

            // Asignar las rutas al modelo config_carusel
            $carrusel->img_uno = $rutaImagen_1;
            $carrusel->img_dos = $rutaImagen_2;
            $carrusel->img_tres = $rutaImagen_3;
            $carrusel->img_cuatro = $rutaImagen_4;

            // Guardar el modelo en la base de datos
            $carrusel->save();

            $r = new Success($carrusel);
            return $r->Send();
        } catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }

    private function guardarImagen($imagenBase64)
    {
        // Decodificar la imagen base64
        $imagenData = base64_decode($imagenBase64);

        // Obtener la extensión del archivo desde los datos base64
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

        // Generar un nombre de archivo único
        $nombreImagen = uniqid() . '.' . $fileExtension;

        // Especificar la ruta donde se guardará la imagen
        $rutaImagen = '/var/www/html/apiPhp/public/img/carrusel/' . $nombreImagen;

        // Guardar la imagen en el directorio especificado
        file_put_contents($rutaImagen, $imagenData);

        // Retorna la ruta donde se guardó la imagen
        return $rutaImagen;
    }


}