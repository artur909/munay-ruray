<?php
require_once __DIR__ . '/../models/ExperienciaModel.php';
require_once __DIR__ . '/../views/ResponseView.php';
require_once __DIR__ . '/../config.php';

/**
 * Controlador para manejar experiencias
 */
class ExperienciaController {
    private $model;
    
    public function __construct() {
        $this->model = new ExperienciaModel();
    }
    
    /**
     * Obtener todas las experiencias con filtros
     */
    public function index() {
        try {
            $filters = [
                'categoria' => $_GET['categoria'] ?? null,
                'featured' => $_GET['featured'] ?? null,
                'search' => $_GET['search'] ?? null
            ];
            
            $experiencias = $this->model->getAll($filters);
            ResponseView::success($experiencias);
        } catch (Exception $e) {
            ResponseView::serverError($e->getMessage());
        }
    }
    
    /**
     * Obtener experiencia por ID
     */
    public function show($id) {
        try {
            $experiencia = $this->model->getById($id);
            
            if (!$experiencia) {
                ResponseView::notFound('Experiencia no encontrada');
            }
            
            ResponseView::success($experiencia);
        } catch (Exception $e) {
            ResponseView::serverError($e->getMessage());
        }
    }
    
    /**
     * Obtener experiencia por slug
     */
    public function getBySlug($slug) {
        try {
            $experiencia = $this->model->getBySlug($slug);
            
            if (!$experiencia) {
                ResponseView::notFound('Experiencia no encontrada');
            }
            
            ResponseView::success($experiencia);
        } catch (Exception $e) {
            ResponseView::serverError($e->getMessage());
        }
    }
    
    /**
     * Obtener experiencias destacadas
     */
    public function featured() {
        try {
            $experiencias = $this->model->getFeatured();
            ResponseView::success($experiencias);
        } catch (Exception $e) {
            ResponseView::serverError($e->getMessage());
        }
    }
    
    /**
     * Obtener categorías
     */
    public function categories() {
        try {
            $categorias = $this->model->getCategories();
            ResponseView::success($categorias);
        } catch (Exception $e) {
            ResponseView::serverError($e->getMessage());
        }
    }
    
    /**
     * Crear nueva experiencia
     */
    public function store() {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!$data) {
                ResponseView::validationError([], 'Datos JSON no válidos');
            }
            
            // Validar datos requeridos
            $errors = $this->validateExperienciaData($data);
            if (!empty($errors)) {
                ResponseView::validationError($errors);
            }
            
            // Generar slug único si no se proporciona
            if (empty($data['slug'])) {
                $data['slug'] = $this->generateSlug($data['titulo']);
            }
            
            // Procesar imágenes si existen
            if (isset($_FILES['imagen_principal'])) {
                $data['imagen_principal'] = $this->handleImageUpload($_FILES['imagen_principal']);
            }
            
            if (isset($_FILES['galeria'])) {
                $data['galeria'] = $this->handleGalleryUpload($_FILES['galeria']);
            }
            
            $experiencia = $this->model->createExperiencia($data);
            ResponseView::created($experiencia, 'Experiencia creada exitosamente');
            
        } catch (Exception $e) {
            ResponseView::serverError($e->getMessage());
        }
    }
    
    /**
     * Actualizar experiencia
     */
    public function update($id) {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!$data) {
                ResponseView::validationError([], 'Datos JSON no válidos');
            }
            
            $experiencia = $this->model->getById($id);
            if (!$experiencia) {
                ResponseView::notFound('Experiencia no encontrada');
            }
            
            // Validar datos
            $errors = $this->validateExperienciaData($data, $id);
            if (!empty($errors)) {
                ResponseView::validationError($errors);
            }
            
            // Procesar imágenes si existen
            if (isset($_FILES['imagen_principal'])) {
                $data['imagen_principal'] = $this->handleImageUpload($_FILES['imagen_principal']);
            }
            
            if (isset($_FILES['galeria'])) {
                $data['galeria'] = $this->handleGalleryUpload($_FILES['galeria']);
            }
            
            $updated = $this->model->updateExperiencia($id, $data);
            ResponseView::updated($updated, 'Experiencia actualizada exitosamente');
            
        } catch (Exception $e) {
            ResponseView::serverError($e->getMessage());
        }
    }
    
    /**
     * Eliminar experiencia
     */
    public function destroy($id) {
        try {
            $experiencia = $this->model->getById($id);
            if (!$experiencia) {
                ResponseView::notFound('Experiencia no encontrada');
            }
            
            $this->model->deleteExperiencia($id);
            ResponseView::deleted('Experiencia eliminada exitosamente');
            
        } catch (Exception $e) {
            ResponseView::serverError($e->getMessage());
        }
    }
    
    /**
     * Alternar estado destacado
     */
    public function toggleFeatured($id) {
        try {
            $experiencia = $this->model->getById($id);
            if (!$experiencia) {
                ResponseView::notFound('Experiencia no encontrada');
            }
            
            $updated = $this->model->toggleFeatured($id);
            ResponseView::updated($updated, 'Estado destacado actualizado');
            
        } catch (Exception $e) {
            ResponseView::serverError($e->getMessage());
        }
    }
    
    /**
     * Validar datos de experiencia
     */
    private function validateExperienciaData($data, $id = null) {
        $errors = [];
        
        if (empty($data['titulo'])) $errors[] = 'Título requerido';
        if (empty($data['descripcion'])) $errors[] = 'Descripción requerida';
        if (empty($data['categoria'])) $errors[] = 'Categoría requerida';
        if (empty($data['ubicacion'])) $errors[] = 'Ubicación requerida';
        if (empty($data['precio'])) $errors[] = 'Precio requerido';
        if (empty($data['duracion'])) $errors[] = 'Duración requerida';
        
        // Validar precio
        if (!empty($data['precio']) && !is_numeric($data['precio'])) {
            $errors[] = 'Precio debe ser numérico';
        }
        
        // Validar slug único
        if (!empty($data['titulo'])) {
            $slug = $this->generateSlug($data['titulo']);
            if ($this->model->slugExists($slug, $id)) {
                $errors[] = 'Ya existe una experiencia con este título';
            }
        }
        
        return $errors;
    }
    
    /**
     * Generar slug a partir del título
     */
    private function generateSlug($titulo) {
        $slug = strtolower($titulo);
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/[\s-]+/', '-', $slug);
        return trim($slug, '-');
    }
    
    /**
     * Manejar subida de imagen principal
     */
    private function handleImageUpload($file) {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('Error al subir imagen');
        }
        
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        if (!in_array($file['type'], $allowedTypes)) {
            throw new Exception('Tipo de imagen no permitido');
        }
        
        if ($file['size'] > MAX_FILE_SIZE) {
            throw new Exception('Imagen muy grande');
        }
        
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $extension;
        $destination = IMAGES_PATH . $filename;
        
        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new Exception('Error al guardar imagen');
        }
        
        return $filename;
    }
    
    /**
     * Manejar subida de galería
     */
    private function handleGalleryUpload($files) {
        $gallery = [];
        
        foreach ($files['name'] as $key => $name) {
            if ($files['error'][$key] === UPLOAD_ERR_OK) {
                $file = [
                    'name' => $files['name'][$key],
                    'type' => $files['type'][$key],
                    'tmp_name' => $files['tmp_name'][$key],
                    'error' => $files['error'][$key],
                    'size' => $files['size'][$key]
                ];
                
                $gallery[] = $this->handleImageUpload($file);
            }
        }
        
        return json_encode($gallery);
    }
}