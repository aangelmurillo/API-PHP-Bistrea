<?php
namespace proyecto;
require("../vendor/autoload.php");
use proyecto\Controller\RegistroController;
use PDOException;
use PDO;
use proyecto\Models\User;
use proyecto\Response\Failure;
use proyecto\Response\Success;

Router::post("/registroUsuario", [RegistroController::class, "registrarUsuario"]);

Router::get("/obtenerImagenesCarrusel", );

// Routers de prueba para saber si funciona el mod_rewrite y el PDO
Router::get("/", function () {
    echo "Probando";
});

Router::get("/mostrar", function () {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=cafeteria', "bistrea", "bistrea1234");
        echo "Conexión exitosa!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
});




// Esto es codigo de ramiro
Router::get('/prueba', [crearPersonaController::class, "prueba"]);

Router::get('/crearpersona', [crearPersonaController::class, "crearPersona"]);
Router::get('/usuario/buscar/$id', function ($id) {

    $user = User::find($id);
    if (!$user) {
        $r = new Failure(404, "no se encontro el usuario");
        return $r->Send();
    }
    $r = new Success($user);
    return $r->Send();


});
Router::get('/respuesta', [crearPersonaController::class, "response"]);
Router::any('/404', '../views/404.php');


?>