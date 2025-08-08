<template>
  <div>
    <!-- Hero Section -->
    <section class="relative py-24 bg-rich-black">
      <div class="container relative z-10 text-white">
        <h1 class="font-display text-center mb-6">Sobre Nosotros</h1>
      </div>
    </section>

    <!-- Quiénes Somos -->
    <section class="section bg-white">
      <div class="container">
        <div class="max-w-4xl mx-auto text-center">
          <h2 class="mb-8">Quiénes Somos</h2>
          <p class="text-xl text-gray-600 mb-12">
            Somos una iniciativa universitaria comprometida con el desarrollo social que busca transformar la vida de las personas
            a través del voluntariado. Creemos en el poder de la acción colectiva y en el impacto que podemos generar cuando
            unimos nuestras fuerzas por un propósito común.
          </p>
        </div>
      </div>
    </section>

    <!-- Misión, Visión, Propósito -->
    <section class="section bg-antiflash-white">
      <div class="container">
        <div class="grid md:grid-cols-3 gap-8">
          <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-md transition-shadow">
            <div class="w-16 h-16 bg-turquoise/10 rounded-full flex items-center justify-center mb-6 mx-auto">
              <svg class="w-8 h-8 text-turquoise" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </div>
            <h3 class="text-2xl font-bold text-center mb-4">Misión</h3>
            <p class="text-gray-600 text-center">
              Generar impacto social positivo a través del voluntariado universitario, potenciando el desarrollo humano y
              profesional de nuestros participantes.
            </p>
          </div>

          <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-md transition-shadow">
            <div class="w-16 h-16 bg-turquoise/10 rounded-full flex items-center justify-center mb-6 mx-auto">
              <svg class="w-8 h-8 text-turquoise" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </div>
            <h3 class="text-2xl font-bold text-center mb-4">Visión</h3>
            <p class="text-gray-600 text-center">
              Ser el programa líder en voluntariado universitario, reconocido por su impacto transformador en la sociedad y en
              el desarrollo integral de los voluntarios.
            </p>
          </div>

          <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-md transition-shadow">
            <div class="w-16 h-16 bg-turquoise/10 rounded-full flex items-center justify-center mb-6 mx-auto">
              <svg class="w-8 h-8 text-turquoise" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M22 12H18L15 21L9 3L6 12H2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </div>
            <h3 class="text-2xl font-bold text-center mb-4">Propósito</h3>
            <p class="text-gray-600 text-center">
              Crear un espacio donde los universitarios puedan desarrollar su potencial mientras generan un impacto positivo en
              la sociedad.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Objetivos Específicos -->
    <section class="section bg-white">
      <div class="container">
        <h2 class="text-center mb-12">Objetivos Específicos</h2>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div v-for="(objetivo, index) in objetivos" :key="index"
            class="bg-antiflash-white rounded-2xl p-6 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 bg-turquoise/10 rounded-full flex items-center justify-center mb-4">
              <span class="text-turquoise text-xl font-bold">{{ index + 1 }}</span>
            </div>
            <h3 class="text-xl font-bold mb-3">{{ objetivo.titulo }}</h3>
            <p class="text-gray-600">{{ objetivo.descripcion }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Valores Institucionales -->
    <section class="section bg-antiflash-white">
      <div class="container">
        <h2 class="text-center mb-12">Valores Institucionales</h2>
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
          <div v-for="(valor, index) in valores" :key="index"
            class="text-center">
            <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mb-6 mx-auto shadow-sm">
              <component :is="valor.icono" class="w-10 h-10 text-turquoise" />
            </div>
            <h3 class="text-xl font-bold mb-2">{{ valor.nombre }}</h3>
            <p class="text-gray-600">{{ valor.descripcion }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Aliados Estratégicos -->
    <section class="section bg-white">
      <div class="container">
        <h2 class="text-center mb-12">Aliados Estratégicos</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 items-center justify-items-center">
          <div v-for="(aliado, index) in aliados" :key="index"
            class="w-40 h-40 bg-antiflash-white rounded-2xl p-4 flex items-center justify-center">
            <img :src="aliado.logo" :alt="aliado.nombre" class="max-w-full max-h-full object-contain" />
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Final -->
    <section class="bg-turquoise text-white py-20">
      <div class="container text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">
          ¿Listo para ser parte del cambio?
        </h2>
        <nuxt-link to="/unete"
          class="inline-block bg-white text-turquoise px-8 py-4 rounded-2xl font-bold hover:bg-gray-100 transition-colors">
          Únete a Munay Ruray
        </nuxt-link>
      </div>
    </section>
  </div>
</template>

<script setup>
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
    icono: 'IconoCompromiso'
  },
  {
    nombre: 'Empatía',
    descripcion: 'Capacidad de entender y compartir los sentimientos de otros.',
    icono: 'IconoEmpatia'
  },
  {
    nombre: 'Integridad',
    descripcion: 'Actuamos con honestidad y coherencia en todo momento.',
    icono: 'IconoIntegridad'
  },
  {
    nombre: 'Innovación',
    descripcion: 'Buscamos constantemente nuevas formas de generar impacto.',
    icono: 'IconoInnovacion'
  }
]

const aliados = [
  {
    nombre: 'Universidad Nacional Mayor de San Marcos',
    logo: 'https://placehold.co/200x200'
  },
  {
    nombre: 'Pontificia Universidad Católica del Perú',
    logo: 'https://placehold.co/200x200'
  },
  {
    nombre: 'Universidad Nacional de Ingeniería',
    logo: 'https://placehold.co/200x200'
  },
  {
    nombre: 'Universidad del Pacífico',
    logo: 'https://placehold.co/200x200'
  }
]

// Definir componentes de íconos (temporalmente usando placeholder)
const IconoCompromiso = defineComponent({
  template: `<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
  </svg>`
})

const IconoEmpatia = defineComponent({
  template: `<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M12 21.35L10.55 20.03C5.4 15.36 2 12.27 2 8.5C2 5.41 4.42 3 7.5 3C9.24 3 10.91 3.81 12 5.08C13.09 3.81 14.76 3 16.5 3C19.58 3 22 5.41 22 8.5C22 12.27 18.6 15.36 13.45 20.03L12 21.35Z" fill="currentColor"/>
  </svg>`
})

const IconoIntegridad = defineComponent({
  template: `<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M12 22S3 18 3 12V5L12 2L21 5V12C21 18 12 22 12 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
  </svg>`
})

const IconoInnovacion = defineComponent({
  template: `<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
  </svg>`
})
</script>
