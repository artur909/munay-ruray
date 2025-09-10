<template>
  <div>
    <!-- Hero Section -->
    <section class="relative py-24 wave-shape-primary text-white overflow-hidden">
      <!-- Formas orgánicas de fondo -->
      <div class="organic-blob-1" style="top: 15%; right: 10%; z-index: 1;"></div>
      <div class="organic-blob-2" style="bottom: 25%; left: 5%; z-index: 1;"></div>

      <div class="container-full relative z-10 text-white">
        <h1 class="font-display text-center mb-6">Sobre Nosotros</h1>
        <p class="text-lg md:text-xl text-center text-white/90 max-w-3xl mx-auto">
          Conoce nuestra historia, misión y los valores que nos impulsan a transformar vidas a través del voluntariado
        </p>
      </div>

      <!-- Divisor ondulado inferior -->
      <sectionDivider type="organic2" />
    </section>

    <!-- Quiénes Somos -->
    <section class="py-16 md:py-24 bg-white section-with-shapes">
      <div class="container-full">
        <div class="max-w-4xl mx-auto text-center">
          <h2 class="mb-8">Quiénes Somos</h2>
          <p class="text-xl text-gray-600 mb-12">
            El voluntariado Munay Ruray es un programa para jóvenes universitarios que busca fortalecer su desarrollo profesional y humano mediante experiencias prácticas en proyectos sociales, comunitarios, ambientales y digitales.
          </p>
        </div>
      </div>
    </section>

    <!-- Misión, Visión, Propósito -->
    <section class="py-16 md:py-24 bg-gray-50 relative">
      <SectionDivider type="wave2" color="white" backgroundColor="gray" position="top" />

      <div class="container-full">
        <div class="grid md:grid-cols-3 gap-8">
          <div class="card-enhanced group">
            <div
              class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mb-6 mx-auto group-hover:bg-primary/20 transition-all duration-500">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-primary">
                <path
                  d="M14.59 6.59c-.78.78-.78 2.05 0 2.83s2.05.78 2.83 0 .78-2.05 0-2.83-2.05-.78-2.83 0M5 16c-2 1-2 5-2 5s3 0 5-2z">
                </path>
                <path
                  d="M21 2h-3.69c-2.4 0-4.66.94-6.36 2.64L8.69 6.9a8.4 8.4 0 0 0-6.24 1.27c-.25.17-.41.44-.44.73s.08.59.29.81l12 12c.2.2.45.29.71.29s.51-.1.71-.29c1.9-1.9 1.6-5.08 1.38-6.38l2.28-2.28c1.7-1.7 2.64-3.96 2.64-6.36V3c0-.55-.45-1-1-1Zm-1 4.69c0 1.87-.73 3.63-2.05 4.95l-2.66 2.66c-.25.25-.35.61-.26.95.19.79.45 2.78-.17 4.2L4.65 9.24c2.11-.89 3.94-.32 4.03-.29.36.12.76.03 1.02-.24l2.66-2.66A6.96 6.96 0 0 1 17.31 4H20z">
                </path>
              </svg>
            </div>
            <h3 class="text-2xl font-bold text-center mb-4 group-hover:text-primary transition-colors duration-500">
              Misión</h3>
            <p class="text-gray-600 text-center">
              Brindamos a jóvenes universitarios experiencias reales y formativas que 
fortalezcan sus competencias profesionales, habilidades blandas y compromiso social, 
preparándolos para afrontar con seguridad, humanidad y responsabilidad los desafíos 
del mundo laboral.
            </p>
          </div>

          <div class="card-enhanced group">
            <div
              class="w-16 h-16 bg-secondary/10 rounded-full flex items-center justify-center mb-6 mx-auto group-hover:bg-secondary/20 transition-all duration-500">
              <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                class="text-secondary w-8 h-8">
                <path
                  d="M12 5c-7.63 0-9.93 6.62-9.95 6.68-.07.21-.07.43 0 .63.02.07 2.32 6.68 9.95 6.68s9.93-6.62 9.95-6.68c.07-.21.07-.43 0-.63C21.93 11.61 19.63 5 12 5m0 12c-5.35 0-7.42-3.84-7.93-5 .5-1.16 2.58-5 7.93-5s7.42 3.85 7.93 5c-.5 1.16-2.58 5-7.93 5">
                </path>
                <path
                  d="M13.5 12c-.83 0-1.5-.67-1.5-1.5 0-.6.36-1.12.87-1.35-.28-.09-.56-.15-.87-.15-1.64 0-3 1.36-3 3s1.36 3 3 3 3-1.36 3-3c0-.3-.06-.59-.15-.87-.24.51-.75.87-1.35.87">
                </path>
              </svg>
            </div>
            <h3 class="text-2xl font-bold text-center mb-4 group-hover:text-secondary transition-colors duration-500">
              Visión</h3>
            <p class="text-gray-600 text-center">
              Ser un voluntariado reconocido por impulsar una nueva generación de profesionales 
