<?php
namespace proyecto;

use proyecto\Controller\PedidoCafeController;
use proyecto\Controller\UsuarioController;

require("../vendor/autoload.php");

/*use PDOException;
use PDO;*/
use proyecto\Controller\UserController;
use proyecto\Controller\EmpleadoController;
use proyecto\Controller\ProductosController;
use proyecto\Controller\PedidoController;
use proyecto\Controller\ResenasController;
use proyecto\Models\empleado;
use proyecto\Models\User;
use proyecto\Models\usuario;
use proyecto\Models\producto;
use proyecto\Response\Failure;
use proyecto\Response\Success;

date_default_timezone_set('America/Monterrey');

Router::headers();
Router::getBearerToken();

Router::get("/", function () {
    echo "Bienvenido";
});


// Ver los pedidos totales desde cafe
Router::get("/verpedidostotales", [PedidoCafeController::class, "verpedidos"]);

// Ver los detalles de pedido
Router::get("/verdetallespedido", [PedidoCafeController::class, "verdetallespedido"]);

// Ver los detalles de tipo cafe
Router::get("/detallespepidotipocafe", [PedidoCafeController::class, "detallespepidotipocafe"]);

// Ver los detallespedidope
Router::get("/detallespedidope", [PedidoCafeController::class, "detallespedidope"]);

// Ver los ingresar pedido
Router::post("/ingresarpedido", [PedidoCafeController::class, "ingresarpedido"]);


// Routers de prueba para saber si funciona el mod_rewrite y el PDO
/*

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
    try {;
        $pdo = new PDO('mysql:host=localhost;dbname=cafeteria', "Angel", "12345");
        $pdo = new PDO('mysql:host=localhost;dbname=cafeteria', "bistrea", "bistrea1234");
        echo "Conexión exitosa!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
});
*/

// Ruta para ver usuarios para apartado de admin
Router::get("/verusuariosadmin", [UsuarioController::class, "verUsuariosAdmin"]);


// Ruta para ver resumen pedidos pendientes
Router::get("/verresumenpedidospendientes", [PedidoController::class, "verresumenpedidospendientes"]);

// Ruta para barista pendientes
Router::get("/verpedidospendientes", [PedidoController::class, "verpedidospendientes"]);

// Ruta para liberar y cancelar pedidos
Router::post("/liberarcancelarpedidos", [PedidoController::class, "liberarcancelarpedidos"]);

//ruta para ver productos vendidos
Router::get('/verproductosvendidos', [ProductosController::class, "verproductosvendidos"]);

// Ruta para actualizar producto
Router::post("/actualizarproducto", [ProductosController::class, "actualizarproducto"]);

// Ruta para eliminar producto
Router::post("/eliminarproducto", [ProductosController::class, "eliminarproducto"]);

//ruta para ver corte de caja
Router::get('/vercortedecaja', [PedidoController::class, "vercortedecaja"]);

// ruta para ver resenas
Router::get('/verresenas', [ResenasController::class, "verresenas"]);

// ruta para hacer resena
Router::post('/hacerresena', [ResenasController::class, "hacerresena"]);

// Ruta para actualizar el stock en producto
Router::post("/actualizarstock", [ProductosController::class, "actualizarstock"]);

//ver productos
Router::get('/verproductos', [ProductosController::class, "verproductos"]);

//ver barista
Router::get('/verempleados', [EmpleadoController::class, 'verempleados']);


//ver usuarios
Router::get('/verusuario', [UsuarioController::class, 'verusuario']);

//prueba usuarios
Router::post('/usuario', [UsuarioController::class, 'all', true]);
//                   /$id, fuction ($id) 

//ver pedidos
Router::get('/verpedidos', [PedidoController::class, 'verpedido']);


//funcion login
Router::post('/login', [UserController::class, "login"]);


//verificacion de correo y contrasena
Router::post('/verificacion', [UserController::class, "verificar"]);


//actualizar productos
Router::put('/productoa', [ProductosController::class, "actualizarProd"]);


//insertar productos
Router::post('/insertarproducto', [ProductosController::class, "Insertarproducto"]);


//registro usuario
Router::post('/registrousuario', [UserController::class, 'registrousuario']);


//authenticacion
Router::post('/auth', [UserController::class, 'auth']);

//obtener contrasena
Router::get('/contrasena', [UserController::class, 'getpassword']);

Router::get('/all', [UserController::class, 'all']);

//ingresar empleado
Router::post("/altaempleado", [EmpleadoController::class, "altaempleado"]);
//hacer pedido
Router::post("/hacerpedido", [PedidoController::class, "hacerpedido"]);
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