<?php
require_once __DIR__ . '/BaseModel.php';

/**
 * Modelo para manejar experiencias
 */
class ExperienciaModel extends BaseModel {
    protected $table = 'experiencias';
    
    /**
     * Obtener todas las experiencias con filtros
     */
    public function getAll($filters = []) {
        $conditions = [];
        $params = [];
        
        // Filtro por categoría
        if (!empty($filters['category']) && $filters['category'] !== 'todas') {
            $conditions[] = "category = ?";
            $params[] = $filters['category'];
        }
        
        // Filtro por estado (para admin)
        if (isset($filters['status'])) {
            $conditions[] = "status = ?";
            $params[] = $filters['status'];
        } else {
            // Por defecto solo publicadas para público
            $conditions[] = "status = 'published'";
        }
        
        // Excluir destacadas
        if (isset($filters['exclude_featured']) && $filters['exclude_featured']) {
            $conditions[] = "featured = 0";
        }
        
        $limit = $filters['limit'] ?? null;
        $orderBy = "featured DESC, created_at DESC";
        
        $experiencias = $this->findAll($conditions, $params, $orderBy, $limit);
        
        // Procesar campos JSON
        return $this->processJsonFields($experiencias);
    }
    
    /**
     * Obtener experiencia por slug
     */
    public function getBySlug($slug, $includeUnpublished = false) {
        $conditions = ["slug = ?"];
        $params = [$slug];
        
        if (!$includeUnpublished) {
            $conditions[] = "status = 'published'";
        }
        
        $sql = "SELECT * FROM {$this->table} WHERE " . implode(" AND ", $conditions);
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $experiencia = $stmt->fetch();
        
        if ($experiencia) {
            return $this->processJsonFields([$experiencia])[0];
        }
        
        return null;
    }
    
    /**
     * Obtener experiencia destacada
     */
    public function getFeatured() {
        // Buscar experiencia marcada como destacada
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            WHERE featured = 1 AND status = 'published' 
            ORDER BY created_at DESC 
            LIMIT 1
        ");
        $stmt->execute();
        $experiencia = $stmt->fetch();
        
        // Si no hay destacada, tomar la más reciente
        if (!$experiencia) {
            $stmt = $this->db->prepare("
                SELECT * FROM {$this->table} 
                WHERE status = 'published' 
                ORDER BY created_at DESC 
                LIMIT 1
            ");
            $stmt->execute();
            $experiencia = $stmt->fetch();
        }
        
        if ($experiencia) {
            return $this->processJsonFields([$experiencia])[0];
        }
        
        return null;
    }
    
    /**
     * Obtener categorías con conteo
     */
    public function getCategories() {
        $stmt = $this->db->prepare("
            SELECT category, COUNT(*) as count 
            FROM {$this->table} 
            WHERE status = 'published' 
            GROUP BY category
            ORDER BY count DESC
        ");
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    /**
     * Crear nueva experiencia
     */
    public function createExperiencia($data) {
        // Generar slug único
        $data['slug'] = $this->generateUniqueSlug($data['title']);
        
        // Procesar estadísticas y galería como JSON
        $data['stats'] = json_encode($data['stats'] ?? []);
        $data['gallery'] = json_encode($data['gallery'] ?? []);
        
        $id = $this->create($data);
        
        // Retornar la experiencia creada
        return $this->getById($id);
    }
    
    /**
     * Actualizar experiencia
     */
    public function updateExperiencia($id, $data) {
        // Procesar estadísticas y galería como JSON si están presentes
        if (isset($data['stats'])) {
            $data['stats'] = json_encode($data['stats']);
        }
        if (isset($data['gallery'])) {
            $data['gallery'] = json_encode($data['gallery']);
        }
        
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $this->update($id, $data);
        
        // Retornar la experiencia actualizada
        return $this->getById($id);
    }
    
    /**
     * Obtener experiencia por ID
     */
    public function getById($id) {
        $experiencia = $this->findById($id);
        
        if ($experiencia) {
            return $this->processJsonFields([$experiencia])[0];
        }
        
        return null;
    }
    
    /**
     * Eliminar experiencia
     */
    public function deleteExperiencia($id) {
        return $this->delete($id);
    }
    
    /**
     * Marcar/desmarcar como destacada
     */
    public function toggleFeatured($id) {
        // Quitar featured de todas
        $stmt = $this->db->prepare("UPDATE {$this->table} SET featured = 0");
        $stmt->execute();
        
        // Marcar la seleccionada
        $stmt = $this->db->prepare("UPDATE {$this->table} SET featured = 1 WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    /**
     * Verificar si un slug existe
     */
    public function slugExists($slug) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM {$this->table} WHERE slug = ?");
        $stmt->execute([$slug]);
        return $stmt->fetchColumn() > 0;
    }
    
    /**
     * Generar slug único
     */
    private function generateUniqueSlug($title) {
        $slug = createSlug($title);
        $originalSlug = $slug;
        $counter = 1;
        
        while ($this->slugExists($slug)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }
    
    /**
     * Procesar campos JSON de las experiencias
     */
    private function processJsonFields($experiencias) {
        foreach ($experiencias as &$exp) {
            $exp['stats'] = json_decode($exp['stats'] ?? '[]', true);
            $exp['gallery'] = json_decode($exp['gallery'] ?? '[]', true);
            $exp['featured'] = (bool)$exp['featured'];
        }
        
        return $experiencias;
    }
}