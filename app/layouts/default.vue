<template>
  <div class="min-h-screen bg-antiflash-white">
    <nav class="fixed w-full top-0 z-50 bg-white/80 backdrop-blur-sm">
      <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <nuxt-link to="/" class="text-2xl font-bold text-rich-black">
          Munay Ruray
        </nuxt-link>
        <div class="hidden md:flex space-x-8">
          <nuxt-link v-for="item in menuItems" :key="item.path"
            :to="item.path"
            class="text-rich-black hover:text-turquoise transition-colors">
            {{ item.name }}
          </nuxt-link>
        </div>
        <button class="md:hidden" @click="toggleMenu">
          <span class="sr-only">Menú</span>
          <!-- Icono de hamburguesa -->
          <div class="w-6 h-6 flex flex-col justify-around">
            <span class="w-full h-0.5 bg-rich-black"></span>
            <span class="w-full h-0.5 bg-rich-black"></span>
            <span class="w-full h-0.5 bg-rich-black"></span>
          </div>
        </button>
      </div>
      <!-- Menú móvil -->
      <div v-show="isMenuOpen" class="md:hidden">
        <div class="px-4 py-2 bg-white">
          <nuxt-link v-for="item in menuItems" :key="item.path"
            :to="item.path"
            class="block py-2 text-rich-black hover:text-turquoise transition-colors">
            {{ item.name }}
          </nuxt-link>
        </div>
      </div>
    </nav>

    <main class="pt-20">
      <slot />
    </main>

    <!-- Botón flotante CTA para móviles -->
    <nuxt-link to="/unete" 
      class="floating-cta bg-turquoise text-white px-6 py-3 rounded-full font-bold shadow-lg hover:shadow-xl transition-all duration-300 flex items-center space-x-2">
      <span>Postula</span>
      <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
      </svg>
    </nuxt-link>

    <footer class="bg-rich-black text-white py-12">
      <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
          <div>
            <h3 class="text-xl font-bold mb-4">Munay Ruray</h3>
            <p class="text-gray-400">Transformando vidas a través del voluntariado universitario</p>
          </div>
          <div>
            <h4 class="font-bold mb-4">Enlaces Rápidos</h4>
            <ul class="space-y-2">
              <li v-for="item in menuItems" :key="item.path">
                <nuxt-link :to="item.path" class="text-gray-400 hover:text-turquoise transition-colors">
                  {{ item.name }}
                </nuxt-link>
              </li>
            </ul>
          </div>
          <div>
            <h4 class="font-bold mb-4">Contacto</h4>
            <ul class="space-y-2 text-gray-400">
              <li>contacto@munayruray.pe</li>
              <li>+51 999 999 999</li>
            </ul>
          </div>
          <div>
            <h4 class="font-bold mb-4">Síguenos</h4>
            <div class="flex space-x-4">
              <a href="#" class="text-gray-400 hover:text-turquoise transition-colors">
                <span class="sr-only">Facebook</span>
                <!-- Icono de Facebook -->
              </a>
              <!-- Añadir más iconos de redes sociales -->
            </div>
          </div>
        </div>
        <div class="mt-8 pt-8 border-t border-gray-800 text-center text-gray-400">
          <p>&copy; {{ new Date().getFullYear() }} Munay Ruray. Todos los derechos reservados.</p>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
const isMenuOpen = ref(false)
const menuItems = [
  { name: 'Inicio', path: '/' },
  { name: 'Sobre Nosotros', path: '/sobre-nosotros' },
  { name: 'Líneas de Acción', path: '/lineas-de-accion' },
  { name: 'Experiencias', path: '/experiencias' },
  { name: 'Únete', path: '/unete' },
  { name: 'FAQ', path: '/faq' },
]

const toggleMenu = () => {
  isMenuOpen.value = !isMenuOpen.value
}
</script>
