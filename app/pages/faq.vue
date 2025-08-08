<template>
  <div>
    <!-- Hero Section -->
    <section class="relative py-24 bg-rich-black">
      <div class="container relative z-10 text-white">
        <h1 class="font-display text-center mb-6">Preguntas Frecuentes</h1>
        <p class="text-xl md:text-2xl text-center max-w-3xl mx-auto">
          Resolvemos tus dudas sobre el programa
        </p>
      </div>
    </section>

    <!-- FAQ Section -->
    <section class="section bg-antiflash-white">
      <div class="container max-w-4xl">
        <div class="space-y-6">
          <div v-for="(pregunta, index) in preguntas" :key="index"
            class="bg-white rounded-2xl overflow-hidden shadow-sm">
            <button
              @click="togglePregunta(index)"
              class="w-full px-6 py-4 flex justify-between items-center hover:bg-gray-50 transition-colors"
              :aria-expanded="preguntaActiva === index"
            >
              <span class="text-lg font-bold text-left">{{ pregunta.pregunta }}</span>
              <svg
                class="w-6 h-6 text-turquoise transform transition-transform"
                :class="{ 'rotate-180': preguntaActiva === index }"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div
              v-show="preguntaActiva === index"
              class="px-6 py-4 bg-gray-50 border-t border-gray-100"
            >
              <p class="text-gray-600">{{ pregunta.respuesta }}</p>
            </div>
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
const preguntaActiva = ref(null)

const preguntas = [
  {
    pregunta: "¿Quiénes pueden postular?",
    respuesta: "Pueden postular estudiantes universitarios de cualquier carrera que estén cursando entre el 1° y 5° año de estudios. Valoramos la diversidad y el compromiso con el cambio social."
  },
  {
    pregunta: "¿En qué consiste el voluntariado?",
    respuesta: "El voluntariado consiste en participar en proyectos sociales, ambientales y culturales, dedicando un mínimo de 4 horas semanales. Los voluntarios reciben capacitación continua y pueden elegir el área de acción que más les interese."
  },
  {
    pregunta: "¿Hay un proceso de selección?",
    respuesta: "Sí, realizamos un proceso de selección que incluye la evaluación de tu postulación y una entrevista personal. Buscamos personas comprometidas, con iniciativa y genuino interés en el trabajo social."
  },
  {
    pregunta: "¿Qué duración tiene el programa?",
    respuesta: "El programa tiene una duración mínima de 6 meses, con posibilidad de extensión según tu desempeño y compromiso. Cada ciclo comienza al inicio de cada semestre académico."
  },
  {
    pregunta: "¿Es obligatorio asistir a todas las actividades?",
    respuesta: "Es obligatorio cumplir con el mínimo de horas semanales y asistir a las capacitaciones principales. Sin embargo, entendemos la carga académica y somos flexibles con los horarios."
  },
  {
    pregunta: "¿Hay algún beneficio o certificado?",
    respuesta: "Sí, al completar el programa recibirás un certificado oficial de participación. Además, obtendrás capacitación especializada, networking profesional y la posibilidad de liderar proyectos."
  },
  {
    pregunta: "¿Puedo participar si estudio en otra universidad?",
    respuesta: "¡Por supuesto! El programa está abierto a estudiantes de todas las universidades. De hecho, valoramos la diversidad de instituciones y perspectivas."
  }
]

const togglePregunta = (index) => {
  preguntaActiva.value = preguntaActiva.value === index ? null : index
}
</script>
