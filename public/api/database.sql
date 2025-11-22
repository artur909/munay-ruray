-- Base de datos para Munay Ruray
-- Creación de tablas necesarias

-- Tabla para las experiencias/entradas
CREATE TABLE IF NOT EXISTS experiencias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(255) UNIQUE NOT NULL,
    title VARCHAR(500) NOT NULL,
    excerpt TEXT NOT NULL,
    content LONGTEXT NOT NULL,
    date VARCHAR(50) NOT NULL,
    author VARCHAR(255) DEFAULT 'Equipo Munay Ruray',
    category ENUM('ambiental', 'educacion', 'salud', 'cultura', 'social') NOT NULL,
    read_time VARCHAR(20) DEFAULT '5',
    duration VARCHAR(100),
    participants VARCHAR(100),
    location VARCHAR(255),
    cover VARCHAR(500) NOT NULL,
    featured BOOLEAN DEFAULT FALSE,
    stats JSON, -- Para almacenar las estadísticas como JSON
    gallery JSON, -- Para almacenar las URLs de la galería como JSON
    video VARCHAR(500) NULL,
    status ENUM('draft', 'published') DEFAULT 'published',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


-- Tabla para usuarios administrativos
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    nombre_completo VARCHAR(255) NOT NULL,
    role ENUM('admin', 'editor') DEFAULT 'editor',
    activo BOOLEAN DEFAULT TRUE,
    ultimo_acceso TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
-- Insertar usuario administrador por defecto
-- Contraseña: admin123 (cambiar en producción)
INSERT INTO usuarios (username, email, password_hash, nombre_completo, role) VALUES 
('admin', 'admin@munayruray.org', 'l9jJ5ESeXawyiFhQ:2aaef4234688cd679cb463c69ccd917a9357b17e9e83ed058cac4605fad76c02', 'Administrador Principal', 'admin');

-- Tabla para las postulaciones
CREATE TABLE IF NOT EXISTS postulaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(255) NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL,
    universidad VARCHAR(255) NOT NULL,
    universidad_otros VARCHAR(255) NULL,
    anio_estudio ENUM('primero', 'segundo', 'tercero', 'cuarto', 'quinto', 'egresado') NOT NULL,
    edad ENUM('18-22', '22-mas') NOT NULL,
    carrera VARCHAR(255) NOT NULL,
    carrera_otro VARCHAR(255) NULL,
    experiencia_previa TEXT,
    disponibilidad ENUM('todo-dia', 'manana', 'tarde') NOT NULL,
    cv_filename VARCHAR(500) NOT NULL,
    cv_original_name VARCHAR(500) NOT NULL,
    terminos BOOLEAN DEFAULT TRUE,
    status ENUM('pending', 'reviewed', 'accepted', 'rejected') DEFAULT 'pending',
    notas_admin TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Índices para mejorar performance
CREATE INDEX idx_experiencias_slug ON experiencias(slug);
CREATE INDEX idx_experiencias_category ON experiencias(category);
CREATE INDEX idx_experiencias_featured ON experiencias(featured);
CREATE INDEX idx_experiencias_status ON experiencias(status);
CREATE INDEX idx_postulaciones_email ON postulaciones(email);
CREATE INDEX idx_postulaciones_status ON postulaciones(status);
CREATE INDEX idx_postulaciones_created ON postulaciones(created_at);

