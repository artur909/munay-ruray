<?php
// Configuración de la base de datos y constantes del sistema
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Configurar límites de PHP programáticamente
ini_set('upload_max_filesize', '10M');
ini_set('post_max_size', '12M');
ini_set('max_execution_time', '300');
ini_set('max_input_time', '300');
ini_set('memory_limit', '256M');

// Manejar preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

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
define('DIST_PATH', '../dist/');
define('EXPERIENCIAS_PATH', DIST_PATH . 'experiencias/');

// Configuración de archivos
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/webp']);
define('ALLOWED_CV_TYPES', ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']);

// Función para conectar a la base de datos
function getDBConnection() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]);
        return $pdo;
    } catch (PDOException $e) {
        error_log("Error de conexión a la base de datos: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => 'Error de conexión a la base de datos']);
        exit();
    }
}

// Función para validar y sanitizar datos
function sanitizeInput($data) {
    if (is_array($data)) {
        return array_map('sanitizeInput', $data);
    }
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

// Función para generar slug único
function generateSlug($title) {
    $slug = strtolower($title);
    $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
    $slug = preg_replace('/[\s-]+/', '-', $slug);
    $slug = trim($slug, '-');
    return $slug;
}

// Función para crear directorios si no existen
function ensureDirectoryExists($path) {
    if (!is_dir($path)) {
        if (!mkdir($path, 0755, true)) {
            throw new Exception("No se pudo crear el directorio: " . $path);
        }
    }
}

// Función para responder con JSON
function jsonResponse($data, $status = 200) {
    http_response_code($status);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit();
}

// Función para manejar errores
function handleError($message, $status = 400) {
    error_log("API Error: " . $message);
    jsonResponse(['error' => $message], $status);
}

// Crear directorios necesarios
ensureDirectoryExists(IMAGES_PATH);
ensureDirectoryExists(CV_PATH);
ensureDirectoryExists(EXPERIENCIAS_PATH);

// Inicializar conexión a la base de datos
$pdo = getDBConnection();
?>