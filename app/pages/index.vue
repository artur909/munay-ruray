<template>
  <div>
    <!-- Hero Section - Minimalista con video de fondo -->
    <section class="relative min-h-screen overflow-hidden">
      <!-- Video de fondo -->
      <div class="absolute inset-0 z-0">
        <video autoplay muted loop playsinline class="w-full h-full object-cover"
          poster="https://placehold.co/1920x1080/e9b026/ffffff?text=Video+Poster">
          <source src="https://testeo.marcaperuana.com/wp-content/uploads/2025/05/base-video_1.mp4" type="video/mp4">
          <!-- Fallback para navegadores que no soportan video -->
          <div class="w-full h-full bg-gradient-to-br from-primary/20 to-secondary/20"></div>
        </video>
        <!-- Overlay oscuro para legibilidad -->
        <div class="absolute inset-0 bg-black/40"></div>
      </div>

      <!-- Contenido alineado a la izquierda y minimalista -->
      <div class="container-full relative z-10 flex items-center min-h-screen">
        <div class="max-w-4xl space-y-8 text-white">
          <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight scroll-reveal text-reveal-words">
            <span class="word" style="animation-delay: 0.1s">Transforma</span>
            <span class="word" style="animation-delay: 0.2s">tu</span>
            <span class="text-primary word" style="animation-delay: 0.3s">vocación</span>
            <span class="word" style="animation-delay: 0.4s">en</span>
            <span class="text-secondary word" style="animation-delay: 0.5s">acción</span>
          </h1>

          <p class="text-lg md:text-xl text-white/90 max-w-2xl scroll-reveal-stagger" style="animation-delay: 0.6s">
            Munay Ruray es más que voluntariado. Es una comunidad que genera impacto y transforma vidas.
          </p>

          <div class="flex flex-col sm:flex-row gap-6 scroll-reveal-stagger" style="animation-delay: 0.8s">
            <nuxt-link to="/unete" class="cta-enhanced">
              <span>Postula al voluntariado</span>
              <svg class="w-5 h-5 ml-3 icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3">
                </path>
              </svg>
            </nuxt-link>
            <nuxt-link to="/sobre-nosotros" class="cta-secondary-enhanced border-white text-white bg-white/10">
              <span>Conoce más</span>
              <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </nuxt-link>
          </div>
        </div>
      </div>

      <!-- Scroll indicator -->
      <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <div class="w-6 h-10 border-2 border-white/50 rounded-full flex justify-center">
          <div class="w-1 h-3 bg-white rounded-full mt-2 animate-bounce"></div>
        </div>
      </div>
    </section>

    <!-- Sección de beneficios con parallax -->
    <section class="py-16 md:py-24 bg-white parallax-bg"
      style="background-image: linear-gradient(rgba(255,255,255,0.95), rgba(255,255,255,0.95)), url('https://placehold.co/1920x1080/f8f9fa/e9e9e9?text=Background+Pattern')">
      <div class="container-full">
        <div class="grid lg:grid-cols-2 gap-20 items-center">
          <!-- Contenido -->
          <div class="space-y-8 fade-in-left">
            <div class="space-y-8">
              <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 scroll-reveal text-reveal-words">
                <span class="word" style="animation-delay: 0.1s">¿Qué</span> <span class="word"
                  style="animation-delay: 0.2s">es</span> <span class="text-primary word"
                  style="animation-delay: 0.3s">Munay</span> <span class="text-primary word"
                  style="animation-delay: 0.4s">Ruray</span><span class="word" style="animation-delay: 0.5s">?</span>
              </h2>
              <p class="text-lg md:text-xl text-gray-600 scroll-reveal-stagger" style="animation-delay: 0.6s">
                Somos un programa de voluntariado universitario que busca generar impacto social, cultural, ambiental y
                digital, potenciando el desarrollo humano y profesional de nuestros voluntarios.
              </p>
            </div>

            <!-- Lista de beneficios -->
            <div class="space-y-6">
              <div class="flex items-start space-x-4">
                <div class="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                  <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                      clip-rule="evenodd"></path>
                  </svg>
                </div>
                <div>
                  <h3 class="text-lg font-semibold text-gray-900 mb-1">Impacto Social Real</h3>
                  <p class="text-gray-600">Genera cambios positivos en comunidades vulnerables</p>
                </div>
              </div>

              <div class="flex items-start space-x-4">
                <div class="w-8 h-8 bg-secondary/10 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                  <svg class="w-4 h-4 text-secondary" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                      clip-rule="evenodd"></path>
                  </svg>
                </div>
                <div>
                  <h3 class="text-lg font-semibold text-gray-900 mb-1">Desarrollo Profesional</h3>
                  <p class="text-gray-600">Fortalece habilidades y competencias clave</p>
                </div>
              </div>

              <div class="flex items-start space-x-4">
                <div class="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                  <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                      clip-rule="evenodd"></path>
                  </svg>
                </div>
                <div>
                  <h3 class="text-lg font-semibold text-gray-900 mb-1">Experiencia Transformadora</h3>
                  <p class="text-gray-600">Cambia perspectivas y descubre tu potencial</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Visual -->
          <div class="relative fade-in-right">
            <div class="grid grid-cols-2 gap-4">
              <div class="space-y-4">
                <div
                  class="aspect-square bg-gradient-to-br from-primary/20 to-primary/10 rounded-2xl p-6 flex items-center justify-center">
                  <div class="text-center">
                    <div class="text-3xl font-bold text-primary mb-2">500+</div>
                    <div class="text-sm text-gray-600">Voluntarios</div>
                  </div>
                </div>
                <div class="aspect-[4/3] bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl overflow-hidden">
                  <img src="https://placehold.co/300x225/66c7cb/ffffff?text=Comunidad" alt="Comunidad"
                    class="w-full h-full object-cover" />
                </div>
              </div>
              <div class="space-y-4 pt-8">
                <div class="aspect-[4/3] bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl overflow-hidden">
                  <img src="https://placehold.co/300x225/e9b026/ffffff?text=Impacto" alt="Impacto"
                    class="w-full h-full object-cover" />
                </div>
                <div
                  class="aspect-square bg-gradient-to-br from-secondary/20 to-secondary/10 rounded-2xl p-6 flex items-center justify-center">
                  <div class="text-center">
                    <div class="text-3xl font-bold text-secondary mb-2">85%</div>
                    <div class="text-sm text-gray-600">Satisfacción</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Líneas de acción - Layout myhealthprac.com -->
    <section class="py-16 md:py-24 bg-gray-50">
      <div class="container-full">
        <div class="text-center mb-20 fade-in-up">
          <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-8 leading-tight">
            Ejes que nos <span class="text-secondary">mueven</span>
          </h2>
          <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
            Estas son nuestras formas de actuar y transformar
          </p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 max-w-6xl mx-auto">
          <div v-for="(linea, index) in lineasAccion" :key="index" class="card-enhanced group scroll-reveal-stagger"
            :style="{ animationDelay: `${index * 0.1}s` }">
            <div class="flex items-start space-x-6">
              <div
                class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:bg-primary/20 transition-all duration-500 group-hover:scale-110 group-hover:rotate-3">
                <IconoLineasAccion :tipo="linea.icono" />
              </div>
              <div class="flex-1">
                <h3
                  class="text-xl font-bold mb-4 text-gray-900 group-hover:text-primary transition-colors duration-500">
                  {{ linea.titulo }}</h3>
                <p class="text-gray-600 mb-6 leading-relaxed">{{ linea.descripcion }}</p>
                <nuxt-link to="/lineas-de-accion"
                  class="inline-flex items-center text-secondary hover:text-secondary/80 transition-all duration-300 font-semibold group-hover:translate-x-2">
                  Ver más
                  <svg class="w-4 h-4 ml-2 group-hover:translate-x-2 group-hover:scale-110 transition-all duration-300"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3">
                    </path>
                  </svg>
                </nuxt-link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Testimonios - Layout myhealthprac.com -->
    <section class="py-16 md:py-24 bg-white">
      <div class="container-full">
        <div class="grid lg:grid-cols-2 gap-20 items-center">
          <!-- Contenido -->
          <div class="space-y-8 fade-in-left">
            <div class="space-y-6">
              <h2 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight">
                Experiencias que <span class="text-secondary">Transforman</span>
              </h2>
              <p class="text-lg md:text-xl text-gray-600 leading-relaxed">
                Descubre cómo nuestros voluntarios han encontrado su propósito y transformado sus vidas a través del
                servicio.
              </p>
            </div>

            <!-- Estadísticas -->
            <div class="grid grid-cols-2 gap-8">
              <div class="text-center p-6 bg-primary/5 rounded-2xl">
                <div class="text-3xl font-bold text-primary mb-2">10,000+</div>
                <div class="text-gray-600">Personas impactadas</div>
              </div>
              <div class="text-center p-6 bg-secondary/5 rounded-2xl">
                <div class="text-3xl font-bold text-secondary mb-2">95%</div>
                <div class="text-gray-600">Recomendarían</div>
              </div>
            </div>

            <nuxt-link to="/experiencias" class="btn-secondary">
              Ver más testimonios
            </nuxt-link>
          </div>

          <!-- Testimonios -->
          <div class="space-y-6 fade-in-right">
            <div v-for="(testimonio, index) in testimonios" :key="index"
              class="bg-gray-50 rounded-3xl p-8 hover:bg-white hover:shadow-lg transition-all duration-500"
              :style="{ animationDelay: `${index * 0.2}s` }">
              <div class="flex items-start space-x-4 mb-6">
                <img :src="testimonio.imagen" :alt="testimonio.nombre"
                  class="w-16 h-16 rounded-full object-cover flex-shrink-0" />
                <div>
                  <h4 class="font-bold text-gray-900 mb-1">{{ testimonio.nombre }}</h4>
                  <p class="text-gray-600 text-sm">{{ testimonio.carrera }}</p>
                </div>
              </div>
              <p class="text-gray-700 leading-relaxed italic">"{{ testimonio.texto }}"</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Final con imagen de fondo -->
    <section class="py-16 md:py-24 bg-image-section text-white relative overflow-hidden parallax-bg"
      style="background-image: url('https://placehold.co/1920x800/e9b026/ffffff?text=Comunidad+Transformadora')">
      <!-- Overlay adicional -->
      <div class="absolute inset-0 bg-gradient-to-br from-primary/80 via-primary/70 to-secondary/60 z-1"></div>

      <!-- Formas orgánicas flotantes -->
      <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl animate-float"></div>
      <div class="absolute bottom-0 left-0 w-80 h-80 bg-white/5 rounded-full blur-3xl animate-float-delayed"></div>

      <div class="container-full relative z-2">
        <div class="max-w-4xl mx-auto text-center">
          <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-8 scroll-reveal text-reveal-words">
            <span class="word" style="animation-delay: 0.1s">Súmate</span>
            <span class="word" style="animation-delay: 0.2s">a</span>
            <span class="word" style="animation-delay: 0.3s">una</span>
            <span class="word" style="animation-delay: 0.4s">experiencia</span>
            <span class="word" style="animation-delay: 0.5s">que</span>
            <span class="text-white/90 word" style="animation-delay: 0.6s">transforma</span>
          </h2>
          <p class="text-lg md:text-xl mb-12 text-white/90 max-w-3xl mx-auto scroll-reveal-stagger"
            style="animation-delay: 0.8s">
            Únete a una comunidad de jóvenes comprometidos con el cambio social y descubre tu potencial
          </p>
          <div class="flex flex-col sm:flex-row gap-8 justify-center scroll-reveal-stagger" style="animation-delay: 1s">
            <nuxt-link to="/unete" class="cta-enhanced bg-white text-primary group">
              <span>Postula ahora</span>
              <svg class="w-5 h-5 ml-3 icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3">
                </path>
              </svg>
            </nuxt-link>
            <nuxt-link to="/experiencias" class="cta-secondary-enhanced border-white text-white bg-white/10">
              <span>Ver experiencias</span>
              <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                </path>
              </svg>
            </nuxt-link>
          </div>
        </div>
      </div>
    </section>

    <!-- Botón flotante móvil -->
    <div class="floating-cta">
      <nuxt-link to="/unete"
        class="bg-primary text-white px-6 py-3 rounded-full font-bold shadow-lg hover:shadow-xl transition-all duration-300 flex items-center space-x-2 hover-scale">
        <span>Postula</span>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
      </nuxt-link>
    </div>
  </div>
