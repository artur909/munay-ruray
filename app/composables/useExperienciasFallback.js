// Composable para datos de fallback cuando la API no está disponible
export const useExperienciasFallback = () => {
  
  // Datos de experiencias de ejemplo para desarrollo
  const experienciasFallback = ref([
    {
      id: 1,
      slug: 'reforestacion-amazonia-2024',
      title: 'Reforestación en la Amazonía Peruana',
      excerpt: 'Proyecto de conservación ambiental donde plantamos más de 500 árboles nativos en comunidades amazónicas.',
      content: `
        <h2>Una experiencia transformadora en el corazón de la Amazonía</h2>
        <p>Durante tres semanas, nuestro equipo de voluntarios trabajó junto a las comunidades locales en un ambicioso proyecto de reforestación que no solo buscaba restaurar el ecosistema, sino también fortalecer los lazos entre la universidad y las poblaciones amazónicas.</p>
        
        <h3>El desafío</h3>
        <p>La deforestación en la región había afectado gravemente la biodiversidad local. Trabajamos en la identificación de especies nativas y en la preparación de terrenos para la siembra.</p>
        
        <h3>Nuestro impacto</h3>
        <ul>
          <li>500+ árboles plantados</li>
          <li>15 hectáreas restauradas</li>
          <li>3 comunidades beneficiadas</li>
          <li>20 voluntarios participantes</li>
        </ul>
        
        <h3>Aprendizajes</h3>
        <p>Esta experiencia nos enseñó sobre la importancia de la conservación, el trabajo en equipo y el impacto real que podemos generar cuando unimos fuerzas por una causa común.</p>
      `,
      date: '2024-08-15',
      author: 'Equipo Munay Ruray',
      category: 'ambiental',
      read_time: '8',
      duration: '3 semanas',
      participants: '20 voluntarios',
      location: 'Madre de Dios, Perú',
      cover: '/assets/images/experiencias/reforestacion-cover.jpg',
      featured: true,
      stats: {
        arboles: 500,
        hectareas: 15,
        comunidades: 3,
        voluntarios: 20
      },
      gallery: [
        '/assets/images/experiencias/reforestacion-1.jpg',
        '/assets/images/experiencias/reforestacion-2.jpg',
        '/assets/images/experiencias/reforestacion-3.jpg'
      ],
      video: null,
      status: 'published'
    },
    {
      id: 2,
      slug: 'educacion-rural-cusco',
      title: 'Educación Digital en Comunidades Rurales de Cusco',
      excerpt: 'Implementamos aulas digitales y capacitamos a docentes en tecnologías educativas en escuelas rurales.',
      content: `
        <h2>Llevando la tecnología educativa a las alturas del Cusco</h2>
        <p>En las comunidades rurales de Cusco, la brecha digital representa uno de los mayores desafíos educativos. Nuestro proyecto buscó cerrar esta brecha mediante la implementación de aulas digitales y la capacitación de docentes locales.</p>
        
        <h3>El proyecto</h3>
        <p>Trabajamos con 5 escuelas rurales para instalar equipos de cómputo, establecer conexiones a internet y capacitar a 30 docentes en el uso de herramientas digitales educativas.</p>
        
        <h3>Resultados alcanzados</h3>
        <ul>
          <li>5 aulas digitales implementadas</li>
          <li>30 docentes capacitados</li>
          <li>200+ estudiantes beneficiados</li>
          <li>15 voluntarios técnicos</li>
        </ul>
        
        <h3>Impacto a largo plazo</h3>
        <p>Los docentes ahora pueden integrar tecnología en sus clases, mejorando la calidad educativa y preparando a los estudiantes para un mundo cada vez más digital.</p>
      `,
      date: '2024-07-20',
      author: 'Equipo Munay Ruray',
      category: 'educacion',
      read_time: '6',
      duration: '4 semanas',
      participants: '15 voluntarios',
      location: 'Cusco, Perú',
      cover: '/assets/images/experiencias/educacion-cover.jpg',
      featured: false,
      stats: {
        escuelas: 5,
        docentes: 30,
        estudiantes: 200,
        voluntarios: 15
      },
      gallery: [
        '/assets/images/experiencias/educacion-1.jpg',
        '/assets/images/experiencias/educacion-2.jpg'
      ],
      video: null,
      status: 'published'
    },
    {
      id: 3,
      slug: 'salud-comunitaria-lima',
      title: 'Campaña de Salud Comunitaria en Lima Norte',
      excerpt: 'Organizamos jornadas de salud preventiva y educación sanitaria en asentamientos humanos de Lima Norte.',
      content: `
        <h2>Salud para todos en Lima Norte</h2>
        <p>Las comunidades de Lima Norte enfrentan desafíos significativos en el acceso a servicios de salud. Nuestro equipo organizó jornadas de salud preventiva que llegaron directamente a las familias más necesitadas.</p>
        
        <h3>Servicios brindados</h3>
        <p>Durante dos meses, realizamos campañas de salud que incluyeron chequeos médicos básicos, vacunación, educación en higiene y prevención de enfermedades.</p>
        
        <h3>Números del impacto</h3>
        <ul>
          <li>800+ personas atendidas</li>
          <li>12 jornadas de salud</li>
          <li>6 asentamientos visitados</li>
          <li>25 voluntarios de salud</li>
        </ul>
        
        <h3>Educación preventiva</h3>
        <p>Además de la atención médica, implementamos talleres educativos sobre nutrición, higiene personal y prevención de enfermedades comunes.</p>
      `,
      date: '2024-06-10',
      author: 'Equipo Munay Ruray',
      category: 'salud',
      read_time: '7',
      duration: '2 meses',
      participants: '25 voluntarios',
      location: 'Lima Norte, Perú',
      cover: '/assets/images/experiencias/salud-cover.jpg',
      featured: false,
      stats: {
        personas: 800,
        jornadas: 12,
        asentamientos: 6,
        voluntarios: 25
      },
      gallery: [
        '/assets/images/experiencias/salud-1.jpg',
        '/assets/images/experiencias/salud-2.jpg',
        '/assets/images/experiencias/salud-3.jpg'
      ],
      video: null,
      status: 'published'
    }
  ])

  // Función para obtener experiencia por slug
  const getExperienciaBySlug = (slug) => {
    return experienciasFallback.value.find(exp => exp.slug === slug) || null
  }

  // Función para obtener experiencias relacionadas
  const getExperienciasRelacionadas = (currentSlug, limit = 3) => {
    return experienciasFallback.value
      .filter(exp => exp.slug !== currentSlug)
      .slice(0, limit)
  }

  // Función para obtener todas las experiencias
  const getAllExperiencias = () => {
    return experienciasFallback.value
  }

  // Función para obtener experiencias por categoría
  const getExperienciasByCategory = (category) => {
    if (!category) return experienciasFallback.value
    return experienciasFallback.value.filter(exp => exp.category === category)
  }

  return {
    experienciasFallback,
    getExperienciaBySlug,
    getExperienciasRelacionadas,
    getAllExperiencias,
    getExperienciasByCategory
  }
}