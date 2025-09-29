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
            getAllExperienciasPublic($pdo);
            break;
        case 'get':
            getExperienciaBySlug($pdo);
            break;
        case 'featured':
            getFeaturedExperiencia($pdo);
            break;
        case 'categories':
            getCategoriesPublic($pdo);
            break;
        default:
            getAllExperienciasPublic($pdo);
    }
}

// Obtener todas las experiencias públicas
function getAllExperienciasPublic($pdo) {
    try {
        $category = $_GET['category'] ?? '';
        $limit = (int)($_GET['limit'] ?? 50);
        $excludeFeatured = isset($_GET['exclude_featured']) && $_GET['exclude_featured'] === 'true';
        
        // Construir query base
        $whereConditions = ["status = 'published'"];
        $params = [];
        
        if (!empty($category) && $category !== 'todas') {
            $whereConditions[] = "category = ?";
            $params[] = $category;
        }
        
        if ($excludeFeatured) {
            $whereConditions[] = "featured = 0";
        }
        
        $whereClause = "WHERE " . implode(" AND ", $whereConditions);
        
        // Obtener experiencias
        $stmt = $pdo->prepare("
            SELECT id, slug, title, excerpt, date, category, read_time, duration, 
                   participants, location, cover, featured, stats, gallery, video, created_at
            FROM experiencias 
            $whereClause
            ORDER BY featured DESC, created_at DESC 
            LIMIT ?
        ");
        
        $params[] = $limit;
        $stmt->execute($params);
        $experiencias = $stmt->fetchAll();

        // Decodificar JSON fields para cada experiencia
        foreach ($experiencias as &$exp) {
            $exp['stats'] = json_decode($exp['stats'] ?? '[]', true);
            $exp['gallery'] = json_decode($exp['gallery'] ?? '[]', true);
            $exp['featured'] = (bool)$exp['featured'];
        }

        jsonResponse([
            'success' => true,
            'data' => $experiencias,
            'total' => count($experiencias)
        ]);
    } catch (Exception $e) {
        handleError('Error al obtener experiencias: ' . $e->getMessage());
    }
}

// Obtener experiencia por slug
function getExperienciaBySlug($pdo) {
    $slug = $_GET['slug'] ?? null;
    
    if (!$slug) {
        handleError('Slug requerido');
    }

    try {
        $stmt = $pdo->prepare("
            SELECT id, slug, title, excerpt, content, date, author, category, read_time, 
                   duration, participants, location, cover, featured, stats, gallery, video, created_at
            FROM experiencias 
            WHERE slug = ? AND status = 'published'
        ");
        $stmt->execute([$slug]);
        $experiencia = $stmt->fetch();

        if (!$experiencia) {
            handleError('Experiencia no encontrada', 404);
        }

        // Decodificar JSON fields
        $experiencia['stats'] = json_decode($experiencia['stats'] ?? '[]', true);
        $experiencia['gallery'] = json_decode($experiencia['gallery'] ?? '[]', true);
        $experiencia['featured'] = (bool)$experiencia['featured'];

        jsonResponse([
            'success' => true,
            'data' => $experiencia
        ]);
    } catch (Exception $e) {
        handleError('Error al obtener experiencia: ' . $e->getMessage());
    }
}

// Obtener experiencia destacada
function getFeaturedExperiencia($pdo) {
    try {
        $stmt = $pdo->prepare("
            SELECT id, slug, title, excerpt, date, category, read_time, duration, 
                   participants, location, cover, featured, stats, gallery, created_at
            FROM experiencias 
            WHERE featured = 1 AND status = 'published'
            ORDER BY created_at DESC 
            LIMIT 1
        ");
        $stmt->execute();
        $experiencia = $stmt->fetch();

        // Si no hay destacada, tomar la más reciente
        if (!$experiencia) {
            $stmt = $pdo->prepare("
                SELECT id, slug, title, excerpt, date, category, read_time, duration, 
                       participants, location, cover, featured, stats, gallery, created_at
                FROM experiencias 
                WHERE status = 'published'
                ORDER BY created_at DESC 
                LIMIT 1
            ");
            $stmt->execute();
            $experiencia = $stmt->fetch();
        }

        if ($experiencia) {
            // Decodificar JSON fields
            $experiencia['stats'] = json_decode($experiencia['stats'] ?? '[]', true);
            $experiencia['gallery'] = json_decode($experiencia['gallery'] ?? '[]', true);
            $experiencia['featured'] = (bool)$experiencia['featured'];
        }

        jsonResponse([
            'success' => true,
            'data' => $experiencia
        ]);
    } catch (Exception $e) {
        handleError('Error al obtener experiencia destacada: ' . $e->getMessage());
    }
}

// Obtener categorías públicas
function getCategoriesPublic($pdo) {
    try {
        $stmt = $pdo->prepare("
            SELECT category, COUNT(*) as count 
            FROM experiencias 
            WHERE status = 'published' 
            GROUP BY category
            ORDER BY count DESC
        ");
        $stmt->execute();
        $categories = $stmt->fetchAll();

        jsonResponse([
            'success' => true,
            'data' => $categories
        ]);
    } catch (Exception $e) {
        handleError('Error al obtener categorías: ' . $e->getMessage());
    }
}
?>