</template>

<script setup>
import { onMounted, onUnmounted } from 'vue'

// SEO
useHead({
  title: 'Inicio - Munay Ruray',
  meta: [
    {
      name: 'description',
      content: 'Munay Ruray - Transforma tu vocación en acción. Únete a nuestro programa de voluntariado universitario y genera impacto social, cultural, ambiental y digital.'
    }
  ]
})

// Animaciones de scroll y parallax
let scrollAnimationFrame = null

const initScrollAnimations = () => {
  if (process.client) {
    // Intersection Observer para animaciones de scroll
    const observerOptions = {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    }

    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible')

          // Animación especial para palabras
          if (entry.target.classList.contains('text-reveal-words')) {
            const words = entry.target.querySelectorAll('.word')
            words.forEach((word, index) => {
              setTimeout(() => {
                word.style.animationPlayState = 'running'
              }, index * 100)
            })
          }
        }
      })
    }, observerOptions)

    // Observar elementos con animaciones
    const elementsToObserve = document.querySelectorAll('.scroll-reveal, .scroll-reveal-stagger, .text-reveal-words')
    elementsToObserve.forEach(el => observer.observe(el))

    // Efectos parallax
    const handleScroll = () => {
      if (scrollAnimationFrame) return

      scrollAnimationFrame = requestAnimationFrame(() => {
        const scrolled = window.pageYOffset
        const parallaxElements = document.querySelectorAll('.parallax-element')

        parallaxElements.forEach((element, index) => {
          const speed = 0.5 + (index * 0.1)
          const yPos = -(scrolled * speed)
          element.style.transform = `translateY(${yPos}px)`
        })

        scrollAnimationFrame = null
      })
    }

    // Event listeners
    window.addEventListener('scroll', handleScroll, { passive: true })

    // Cleanup function
    return () => {
      window.removeEventListener('scroll', handleScroll)
      observer.disconnect()
      if (scrollAnimationFrame) {
        cancelAnimationFrame(scrollAnimationFrame)
      }
    }
  }
}

