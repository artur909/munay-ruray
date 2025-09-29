<?php
require_once 'config.php';
require_once 'utils.php';

// Obtener método HTTP
$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

try {
    switch ($method) {
        case 'GET':
            handleGetRequest($action, $pdo);
            break;
        case 'POST':
            handlePostRequest($action, $pdo);
            break;
        case 'PUT':
            handlePutRequest($action, $pdo);
            break;
        case 'DELETE':
            handleDeleteRequest($action, $pdo);
            break;
        default:
            handleError('Método no permitido', 405);
    }
} catch (Exception $e) {
    handleError($e->getMessage(), 500);
}

// Manejar peticiones GET
function handleGetRequest($action, $pdo) {
    switch ($action) {
        case 'list':
            getAllPostulaciones($pdo);
            break;
        case 'get':
            getPostulacionById($pdo);
            break;
        case 'stats':
            getPostulacionesStats($pdo);
            break;
        default:
            getAllPostulaciones($pdo);
            break;
    }
}

// Manejar peticiones POST
function handlePostRequest($action, $pdo) {
    switch ($action) {
        case 'create':
        case '':
            createPostulacion($pdo);
            break;
        default:
            handleError('Acción no válida');
    }
}

// Manejar peticiones PUT
function handlePutRequest($action, $pdo) {
    switch ($action) {
        case 'update-status':
            updatePostulacionStatus($pdo);
            break;
        case 'add-notes':
            addNotesPostulacion($pdo);
            break;
        default:
            handleError('Acción no válida');
    }
}

// Manejar peticiones DELETE
function handleDeleteRequest($action, $pdo) {
    switch ($action) {
        case 'delete':
            deletePostulacion($pdo);
            break;
        default:
            handleError('Acción no válida');
    }
}