-- Insertar datos de ejemplo (basados en el composable)
INSERT INTO experiencias (slug, title, excerpt, content, date, category, read_time, duration, participants, location, cover, featured, stats, gallery, video) VALUES
(
    'jornada-reforestacion-alto-mayo',
    'Jornada de reforestación en Alto Mayo',
    'Voluntarios y comunidad unidos en la protección del bosque tropical. Una experiencia transformadora que mostró la importancia del trabajo colaborativo.',
    '<p class="lead">En esta jornada histórica realizamos la reforestación de más de 1,000 árboles nativos en la cuenca del Alto Mayo, una de las zonas de mayor biodiversidad del Perú. La comunidad local, voluntarios universitarios y especialistas en conservación trabajaron juntos durante dos días intensos para restaurar áreas degradadas y fortalecer las capacidades locales de manejo forestal.</p><h3>El desafío ambiental</h3><p>La cuenca del Alto Mayo ha perdido más del 40% de su cobertura forestal en las últimas dos décadas debido a la agricultura migratoria y la tala ilegal. Este proyecto surge como una respuesta directa a esta problemática, buscando no solo restaurar el ecosistema, sino también generar alternativas económicas sostenibles para las comunidades locales.</p><h3>Actividades principales</h3><ul><li><strong>Plantación de especies nativas:</strong> Caoba, cedro, ishpingo y otras especies endémicas</li><li><strong>Talleres de manejo forestal:</strong> Capacitación en técnicas de silvicultura sostenible</li><li><strong>Monitoreo ecológico:</strong> Establecimiento de parcelas de seguimiento a largo plazo</li><li><strong>Educación ambiental:</strong> Sesiones con niños y jóvenes de la comunidad</li><li><strong>Mapeo participativo:</strong> Identificación de áreas prioritarias para conservación</li></ul><h3>Impacto y resultados</h3><p>Los resultados superaron nuestras expectativas. No solo logramos plantar los 1,000 árboles programados, sino que establecimos un vivero comunitario que garantizará la continuidad del proyecto. Además, se formó un comité local de vigilancia forestal que ya ha reportado una reducción del 60% en actividades de tala ilegal en la zona.</p><p>Esta experiencia nos enseñó que la conservación ambiental solo es posible cuando se involucra activamente a las comunidades locales, respetando sus conocimientos ancestrales y ofreciendo alternativas económicas viables.</p>',
    '12 Ago 2025',
    'ambiental',
    '8',
    '2 días',
    '45 voluntarios',
    'Alto Mayo, San Martín',
    'https://placehold.co/800x600?text=Reforestacion',
    TRUE,
    '[{"value": "1,000+", "label": "Árboles plantados"}, {"value": "45", "label": "Voluntarios"}, {"value": "15 ha", "label": "Área restaurada"}]',
    '["https://placehold.co/800x600/22c55e/ffffff?text=Plantacion+1", "https://placehold.co/800x600/16a34a/ffffff?text=Voluntarios+2", "https://placehold.co/800x600/15803d/ffffff?text=Comunidad+3"]',
    'https://www.youtube.com/embed/dQw4w9WgXcQ'
),
(
    'taller-educacion-ambiental',
    'Taller de educación ambiental con niños',
    'Actividades prácticas para fomentar el cuidado del entorno desde la infancia, creando conciencia ecológica.',
    '<p class="lead">Un día lleno de aprendizaje y diversión donde 30 niños de primaria descubrieron la importancia de cuidar nuestro planeta a través de actividades lúdicas y experimentos prácticos.</p><h3>Metodología innovadora</h3><p>Utilizamos una metodología basada en el aprendizaje experiencial, donde los niños no solo escuchan sobre el medio ambiente, sino que lo experimentan directamente a través de juegos, experimentos y actividades creativas.</p><h3>Actividades realizadas</h3><ul><li>Creación de un huerto escolar</li><li>Taller de reciclaje creativo</li><li>Experimentos sobre contaminación del agua</li><li>Teatro ambiental participativo</li></ul>',
    '05 Jul 2025',
    'educacion',
    '5',
    '1 día',
    '30 niños',
    'Colegio San José, Lima',
    'https://placehold.co/800x600?text=Taller+Ambiental',
    FALSE,
    '[{"value": "30", "label": "Niños participantes"}, {"value": "8", "label": "Actividades"}, {"value": "100%", "label": "Satisfacción"}]',
    '["https://placehold.co/800x600/3b82f6/ffffff?text=Huerto+1", "https://placehold.co/800x600/2563eb/ffffff?text=Reciclaje+2", "https://placehold.co/800x600/1d4ed8/ffffff?text=Experimentos+3"]',
    NULL
);