empáticos, comprometidos con su carrera, conscientes del valor de su rol en la sociedad y 
preparados para desenvolverse en entornos laborales cambiantes.
            </p>
          </div>

          <div class="card-enhanced group">
            <div
              class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mb-6 mx-auto group-hover:bg-primary/20 transition-all duration-500">
              <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                class="fill-primary w-8 h-8">
                <path d="M12 9a3 3 0 1 0 0 6 3 3 0 1 0 0-6"></path>
                <path
                  d="M13 4.07V2h-2v2.07A8 8 0 0 0 4.07 11H2v2h2.07A8 8 0 0 0 11 19.93V22h2v-2.07A8 8 0 0 0 19.93 13H22v-2h-2.07A8 8 0 0 0 13 4.07M12 18c-3.31 0-6-2.69-6-6s2.69-6 6-6 6 2.69 6 6-2.69 6-6 6">
                </path>
              </svg>
            </div>
            <h3 class="text-2xl font-bold text-center mb-4 group-hover:text-primary transition-colors duration-500">
              Propósito</h3>
            <p class="text-gray-600 text-center">
              Impulsar el desarrollo personal, profesional y social de los voluntarios universitarios 
mediante actividades formativas, comunitarias y creativas que refuercen su identidad 
profesional, sus habilidades blandas y su preparación para el mundo laboral.
            </p>
          </div>
        </div>
      </div>

      <!-- Divisor ondulado inferior -->
      <SectionDivider type="wave4" color="gray" backgroundColor="white" />
    </section>

    <!-- Objetivos Específicos -->
    <section class="py-16 md:py-24 bg-white section-with-shapes">
      <div class="container-full">
        <h2 class="text-center mb-12">Objetivos Específicos</h2>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div v-for="(objetivo, index) in objetivos" :key="index" class="card-enhanced group">
            <div
              class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center mb-4 group-hover:bg-primary/20 transition-all duration-500">
              <span class="text-primary text-xl font-bold">{{ index + 1 }}</span>
            </div>
            <h3 class="text-xl font-bold mb-3 group-hover:text-primary transition-colors duration-500">{{
              objetivo.titulo }}</h3>
            <p class="text-gray-600">{{ objetivo.descripcion }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Valores Institucionales -->
    <section class="py-16 md:py-24 bg-gray-50 relative">
      <!-- Divisor ondulado superior -->
      <sectionDivider type="wave4" color="white" backgroundColor="gray" position="top" />

      <div class="container-full">
        <h2 class="text-center mb-12">Valores Institucionales</h2>
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
          <div v-for="(valor, index) in valores" :key="index" class="text-center">
            <div
              class="w-20 h-20 bg-white rounded-full flex items-center justify-center mb-6 mx-auto shadow-sm hover:shadow-md transition-all duration-300 hover:scale-110">
              <svg v-html="valor.icono" class="w-10 h-10 text-secondary" viewBox="0 0 24 24" fill="currentColor"></svg>
            </div>
            <h3 class="text-xl font-bold mb-2">{{ valor.nombre }}</h3>
            <p class="text-gray-600">{{ valor.descripcion }}</p>
          </div>
        </div>
      </div>

      <!-- Divisor ondulado inferior -->
      <SectionDivider type="wave2" color="gray" backgroundColor="white" position="bottom" />
    </section>

    <!-- Aliados Estratégicos -->
    <section class="py-16 md:py-24 bg-white">
      <div class="container-full">
        <h2 class="text-center mb-12">Aliados Estratégicos</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 items-center justify-items-center">
          <div v-for="(aliado, index) in aliados" :key="index"
            class="w-auto  bg-gray-50 rounded-2xl p-4 flex items-center justify-center hover:shadow-lg hover:scale-105 transition-all duration-300">
            <img :src="aliado.logo" :alt="aliado.nombre" class="max-w-full max-h-full object-contain" />
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Final -->
    <section class="py-16 md:py-24 wave-shape-secondary text-white relative overflow-hidden">

      <sectionDivider type="wave2" color="white" backgroundColor="secondary" position="top" />

      <!-- Formas orgánicas sólidas características -->
      <div class="absolute top-20 right-10 w-48 h-48 bg-primary opacity-15 animate-float-organic pointer-events-none"
        style="border-radius: 63% 37% 54% 46% / 55% 48% 52% 45%; z-index: 0;"></div>
      <div class="absolute bottom-20 left-10 w-36 h-36 bg-white opacity-8 animate-float-organic pointer-events-none"
        style="border-radius: 38% 62% 63% 37% / 70% 33% 67% 30%; animation-delay: 2s; z-index: 0;"></div>

      <div class="container-full relative z-2 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">
          ¿Listo para ser parte del cambio?
        </h2>
        <p class="text-lg md:text-xl text-white/90 mb-8 max-w-2xl mx-auto">
          Únete a nuestra comunidad de voluntarios y transforma tu vocación en acción
        </p>
        <nuxt-link to="/unete" class="cta-enhanced bg-white text-secondary">
          <span>Únete a Munay Ruray</span>
          <svg class="w-5 h-5 ml-3 icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
          </svg>
        </nuxt-link>
      </div>
    </section>
  </div>
</template>

<script setup>
import { SectionDivider } from '#components'




const objetivos = [
  {
    titulo: 'Fomentar Ciudadanía Activa',
    descripcion: 'Promover la participación activa de los universitarios en la solución de problemas sociales.'
  },
  {
    titulo: 'Fortalecer Habilidades',
    descripcion: 'Desarrollar competencias blandas y profesionales a través de experiencias prácticas.'
  },
  {
    titulo: 'Promover Cultura Solidaria',
    descripcion: 'Crear una comunidad universitaria comprometida con el bienestar social.'
  },
  {
    titulo: 'Generar Impacto Medible',
    descripcion: 'Implementar proyectos con resultados tangibles y sostenibles.'
  },
  {
    titulo: 'Innovación Social',
    descripcion: 'Fomentar soluciones creativas a problemas sociales complejos.'
  },
  {
    titulo: 'Networking Profesional',
    descripcion: 'Crear conexiones valiosas entre voluntarios y organizaciones.'
  }
]

const valores = [
  {
    nombre: 'Compromiso',
    descripcion: 'Dedicación constante con nuestros objetivos y comunidad.',
    icono: '<path d="m20.24,4.76c-2.3-2.29-5.87-2.35-8.24-.19-2.37-2.16-5.93-2.09-8.24.2-2.36,2.37-2.36,6.07,0,8.43l7.53,7.52c.2.19.45.29.71.29s.51-.1.71-.29l7.53-7.52c2.36-2.36,2.36-6.06,0-8.43,0,0,0,0,0,0Zm-8.24,13.83l-6.82-6.81c-1.57-1.57-1.57-4.03,0-5.6.79-.79,1.8-1.18,2.81-1.18s2.02.39,2.8,1.18l.5.5s0,0,0,0l-2.38,2.39c-.51.52-.51,1.36,0,1.88.49.49,1.13.73,1.77.73s1.28-.24,1.77-.73l1.64-1.64,3.59,3.59-1.04,1.04-2.3-2.3-.71.71,2.3,2.3-.79.79-2.3-2.3-.71.71,2.3,2.3-.79.79-2.29-2.29-.71.71,2.29,2.29-.94.94Zm6.82-6.81l-.42.42-3.59-3.59,1.24-1.24-.71-.71-3.59,3.59c-.58.58-1.54.58-2.12,0-.13-.13-.13-.34,0-.47l3.42-3.44h0s.16-.16.16-.16c1.57-1.57,4.04-1.57,5.62,0,1.57,1.58,1.57,4.04,0,5.6Z"/>'
  },
  {
    nombre: 'Empatía',
    descripcion: 'Capacidad de entender y compartir los sentimientos de otros.',
    icono: '<path d="M12 21.35L10.55 20.03C5.4 15.36 2 12.27 2 8.5C2 5.41 4.42 3 7.5 3C9.24 3 10.91 3.81 12 5.08C13.09 3.81 14.76 3 16.5 3C19.58 3 22 5.41 22 8.5C22 12.27 18.6 15.36 13.45 20.03L12 21.35Z"/>'
  },
  {
    nombre: 'Integridad',
    descripcion: 'Actuamos con honestidad y coherencia en todo momento.',
    icono: '<path d="M12 22S3 18 3 12V5L12 2L21 5V12C21 18 12 22 12 22Z" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>'
  },
  {
    nombre: 'Innovación',
    descripcion: 'Buscamos constantemente nuevas formas de generar impacto.',
    icono: '<path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>'
  }
]

const aliados = [
  {
    nombre: 'Universidad Nacional Mayor de San Marcos',
    logo: 'https://placehold.co/400x200'
  },
  {
    nombre: 'Pontificia Universidad Católica del Perú',
    logo: 'https://placehold.co/400x200'
  },
  {
    nombre: 'Universidad Nacional de Ingeniería',
    logo: 'https://placehold.co/400x200'
  },
  {
    nombre: 'Universidad del Pacífico',
    logo: 'https://placehold.co/400x200'
  }
]

</script>
