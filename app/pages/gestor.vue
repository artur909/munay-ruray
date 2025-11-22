<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Pantalla de Login -->
    <div v-if="!isAuthenticated" class="min-h-screen">
      <LoginForm @login-success="handleLoginSuccess" />
    </div>

    <!-- Panel Administrativo -->
    <div v-else class="min-h-screen">
      <!-- Header Global -->
      <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex justify-between items-center py-4">
            <div class="flex items-center space-x-8">
              <div>
                <h1 class="text-2xl font-bold text-gray-900">Munay Ruray</h1>
                <p class="text-sm text-gray-600">Panel de Administración</p>
              </div>
              
              <!-- Navegación de Pestañas -->
              <nav class="flex space-x-1">
                <button
                  @click="activeTab = 'experiencias'"
                  :class="[
                    'px-4 py-2 rounded-lg text-sm font-medium transition-colors',
                    activeTab === 'experiencias'
                      ? 'bg-blue-600 text-white'
                      : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100'
                  ]"
                >
                  <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                    </path>
                  </svg>
                  Experiencias
                </button>
                
                <button
                  @click="activeTab = 'postulaciones'"
                  :class="[
                    'px-4 py-2 rounded-lg text-sm font-medium transition-colors',
                    activeTab === 'postulaciones'
                      ? 'bg-blue-600 text-white'
                      : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100'
                  ]"
                >
                  <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                  </svg>
                  Postulaciones
                </button>
              </nav>
            </div>

            <!-- Usuario y Acciones -->
            <div class="flex items-center space-x-4">
              <!-- Información del Usuario -->
              <div class="flex items-center space-x-3">
                <div class="text-right">
                  <p class="text-sm font-medium text-gray-900">{{ userName }}</p>
                  <p class="text-xs text-gray-500 capitalize">{{ user?.role }}</p>
                </div>
                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                  <span class="text-white text-sm font-medium">
                    {{ getUserInitials(userName) }}
                  </span>
                </div>
              </div>

              <!-- Botón Ver Sitio -->
              <nuxt-link 
                to="/" 
                class="text-gray-500 hover:text-gray-700 flex items-center px-3 py-2 rounded-lg hover:bg-gray-100 transition-colors"
                title="Ver sitio web"
              >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                  </path>
                </svg>
                Ver Sitio
              </nuxt-link>

              <!-- Botón Cerrar Sesión -->
              <button
                @click="handleLogout"
                :disabled="isLoading"
                class="text-red-600 hover:text-red-700 flex items-center px-3 py-2 rounded-lg hover:bg-red-50 transition-colors disabled:opacity-50"
                title="Cerrar sesión"
              >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                  </path>
                </svg>
                Salir
              </button>
            </div>
          </div>
        </div>
      </header>

      <!-- Contenido de los Paneles -->
      <div class="relative">
        <!-- Loading Overlay -->
        <div v-if="isLoading" class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center z-40">
          <div class="flex items-center space-x-3">
            <svg class="animate-spin h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24">
              <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25"></circle>
              <path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" class="opacity-75"></path>
            </svg>
            <span class="text-gray-600">Cargando...</span>
          </div>
        </div>

        <!-- Panel de Experiencias -->
        <div v-show="activeTab === 'experiencias'" class="transition-opacity duration-200">
          <AlimentadorPanel />
        </div>

        <!-- Panel de Postulaciones -->
        <div v-show="activeTab === 'postulaciones'" class="transition-opacity duration-200">
          <PostulacionesPanel />
        </div>
      </div>
    </div>

    <!-- Notificaciones Toast -->
    <div v-if="notification" class="fixed top-4 right-4 z-50">
      <div 
        :class="[
          'max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden',
          notification.type === 'success' ? 'border-l-4 border-green-400' : 'border-l-4 border-red-400'
        ]"
      >
        <div class="p-4">
          <div class="flex items-start">
            <div class="flex-shrink-0">
              <svg v-if="notification.type === 'success'" class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <svg v-else class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
              </svg>
            </div>
            <div class="ml-3 w-0 flex-1 pt-0.5">
              <p class="text-sm font-medium text-gray-900">{{ notification.title }}</p>
              <p v-if="notification.message" class="mt-1 text-sm text-gray-500">{{ notification.message }}</p>
            </div>
            <div class="ml-4 flex-shrink-0 flex">
              <button @click="clearNotification" class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500">
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import { useAuth } from '~/composables/useAuth'
import LoginForm from '~/components/LoginForm.vue'
import AlimentadorPanel from '~/components/AlimentadorPanel.vue'
import PostulacionesPanel from '~/components/PostulacionesPanel.vue'

