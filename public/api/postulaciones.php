<?php
require_once 'config.php';
require_once 'auth.php';
require_once 'controllers/PostulacionController.php';

// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Obtener método HTTP y acción
$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;

// Verificar autenticación para operaciones de escritura y lectura administrativa
if (in_array($method, ['POST', 'PUT', 'DELETE']) && !isAuthenticated()) {
    ResponseView::unauthorized('Acceso no autorizado');
}

// Para operaciones GET administrativas también requerir autenticación
if ($method === 'GET' && in_array($action, ['list', 'get', 'stats']) && !isAuthenticated()) {
    ResponseView::unauthorized('Acceso no autorizado');
}

// Crear instancia del controlador
$controller = new PostulacionController();

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
            handlePutRequest($controller, $action, $id);
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
            
        case 'stats':
            $controller->stats();
            break;
            
        default:
            ResponseView::error('Acción no válida', 400);
    }
}

/**
 * Manejar peticiones PUT
 */
function handlePutRequest($controller, $action, $id) {
    switch ($action) {
        case 'update-status':
            $controller->updateStatus($id);
            break;
            
        case 'add-note':
            $controller->addNote($id);
            break;
            
        default:
            ResponseView::error('Acción no válida', 400);
    }
}

// === FUNCIONES GET ===
function handleGet($action) {
    switch ($action) {
        case 'list':
        case '':
            getPostulaciones();
            break;
        case 'get':
            getPostulacion();
            break;
        case 'stats':
            getStats();
            break;
        default:
            getPostulaciones();
    }
}

