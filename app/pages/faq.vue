<template>
  <div>
    <!-- Hero Section -->
    <section class="relative py-24 wave-shape-primary text-white overflow-hidden">
      <!-- Formas orgánicas de fondo -->
      <div class="organic-blob-1" style="top: 15%; right: 10%; z-index: 1;"></div>
      <div class="organic-blob-2" style="bottom: 25%; left: 5%; z-index: 1;"></div>

      <div class="container-full relative z-10 text-white">
        <h1 class="font-display text-center mb-6">Preguntas Frecuentes</h1>
        <p class="text-xl md:text-2xl text-center max-w-3xl mx-auto text-white/90">
          Resolvemos tus dudas sobre el programa
        </p>
      </div>

      <!-- Divisor ondulado inferior -->
      <div class="wave-divider-bottom">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
          <path
            d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z"
            class="fill-gray-50"></path>
        </svg>
      </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16 md:py-24 bg-gray-50 section-with-shapes">
      <div class="container-full max-w-4xl">
        <div class="space-y-6">
          <div v-for="(pregunta, index) in preguntas" :key="index"
            class="bg-white rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden">
            <button @click="togglePregunta(index)"
              class="w-full px-8 py-8 flex justify-between items-center hover:bg-gray-50 transition-colors text-left"
              :aria-expanded="preguntaActiva === index" :class="{ 'bg-gray-50': preguntaActiva === index }">
              <span class="text-lg font-bold text-gray-900 pr-4">{{ pregunta.pregunta }}</span>
              <svg class="w-6 h-6 text-secondary transform transition-transform duration-300 flex-shrink-0"
                :class="{ 'rotate-180': preguntaActiva === index }" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <Transition enter-active-class="accordion-enter-active" enter-from-class="accordion-enter-from"
              enter-to-class="accordion-enter-to" leave-active-class="accordion-leave-active"
              leave-from-class="accordion-leave-from" leave-to-class="accordion-leave-to">
              <div v-if="preguntaActiva === index" class="accordion-content">
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                  <!-- <p class="text-gray-600 leading-relaxed"><template v-html="pregunta.respuesta"></template>></p> -->
                   <div v-html="pregunta.respuesta"></div>
                </div>
              </div>
            </Transition>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="section bg-white">
      <div class="container text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">
          ¿Tienes más preguntas?
        </h2>
        <p class="text-gray-600 mb-8 max-w-2xl mx-auto">
          Si tienes dudas adicionales, no dudes en contactarnos. Estaremos encantados de ayudarte.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <nuxt-link to="/contacto" class="btn-primary">
            Contáctanos
          </nuxt-link>
          <nuxt-link to="/unete" class="btn-secondary">
            Postula ahora
          </nuxt-link>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
// SEO
useHead({
  title: 'Preguntas Frecuentes - Munay Ruray',
  meta: [
    {
      name: 'description',
      content: 'Encuentra respuestas a las preguntas más frecuentes sobre nuestro programa de voluntariado universitario.'
    }
  ]
})

// Estado reactivo
const preguntaActiva = ref(null)

