<?php
require_once 'config.php';

// Función para subir archivos de imagen
function uploadImage($file, $slug) {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('Error al subir la imagen');
    }

    // Validar tipo de archivo
    if (!in_array($file['type'], ALLOWED_IMAGE_TYPES)) {
        throw new Exception('Tipo de archivo no permitido. Solo se permiten JPG, PNG y WebP');
    }

    // Validar tamaño
    if ($file['size'] > MAX_FILE_SIZE) {
        throw new Exception('El archivo es demasiado grande. Máximo 5MB');
    }

    // Generar nombre único
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = $slug . '_' . time() . '.' . $extension;
    $filepath = IMAGES_PATH . $filename;

    // Mover archivo
    if (!move_uploaded_file($file['tmp_name'], $filepath)) {
        throw new Exception('Error al guardar la imagen');
    }

    return '/assets/images/entradas/' . $filename;
}

// Función para subir múltiples imágenes (galería)
function uploadGalleryImages($files, $slug) {
    $uploadedImages = [];
    
    if (!is_array($files['name'])) {
        return $uploadedImages;
    }

    for ($i = 0; $i < count($files['name']); $i++) {
        if ($files['error'][$i] === UPLOAD_ERR_OK) {
            $file = [
                'name' => $files['name'][$i],
                'type' => $files['type'][$i],
                'tmp_name' => $files['tmp_name'][$i],
                'error' => $files['error'][$i],
                'size' => $files['size'][$i]
            ];
            
            try {
                $uploadedImages[] = uploadImage($file, $slug . '_gallery_' . $i);
            } catch (Exception $e) {
                error_log("Error subiendo imagen de galería: " . $e->getMessage());
            }
        }
    }

    return $uploadedImages;
}

// Función para subir CV
function uploadCV($file) {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('Error al subir el CV');
    }

    // Validar tipo de archivo
    if (!in_array($file['type'], ALLOWED_CV_TYPES)) {
        throw new Exception('Tipo de archivo no permitido. Solo se permiten PDF, DOC y DOCX');
    }

    // Validar tamaño
    if ($file['size'] > MAX_FILE_SIZE) {
        throw new Exception('El archivo es demasiado grande. Máximo 5MB');
    }

    // Generar nombre único
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = 'cv_' . time() . '_' . uniqid() . '.' . $extension;
    $filepath = CV_PATH . $filename;

    // Mover archivo
    if (!move_uploaded_file($file['tmp_name'], $filepath)) {
        throw new Exception('Error al guardar el CV');
    }

    return $filename;
}

// Función para generar HTML de experiencia
function generateExperienceHTML($experiencia) {
    $template = '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>' . htmlspecialchars($experiencia['title']) . ' - Munay Ruray</title>
    <meta name="description" content="' . htmlspecialchars($experiencia['excerpt']) . '">
    <meta property="og:title" content="' . htmlspecialchars($experiencia['title']) . '">
    <meta property="og:description" content="' . htmlspecialchars($experiencia['excerpt']) . '">
    <meta property="og:image" content="' . htmlspecialchars($experiencia['cover']) . '">
    <link rel="stylesheet" href="/assets/css/main.css">
</head>
<body>
    <div id="__nuxt">
        <div class="min-h-screen bg-white">
            <!-- Contenido de la experiencia -->
            <section class="relative min-h-screen overflow-hidden">
                <div class="absolute inset-0 z-0">
                    <img src="' . htmlspecialchars($experiencia['cover']) . '" alt="' . htmlspecialchars($experiencia['title']) . '" class="w-full h-full object-cover" />
                    <div class="absolute inset-0 bg-black/50"></div>
                </div>
                <div class="container-full relative z-10 flex items-center min-h-screen">
                    <div class="max-w-5xl space-y-8 text-white">
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">
                            ' . htmlspecialchars($experiencia['title']) . '
                        </h1>
                        <p class="text-lg md:text-xl text-white/90 max-w-3xl">
                            ' . htmlspecialchars($experiencia['excerpt']) . '
                        </p>
                    </div>
                </div>
            </section>
            
            <main class="relative bg-white">
                <section class="py-16 md:py-24 bg-white relative">
                    <div class="container-full max-w-6xl">
                        <div class="grid lg:grid-cols-12 gap-16 items-start">
                            <article class="lg:col-span-8 space-y-8">
                                <div class="prose prose-lg prose-gray max-w-none">
                                    ' . $experiencia['content'] . '
                                </div>
                            </article>
                        </div>
                    </div>
                </section>
            </main>
        </div>
    </div>
    <script src="/assets/js/main.js"></script>
</body>
</html>';

    return $template;
}

