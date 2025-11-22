<?php
/**
 * Modelo base con funcionalidades comunes
 */
class BaseModel {
    protected $db;
    protected $table;
    
    public function __construct() {
        $this->db = getDB();
    }
    
    /**
     * Obtener todos los registros con filtros opcionales
     */
    protected function findAll($conditions = [], $params = [], $orderBy = 'created_at DESC', $limit = null) {
        $whereClause = !empty($conditions) ? "WHERE " . implode(" AND ", $conditions) : "";
        $limitClause = $limit ? "LIMIT $limit" : "";
        
        $sql = "SELECT * FROM {$this->table} $whereClause ORDER BY $orderBy $limitClause";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        
        return $stmt->fetchAll();
    }
    
    /**
     * Obtener un registro por ID
     */
    protected function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    /**
     * Obtener un registro por campo específico
     */
    protected function findBy($field, $value) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE $field = ?");
        $stmt->execute([$value]);
        return $stmt->fetch();
    }
    
    /**
     * Crear un nuevo registro
     */
    protected function create($data) {
        $fields = array_keys($data);
        $placeholders = array_fill(0, count($fields), '?');
        
        $sql = "INSERT INTO {$this->table} (" . implode(', ', $fields) . ") VALUES (" . implode(', ', $placeholders) . ")";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array_values($data));
        
        return $this->db->lastInsertId();
    }
    
    /**
     * Actualizar un registro
     */
    protected function update($id, $data) {
        $fields = array_keys($data);
        $setClause = implode(' = ?, ', $fields) . ' = ?';
        
        $sql = "UPDATE {$this->table} SET $setClause WHERE id = ?";
        $params = array_values($data);
        $params[] = $id;
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }
    
    /**
     * Eliminar un registro
     */
    protected function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    /**
     * Contar registros con condiciones
     */
    protected function count($conditions = [], $params = []) {
        $whereClause = !empty($conditions) ? "WHERE " . implode(" AND ", $conditions) : "";
        $sql = "SELECT COUNT(*) FROM {$this->table} $whereClause";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        
        return $stmt->fetchColumn();
    }
}