// Obtener todas las postulaciones
function getAllPostulaciones($pdo) {
    try {
        $page = (int)($_GET['page'] ?? 1);
        $limit = (int)($_GET['limit'] ?? 20);
        $status = $_GET['status'] ?? '';
        $search = $_GET['search'] ?? '';
        
        $offset = ($page - 1) * $limit;
        
        // Construir query base
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
        
        // Obtener total de registros
        $countStmt = $pdo->prepare("SELECT COUNT(*) FROM postulaciones $whereClause");
        $countStmt->execute($params);
        $total = $countStmt->fetchColumn();
        
        // Obtener postulaciones paginadas
        $stmt = $pdo->prepare("
            SELECT id, nombres, email, telefono, universidad, carrera, anio_estudio, 
                   edad, disponibilidad,cv_filename, cv_original_name, status, created_at, updated_at
            FROM postulaciones 
            $whereClause
            ORDER BY created_at DESC 
            LIMIT ? OFFSET ?
        ");
        
        $params[] = $limit;
        $params[] = $offset;
        $stmt->execute($params);
        $postulaciones = $stmt->fetchAll();

        jsonResponse([
            'success' => true,
            'data' => $postulaciones,
            'pagination' => [
                'page' => $page,
                'limit' => $limit,
                'total' => $total,
                'pages' => ceil($total / $limit)
            ]
        ]);
    } catch (Exception $e) {
        handleError('Error al obtener postulaciones: ' . $e->getMessage());
    }
}

// Obtener postulación por ID
function getPostulacionById($pdo) {
    $id = $_GET['id'] ?? null;
    
    if (!$id) {
        handleError('ID requerido');
    }

    try {
        $stmt = $pdo->prepare("SELECT * FROM postulaciones WHERE id = ?");
        $stmt->execute([$id]);
        $postulacion = $stmt->fetch();

        if (!$postulacion) {
            handleError('Postulación no encontrada', 404);
        }

        jsonResponse([
            'success' => true,
            'data' => $postulacion
        ]);
    } catch (Exception $e) {
        handleError('Error al obtener postulación: ' . $e->getMessage());
    }
}

// Obtener estadísticas de postulaciones
function getPostulacionesStats($pdo) {
    try {
        // Total de postulaciones
        $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM postulaciones");
        $stmt->execute();
        $total = $stmt->fetchColumn();

        // Por status
        $stmt = $pdo->prepare("
            SELECT status, COUNT(*) as count 
            FROM postulaciones 
            GROUP BY status
        ");
        $stmt->execute();
        $byStatus = $stmt->fetchAll();

        // Por universidad
        $stmt = $pdo->prepare("
            SELECT universidad, COUNT(*) as count 
            FROM postulaciones 
            GROUP BY universidad 
            ORDER BY count DESC 
            LIMIT 10
        ");
        $stmt->execute();
        $byUniversidad = $stmt->fetchAll();

        // Por carrera
        $stmt = $pdo->prepare("
            SELECT carrera, COUNT(*) as count 
            FROM postulaciones 
            GROUP BY carrera 
            ORDER BY count DESC 
            LIMIT 10
        ");
        $stmt->execute();
        $byCarrera = $stmt->fetchAll();

        // Postulaciones por mes (últimos 6 meses)
        $stmt = $pdo->prepare("
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

        jsonResponse([
            'success' => true,
            'data' => [
                'total' => $total,
                'by_status' => $byStatus,
                'by_universidad' => $byUniversidad,
                'by_carrera' => $byCarrera,
                'by_month' => $byMonth
            ]
        ]);
    } catch (Exception $e) {
        handleError('Error al obtener estadísticas: ' . $e->getMessage());
    }
}

// Crear nueva postulación
function createPostulacion($pdo) {
    try {
        // Obtener datos del formulario
        $data = [
            'nombres' => sanitizeInput($_POST['nombres'] ?? ''),
            'telefono' => sanitizeInput($_POST['telefono'] ?? ''),
            'email' => sanitizeInput($_POST['email'] ?? ''),
            'universidad' => sanitizeInput($_POST['universidad'] ?? ''),
            'universidad_otros' => sanitizeInput($_POST['universidadOtros'] ?? ''),
            'anio_estudio' => sanitizeInput($_POST['anioEstudio'] ?? ''),
            'edad' => sanitizeInput($_POST['edad'] ?? ''),
            'carrera' => sanitizeInput($_POST['carrera'] ?? ''),
            'carrera_otro' => sanitizeInput($_POST['carreraOtro'] ?? ''),
            'experiencia_previa' => sanitizeInput($_POST['experienciaPrevia'] ?? ''),
            'disponibilidad' => sanitizeInput($_POST['disponibilidad'] ?? ''),
            'terminos' => isset($_POST['terminos']) ? 1 : 0
        ];

        // Validar datos
        $errors = validatePostulacionData($data);
        if (!empty($errors)) {
            handleError('Datos inválidos: ' . implode(', ', $errors));
        }

        // Verificar si el email ya existe
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM postulaciones WHERE email = ?");
        $stmt->execute([$data['email']]);
        if ($stmt->fetchColumn() > 0) {
            handleError('Ya existe una postulación con este email');
        }

        // Subir CV
        $cvFilename = '';
        $cvOriginalName = '';
        if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
            $cvFilename = uploadCV($_FILES['cv']);
            $cvOriginalName = $_FILES['cv']['name'];
        } else {
            handleError('CV requerido');
        }

        // Insertar en base de datos
        $stmt = $pdo->prepare("
            INSERT INTO postulaciones (
                nombres, telefono, email, universidad, universidad_otros, 
                anio_estudio, edad, carrera, carrera_otro, experiencia_previa, 
                disponibilidad, cv_filename, cv_original_name, terminos
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $data['nombres'],
            $data['telefono'],
            $data['email'],
            $data['universidad'],
            $data['universidad_otros'],
            $data['anio_estudio'],
            $data['edad'],
            $data['carrera'],
            $data['carrera_otro'],
            $data['experiencia_previa'],
            $data['disponibilidad'],
            $cvFilename,
            $cvOriginalName,
            $data['terminos']
        ]);

        $postulacionId = $pdo->lastInsertId();

        // Enviar email de confirmación (opcional)
        sendConfirmationEmail($data['email'], $data['nombres']);

        // Notificar a administradores (opcional)
        notifyAdmins($data);

        jsonResponse([
            'success' => true,
            'message' => 'Postulación enviada exitosamente',
            'data' => [
                'id' => $postulacionId,
                'nombres' => $data['nombres'],
                'email' => $data['email']
            ]
        ], 201);

    } catch (Exception $e) {
        handleError('Error al crear postulación: ' . $e->getMessage());
    }
}

// Actualizar status de postulación
function updatePostulacionStatus($pdo) {
    $id = $_GET['id'] ?? $_POST['id'] ?? null;

    $inputData = [];
    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        $rawInput = file_get_contents('php://input');
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        if (strpos($contentType, 'application/json') !== false) {
            $inputData = json_decode($rawInput, true) ?? [];
        }else{
            parse_str($rawInput, $inputData);
        }
    }
    
    $status = sanitizeInput($_POST['status'] ?? $inputData['status'] ?? '');
    
    if (!$id || !$status) {
        handleError('ID y status requeridos');
    }

    $validStatuses = ['pending', 'reviewed', 'accepted', 'rejected'];
    if (!in_array($status, $validStatuses)) {
        handleError('Status no válido');
    }

    try {
        $stmt = $pdo->prepare("
            UPDATE postulaciones 
            SET status = ?, updated_at = CURRENT_TIMESTAMP 
            WHERE id = ?
        ");
        $stmt->execute([$status, $id]);

        if ($stmt->rowCount() === 0) {
            handleError('Postulación no encontrada', 404);
        }

        jsonResponse([
            'success' => true,
            'message' => 'Status actualizado exitosamente'
        ]);

    } catch (Exception $e) {
        handleError('Error al actualizar status: ' . $e->getMessage());
    }
}

// Agregar notas a postulación
function addNotesPostulacion($pdo) {
    $id = $_GET['id'] ?? $_POST['id'] ?? null;
    
    $inputData = [];
    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        $rawInput = file_get_contents('php://input');
        parse_str($rawInput, $inputData);
    }
    
    $notas = sanitizeInput($_POST['notas'] ?? $inputData['notas'] ?? '');

    if (!$id) {
        handleError('ID requerido');
    }

    try {
        $stmt = $pdo->prepare("
            UPDATE postulaciones 
            SET notas_admin = ?, updated_at = CURRENT_TIMESTAMP 
            WHERE id = ?
        ");
        $stmt->execute([$notas, $id]);

        if ($stmt->rowCount() === 0) {
            handleError('Postulación no encontrada', 404);
        }

        jsonResponse([
            'success' => true,
            'message' => 'Notas actualizadas exitosamente'
        ]);

    } catch (Exception $e) {
        handleError('Error al actualizar notas: ' . $e->getMessage());
    }
}

// Eliminar postulación
function deletePostulacion($pdo) {
    $id = $_GET['id'] ?? null;
    
    if (!$id) {
        handleError('ID requerido');
    }

    try {
        // Obtener datos de la postulación antes de eliminar
        $stmt = $pdo->prepare("SELECT cv_filename FROM postulaciones WHERE id = ?");
        $stmt->execute([$id]);
        $postulacion = $stmt->fetch();

        if (!$postulacion) {
            handleError('Postulación no encontrada', 404);
        }

        // Eliminar archivo CV
        $cvPath = CV_PATH . $postulacion['cv_filename'];
        if (file_exists($cvPath)) {
            unlink($cvPath);
        }

        // Eliminar de la base de datos
        $stmt = $pdo->prepare("DELETE FROM postulaciones WHERE id = ?");
        $stmt->execute([$id]);

        jsonResponse([
            'success' => true,
            'message' => 'Postulación eliminada exitosamente'
        ]);

    } catch (Exception $e) {
        handleError('Error al eliminar postulación: ' . $e->getMessage());
    }
}

// Funciones auxiliares
function sendConfirmationEmail($email, $nombres) {
    // Implementar envío de email de confirmación
    // Puedes usar PHPMailer, mail() nativo, o un servicio como SendGrid
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
    // Implementar notificación a administradores
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