// Función para generar _payload.json
function generatePayloadJSON($experiencia) {
    return json_encode([
        'data' => $experiencia,
        'state' => [],
        '_errors' => []
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}

// Función para actualizar el index.html de experiencias
function updateExperienciasIndex($pdo) {
    try {
        // Obtener todas las experiencias publicadas
        $stmt = $pdo->prepare("SELECT * FROM experiencias WHERE status = 'published' ORDER BY created_at DESC");
        $stmt->execute();
        $experiencias = $stmt->fetchAll();
        
        // Decodificar JSON fields para cada experiencia
        foreach ($experiencias as &$exp) {
            $exp['stats'] = json_decode($exp['stats'] ?? '[]', true);
            $exp['gallery'] = json_decode($exp['gallery'] ?? '[]', true);
        }

        // Generar HTML del index
        $indexHTML = generateExperienciasIndexHTML($experiencias);
        
        if (empty($indexHTML)) {
            throw new Exception("HTML del index generado está vacío");
        }
        
        // Verificar que el directorio existe
        if (!is_dir(EXPERIENCIAS_PATH)) {
            throw new Exception("Directorio de experiencias no existe: " . EXPERIENCIAS_PATH);
        }
        
        // Guardar archivo
        $indexFile = EXPERIENCIAS_PATH . 'index.html';
        $result = file_put_contents($indexFile, $indexHTML);
        
        if ($result === false) {
            throw new Exception("No se pudo escribir index.html en: " . $indexFile);
        }
        
        return true;
    } catch (Exception $e) {
        error_log("Error actualizando index de experiencias: " . $e->getMessage());
        return false;
    }
}

// Función para generar HTML del index de experiencias
function generateExperienciasIndexHTML($experiencias) {
    // Asegurar que $experiencias es un array
    if (!is_array($experiencias)) {
        $experiencias = [$experiencias];
    }
    
    $experienciaDestacada = null;
    $experienciasRegulares = [];
    
    foreach ($experiencias as $exp) {
        if (isset($exp['featured']) && $exp['featured']) {
            $experienciaDestacada = $exp;
        } else {
            $experienciasRegulares[] = $exp;
        }
    }
    
    if (!$experienciaDestacada && !empty($experiencias)) {
        $experienciaDestacada = $experiencias[0];
        $experienciasRegulares = array_slice($experiencias, 1);
    }

    $template = '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Experiencias - Munay Ruray</title>
    <meta name="description" content="Descubre las historias inspiradoras de nuestros voluntarios y el impacto que generamos juntos en las comunidades.">
    <link rel="stylesheet" href="/assets/css/main.css">
</head>
<body>
    <div id="__nuxt">
        <!-- Contenido generado dinámicamente -->
        <div class="experiencias-container">
            <!-- Aquí iría el contenido completo de la página -->
        </div>
    </div>
    <script src="/assets/js/main.js"></script>
</body>
</html>';

    return $template;
}

// Función para validar datos de experiencia
function validateExperienceData($data, $isUpdate = false) {
    $errors = [];

    if (empty($data['title'])) {
        $errors[] = 'El título es requerido';
    }

    if (empty($data['excerpt'])) {
        $errors[] = 'El extracto es requerido';
    }

    // Solo validar contenido como requerido en creación, no en actualización
    if (!$isUpdate && empty($data['content'])) {
        $errors[] = 'El contenido es requerido';
    }

    if (empty($data['category'])) {
        $errors[] = 'La categoría es requerida';
    }

    if (!in_array($data['category'], ['ambiental', 'educacion', 'salud', 'cultura', 'social'])) {
        $errors[] = 'Categoría no válida';
    }

    return $errors;
}

// Función para validar datos de postulación
function validatePostulacionData($data) {
    $errors = [];

    if (empty($data['nombres'])) {
        $errors[] = 'Los nombres son requeridos';
    }

    if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email válido es requerido';
    }

    if (empty($data['telefono'])) {
        $errors[] = 'El teléfono es requerido';
    }

    if (empty($data['universidad'])) {
        $errors[] = 'La universidad es requerida';
    }

    if (empty($data['carrera'])) {
        $errors[] = 'La carrera es requerida';
    }

    // Validar edad si está presente
    if (!empty($data['edad']) && (!is_numeric($data['edad']) || $data['edad'] < 16 || $data['edad'] > 100)) {
        $errors[] = 'La edad debe ser un número válido entre 16 y 100 años';
    }

    // Validar año de estudio si está presente
    if (!empty($data['anio_estudio']) && !in_array($data['anio_estudio'], ['1', '2', '3', '4', '5', '6', 'egresado'])) {
        $errors[] = 'Año de estudio no válido';
    }

    return $errors;
}


?>