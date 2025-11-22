<?php
require_once __DIR__ . '/../models/PostulacionModel.php';
require_once __DIR__ . '/../views/ResponseView.php';
require_once __DIR__ . '/../config.php';

/**
 * Controlador para manejar postulaciones
 */
class PostulacionController {
    private $model;
    
    public function __construct() {
        $this->model = new PostulacionModel();
    }
    
    /**
     * Obtener postulaciones con paginación y filtros
     */
    public function index() {
        try {
            $page = (int)($_GET['page'] ?? 1);
            $limit = (int)($_GET['limit'] ?? 20);
            
            $filters = [
                'status' => $_GET['status'] ?? null,
                'search' => $_GET['search'] ?? null
            ];
            
            $result = $this->model->getPaginated($page, $limit, $filters);
            ResponseView::paginated($result['postulaciones'], $result['pagination']);
            
        } catch (Exception $e) {
            ResponseView::serverError($e->getMessage());
        }
    }
    
    /**
     * Obtener postulación por ID
     */
    public function show($id) {
        try {
            $postulacion = $this->model->getById($id);
            
            if (!$postulacion) {
                ResponseView::notFound('Postulación no encontrada');
            }
            
            ResponseView::success($postulacion);
        } catch (Exception $e) {
            ResponseView::serverError($e->getMessage());
        }
    }
    
    /**
     * Crear nueva postulación
     */
    public function store() {
        try {
            $data = $_POST;
            
            // Validar datos
            $errors = $this->model->validateData($data);
            if (!empty($errors)) {
                ResponseView::validationError($errors);
            }
            
            // Manejar archivo CV
            if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
                $cvData = $this->handleCVUpload($_FILES['cv']);
                $data['cv_filename'] = $cvData['filename'];
                $data['cv_original_name'] = $cvData['original_name'];
            }
            
            // Agregar timestamps
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            $data['status'] = 'pending';
            
            $postulacion = $this->model->createPostulacion($data);
            
            // Enviar emails
            $this->sendConfirmationEmail($postulacion);
            $this->notifyAdmins($postulacion);
            
            ResponseView::created($postulacion, 'Postulación enviada exitosamente');
            
        } catch (Exception $e) {
            ResponseView::serverError($e->getMessage());
        }
    }
    
    /**
     * Actualizar estado de postulación
     */
    public function updateStatus($id) {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($data['status'])) {
                ResponseView::validationError(['Status requerido']);
            }
            
            $postulacion = $this->model->getById($id);
            if (!$postulacion) {
                ResponseView::notFound('Postulación no encontrada');
            }
            
            $this->model->updateStatus($id, $data['status']);
            $updated = $this->model->getById($id);
            
            ResponseView::updated($updated, 'Estado actualizado exitosamente');
            
        } catch (Exception $e) {
            ResponseView::serverError($e->getMessage());
        }
    }
    
    /**
     * Agregar notas administrativas
     */
    public function addNotes($id) {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($data['notas'])) {
                ResponseView::validationError(['Notas requeridas']);
            }
            
            $postulacion = $this->model->getById($id);
            if (!$postulacion) {
                ResponseView::notFound('Postulación no encontrada');
            }
            
            $this->model->addNotes($id, $data['notas']);
            $updated = $this->model->getById($id);
            
            ResponseView::updated($updated, 'Notas agregadas exitosamente');
            
        } catch (Exception $e) {
            ResponseView::serverError($e->getMessage());
        }
    }
    
    /**
     * Eliminar postulación
     */
    public function destroy($id) {
        try {
            $postulacion = $this->model->getById($id);
            if (!$postulacion) {
                ResponseView::notFound('Postulación no encontrada');
            }
            
            $this->model->deletePostulacion($id);
            ResponseView::deleted('Postulación eliminada exitosamente');
            
        } catch (Exception $e) {
            ResponseView::serverError($e->getMessage());
        }
    }
    
    /**
     * Obtener estadísticas
     */
    public function stats() {
        try {
            $stats = $this->model->getStats();
            ResponseView::stats($stats);
        } catch (Exception $e) {
            ResponseView::serverError($e->getMessage());
        }
    }
    
    /**
     * Manejar subida de CV
     */
    private function handleCVUpload($file) {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('Error al subir CV');
        }
        
        if (!in_array($file['type'], ALLOWED_CV_TYPES)) {
            throw new Exception('Tipo de archivo no permitido. Solo PDF y DOC/DOCX');
        }
        
        if ($file['size'] > MAX_FILE_SIZE) {
            throw new Exception('Archivo muy grande. Máximo 5MB');
        }
        
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '_' . time() . '.' . $extension;
        $destination = CV_PATH . $filename;
        
        // Crear directorio si no existe
        if (!is_dir(CV_PATH)) {
            mkdir(CV_PATH, 0755, true);
        }
        
        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new Exception('Error al guardar CV');
        }
        
        return [
            'filename' => $filename,
            'original_name' => $file['name']
        ];
    }
    
    /**
     * Enviar email de confirmación
     */
    private function sendConfirmationEmail($postulacion) {
        $to = $postulacion['email'];
        $subject = 'Confirmación de postulación - Munay Ruray';
        
        $message = "
        <html>
        <head>
            <title>Confirmación de postulación</title>
        </head>
        <body>
            <h2>¡Gracias por tu postulación!</h2>
            <p>Hola {$postulacion['nombres']},</p>
            <p>Hemos recibido tu postulación para formar parte de nuestro equipo.</p>
            <p>Revisaremos tu información y nos pondremos en contacto contigo pronto.</p>
            <p>Saludos,<br>Equipo Munay Ruray</p>
        </body>
        </html>
        ";
        
        $headers = [
            'MIME-Version: 1.0',
            'Content-type: text/html; charset=UTF-8',
            'From: noreply@munayruray.com',
            'Reply-To: info@munayruray.com'
        ];
        
        mail($to, $subject, $message, implode("\r\n", $headers));
    }
    
    /**
     * Notificar a administradores
     */
    private function notifyAdmins($postulacion) {
        $adminEmails = ['admin@munayruray.com', 'rrhh@munayruray.com'];
        $subject = 'Nueva postulación recibida - Munay Ruray';
        
        $message = "
        <html>
        <head>
            <title>Nueva postulación</title>
        </head>
        <body>
            <h2>Nueva postulación recibida</h2>
            <p><strong>Nombre:</strong> {$postulacion['nombres']}</p>
            <p><strong>Email:</strong> {$postulacion['email']}</p>
            <p><strong>Universidad:</strong> {$postulacion['universidad']}</p>
            <p><strong>Carrera:</strong> {$postulacion['carrera']}</p>
            <p><strong>Fecha:</strong> {$postulacion['created_at']}</p>
            <p>Revisa la postulación completa en el panel de administración.</p>
        </body>
        </html>
        ";
        
        $headers = [
            'MIME-Version: 1.0',
            'Content-type: text/html; charset=UTF-8',
            'From: noreply@munayruray.com'
        ];
        
        foreach ($adminEmails as $email) {
            mail($email, $subject, $message, implode("\r\n", $headers));
        }
    }
}