<?php
namespace proyecto;
require("../vendor/autoload.php");

/*use PDOException;
use PDO;*/
use proyecto\Controller\UserPersonaController;
use proyecto\Controller\UserController;
use proyecto\Controller\crearPersonaController;
use proyecto\Controller\AgendaController;
use proyecto\Controller\ProductosController;
use proyecto\Models\empleado;
use proyecto\Controller\UsuarioController;
use proyecto\Controller\RegistroController;
use proyecto\Controller\CarruselController;
use proyecto\Models\User;
use proyecto\Models\usuario;
use proyecto\Models\producto;
use proyecto\Response\Failure;
use proyecto\Response\Success;

// Routers de prueba para saber si funciona el mod_rewrite y el PDO
/*
Router::headers();

// Registrar Usuario
Router::post("/registroUsuario", [RegistroController::class, "registrarUsuario"]);

// Ver usuarios
Router::get("/verUsuarios", [UsuarioController::class,"verUsuarios"]);

// Ver imagenes 
Router::get("/verImagenesCarrusel", [CarruselController::class, "verImagenes"]);

// Insertar imagenes para el carrusel
Router::post("/obtenerImagenes", [CarruselController::class, "insertarImagenesCarrusel"]);

// Routers de prueba para saber si funciona el mod_rewrite y el PDO
Router::get("/", function () {
    echo "Probando";
});

Router::get("/mostrar", function () {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=cafeteria', "Angel", "12345");
        $pdo = new PDO('mysql:host=localhost;dbname=cafeteria', "bistrea", "bistrea1234");
        echo "Conexión exitosa!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
});
*/



// Esto es codigo de ramiro
//Router::get('/crearpersona', [crearPersonaController::class, "crearPersona"]);
//Router::get('/prueba', [crearPersonaController::class, "prueba"]);

//codigo pepechuy
//ver productos
Router::get('/verproductos', [producto::class, "prod"]);
//ver barista
Router::get('/empleado',[empleado::class,'emp']);
Router::get('/usuario',[usuario::class,'usuario']);
Router::post('/login',[UserController::class,"login"]);
Router::post('/verificacion',[UserController::class,"verificar"]);
Router::put('/productoa',[ProductosController::class,"actualizarProd"]);
Router::post('/productoi',[ProductosController::class, "Insertarprod"]);
Router::post('/usuarioi',[UserController::class,'registro']);
Router::post('/auth',[usuario::class,'auth']);
Router::get('/contrasena', [UserController::class, 'getpassword']);
Router::post('/empleadoin',[AgendaController::class,'Insertaremplead']);
// Router::get('/prueba', [crearPersonaController::class, "prueba"]);

// Router::get('/crearpersona', [crearPersonaController::class, "crearPersona"]);
Router::get('/usuario/buscar/$id', function ($id) {

    $user = User::find($id);
    if (!$user) {
        $r = new Failure(404, "no se encontro el usuario");
        return $r->Send();
    }
    $r = new Success($user);
    return $r->Send();


});
// Router::get('/respuesta', [crearPersonaController::class, "response"]);
Router::any('/404', '../views/404.php');


?>