// Composable para manejar experiencias
export const useExperiencias = () => {
  // Datos base de experiencias
  const experienciasData = [
    {
      slug: 'jornada-reforestacion-alto-mayo',
      title: 'Jornada de reforestación en Alto Mayo',
      excerpt: 'Voluntarios y comunidad unidos en la protección del bosque tropical. Una experiencia transformadora que mostró la importancia del trabajo colaborativo.',
      date: '12 Ago 2025',
      author: 'Equipo Munay Ruray',
      category: 'ambiental',
      readTime: '8',
      duration: '2 días',
      participants: '45 voluntarios',
      location: 'Alto Mayo, San Martín',
      cover: 'https://placehold.co/800x600?text=Reforestacion',
      featured: true,
      // Contenido completo para la página de detalle
      content: `
        <p class="lead">En esta jornada histórica realizamos la reforestación de más de 1,000 árboles nativos en la cuenca del Alto Mayo, una de las zonas de mayor biodiversidad del Perú. La comunidad local, voluntarios universitarios y especialistas en conservación trabajaron juntos durante dos días intensos para restaurar áreas degradadas y fortalecer las capacidades locales de manejo forestal.</p>
        
        <h3>El desafío ambiental</h3>
        <p>La cuenca del Alto Mayo ha perdido más del 40% de su cobertura forestal en las últimas dos décadas debido a la agricultura migratoria y la tala ilegal. Este proyecto surge como una respuesta directa a esta problemática, buscando no solo restaurar el ecosistema, sino también generar alternativas económicas sostenibles para las comunidades locales.</p>
        
        <h3>Actividades principales</h3>
        <ul>
          <li><strong>Plantación de especies nativas:</strong> Caoba, cedro, ishpingo y otras especies endémicas</li>
          <li><strong>Talleres de manejo forestal:</strong> Capacitación en técnicas de silvicultura sostenible</li>
          <li><strong>Monitoreo ecológico:</strong> Establecimiento de parcelas de seguimiento a largo plazo</li>
          <li><strong>Educación ambiental:</strong> Sesiones con niños y jóvenes de la comunidad</li>
          <li><strong>Mapeo participativo:</strong> Identificación de áreas prioritarias para conservación</li>
        </ul>
        
        <h3>Impacto y resultados</h3>
        <p>Los resultados superaron nuestras expectativas. No solo logramos plantar los 1,000 árboles programados, sino que establecimos un vivero comunitario que garantizará la continuidad del proyecto. Además, se formó un comité local de vigilancia forestal que ya ha reportado una reducción del 60% en actividades de tala ilegal en la zona.</p>
        
        <p>Esta experiencia nos enseñó que la conservación ambiental solo es posible cuando se involucra activamente a las comunidades locales, respetando sus conocimientos ancestrales y ofreciendo alternativas económicas viables.</p>
      `,
      stats: [
        { value: '1,000+', label: 'Árboles plantados' },
        { value: '45', label: 'Voluntarios' },
        { value: '15 ha', label: 'Área restaurada' }
      ],
      gallery: [
        'https://placehold.co/800x600/22c55e/ffffff?text=Plantacion+1',
        'https://placehold.co/800x600/16a34a/ffffff?text=Voluntarios+2',
        'https://placehold.co/800x600/15803d/ffffff?text=Comunidad+3',
        'https://placehold.co/800x600/166534/ffffff?text=Vivero+4',
        'https://placehold.co/800x600/14532d/ffffff?text=Monitoreo+5',
        'https://placehold.co/800x600/052e16/ffffff?text=Resultados+6'
      ],
      video: 'https://www.youtube.com/embed/dQw4w9WgXcQ'
    },
    {
      slug: 'taller-educacion-ambiental',
      title: 'Taller de educación ambiental con niños',
      excerpt: 'Actividades prácticas para fomentar el cuidado del entorno desde la infancia, creando conciencia ecológica.',
      date: '05 Jul 2025',
      author: 'Equipo Munay Ruray',
      category: 'educacion',
      readTime: '5',
      duration: '1 día',
      participants: '30 niños',
      location: 'Colegio San José, Lima',
      cover: 'https://placehold.co/800x600?text=Taller+Ambiental',
      featured: false,
      content: `
        <p class="lead">Un día lleno de aprendizaje y diversión donde 30 niños de primaria descubrieron la importancia de cuidar nuestro planeta a través de actividades lúdicas y experimentos prácticos.</p>
        
        <h3>Metodología innovadora</h3>
        <p>Utilizamos una metodología basada en el aprendizaje experiencial, donde los niños no solo escuchan sobre el medio ambiente, sino que lo experimentan directamente a través de juegos, experimentos y actividades creativas.</p>
        
        <h3>Actividades realizadas</h3>
        <ul>
          <li>Creación de un huerto escolar</li>
          <li>Taller de reciclaje creativo</li>
          <li>Experimentos sobre contaminación del agua</li>
          <li>Teatro ambiental participativo</li>
        </ul>
      `,
      stats: [
        { value: '30', label: 'Niños participantes' },
        { value: '8', label: 'Actividades' },
        { value: '100%', label: 'Satisfacción' }
      ],
      gallery: [
        'https://placehold.co/800x600/3b82f6/ffffff?text=Huerto+1',
        'https://placehold.co/800x600/2563eb/ffffff?text=Reciclaje+2',
        'https://placehold.co/800x600/1d4ed8/ffffff?text=Experimentos+3'
      ],
      video: null
    },
    {
      slug: 'campana-salud-rural',
      title: 'Campaña de salud en zonas rurales',
      excerpt: 'Llevamos atención médica básica y educación en salud a comunidades alejadas de la ciudad.',
      date: '20 Jun 2025',
      author: 'Equipo Munay Ruray',
      category: 'salud',
      readTime: '6',
      duration: '3 días',
      participants: '25 voluntarios',
      location: 'Comunidad Andina, Huancayo',
      cover: 'https://placehold.co/800x600?text=Salud+Rural',
      featured: false,
      content: `
        <p class="lead">Campaña integral de salud que llevó atención médica básica y educación preventiva a comunidades rurales de difícil acceso en la región de Huancayo.</p>
        
        <h3>Servicios brindados</h3>
        <ul>
          <li>Consultas médicas generales</li>
          <li>Campañas de vacunación</li>
          <li>Talleres de nutrición</li>
          <li>Educación en salud preventiva</li>
        </ul>
      `,
      stats: [
        { value: '150', label: 'Personas atendidas' },
        { value: '25', label: 'Voluntarios' },
        { value: '3', label: 'Comunidades' }
      ],
      gallery: [
        'https://placehold.co/800x600/ef4444/ffffff?text=Consultas+1',
        'https://placehold.co/800x600/dc2626/ffffff?text=Vacunacion+2'
      ],
      video: null
    },
    {
      slug: 'construccion-biblioteca-comunitaria',
      title: 'Construcción de biblioteca comunitaria',
      excerpt: 'Proyecto colaborativo para crear un espacio de aprendizaje y cultura en la comunidad de San Martín.',
      date: '15 May 2025',
      author: 'Equipo Munay Ruray',
      category: 'educacion',
      readTime: '7',
      duration: '5 días',
      participants: '35 voluntarios',
      location: 'San Martín, Lima',
      cover: 'https://placehold.co/800x600?text=Biblioteca',
      featured: false,
      content: `
        <p class="lead">Construcción colaborativa de una biblioteca comunitaria que se ha convertido en el centro cultural y educativo de la comunidad de San Martín.</p>
        
        <h3>Fases del proyecto</h3>
        <ul>
          <li>Diseño participativo con la comunidad</li>
          <li>Construcción colaborativa</li>
          <li>Equipamiento y organización</li>
          <li>Capacitación en gestión bibliotecaria</li>
        </ul>
      `,
      stats: [
        { value: '500+', label: 'Libros donados' },
        { value: '35', label: 'Voluntarios' },
        { value: '120m²', label: 'Área construida' }
      ],
      gallery: [
        'https://placehold.co/800x600/8b5cf6/ffffff?text=Construccion+1',
        'https://placehold.co/800x600/7c3aed/ffffff?text=Equipamiento+2'
      ],
      video: null
    },
    {
      slug: 'festival-cultural-munay-ruray',
      title: 'Festival cultural Munay Ruray',
      excerpt: 'Celebración de la diversidad cultural peruana con música, danza y gastronomía tradicional.',
      date: '28 Abr 2025',
      author: 'Equipo Munay Ruray',
      category: 'cultura',
      readTime: '4',
      duration: '1 día',
      participants: '50 voluntarios',
      location: 'Plaza de Armas, Lima',
      cover: 'https://placehold.co/800x600?text=Festival+Cultural',
      featured: false,
      content: `
        <p class="lead">Festival que celebró la riqueza cultural del Perú, reuniendo a artistas, músicos y cocineros tradicionales en una jornada de intercambio cultural.</p>
        
        <h3>Actividades del festival</h3>
        <ul>
          <li>Presentaciones de danzas tradicionales</li>
          <li>Conciertos de música andina</li>
          <li>Feria gastronómica regional</li>
          <li>Talleres de artesanía</li>
        </ul>
      `,
      stats: [
        { value: '2000+', label: 'Visitantes' },
        { value: '50', label: 'Voluntarios' },
        { value: '15', label: 'Artistas' }
      ],
      gallery: [
        'https://placehold.co/800x600/f59e0b/ffffff?text=Danzas+1',
        'https://placehold.co/800x600/d97706/ffffff?text=Musica+2'
      ],
      video: null
    },
    {
      slug: 'programa-mentoring-universitario',
      title: 'Programa de mentoring universitario',
      excerpt: 'Acompañamiento académico y personal a estudiantes de primer año para facilitar su adaptación.',
      date: '10 Mar 2025',
      author: 'Equipo Munay Ruray',
      category: 'educacion',
      readTime: '5',
      duration: '6 meses',
      participants: '20 mentores',
      location: 'Universidad Nacional, Lima',
      cover: 'https://placehold.co/800x600?text=Mentoring',
      featured: false,
      content: `
        <p class="lead">Programa de mentoring que conectó a estudiantes de años superiores con estudiantes de primer año para facilitar su adaptación universitaria.</p>
        
        <h3>Componentes del programa</h3>
        <ul>
          <li>Sesiones de orientación académica</li>
          <li>Apoyo en técnicas de estudio</li>
          <li>Desarrollo de habilidades sociales</li>
          <li>Seguimiento personalizado</li>
        </ul>
      `,
      stats: [
        { value: '60', label: 'Estudiantes mentoreados' },
        { value: '20', label: 'Mentores' },
        { value: '95%', label: 'Tasa de retención' }
      ],
      gallery: [
        'https://placehold.co/800x600/06b6d4/ffffff?text=Mentoring+1',
        'https://placehold.co/800x600/0891b2/ffffff?text=Sesiones+2'
      ],
      video: null
    }
  ]

  // Funciones del composable
  const getAllExperiencias = () => experienciasData

  const getExperienciaBySlug = (slug) => {
    return experienciasData.find(exp => exp.slug === slug) || null
  }

  const getExperienciaDestacada = () => {
    return experienciasData.find(exp => exp.featured) || experienciasData[0]
  }

  const getCategorias = () => {
    return [...new Set(experienciasData.map(exp => exp.category))]
  }

  const getExperienciasFiltradas = (filtro = 'todas', excludeFeatured = false) => {
    let filtered = experienciasData

    if (excludeFeatured) {
      filtered = filtered.filter(exp => !exp.featured)
    }

    if (filtro === 'todas') {
      return filtered
    }

    return filtered.filter(exp => exp.category === filtro)
  }

  const getRelatedExperiencias = (currentSlug, limit = 3) => {
    return experienciasData
      .filter(exp => exp.slug !== currentSlug)
      .slice(0, limit)
  }

  return {
    // Datos
    experienciasData,
    
    // Funciones
    getAllExperiencias,
    getExperienciaBySlug,
    getExperienciaDestacada,
    getCategorias,
    getExperienciasFiltradas,
    getRelatedExperiencias
  }
}