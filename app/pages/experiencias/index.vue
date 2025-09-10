<template>
  <div>
    <!-- Hero Section -->
    <section class="relative py-24 wave-shape-secondary text-white overflow-hidden">
      <!-- Formas orgánicas de fondo -->
      <div class="organic-blob-1" style="top: 15%; right: 10%; z-index: 1;"></div>
      <div class="organic-blob-2" style="bottom: 25%; left: 5%; z-index: 1;"></div>
      
      <div class="container-full relative z-10 text-white">
        <h1 class="font-display text-center mb-6">Experiencias</h1>
        <p class="text-xl md:text-2xl text-center max-w-3xl mx-auto text-white/90">
          Historias que inspiran y transforman
        </p>
      </div>

      <!-- Divisor ondulado inferior -->
      <SectionDivider type="wave4" color="secondary" backgroundColor="white" height="50px"/>
    </section>

    <!-- Experiencia Destacada -->
    <section class="py-16 md:py-24 bg-white">
      <div class="container-full">
        <div class="max-w-6xl mx-auto">
          <h2 class="text-2xl md:text-3xl font-bold text-center mb-12">Experiencia Destacada</h2>
          <div class="bg-gradient-to-r from-primary/5 to-secondary/5 rounded-3xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="grid lg:grid-cols-2 gap-0">
              <div class="aspect-[4/3] lg:aspect-auto">
                <img :src="experienciaDestacada.cover" :alt="experienciaDestacada.title"
                  class="w-full h-full object-cover" />
              </div>
              <div class="p-8 md:p-12 flex flex-col justify-center">
                <div class="text-sm text-primary font-semibold mb-2">{{ experienciaDestacada.date }}</div>
                <h3 class="text-2xl md:text-3xl font-bold mb-4">{{ experienciaDestacada.title }}</h3>
                <p class="text-gray-600 mb-6 leading-relaxed">{{ experienciaDestacada.excerpt }}</p>
                <nuxt-link :to="`/experiencias/${experienciaDestacada.slug}`" 
                  class="inline-flex items-center text-secondary hover:text-secondary/80 font-semibold transition-colors">
                  Leer historia completa
                  <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                  </svg>
                </nuxt-link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Lista de Experiencias -->
    <section class="py-16 md:py-24 bg-gray-50">
      <div class="container-full">
        <div class="max-w-6xl mx-auto">
          <h2 class="text-2xl md:text-3xl font-bold text-center mb-12">Todas las Experiencias</h2>
          
          <!-- Filtros -->
          <div class="flex flex-wrap justify-center gap-4 mb-12">
            <button @click="filtroActivo = 'todas'"
              :class="['px-6 py-2 rounded-full font-semibold transition-colors', 
                filtroActivo === 'todas' ? 'bg-primary text-white' : 'bg-white text-gray-600 hover:bg-gray-100']">
              Todas
            </button>
            <button v-for="categoria in categorias" :key="categoria"
              @click="filtroActivo = categoria"
              :class="['px-6 py-2 rounded-full font-semibold transition-colors capitalize', 
                filtroActivo === categoria ? 'bg-primary text-white' : 'bg-white text-gray-600 hover:bg-gray-100']">
              {{ categoria }}
            </button>
          </div>

          <!-- Grid de experiencias -->
          <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <article v-for="experiencia in experienciasFiltradas" :key="experiencia.slug"
              class="bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 group">
              <div class="aspect-[4/3] overflow-hidden">
                <img :src="experiencia.cover" :alt="experiencia.title"
                  class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
              </div>
              <div class="p-6">
                <div class="flex items-center justify-between mb-3">
                  <span class="text-xs font-semibold text-primary bg-primary/10 px-3 py-1 rounded-full capitalize">
                    {{ experiencia.category }}
                  </span>
                  <time class="text-sm text-gray-500">{{ experiencia.date }}</time>
                </div>
                <h3 class="text-xl font-bold mb-3 group-hover:text-primary transition-colors">
                  {{ experiencia.title }}
                </h3>
                <p class="text-gray-600 mb-4 line-clamp-3">{{ experiencia.excerpt }}</p>
                <nuxt-link :to="`/experiencias/${experiencia.slug}`"
                  class="inline-flex items-center text-secondary hover:text-secondary/80 font-semibold transition-colors">
                  Leer más
                  <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                  </svg>
                </nuxt-link>
              </div>
            </article>
          </div>
        </div>
      </div>
    </section>

    <!-- Testimonios Rápidos -->
    <section class="py-16 md:py-24 bg-white">
      <div class="container-full">
        <div class="max-w-4xl mx-auto text-center">
          <h2 class="text-2xl md:text-3xl font-bold mb-12">Lo que dicen nuestros voluntarios</h2>
          <div class="grid md:grid-cols-3 gap-8">
            <div v-for="(testimonio, index) in testimoniosRapidos" :key="index"
              class="bg-gray-50 rounded-2xl p-6 hover:bg-white hover:shadow-lg transition-all duration-300">
              <div class="w-16 h-16 rounded-full overflow-hidden mx-auto mb-4">
                <img :src="testimonio.imagen" :alt="testimonio.nombre"
                  class="w-full h-full object-cover" />
              </div>
              <p class="text-gray-600 italic mb-4">"{{ testimonio.texto }}"</p>
              <div>
                <h4 class="font-bold text-gray-900">{{ testimonio.nombre }}</h4>
                <p class="text-sm text-gray-500">{{ testimonio.carrera }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Final -->
    <section class="py-16 md:py-24 bg-primary text-white">
      <div class="container-full text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">
          Tú también puedes vivir esta experiencia
        </h2>
        <p class="text-xl mb-8 text-white/90 max-w-2xl mx-auto">
          Únete a nuestra comunidad y crea tu propia historia de transformación
        </p>
        <nuxt-link to="/unete" class="btn-secondary bg-white text-primary hover:bg-gray-100">
          Postula ahora
        </nuxt-link>
      </div>
    </section>
  </div>
</template>

<script setup>
import { SectionDivider } from '#components'

// SEO
useHead({
  title: 'Experiencias - Munay Ruray',
  meta: [
    {
      name: 'description',
      content: 'Descubre las historias inspiradoras de nuestros voluntarios y el impacto que generamos juntos en las comunidades.'
    }
  ]
})

// Usar el composable de experiencias
const { getExperienciaDestacada, getCategorias, getExperienciasFiltradas } = useExperiencias()

// Estado reactivo para filtros
const filtroActivo = ref('todas')

// Datos usando el composable
const experienciaDestacada = computed(() => getExperienciaDestacada())
const categorias = computed(() => getCategorias())
const experienciasFiltradas = computed(() => 
  getExperienciasFiltradas(filtroActivo.value, true) // true para excluir featured
)

// Testimonios rápidos
const testimoniosRapidos = [
  {
    nombre: 'María Sánchez',
    carrera: 'Psicología',
    texto: 'Descubrí mi verdadera vocación de servicio',
    imagen: 'https://placehold.co/400x400'
  },
  {
    nombre: 'Juan Carlos',
    carrera: 'Ing. Ambiental',
    texto: 'Cambió mi perspectiva sobre el impacto ambiental',
    imagen: 'https://placehold.co/400x400'
  },
  {
    nombre: 'Ana Paula',
    carrera: 'Comunicación',
    texto: 'Entendí el poder de la comunicación social',
    imagen: 'https://placehold.co/400x400'
  }
]
</script>