function getPostulaciones() {
    $db = getDB();
    
    try {
        $page = (int)($_GET['page'] ?? 1);
        $limit = (int)($_GET['limit'] ?? 20);
        $status = $_GET['status'] ?? '';
        $search = $_GET['search'] ?? '';
        
        $offset = ($page - 1) * $limit;
        
        // Construir query
        $whereConditions = [];
        $params = [];
        
        if (!empty($status)) {
            $whereConditions[] = "status = ?";
            $params[] = $status;
        }
        
        if (!empty($search)) {
            $whereConditions[] = "(nombres LIKE ? OR email LIKE ? OR universidad LIKE ?)";
            $searchTerm = "%$search%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }
        
        $whereClause = !empty($whereConditions) ? "WHERE " . implode(" AND ", $whereConditions) : "";
        
        // Obtener total
        $countStmt = $db->prepare("SELECT COUNT(*) FROM postulaciones $whereClause");
        $countStmt->execute($params);
        $total = $countStmt->fetchColumn();
        
        // Obtener postulaciones paginadas
        $stmt = $db->prepare("
            SELECT id, nombres, email, telefono, universidad, carrera, anio_estudio, 
                   edad, disponibilidad, cv_filename, cv_original_name, status, 
                   created_at, updated_at
            FROM postulaciones 
            $whereClause
            ORDER BY created_at DESC 
            LIMIT ? OFFSET ?
        ");
        
        $params[] = $limit;
        $params[] = $offset;
        $stmt->execute($params);
        $postulaciones = $stmt->fetchAll();

        sendResponse(true, 'Postulaciones obtenidas', [
            'postulaciones' => $postulaciones,
            'pagination' => [
                'page' => $page,
                'limit' => $limit,
                'total' => $total,
                'pages' => ceil($total / $limit)
            ]
        ]);
    } catch (Exception $e) {
        sendError('Error al obtener postulaciones: ' . $e->getMessage());
    }
}

function getPostulacion() {
    $id = $_GET['id'] ?? null;
    
    if (!$id) sendError('ID requerido');

    $db = getDB();
    
    try {
        $stmt = $db->prepare("SELECT * FROM postulaciones WHERE id = ?");
        $stmt->execute([$id]);
        $postulacion = $stmt->fetch();

        if (!$postulacion) sendError('Postulación no encontrada', 404);

        sendResponse(true, 'Postulación obtenida', $postulacion);
    } catch (Exception $e) {
        sendError('Error al obtener postulación: ' . $e->getMessage());
    }
}

function getStats() {
    $db = getDB();
    
    try {
        // Total de postulaciones
        $stmt = $db->prepare("SELECT COUNT(*) as total FROM postulaciones");
        $stmt->execute();
        $total = $stmt->fetchColumn();

        // Por status
        $stmt = $db->prepare("
            SELECT status, COUNT(*) as count 
            FROM postulaciones 
            GROUP BY status
        ");
        $stmt->execute();
        $byStatus = $stmt->fetchAll();

        // Por universidad
        $stmt = $db->prepare("
            SELECT universidad, COUNT(*) as count 
            FROM postulaciones 
            GROUP BY universidad 
            ORDER BY count DESC 
            LIMIT 10
        ");
        $stmt->execute();
        $byUniversidad = $stmt->fetchAll();

        // Por carrera
        $stmt = $db->prepare("
            SELECT carrera, COUNT(*) as count 
            FROM postulaciones 
            GROUP BY carrera 
            ORDER BY count DESC 
            LIMIT 10
        ");
        $stmt->execute();
        $byCarrera = $stmt->fetchAll();

        // Por mes (últimos 6 meses)
        $stmt = $db->prepare("
            SELECT 
                DATE_FORMAT(created_at, '%Y-%m') as mes,
                COUNT(*) as count
            FROM postulaciones 
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
            GROUP BY DATE_FORMAT(created_at, '%Y-%m')
            ORDER BY mes DESC
        ");
        $stmt->execute();
        $byMonth = $stmt->fetchAll();

        sendResponse(true, 'Estadísticas obtenidas', [
            'total' => $total,
            'by_status' => $byStatus,
            'by_universidad' => $byUniversidad,
            'by_carrera' => $byCarrera,
            'by_month' => $byMonth
        ]);
    } catch (Exception $e) {
        sendError('Error al obtener estadísticas: ' . $e->getMessage());
    }
}

// === FUNCIONES POST ===
function handlePost($action) {
    switch ($action) {
        case 'create':
        case '':
            createPostulacion();
            break;
        default:
            sendError('Acción no válida');
    }
}

function createPostulacion() {
    // Obtener datos del formulario
    $data = [
        'nombres' => cleanInput($_POST['nombres'] ?? ''),
        'telefono' => cleanInput($_POST['telefono'] ?? ''),
        'email' => cleanInput($_POST['email'] ?? ''),
        'universidad' => cleanInput($_POST['universidad'] ?? ''),
        'universidad_otros' => cleanInput($_POST['universidadOtros'] ?? ''),
        'anio_estudio' => cleanInput($_POST['anioEstudio'] ?? ''),
        'edad' => cleanInput($_POST['edad'] ?? ''),
        'carrera' => cleanInput($_POST['carrera'] ?? ''),
        'carrera_otro' => cleanInput($_POST['carreraOtro'] ?? ''),
        'experiencia_previa' => cleanInput($_POST['experienciaPrevia'] ?? ''),
        'disponibilidad' => cleanInput($_POST['disponibilidad'] ?? ''),
        'terminos' => isset($_POST['terminos']) ? 1 : 0
    ];

    // Validar datos
    $errors = validatePostulacion($data);
    if (!empty($errors)) {
        sendError('Datos inválidos: ' . implode(', ', $errors));
    }

    $db = getDB();
    
    try {
        // Verificar email único
        $stmt = $db->prepare("SELECT COUNT(*) FROM postulaciones WHERE email = ?");
        $stmt->execute([$data['email']]);
        if ($stmt->fetchColumn() > 0) {
            sendError('Ya existe una postulación con este email');
        }

        // Subir CV
        if (!isset($_FILES['cv']) || $_FILES['cv']['error'] !== UPLOAD_ERR_OK) {
            sendError('CV requerido');
        }
        
        try {
            $cvFilename = uploadCV($_FILES['cv']);
            $cvOriginalName = $_FILES['cv']['name'];
        } catch (Exception $e) {
            sendError($e->getMessage());
        }

        // Insertar en base de datos
        $stmt = $db->prepare("
            INSERT INTO postulaciones (
                nombres, telefono, email, universidad, universidad_otros, 
                anio_estudio, edad, carrera, carrera_otro, experiencia_previa, 
                disponibilidad, cv_filename, cv_original_name, terminos
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $data['nombres'], $data['telefono'], $data['email'], 
            $data['universidad'], $data['universidad_otros'], $data['anio_estudio'],
            $data['edad'], $data['carrera'], $data['carrera_otro'], 
            $data['experiencia_previa'], $data['disponibilidad'], 
            $cvFilename, $cvOriginalName, $data['terminos']
        ]);

        $postulacionId = $db->lastInsertId();

        // Enviar notificaciones
        sendConfirmationEmail($data['email'], $data['nombres']);
        notifyAdmins($data);

        sendResponse(true, 'Postulación enviada exitosamente', [
            'id' => $postulacionId,
            'nombres' => $data['nombres'],
            'email' => $data['email']
        ], 201);

    } catch (Exception $e) {
        sendError('Error al crear postulación: ' . $e->getMessage());
    }
}

// === FUNCIONES PUT ===
function handlePut($action) {
    switch ($action) {
        case 'update-status':
            updateStatus();
            break;
        case 'add-notes':
            addNotes();
            break;
        default:
            sendError('Acción no válida');
    }
}

function updateStatus() {
    $id = $_GET['id'] ?? $_POST['id'] ?? null;

    // Obtener datos PUT
    $inputData = [];
    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        $rawInput = file_get_contents('php://input');
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        if (strpos($contentType, 'application/json') !== false) {
            $inputData = json_decode($rawInput, true) ?? [];
        } else {
            parse_str($rawInput, $inputData);
        }
    }
    
    $status = cleanInput($_POST['status'] ?? $inputData['status'] ?? '');
    
    if (!$id || !$status) sendError('ID y status requeridos');

    $validStatuses = ['pending', 'reviewed', 'accepted', 'rejected'];
    if (!in_array($status, $validStatuses)) {
        sendError('Status no válido');
    }

    $db = getDB();
    
    try {
        $stmt = $db->prepare("
            UPDATE postulaciones 
            SET status = ?, updated_at = CURRENT_TIMESTAMP 
            WHERE id = ?
        ");
        $stmt->execute([$status, $id]);

        if ($stmt->rowCount() === 0) {
            sendError('Postulación no encontrada', 404);
        }

        sendResponse(true, 'Status actualizado exitosamente');

    } catch (Exception $e) {
        sendError('Error al actualizar status: ' . $e->getMessage());
    }
}

function addNotes() {
    $id = $_GET['id'] ?? $_POST['id'] ?? null;
    
    // Obtener datos PUT
    $inputData = [];
    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        $rawInput = file_get_contents('php://input');
        parse_str($rawInput, $inputData);
    }
    
    $notas = cleanInput($_POST['notas'] ?? $inputData['notas'] ?? '');

    if (!$id) sendError('ID requerido');

    $db = getDB();
    
    try {
        $stmt = $db->prepare("
            UPDATE postulaciones 
            SET notas_admin = ?, updated_at = CURRENT_TIMESTAMP 
            WHERE id = ?
        ");
        $stmt->execute([$notas, $id]);

        if ($stmt->rowCount() === 0) {
            sendError('Postulación no encontrada', 404);
        }

        sendResponse(true, 'Notas actualizadas exitosamente');

    } catch (Exception $e) {
        sendError('Error al actualizar notas: ' . $e->getMessage());
    }
}

// === FUNCIONES DELETE ===
function handleDelete($action) {
    switch ($action) {
        case 'delete':
            deletePostulacion();
            break;
        default:
            sendError('Acción no válida');
    }
}

function deletePostulacion() {
    $id = $_GET['id'] ?? null;
    
    if (!$id) sendError('ID requerido');

    $db = getDB();
    
    try {
        // Obtener datos antes de eliminar
        $stmt = $db->prepare("SELECT cv_filename FROM postulaciones WHERE id = ?");
        $stmt->execute([$id]);
        $postulacion = $stmt->fetch();

        if (!$postulacion) sendError('Postulación no encontrada', 404);

        // Eliminar archivo CV
        if (!empty($postulacion['cv_filename'])) {
            $cvPath = CV_PATH . $postulacion['cv_filename'];
            if (file_exists($cvPath)) {
                unlink($cvPath);
            }
        }

        // Eliminar de la base de datos
        $stmt = $db->prepare("DELETE FROM postulaciones WHERE id = ?");
        $stmt->execute([$id]);

        sendResponse(true, 'Postulación eliminada exitosamente');

    } catch (Exception $e) {
        sendError('Error al eliminar postulación: ' . $e->getMessage());
    }
}

// === FUNCIONES AUXILIARES ===
function validatePostulacion($data) {
    $errors = [];
    
    if (empty($data['nombres'])) $errors[] = 'Nombres requeridos';
    if (empty($data['email'])) $errors[] = 'Email requerido';
    if (empty($data['telefono'])) $errors[] = 'Teléfono requerido';
    if (empty($data['universidad'])) $errors[] = 'Universidad requerida';
    if (empty($data['carrera'])) $errors[] = 'Carrera requerida';
    if (empty($data['anio_estudio'])) $errors[] = 'Año de estudio requerido';
    if (empty($data['edad'])) $errors[] = 'Edad requerida';
    if (empty($data['disponibilidad'])) $errors[] = 'Disponibilidad requerida';
    if (!$data['terminos']) $errors[] = 'Debe aceptar los términos';
    
    // Validar email
    if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email no válido';
    }
    
    // Validar edad
    if (!empty($data['edad']) && (!is_numeric($data['edad']) || $data['edad'] < 16 || $data['edad'] > 100)) {
        $errors[] = 'Edad debe estar entre 16 y 100 años';
    }
    
    return $errors;
}

function sendConfirmationEmail($email, $nombres) {
    try {
        $subject = "Confirmación de postulación - Munay Ruray";
        $message = "
            Hola $nombres,
            
            Hemos recibido tu postulación para ser voluntario en Munay Ruray.
            Te contactaremos pronto para continuar con el proceso.
            
            ¡Gracias por tu interés en ser parte del cambio!
            
            Equipo Munay Ruray
        ";
        
        mail($email, $subject, $message);
        error_log("Email de confirmación enviado a: $email");
    } catch (Exception $e) {
        error_log("Error enviando email de confirmación: " . $e->getMessage());
    }
}

function notifyAdmins($data) {
    try {
        $adminEmail = "aticona@roomstudio.pe";
        $subject = "Nueva postulación recibida";
        $message = "
            Nueva postulación recibida:
            
            Nombre: {$data['nombres']}
            Email: {$data['email']}
            Universidad: {$data['universidad']}
            Carrera: {$data['carrera']}
            
            Revisa el panel de administración para más detalles.
        ";
        
        mail($adminEmail, $subject, $message);
        error_log("Notificación de admin enviada para: " . $data['nombres']);
    } catch (Exception $e) {
        error_log("Error enviando notificación de admin: " . $e->getMessage());
    }
}
?>