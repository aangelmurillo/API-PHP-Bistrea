<?php
namespace proyecto;

use proyecto\Controller\CarritoController;
use proyecto\Controller\PedidoCafeController;
use proyecto\Controller\SMTPController;
use proyecto\Controller\UsuarioController;

require("../vendor/autoload.php");

/*use PDOException;
use PDO;*/
use proyecto\Controller\PedidoPostreController;
use proyecto\Controller\UserController;
use proyecto\Controller\EmpleadoController;
use proyecto\Controller\ProductosController;
use proyecto\Controller\PedidoController;
use proyecto\Controller\ResenasController;
use proyecto\Controller\VerificarController;
use proyecto\Models\empleado;
use proyecto\Models\User;
use proyecto\Models\usuario;
use proyecto\Models\producto;
use proyecto\Models\producto_extra;
use proyecto\Response\Failure;
use proyecto\Response\Success;
use Dotenv\Dotenv;

date_default_timezone_set('America/Monterrey');

Router::headers();
Router::getBearerToken();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


Router::get("/", function () {
    echo "Bienvenido";
});

Router::get("/carrito", [CarritoController::class, "carrito"]);

// Router para enviar correo
// Router::post("/enviarcorreo", [SMTPController::class, "ejemploSMTP"]);


// Cambiar en proceso los pedidos a en solicitud
Router::post("/comprarpedido", [PedidoCafeController::class, "comprarpedido"]);

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

// actualizar datos del usuario
Router::post("/actualizardatosusuario", [UserController::class, "actualizardatosusuario"]);

// Cambio de contraseña
Router::post("/cambiarcontrasena", [UserController::class, "cambiarcontrasena"]);

// obtener historial pedidos
Router::post("/obtenerhistorialpedidos", [UserController::class, "obtenerhistorialpedidos"]);

// Ingresar pedido cafe
Router::post("/ingresarpedidocafe", [PedidoCafeController::class, "ingresarpedidocafe"]);

// Enviar pedido postre
Router::post("/ingresarpedidopostre", [PedidoPostreController::class, "ingresarpedidopostre"]);

// Ver los productos de postre
Router::get("/verpostres", [PedidoPostreController::class,"verpostres"]);

// Ver los productos
Router::get("/vercafes", [PedidoCafeController::class, "vercafes"]);

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

//ver productos extra
Router::get('/verproductosextra', [ProductosController::class, "verproductoextra"]);

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

// Ver pedidos en proceso
Router::post('/mostrarcarrito', [CarritoController::class, 'mostrarcarrito']);

// Router::get('/respuesta', [crearPersonaController::class, "response"]);
Router::any('/404', '../views/404.php');
?>