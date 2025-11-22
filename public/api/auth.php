<?php
require_once 'config.php';
require_once 'utils.php';
require_once 'password_utils.php';

// Configurar headers CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json; charset=utf-8');

// Manejar preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Obtener la acción
$action = $_GET['action'] ?? '';

try {
    switch ($action) {
        case 'login':
            handleLogin();
            break;
        case 'logout':
            handleLogout();
            break;
        case 'check':
            checkSession();
            break;
        case 'profile':
            getUserProfile();
            break;
        default:
            jsonResponse(false, 'Acción no válida', null, 400);
    }
} catch (Exception $e) {
    error_log("Error en auth.php: " . $e->getMessage());
    jsonResponse(false, 'Error interno del servidor', null, 500);
}

function handleLogin() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        jsonResponse(false, 'Método no permitido', null, 405);
        return;
    }

    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        jsonResponse(false, 'Datos JSON inválidos', null, 400);
        return;
    }

    $username = trim($input['username'] ?? '');
    $password = $input['password'] ?? '';

    // Validar campos requeridos
    if (empty($username) || empty($password)) {
        jsonResponse(false, 'Usuario y contraseña son requeridos', null, 400);
        return;
    }

    // Validar longitud
    if (strlen($username) < 3 || strlen($password) < 6) {
        jsonResponse(false, 'Credenciales inválidas', null, 401);
        return;
    }

    global $pdo;
    
    try {
        // Buscar usuario por username o email
        $stmt = $pdo->prepare("
            SELECT id, username, email, password_hash, nombre_completo, role, activo 
            FROM usuarios 
            WHERE (username = ? OR email = ?) AND activo = 1
        ");
        $stmt->execute([$username, $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            jsonResponse(false, 'Credenciales inválidas', null, 401);
            return;
        }

        // Verificar contraseña
        error_log("Intentando login para usuario: " . $user['username']);
        error_log("Hash almacenado: " . $user['password_hash']);
        
        // Primero intentar con nuestro sistema personalizado
        $passwordValid = verifyPasswordHash($password, $user['password_hash']);
        
        // Si no funciona y el hash parece ser de PHP, intentar migrar
        if (!$passwordValid && strpos($user['password_hash'], '$2y$') === 0) {
            error_log("Intentando verificar con password_verify de PHP");
            if (function_exists('password_verify') && password_verify($password, $user['password_hash'])) {
                error_log("Contraseña verificada con PHP, migrando a formato personalizado");
                // Migrar al nuevo formato
                $newHash = createPasswordHash($password);
                $updateHashStmt = $pdo->prepare("UPDATE usuarios SET password_hash = ? WHERE id = ?");
                $updateHashStmt->execute([$newHash, $user['id']]);
                $passwordValid = true;
            }
        }
        
        if (!$passwordValid) {
            error_log("Contraseña inválida para usuario: " . $user['username']);
            jsonResponse(false, 'Credenciales inválidas', null, 401);
            return;
        }
        
        error_log("Login exitoso para usuario: " . $user['username']);

        // Actualizar último acceso
        $updateStmt = $pdo->prepare("UPDATE usuarios SET ultimo_acceso = NOW() WHERE id = ?");
        $updateStmt->execute([$user['id']]);

        // Crear sesión
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['nombre_completo'] = $user['nombre_completo'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['login_time'] = time();

        // Regenerar ID de sesión por seguridad
        session_regenerate_id(true);

        // Respuesta exitosa (sin incluir datos sensibles)
        $userData = [
            'id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'nombre_completo' => $user['nombre_completo'],
            'role' => $user['role']
        ];

        jsonResponse(true, 'Inicio de sesión exitoso', $userData);

    } catch (PDOException $e) {
        error_log("Error de base de datos en login: " . $e->getMessage());
        jsonResponse(false, 'Error interno del servidor', null, 500);
    }
}

function handleLogout() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        jsonResponse(false, 'Método no permitido', null, 405);
        return;
    }

    // Destruir sesión
    if (session_status() === PHP_SESSION_ACTIVE) {
        $_SESSION = array();
        
        // Eliminar cookie de sesión
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        session_destroy();
    }

    jsonResponse(true, 'Sesión cerrada exitosamente');
}

function checkSession() {
    if (!isAuthenticated()) {
        jsonResponse(false, 'No autenticado', null, 401);
        return;
    }

    // Verificar si la sesión no ha expirado (24 horas)
    $loginTime = $_SESSION['login_time'] ?? 0;
    $sessionTimeout = 24 * 60 * 60; // 24 horas en segundos

    if (time() - $loginTime > $sessionTimeout) {
        handleLogout();
        jsonResponse(false, 'Sesión expirada', null, 401);
        return;
    }

    $userData = [
        'id' => $_SESSION['user_id'],
        'username' => $_SESSION['username'],
        'email' => $_SESSION['email'],
        'nombre_completo' => $_SESSION['nombre_completo'],
        'role' => $_SESSION['role']
    ];

    jsonResponse(true, 'Sesión válida', $userData);
}

function getUserProfile() {
    if (!isAuthenticated()) {
        jsonResponse(false, 'No autenticado', null, 401);
        return;
    }

    global $pdo;
    
    try {
        $stmt = $pdo->prepare("
            SELECT id, username, email, nombre_completo, role, ultimo_acceso, created_at 
            FROM usuarios 
            WHERE id = ? AND activo = 1
        ");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            jsonResponse(false, 'Usuario no encontrado', null, 404);
            return;
        }

        jsonResponse(true, 'Perfil obtenido exitosamente', $user);

    } catch (PDOException $e) {
        error_log("Error obteniendo perfil: " . $e->getMessage());
        jsonResponse(false, 'Error interno del servidor', null, 500);
    }
}

function isAuthenticated() {
    return isset($_SESSION['user_id']) && 
           isset($_SESSION['username']) && 
           isset($_SESSION['login_time']);
}

function requireAuth() {
    if (!isAuthenticated()) {
        jsonResponse(false, 'Acceso no autorizado', null, 401);
        exit();
    }
    
    // Verificar expiración de sesión
    $loginTime = $_SESSION['login_time'] ?? 0;
    $sessionTimeout = 24 * 60 * 60; // 24 horas

    if (time() - $loginTime > $sessionTimeout) {
        handleLogout();
        jsonResponse(false, 'Sesión expirada', null, 401);
        exit();
    }
}

function requireRole($requiredRole) {
    requireAuth();
    
    $userRole = $_SESSION['role'] ?? '';
    
    // Admin tiene acceso a todo
    if ($userRole === 'admin') {
        return true;
    }
    
    // Verificar rol específico
    if ($userRole !== $requiredRole) {
        jsonResponse(false, 'Permisos insuficientes', null, 403);
        exit();
    }
    
    return true;
}
?>