onMounted(() => {
  const cleanup = initScrollAnimations()

  // Inicializar palabras con animación pausada
  const words = document.querySelectorAll('.word')
  words.forEach(word => {
    word.style.animationPlayState = 'paused'
  })

  // Cleanup en unmount
  onUnmounted(() => {
    if (cleanup) cleanup()
  })
})

const lineasAccion = [
  {
    titulo: 'Proyección Social',
    descripcion: 'Acciones en comunidades vulnerables, educación, salud y más.',
    icono: 'social'
  },
  {
    titulo: 'Acción Ambiental',
    descripcion: 'Proyectos de reforestación, reciclaje y conciencia ambiental.',
    icono: 'ambiental'
  },
  {
    titulo: 'Cultura e Identidad Profesional',
    descripcion: 'Actividades que fortalecen valores y cultura universitaria.',
    icono: 'cultura'
  },
  {
    titulo: 'Comunicación Social',
    descripcion: 'Producción digital, campañas y diseño para el cambio.',
    icono: 'comunicacion'
  }
]

const testimonios = [
  {
    nombre: 'Ana García',
    carrera: 'Psicología - 4to año',
    texto: 'Munay Ruray me ayudó a descubrir mi verdadera vocación de servicio.',
    imagen: 'https://placehold.co/480x480'
  },
  {
    nombre: 'Carlos Mendoza',
    carrera: 'Ing. Ambiental - 3er año',
    texto: 'Aquí encontré la manera de contribuir realmente con el medio ambiente.',
    imagen: 'https://placehold.co/480x480'
  },
  {
    nombre: 'María Flores',
    carrera: 'Comunicación - 5to año',
    texto: 'La experiencia más enriquecedora de mi vida universitaria.',
    imagen: 'https://placehold.co/480x480'
  }
]
</script>