// Meta de la página
definePageMeta({
  layout: false // Usamos nuestro propio layout
})

// Composables
const { 
  user, 
  isAuthenticated, 
  isLoading, 
  userName, 
  logout, 
  initialize,
  clearError 
} = useAuth()

// Estado del componente
const activeTab = ref('experiencias')
const notification = ref(null)

// Computed
const isLoggedIn = computed(() => isAuthenticated.value && user.value)

// Métodos
const handleLoginSuccess = (userData) => {
  showNotification('success', 'Bienvenido', `Hola ${userData.nombre_completo || userData.username}`)
}

const handleLogout = async () => {
  try {
    const result = await logout()
    if (result.success) {
      showNotification('success', 'Sesión cerrada', 'Has cerrado sesión correctamente')
    }
  } catch (error) {
    showNotification('error', 'Error', 'No se pudo cerrar la sesión')
  }
}

const getUserInitials = (name) => {
  if (!name) return 'U'
  return name
    .split(' ')
    .map(word => word.charAt(0))
    .join('')
    .toUpperCase()
    .substring(0, 2)
}

const showNotification = (type, title, message = '') => {
  notification.value = { type, title, message }
  
  // Auto-ocultar después de 5 segundos
  setTimeout(() => {
    clearNotification()
  }, 5000)
}

const clearNotification = () => {
  notification.value = null
}

// Watchers
watch(activeTab, (newTab) => {
  // Limpiar errores al cambiar de pestaña
  clearError()
})

// Lifecycle
onMounted(async () => {
  // Inicializar autenticación
  await initialize()
  
  // Si hay parámetros de URL para la pestaña activa
  const urlParams = new URLSearchParams(window.location.search)
  const tab = urlParams.get('tab')
  if (tab && ['experiencias', 'postulaciones'].includes(tab)) {
    activeTab.value = tab
  }
})

// Actualizar URL cuando cambie la pestaña activa
watch(activeTab, (newTab) => {
  if (typeof window !== 'undefined') {
    const url = new URL(window.location)
    url.searchParams.set('tab', newTab)
    window.history.replaceState({}, '', url)
  }
})

// Manejo de teclas de acceso rápido
onMounted(() => {
  const handleKeydown = (event) => {
    if (!isAuthenticated.value) return
    
    // Alt + 1 = Experiencias
    if (event.altKey && event.key === '1') {
      event.preventDefault()
      activeTab.value = 'experiencias'
    }
    
    // Alt + 2 = Postulaciones
    if (event.altKey && event.key === '2') {
      event.preventDefault()
      activeTab.value = 'postulaciones'
    }
    
    // Ctrl/Cmd + Shift + L = Logout
    if ((event.ctrlKey || event.metaKey) && event.shiftKey && event.key === 'L') {
      event.preventDefault()
      handleLogout()
    }
  }
  
  window.addEventListener('keydown', handleKeydown)
  
  // Cleanup
  onUnmounted(() => {
    window.removeEventListener('keydown', handleKeydown)
  })
})
</script>

<style scoped>
@reference "~/assets/css/main.css";

/* Estilos personalizados para el gestor */
.btn-primary {
  @apply bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center;
}

/* Animaciones suaves */
.transition-opacity {
  transition: opacity 0.2s ease-in-out;
}

/* Responsive */
@media (max-width: 768px) {
  .max-w-7xl {
    @apply px-2;
  }
  
  .flex.space-x-8 {
    @apply flex-col space-x-0 space-y-4;
  }
  
  .flex.space-x-1 {
    @apply flex-wrap gap-2;
  }
  
  .px-4.py-2 {
    @apply px-3 py-1.5 text-xs;
  }
}

/* Mejoras de accesibilidad */
@media (prefers-reduced-motion: reduce) {
  .transition-opacity,
  .transition-colors {
    transition: none;
  }
  
  .animate-spin {
    animation: none;
  }
}

/* Focus states mejorados */
button:focus-visible,
a:focus-visible {
  @apply outline-2 outline-offset-2 outline-blue-600;
}
</style>