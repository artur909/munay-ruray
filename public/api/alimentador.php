<?php
require_once 'config.php';
require_once 'utils.php';

// Obtener método HTTP y acción
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
            getAllExperiencias($pdo);
            break;
        case 'get':
            getExperienciaById($pdo);
            break;
        case 'categories':
            getCategories($pdo);
            break;
        default:
            getAllExperiencias($pdo);
    }
}

// Manejar peticiones POST (crear y actualizar)
function handlePostRequest($action, $pdo) {
    switch ($action) {
        case 'create':
            createExperiencia($pdo);
            break;
        case 'update':
            updateExperiencia($pdo);
            break;
        default:
            handleError('Acción no válida');
    }
}

// Manejar peticiones PUT (actualizar)
function handlePutRequest($action, $pdo) {
    switch ($action) {
        case 'update':
            updateExperiencia($pdo);
            break;
        case 'toggle-featured':
            toggleFeatured($pdo);
            break;
        default:
            handleError('Acción no válida');
    }
}

// Manejar peticiones DELETE
function handleDeleteRequest($action, $pdo) {
    switch ($action) {
        case 'delete':
            deleteExperiencia($pdo);
            break;
        default:
            handleError('Acción no válida');
    }
}

// Obtener todas las experiencias
function getAllExperiencias($pdo) {
    try {
        $stmt = $pdo->prepare("
            SELECT id, slug, title, excerpt, date, category, read_time, duration, 
                   participants, location, cover, featured, status, stats, gallery, created_at, updated_at
            FROM experiencias 
            ORDER BY created_at DESC
        ");
        $stmt->execute();
        $experiencias = $stmt->fetchAll();

        // Decodificar JSON fields para cada experiencia
        foreach ($experiencias as &$exp) {
            $exp['stats'] = json_decode($exp['stats'] ?? '[]', true);
            $exp['gallery'] = json_decode($exp['gallery'] ?? '[]', true);
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

// Obtener experiencia por ID
function getExperienciaById($pdo) {
    $id = $_GET['id'] ?? null;
    
    if (!$id) {
        handleError('ID requerido');
    }

    try {
        $stmt = $pdo->prepare("SELECT * FROM experiencias WHERE id = ?");
        $stmt->execute([$id]);
        $experiencia = $stmt->fetch();

        if (!$experiencia) {
            handleError('Experiencia no encontrada', 404);
        }

        // Decodificar JSON fields
        $experiencia['stats'] = json_decode($experiencia['stats'] ?? '[]', true);
        $experiencia['gallery'] = json_decode($experiencia['gallery'] ?? '[]', true);

        jsonResponse([
            'success' => true,
            'data' => $experiencia
        ]);
    } catch (Exception $e) {
        handleError('Error al obtener experiencia: ' . $e->getMessage());
    }
}

// Obtener categorías
function getCategories($pdo) {
    try {
        $stmt = $pdo->prepare("
            SELECT category, COUNT(*) as count 
            FROM experiencias 
            WHERE status = 'published' 
            GROUP BY category
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

// Crear nueva experiencia
function createExperiencia($pdo) {
    try {
        // Obtener datos del formulario
        $data = [
            'title' => sanitizeInput($_POST['title'] ?? ''),
            'excerpt' => sanitizeInput($_POST['excerpt'] ?? ''),
            'content' => $_POST['content'] ?? '', // No sanitizar HTML del contenido
            'date' => sanitizeInput($_POST['date'] ?? date('d M Y')),
            'category' => sanitizeInput($_POST['category'] ?? ''),
            'read_time' => sanitizeInput($_POST['read_time'] ?? '5'),
            'duration' => sanitizeInput($_POST['duration'] ?? ''),
            'participants' => sanitizeInput($_POST['participants'] ?? ''),
            'location' => sanitizeInput($_POST['location'] ?? ''),
            'video' => sanitizeInput($_POST['video'] ?? ''),
            'featured' => isset($_POST['featured']) ? 1 : 0,
            'status' => sanitizeInput($_POST['status'] ?? 'published')
        ];

        // Validar datos básicos
        if (empty($data['title'])) {
            handleError('El título es requerido');
        }
        if (empty($data['excerpt'])) {
            handleError('El extracto es requerido');
        }
        if (empty($data['category'])) {
            handleError('La categoría es requerida');
        }
        if (!in_array($data['category'], ['ambiental', 'educacion', 'salud', 'cultura', 'social'])) {
            handleError('Categoría no válida');
        }

        // Generar slug único
        $slug = generateSlug($data['title']);
        $originalSlug = $slug;
        $counter = 1;
        
        // Verificar que el slug sea único
        while (slugExists($pdo, $slug)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Subir imagen de portada
        $coverUrl = '';
        if (isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {
            $coverUrl = uploadImage($_FILES['cover'], $slug);
        } else {
            handleError('Imagen de portada requerida');
        }

        // Subir imágenes de galería
        $galleryImages = [];
        
        if (isset($_FILES['gallery'])) {
            try {
                $galleryImages = uploadGalleryImages($_FILES['gallery'], $slug);
            } catch (Exception $e) {
                error_log("Error subiendo galería: " . $e->getMessage());
            }
        }

        // Procesar estadísticas
        $stats = [];
        if (isset($_POST['stats']) && is_array($_POST['stats'])) {
            foreach ($_POST['stats'] as $stat) {
                if (!empty($stat['value']) && !empty($stat['label'])) {
                    $stats[] = [
                        'value' => sanitizeInput($stat['value']),
                        'label' => sanitizeInput($stat['label'])
                    ];
                }
            }
        }

        // Insertar en base de datos
        $stmt = $pdo->prepare("
            INSERT INTO experiencias (
                slug, title, excerpt, content, date, category, read_time, 
                duration, participants, location, cover, featured, stats, 
                gallery, video, status
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $slug,
            $data['title'],
            $data['excerpt'],
            $data['content'],
            $data['date'],
            $data['category'],
            $data['read_time'],
            $data['duration'],
            $data['participants'],
            $data['location'],
            $coverUrl,
            $data['featured'],
            json_encode($stats),
            json_encode($galleryImages),
            $data['video'],
            $data['status']
        ]);

        $experienciaId = $pdo->lastInsertId();

        // Obtener la experiencia creada
        $stmt = $pdo->prepare("SELECT * FROM experiencias WHERE id = ?");
        $stmt->execute([$experienciaId]);
        $experiencia = $stmt->fetch();

        // Decodificar JSON fields
        $experiencia['stats'] = json_decode($experiencia['stats'], true);
        $experiencia['gallery'] = json_decode($experiencia['gallery'], true);

        // Generar archivos estáticos
        generateStaticFiles($experiencia);

        // Actualizar index de experiencias
        updateExperienciasIndex($pdo);

        jsonResponse([
            'success' => true,
            'message' => 'Experiencia creada exitosamente',
            'data' => $experiencia
        ], 201);

    } catch (Exception $e) {
        handleError('Error al crear experiencia: ' . $e->getMessage());
    }
}

// Actualizar experiencia existente
function updateExperiencia($pdo) {
    $id = $_GET['id'] ?? $_POST['id'] ?? null;
    
    if (!$id) {
        handleError('ID requerido');
    }
    
    error_log("Actualizando experiencia ID: " . $id);

    try {
        // Verificar que la experiencia existe
        $stmt = $pdo->prepare("SELECT * FROM experiencias WHERE id = ?");
        $stmt->execute([$id]);
        $existingExp = $stmt->fetch();

        if (!$existingExp) {
            handleError('Experiencia no encontrada', 404);
        }

        // Obtener datos del formulario
        $data = [
            'title'         => sanitizeInput($_POST['title'] ?? $existingExp['title']),
            'excerpt'       => sanitizeInput($_POST['excerpt'] ?? $existingExp['excerpt']),
            'content'       => $_POST['content'] ?? $existingExp['content'],
            'date'          => sanitizeInput($_POST['date'] ?? $existingExp['date']),
            'category'      => sanitizeInput($_POST['category'] ?? $existingExp['category']),
            'read_time'     => sanitizeInput($_POST['read_time'] ?? $existingExp['read_time']),
            'duration'      => sanitizeInput($_POST['duration'] ?? $existingExp['duration']),
            'participants'  => sanitizeInput($_POST['participants'] ?? $existingExp['participants']),
            'location'      => sanitizeInput($_POST['location'] ?? $existingExp['location']),
            'video'         => sanitizeInput($_POST['video'] ?? $existingExp['video']),
            'featured'      => isset($_POST['featured']) ? 1 : 0,
            'status'        => sanitizeInput($_POST['status'] ?? $existingExp['status'])
        ];

        // Validar datos básicos
        if (empty($data['title'])) {
            handleError('El título es requerido');
        }
        if (empty($data['excerpt'])) {
            handleError('El extracto es requerido');
        }
        if (empty($data['category'])) {
            handleError('La categoría es requerida');
        }
        if (!in_array($data['category'], ['ambiental', 'educacion', 'salud', 'cultura', 'social'])) {
            handleError('Categoría no válida');
        }

        // Manejar imagen de portada
        $coverUrl = $existingExp['cover'];
        if (isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {
            $coverUrl = uploadImage($_FILES['cover'], $existingExp['slug']);
        }

        // Manejar galería
        $galleryImages = json_decode($existingExp['gallery'], true) ?? [];
        if (isset($_FILES['gallery'])) {
            try {
                $newGalleryImages = uploadGalleryImages($_FILES['gallery'], $existingExp['slug']);
                // Si hay nuevas imágenes, reemplazar la galería completa
                if (!empty($newGalleryImages)) {
                    $galleryImages = $newGalleryImages;
                }
            } catch (Exception $e) {
                error_log("Error subiendo galería: " . $e->getMessage());
            }
        }

        // Procesar estadísticas
        $stats = json_decode($existingExp['stats'], true) ?? [];
        if (isset($_POST['stats']) && is_array($_POST['stats'])) {
            $stats = [];
            foreach ($_POST['stats'] as $stat) {
                if (!empty($stat['value']) && !empty($stat['label'])) {
                    $stats[] = [
                        'value' => sanitizeInput($stat['value']),
                        'label' => sanitizeInput($stat['label'])
                    ];
                }
            }
        }

        // Actualizar en base de datos
        $stmt = $pdo->prepare("
            UPDATE experiencias SET 
                title = ?, excerpt = ?, content = ?, date = ?, category = ?, 
                read_time = ?, duration = ?, participants = ?, location = ?, 
                cover = ?, featured = ?, stats = ?, gallery = ?, video = ?, 
                status = ?, updated_at = CURRENT_TIMESTAMP
            WHERE id = ?
        ");

        $stmt->execute([
            $data['title'],
            $data['excerpt'],
            $data['content'],
            $data['date'],
            $data['category'],
            $data['read_time'],
            $data['duration'],
            $data['participants'],
            $data['location'],
            $coverUrl,
            $data['featured'],
            json_encode($stats),
            json_encode($galleryImages),
            $data['video'],
            $data['status'],
            $id
        ]);

        // Obtener la experiencia actualizada
        $stmt = $pdo->prepare("SELECT * FROM experiencias WHERE id = ?");
        $stmt->execute([$id]);
        $experiencia = $stmt->fetch();

        // Decodificar JSON fields
        $experiencia['stats'] = json_decode($experiencia['stats'], true);
        $experiencia['gallery'] = json_decode($experiencia['gallery'], true);

        // Regenerar archivos estáticos
        generateStaticFiles($experiencia);

        // Actualizar index de experiencias
        updateExperienciasIndex($pdo);

        jsonResponse([
            'success' => true,
            'message' => 'Experiencia actualizada exitosamente',
            'data' => $experiencia
        ]);

    } catch (Exception $e) {
        handleError('Error al actualizar experiencia: ' . $e->getMessage());
    }
}

// Alternar estado featured
function toggleFeatured($pdo) {
    $id = $_GET['id'] ?? $_POST['id'] ?? null;
    
    if (!$id) {
        handleError('ID requerido');
    }

    try {
        // Primero quitar featured de todas las experiencias
        $stmt = $pdo->prepare("UPDATE experiencias SET featured = 0");
        $stmt->execute();

        // Luego marcar la seleccionada como featured
        $stmt = $pdo->prepare("UPDATE experiencias SET featured = 1 WHERE id = ?");
        $stmt->execute([$id]);

        // Actualizar index de experiencias
        updateExperienciasIndex($pdo);

        jsonResponse([
            'success' => true,
            'message' => 'Estado featured actualizado'
        ]);

    } catch (Exception $e) {
        handleError('Error al actualizar featured: ' . $e->getMessage());
    }
}

// Eliminar experiencia
function deleteExperiencia($pdo) {
    $id = $_GET['id'] ?? null;
    
    if (!$id) {
        handleError('ID requerido');
    }

    try {
        // Obtener datos de la experiencia antes de eliminar
        $stmt = $pdo->prepare("SELECT slug FROM experiencias WHERE id = ?");
        $stmt->execute([$id]);
        $experiencia = $stmt->fetch();

        if (!$experiencia) {
            handleError('Experiencia no encontrada', 404);
        }

        // Eliminar de la base de datos
        $stmt = $pdo->prepare("DELETE FROM experiencias WHERE id = ?");
        $stmt->execute([$id]);

        // Eliminar archivos estáticos
        $experienciaDir = EXPERIENCIAS_PATH . $experiencia['slug'];
        if (is_dir($experienciaDir)) {
            removeDirectory($experienciaDir);
        }

        // Actualizar index de experiencias
        updateExperienciasIndex($pdo);

        jsonResponse([
            'success' => true,
            'message' => 'Experiencia eliminada exitosamente'
        ]);

    } catch (Exception $e) {
        handleError('Error al eliminar experiencia: ' . $e->getMessage());
    }
}

// Funciones auxiliares
function slugExists($pdo, $slug) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM experiencias WHERE slug = ?");
    $stmt->execute([$slug]);
    return $stmt->fetchColumn() > 0;
}

function generateStaticFiles($experiencia) {
    try {
        // Verificar que tenemos los datos necesarios
        if (empty($experiencia['slug'])) {
            error_log("Slug de experiencia vacío");
            return false;
        }
        
        // Asegurar que el directorio base existe
        ensureDirectoryExists(EXPERIENCIAS_PATH);
        
        // Crear directorio de la experiencia
        $experienciaDir = EXPERIENCIAS_PATH . $experiencia['slug'];
        ensureDirectoryExists($experienciaDir);

        // Generar index.html
        $html = generateExperienceHTML($experiencia);
        if (!empty($html)) {
            $htmlFile = $experienciaDir . '/index.html';
            file_put_contents($htmlFile, $html);
        }

        // Generar _payload.json
        $payload = generatePayloadJSON($experiencia);
        if (!empty($payload)) {
            $payloadFile = $experienciaDir . '/_payload.json';
            file_put_contents($payloadFile, $payload);
        }

        return true;
    } catch (Exception $e) {
        error_log("Error generando archivos estáticos: " . $e->getMessage());
        return false;
    }
}

function removeDirectory($dir) {
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (is_dir($dir . "/" . $object)) {
                    removeDirectory($dir . "/" . $object);
                } else {
                    unlink($dir . "/" . $object);
                }
            }
        }
        rmdir($dir);
    }
}




?>