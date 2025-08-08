<template>
  <div>
    <!-- Hero Section -->
    <section class="relative py-24 bg-rich-black">
      <div class="container relative z-10 text-white">
        <h1 class="font-display text-center mb-6">Experiencias</h1>
        <p class="text-xl md:text-2xl text-center max-w-3xl mx-auto">
          Historias que inspiran y transforman
        </p>
      </div>
    </section>

    <!-- Testimonios Destacados -->
    <section class="section bg-white">
      <div class="container">
        <div class="max-w-6xl mx-auto">
          <div ref="testimoniosSlider" class="overflow-hidden">
            <div class="flex transition-transform duration-500 ease-in-out"
              :style="{ transform: `translateX(-${currentSlide * 100}%)` }">
              <div v-for="(testimonio, index) in testimonios" :key="index"
                class="w-full flex-shrink-0 px-4">
                <div class="bg-antiflash-white rounded-2xl p-8 md:p-12">
                  <div class="flex flex-col md:flex-row gap-8 items-center">
                    <div class="w-40 h-40 md:w-64 md:h-64 rounded-full overflow-hidden flex-shrink-0">
                      <img :src="testimonio.imagen" :alt="testimonio.nombre"
                        class="w-full h-full object-cover" />
                    </div>
                    <div>
                      <p class="text-xl md:text-2xl text-gray-600 italic mb-6">
                        "{{ testimonio.testimonio }}"
                      </p>
                      <div>
                        <h3 class="text-xl font-bold">{{ testimonio.nombre }}</h3>
                        <p class="text-gray-600">{{ testimonio.carrera }}</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Controles del slider -->
          <div class="flex justify-center mt-8 gap-4">
            <button @click="prevSlide"
              class="w-12 h-12 rounded-full border-2 border-turquoise text-turquoise hover:bg-turquoise hover:text-white transition-colors flex items-center justify-center">
              <span class="sr-only">Anterior</span>
              <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
              </svg>
            </button>
            <button @click="nextSlide"
              class="w-12 h-12 rounded-full border-2 border-turquoise text-turquoise hover:bg-turquoise hover:text-white transition-colors flex items-center justify-center">
              <span class="sr-only">Siguiente</span>
              <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- Galería de Fotos -->
    <section class="section bg-antiflash-white">
      <div class="container">
        <h2 class="text-center mb-12">Galería de Momentos</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
          <div v-for="(foto, index) in galeria" :key="index"
            @click="abrirModal(foto)"
            class="relative aspect-square cursor-pointer group overflow-hidden rounded-xl">
            <img :src="foto.imagen" :alt="foto.descripcion"
              class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110" />
            <div
              class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
              <p class="text-white text-sm">{{ foto.descripcion }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Videos Testimoniales -->
    <section class="section bg-white">
      <div class="container">
        <h2 class="text-center mb-12">Videos Testimoniales</h2>
        <div class="grid md:grid-cols-2 gap-8">
          <div v-for="(video, index) in videos" :key="index"
            class="aspect-video rounded-2xl overflow-hidden shadow-lg">
            <iframe :src="video.url" frameborder="0"
              class="w-full h-full"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
              allowfullscreen></iframe>
          </div>
        </div>
      </div>
    </section>

    <!-- Frase Inspiradora -->
    <section class="py-24 bg-turquoise text-white">
      <div class="container">
        <blockquote class="max-w-4xl mx-auto text-center">
          <p class="text-3xl md:text-4xl lg:text-5xl font-display mb-8">
            "Aquí descubrí lo que realmente puedo hacer por los demás."
          </p>
        </blockquote>
      </div>
    </section>

    <!-- CTA Final -->
    <section class="section bg-white">
      <div class="container text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">
          Tú también puedes vivir esta experiencia
        </h2>
        <nuxt-link to="/unete" class="btn-primary">
          Postula
        </nuxt-link>
      </div>
    </section>

    <!-- Modal de Galería -->
    <Teleport to="body">
      <div v-if="modalActivo"
        class="fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center p-4"
        @click="cerrarModal">
        <div class="relative max-w-4xl w-full" @click.stop>
          <button @click="cerrarModal"
            class="absolute -top-12 right-0 text-white hover:text-gray-300 transition-colors">
            <span class="sr-only">Cerrar</span>
            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
          <img :src="fotoSeleccionada?.imagen" :alt="fotoSeleccionada?.descripcion"
            class="w-full rounded-lg" />
          <p class="text-white text-center mt-4">{{ fotoSeleccionada?.descripcion }}</p>
        </div>
      </div>
    </Teleport>
  </div>
</template>

<script setup>
const currentSlide = ref(0)
const modalActivo = ref(false)
const fotoSeleccionada = ref(null)

const testimonios = [
  {
    nombre: 'María Sánchez',
    carrera: 'Psicología - 5to año',
    testimonio: 'Munay Ruray me permitió descubrir mi verdadera vocación. A través del voluntariado, pude aplicar mis conocimientos de psicología en situaciones reales y ayudar a personas que realmente lo necesitan.',
    imagen: 'https://placehold.co/400x400'
  },
  {
    nombre: 'Juan Carlos Medina',
    carrera: 'Ingeniería Ambiental - 4to año',
    testimonio: 'Participar en los proyectos de reforestación cambió mi perspectiva sobre el impacto que podemos tener en el medio ambiente. Ahora sé que cada pequeña acción cuenta.',
    imagen: 'https://placehold.co/400x400'
  },
  {
    nombre: 'Ana Paula Torres',
    carrera: 'Comunicación Social - 3er año',
    testimonio: 'Las campañas sociales que desarrollamos me ayudaron a entender el poder de la comunicación para generar cambios positivos en la sociedad.',
    imagen: 'https://placehold.co/400x400'
  }
]

const galeria = [
  {
    imagen: 'https://placehold.co/800x800',
    descripcion: 'Jornada de reforestación en la comunidad de Alto Mayo'
  },
  {
    imagen: 'https://placehold.co/800x800',
    descripcion: 'Taller de educación ambiental con niños'
  },
  {
    imagen: 'https://placehold.co/800x800',
    descripcion: 'Campaña de salud en zonas rurales'
  },
  {
    imagen: 'https://placehold.co/800x800',
    descripcion: 'Construcción de biblioteca comunitaria'
  },
  {
    imagen: 'https://placehold.co/800x800',
    descripcion: 'Programa de mentoring universitario'
  },
  {
    imagen: 'https://placehold.co/800x800',
    descripcion: 'Festival cultural Munay Ruray'
  },
  {
    imagen: 'https://placehold.co/800x800',
    descripcion: 'Voluntarios en acción social'
  },
  {
    imagen: 'https://placehold.co/800x800',
    descripcion: 'Taller de desarrollo personal'
  },
  {
    imagen: 'https://placehold.co/800x800',
    descripcion: 'Celebración del día del voluntario'
  }
]

const videos = [
  {
    url: 'https://www.youtube.com/embed/dQw4w9WgXcQ',
    titulo: 'Impacto en la Comunidad'
  },
  {
    url: 'https://www.youtube.com/embed/dQw4w9WgXcQ',
    titulo: 'Testimonios de Voluntarios'
  }
]

const nextSlide = () => {
  currentSlide.value = (currentSlide.value + 1) % testimonios.length
}

const prevSlide = () => {
  currentSlide.value = (currentSlide.value - 1 + testimonios.length) % testimonios.length
}

const abrirModal = (foto) => {
  fotoSeleccionada.value = foto
  modalActivo.value = true
}

const cerrarModal = () => {
  modalActivo.value = false
  fotoSeleccionada.value = null
}

// Autoplay para los testimonios
let autoplayInterval
onMounted(() => {
  autoplayInterval = setInterval(nextSlide, 5000)
})

onUnmounted(() => {
  clearInterval(autoplayInterval)
})
</script>