// Datos de preguntas frecuentes
const preguntas = [
  {
    pregunta: "¿Quiénes pueden postular?",
    respuesta: "<ul><li>Jóvenes y adultos desde los 16 años en adelante.</li><li>Estudiantes, egresados o profesionales que deseen aportar con su talento y tiempo.</li><li>Personas con vocación de servicio, empatía y compromiso social.</li><li>No necesitas experiencia previa: solo ganas de aprender, ayudar y crecer.</li></ul>"
  },
  {
    pregunta: "¿En qué consiste el voluntariado?",
    respuesta: "<p>El voluntariado de <b>Munay Ruray</b> es un espacio de servicio y aprendizaje donde personas comprometidas dedican parte de su tiempo, habilidades y energía para <b>apoyar a comunidades y generar impacto social positivo</b></p>"
  },
  {
    pregunta: "¿Hay un proceso de selección?",
    respuesta: `<p>Sí, pero no es un proceso para “eliminar” gente, sino para <b><strong>asegurarse de que los</strong></b></p><p><b><strong>voluntarios estén motivados y alineados</strong></b> con los objetivos de Munay Ruray.</p><ol><li><p><span><b>Postulación</b></span></p><ul><li><p>El/la interesado(a) llena el <a href="/unete"><strong>formulario de inscripción</strong></a> (con datos personales, disponibilidad de tiempo y motivación).</p></li></ul></li><li><p><strong>Entrevista breve / dinámica grupal</strong></p><ul><li><p>Sirve para conocer sus intereses, habilidades y actitudes.</p></li><li><p>Se evalúa la <strong>empatía, responsabilidad y ganas de aprender.</strong></p></li></ul></li><li><p><strong>Revisión de compatibilidad</strong></p><ul><li><p>El equipo de Munay Ruray revisa si el perfil encaja con los proyectos en marcha.</p></li></ul></li><li><p><strong>Capacitación inicial</strong></p><ul><li><p>Todos los seleccionados reciben una <strong>inducción</strong> sobre misión, valores, normas internas y actividades del voluntariado.</p></li></ul></li><li><p><strong>Bienvenida oficial</strong></p><ul><li><p>El voluntario recibe su <strong>credencial/certificado de ingreso</strong> y se integra al equipo.</p></li></ul></li></ol>`
  },
  {
    pregunta: "¿Qué duración tiene el programa?",
    respuesta: "<p>Munay Ruray puede ofrecer modalidades flexibles (corto, regular o anual), pero siempre con un tiempo mínimo de compromiso para garantizar impacto real.</>"
  },
  {
    pregunta: "¿Es obligatorio asistir a todas las actividades?",
    respuesta: "<ol><li><p><b>No es obligatorio estar en <i>todas</i> las actividades</b>, porque cada voluntario tiene estudios, trabajo ocompromisos personales.</p></li><li><p><b>Sí es obligatorio cumplir con el mínimo de participación</b> establecido en el programa.</p></li><li><p>En actividades <b>grandes o institucionales</b> (como campañas principales, eventos masivos o jornadas de impacto)se pide <b>presencia prioritaria</b>, porque ahí se necesita más fuerza de equipo.</p></li><li><p>Si un voluntario <b>no puede asistir</b>, debe avisar con anticipación para organizar los equipos y no dejarhuecos.</p></li></ol>"
  },
  {
    pregunta: "¿Hay algún beneficio o certificado?",
    respuesta: "<ul><li><b>Certificado de participación</b><ol><li>Al culminar el programa (corto, regular o anual), se entrega un certificado oficial que reconoce las horas de voluntariado y las actividades realizadas.</li><li>Este documento puede servir para CV, becas, postulaciones laborales o académicas.</li></ol></li><li><b>Capacitaciones y talleres</b><ol><li>Formación en liderazgo, trabajo en equipo, gestión social, comunicación y otras áreas según proyectos.</li></ol></li><li><b>Experiencia práctica</b><ol><li>Oportunidad de aplicar conocimientos en proyectos reales y desarrollar nuevas habilidades (organización de eventos, campañas sociales, talleres comunitarios, etc.).</li></ol></li><li><b>Red de contactos</b><ol><li>Conexión con jóvenes, profesionales y líderes comunitarios.</li><li>Networking que puede abrir puertas académicas, laborales y personales.</li></ol></li><li><b>Crecimiento personal</b><ol><li>Desarrollo de empatía, resiliencia y habilidades blandas muy valoradas en el mundo laboral.</li><li>Sentir la satisfacción de generar un <b>impacto positivo en la sociedad.</b></li></ol></li></ul>"
  },
  {
    pregunta: "¿Puedo participar si estudio en otra universidad?",
    respuesta: "<p><b>Sí puedes</b> postular y participar.</p><p>Muchos voluntarios suelen ser estudiantes, porque el voluntariado te da:</p><ul><li>• Experiencia práctica para tu carrera.</li><li>• Certificados que sirven en tu <b>CV, becas y prácticas preprofesionales.</b></li><li>• Desarrollo de <b>habilidades blandas</b>: liderazgo, trabajo en equipo, empatía.</li><li>• Una red de contactos que puede abrirte puertas</li></ul>"
  }
]

// Función para alternar preguntas con transición suave
const togglePregunta = (index) => {
  if (preguntaActiva.value === index) {
    // Si es la misma pregunta, simplemente cerrar
    preguntaActiva.value = null
  } else if (preguntaActiva.value !== null) {
    // Si hay otra pregunta abierta, cerrar primero y luego abrir la nueva
    preguntaActiva.value = null
    setTimeout(() => {
      preguntaActiva.value = index
    }, 100) // Pequeño delay para suavizar la transición
  } else {
    // Si no hay ninguna abierta, abrir directamente
    preguntaActiva.value = index
  }
}
</script>

<style scoped>
/* Transiciones suaves para el acordeón */
.accordion-content {
  overflow: hidden;
}

.accordion-enter-active {
  transition: opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1),
    transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.accordion-leave-active {
  transition: opacity 0.2s cubic-bezier(0.4, 0, 0.2, 1),
    transform 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

.accordion-enter-from {
  opacity: 0;
  transform: translateY(-10px);
}

.accordion-enter-to {
  opacity: 1;
  transform: translateY(0);
}

.accordion-leave-from {
  opacity: 1;
  transform: translateY(0);
}

.accordion-leave-to {
  opacity: 0;
  transform: translateY(-6px);
}

/* Mejoras de accesibilidad */
button:focus {
  outline: 2px solid #02b2a2;
  outline-offset: 2px;
}

/* Hover effects mejorados */
.bg-white:hover {
  transform: translateY(-1px);
}

/* Transición suave para la flecha */
svg {
  transition: transform 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}
</style>
