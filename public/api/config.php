<?php
// Configuración básica de la API
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Manejar preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Configurar límites de PHP
ini_set('upload_max_filesize', '10M');
ini_set('post_max_size', '12M');
ini_set('max_execution_time', '300');
ini_set('memory_limit', '256M');

// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'munay');
define('DB_USER', 'roomstudio');
define('DB_PASS', 'uxCXaroKV8sW7ZZ');
define('DB_CHARSET', 'utf8mb4');

// Rutas de archivos
define('ASSETS_PATH', '../assets/');
define('IMAGES_PATH', ASSETS_PATH . 'images/entradas/');
define('CV_PATH', ASSETS_PATH . 'postulaciones/cv/');

// Configuración de archivos
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/webp']);
define('ALLOWED_CV_TYPES', ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']);

// Variable global para la conexión PDO
$pdo = null;

// Función para obtener conexión a la base de datos
function getDB() {
    global $pdo;
    
    if ($pdo === null) {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]);
        } catch (PDOException $e) {
            error_log("Database connection error: " . $e->getMessage());
            sendError('Error de conexión a la base de datos', 500);
        }
    }
    
    return $pdo;
}

// Función para enviar respuesta JSON
function sendResponse($success, $message = '', $data = null, $status = 200) {
    http_response_code($status);
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ], JSON_UNESCAPED_UNICODE);
    exit();
}

// Función para enviar error
function sendError($message, $status = 400) {
    error_log("API Error: " . $message);
    sendResponse(false, $message, null, $status);
}

// Función para limpiar datos de entrada
function cleanInput($data) {
    if (is_array($data)) {
        return array_map('cleanInput', $data);
    }
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

// Función para generar slug
function createSlug($title) {
    $slug = strtolower($title);
    $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
    $slug = preg_replace('/[\s-]+/', '-', $slug);
    return trim($slug, '-');
}

// Función para crear directorios
function createDir($path) {
    if (!is_dir($path)) {
        if (!mkdir($path, 0755, true)) {
            throw new Exception("No se pudo crear el directorio: " . $path);
        }
    }
}

// Crear directorios necesarios
createDir(IMAGES_PATH);
createDir(CV_PATH);

// Función para validar datos de postulación
function validatePostulacion($data) {
    $errors = [];
    
    if (empty($data['nombres'])) $errors[] = 'Nombres requeridos';
    if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Email válido requerido';
    if (empty($data['telefono'])) $errors[] = 'Teléfono requerido';
    if (empty($data['universidad'])) $errors[] = 'Universidad requerida';
    if (empty($data['carrera'])) $errors[] = 'Carrera requerida';
    if (empty($data['anioEstudio'])) $errors[] = 'Año de estudio requerido';
    if (empty($data['edad']) || !is_numeric($data['edad'])) $errors[] = 'Edad válida requerida';
    if (empty($data['disponibilidad'])) $errors[] = 'Disponibilidad requerida';
    if (!isset($data['terminos']) || !$data['terminos']) $errors[] = 'Debe aceptar los términos';
    
    return $errors;
}

// Función para subir imagen
//function uploadImage($file, $prefix = '') {
//    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
//        throw new Exception('Error al subir la imagen');
//    }
//
//    if (!in_array($file['type'], ALLOWED_IMAGE_TYPES)) {
//        throw new Exception('Tipo de archivo no permitido');
//    }
//
//    if ($file['size'] > MAX_FILE_SIZE) {
//        throw new Exception('Archivo demasiado grande');
//    }
//
//    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
//    $filename = ($prefix ? $prefix . '_' : '') . time() . '.' . $extension;
//    $filepath = IMAGES_PATH . $filename;
//
//    if (!move_uploaded_file($file['tmp_name'], $filepath)) {
//        throw new Exception('Error al guardar la imagen');
//    }
//
//    return '/assets/images/entradas/' . $filename;
//}

// Función para subir CV
//function uploadCV($file) {
//    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
//        throw new Exception('Error al subir el CV');
//    }
//
//    if (!in_array($file['type'], ALLOWED_CV_TYPES)) {
//        throw new Exception('Tipo de archivo no permitido');
//    }
//
//    if ($file['size'] > MAX_FILE_SIZE) {
//        throw new Exception('Archivo demasiado grande');
//    }
//
//    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
//    $filename = 'cv_' . time() . '_' . uniqid() . '.' . $extension;
//    $filepath = CV_PATH . $filename;
//
//    if (!move_uploaded_file($file['tmp_name'], $filepath)) {
//        throw new Exception('Error al guardar el CV');
//    }
//
//    return $filename;
//}
?>