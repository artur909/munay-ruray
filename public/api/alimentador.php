<?php
require_once 'config.php';
require_once 'auth.php';
require_once 'controllers/ExperienciaController.php';

// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Obtener método HTTP y acción
$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;

// Verificar autenticación para operaciones de escritura
if (in_array($method, ['POST', 'PUT', 'DELETE']) && !isAuthenticated()) {
    ResponseView::unauthorized('Acceso no autorizado');
}

// Crear instancia del controlador
$controller = new ExperienciaController();

// Enrutamiento basado en método HTTP y acción
try {
    switch ($method) {
        case 'GET':
            handleGetRequest($controller, $action, $id);
            break;
            
        case 'POST':
            $controller->store();
            break;
            
        case 'PUT':
            if (!$id) {
                ResponseView::validationError(['ID requerido para actualización']);
            }
            $controller->update($id);
            break;
            
        case 'DELETE':
            if (!$id) {
                ResponseView::validationError(['ID requerido para eliminación']);
            }
            $controller->destroy($id);
            break;
            
        default:
            ResponseView::methodNotAllowed();
    }
} catch (Exception $e) {
    ResponseView::serverError($e->getMessage());
}

/**
 * Manejar peticiones GET
 */
function handleGetRequest($controller, $action, $id) {
    switch ($action) {
        case 'list':
            $controller->index();
            break;
            
        case 'get':
            if (!$id) {
                ResponseView::validationError(['ID requerido']);
            }
            $controller->show($id);
            break;
            
        case 'slug':
            $slug = $_GET['slug'] ?? null;
            if (!$slug) {
                ResponseView::validationError(['Slug requerido']);
            }
            $controller->getBySlug($slug);
            break;
            
        case 'featured':
            $controller->featured();
            break;
            
        case 'categories':
            $controller->categories();
            break;
            
        case 'toggle-featured':
            if (!$id) {
                ResponseView::validationError(['ID requerido']);
            }
            $controller->toggleFeatured($id);
            break;
            
        default:
            ResponseView::error('Acción no válida', 400);
    }
}


?>