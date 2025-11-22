<?php
require_once __DIR__ . '/BaseModel.php';

/**
 * Modelo para manejar postulaciones
 */
class PostulacionModel extends BaseModel {
    protected $table = 'postulaciones';
    
    /**
     * Obtener postulaciones con paginación y filtros
     */
    public function getPaginated($page = 1, $limit = 20, $filters = []) {
        $offset = ($page - 1) * $limit;
        $conditions = [];
        $params = [];
        
        // Filtro por estado
        if (!empty($filters['status'])) {
            $conditions[] = "status = ?";
            $params[] = $filters['status'];
        }
        
        // Filtro de búsqueda
        if (!empty($filters['search'])) {
            $conditions[] = "(nombres LIKE ? OR email LIKE ? OR universidad LIKE ?)";
            $searchTerm = "%{$filters['search']}%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }
        
        $whereClause = !empty($conditions) ? "WHERE " . implode(" AND ", $conditions) : "";
        
        // Obtener total
        $countSql = "SELECT COUNT(*) FROM {$this->table} $whereClause";
        $countStmt = $this->db->prepare($countSql);
        $countStmt->execute($params);
        $total = $countStmt->fetchColumn();
        
        // Obtener postulaciones paginadas
        $sql = "
            SELECT id, nombres, email, telefono, universidad, carrera, anio_estudio, 
                   edad, disponibilidad, cv_filename, cv_original_name, status, 
                   created_at, updated_at
            FROM {$this->table} 
            $whereClause
            ORDER BY created_at DESC 
            LIMIT ? OFFSET ?
        ";
        
        $params[] = $limit;
        $params[] = $offset;
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $postulaciones = $stmt->fetchAll();
        
        return [
            'postulaciones' => $postulaciones,
            'pagination' => [
                'page' => $page,
                'limit' => $limit,
                'total' => $total,
                'pages' => ceil($total / $limit)
            ]
        ];
    }
    
    /**
     * Obtener postulación por ID
     */
    public function getById($id) {
        return $this->findById($id);
    }
    
    /**
     * Crear nueva postulación
     */
    public function createPostulacion($data) {
        // Verificar email único
        if ($this->emailExists($data['email'])) {
            throw new Exception('Ya existe una postulación con este email');
        }
        
        $id = $this->create($data);
        return $this->getById($id);
    }
    
    /**
     * Actualizar estado de postulación
     */
    public function updateStatus($id, $status) {
        $validStatuses = ['pending', 'reviewed', 'accepted', 'rejected'];
        if (!in_array($status, $validStatuses)) {
            throw new Exception('Status no válido');
        }
        
        $data = [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        return $this->update($id, $data);
    }
    
    /**
     * Agregar notas administrativas
     */
    public function addNotes($id, $notas) {
        $data = [
            'notas_admin' => $notas,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        return $this->update($id, $data);
    }
    
    /**
     * Eliminar postulación
     */
    public function deletePostulacion($id) {
        $postulacion = $this->getById($id);
        
        if (!$postulacion) {
            throw new Exception('Postulación no encontrada');
        }
        
        // Eliminar archivo CV si existe
        if (!empty($postulacion['cv_filename'])) {
            $cvPath = CV_PATH . $postulacion['cv_filename'];
            if (file_exists($cvPath)) {
                unlink($cvPath);
            }
        }
        
        return $this->delete($id);
    }
    
    /**
     * Obtener estadísticas
     */
    public function getStats() {
        $stats = [];
        
        // Total de postulaciones
        $stats['total'] = $this->count();
        
        // Por status
        $stmt = $this->db->prepare("
            SELECT status, COUNT(*) as count 
            FROM {$this->table} 
            GROUP BY status
        ");
        $stmt->execute();
        $stats['by_status'] = $stmt->fetchAll();
        
        // Por universidad
        $stmt = $this->db->prepare("
            SELECT universidad, COUNT(*) as count 
            FROM {$this->table} 
            GROUP BY universidad 
            ORDER BY count DESC 
            LIMIT 10
        ");
        $stmt->execute();
        $stats['by_universidad'] = $stmt->fetchAll();
        
        // Por carrera
        $stmt = $this->db->prepare("
            SELECT carrera, COUNT(*) as count 
            FROM {$this->table} 
            GROUP BY carrera 
            ORDER BY count DESC 
            LIMIT 10
        ");
        $stmt->execute();
        $stats['by_carrera'] = $stmt->fetchAll();
        
        // Por mes (últimos 6 meses)
        $stmt = $this->db->prepare("
            SELECT 
                DATE_FORMAT(created_at, '%Y-%m') as mes,
                COUNT(*) as count
            FROM {$this->table} 
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
            GROUP BY DATE_FORMAT(created_at, '%Y-%m')
            ORDER BY mes DESC
        ");
        $stmt->execute();
        $stats['by_month'] = $stmt->fetchAll();
        
        return $stats;
    }
    
    /**
     * Verificar si un email ya existe
     */
    public function emailExists($email) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM {$this->table} WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }
    
    /**
     * Validar datos de postulación
     */
    public function validateData($data) {
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
}