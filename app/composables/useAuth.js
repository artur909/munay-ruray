import { ref, computed } from 'vue'

// Estado global de autenticación
const user = ref(null)
const isLoading = ref(false)
const error = ref(null)

// URL base de la API
const API_BASE = '/api'

export const useAuth = () => {
  // Computed properties
  const isAuthenticated = computed(() => !!user.value)
  const isAdmin = computed(() => user.value?.role === 'admin')
  const userName = computed(() => user.value?.nombre_completo || user.value?.username)

  // Función para hacer peticiones a la API
  const apiRequest = async (endpoint, options = {}) => {
    const url = `${API_BASE}${endpoint}`
    
    const defaultOptions = {
      headers: {
        'Content-Type': 'application/json',
      },
      credentials: 'include', // Para incluir cookies de sesión
    }

    const config = { ...defaultOptions, ...options }

    try {
      const response = await fetch(url, config)
      const data = await response.json()

      if (!response.ok) {
        throw new Error(data.message || `HTTP error! status: ${response.status}`)
      }

      return data
    } catch (err) {
      console.error('API Request Error:', err)
      throw err
    }
  }

  // Función de login
  const login = async (credentials) => {
    isLoading.value = true
    error.value = null

    try {
      const response = await apiRequest('/auth.php?action=login', {
        method: 'POST',
        body: JSON.stringify(credentials)
      })

      if (response.success) {
        user.value = response.data
        error.value = null
        return { success: true, user: response.data }
      } else {
        error.value = response.message
        return { success: false, error: response.message }
      }
    } catch (err) {
      error.value = err.message || 'Error de conexión'
      return { success: false, error: error.value }
    } finally {
      isLoading.value = false
    }
  }

  // Función de logout
  const logout = async () => {
    isLoading.value = true
    error.value = null

    try {
      await apiRequest('/auth.php?action=logout', {
        method: 'POST'
      })

      user.value = null
      error.value = null
      
      // Redirigir a la página de login
      if (typeof window !== 'undefined') {
        window.location.href = '/gestor'
      }
      
      return { success: true }
    } catch (err) {
      error.value = err.message || 'Error al cerrar sesión'
      return { success: false, error: error.value }
    } finally {
      isLoading.value = false
    }
  }

  // Verificar sesión actual
  const checkSession = async () => {
    isLoading.value = true
    error.value = null

    try {
      const response = await apiRequest('/auth.php?action=check')

      if (response.success) {
        user.value = response.data
        return { success: true, user: response.data }
      } else {
        user.value = null
        return { success: false, error: response.message }
      }
    } catch (err) {
      user.value = null
      error.value = err.message || 'Error verificando sesión'
      return { success: false, error: error.value }
    } finally {
      isLoading.value = false
    }
  }

  // Obtener perfil del usuario
  const getProfile = async () => {
    isLoading.value = true
    error.value = null

    try {
      const response = await apiRequest('/auth.php?action=profile')

      if (response.success) {
        user.value = { ...user.value, ...response.data }
        return { success: true, user: response.data }
      } else {
        error.value = response.message
        return { success: false, error: response.message }
      }
    } catch (err) {
      error.value = err.message || 'Error obteniendo perfil'
      return { success: false, error: error.value }
    } finally {
      isLoading.value = false
    }
  }

  // Inicializar autenticación (verificar sesión existente)
  const initialize = async () => {
    if (typeof window === 'undefined') return

    try {
      await checkSession()
    } catch (err) {
      console.warn('No se pudo verificar la sesión:', err)
    }
  }

  // Limpiar errores
  const clearError = () => {
    error.value = null
  }

  // Función helper para hacer peticiones autenticadas
  const authenticatedRequest = async (endpoint, options = {}) => {
    if (!isAuthenticated.value) {
      throw new Error('Usuario no autenticado')
    }

    try {
      return await apiRequest(endpoint, options)
    } catch (err) {
      // Si el error es de autenticación, limpiar el usuario
      if (err.message.includes('401') || err.message.includes('no autorizado')) {
        user.value = null
      }
      throw err
    }
  }

  // Función para validar permisos
  const hasPermission = (requiredRole = null) => {
    if (!isAuthenticated.value) return false
    if (!requiredRole) return true
    if (user.value.role === 'admin') return true
    return user.value.role === requiredRole
  }

  // Middleware para rutas protegidas
  const requireAuth = () => {
    if (!isAuthenticated.value) {
      if (typeof window !== 'undefined') {
        window.location.href = '/gestor'
      }
      return false
    }
    return true
  }

  return {
    // Estado
    user: readonly(user),
    isLoading: readonly(isLoading),
    error: readonly(error),
    
    // Computed
    isAuthenticated,
    isAdmin,
    userName,
    
    // Métodos
    login,
    logout,
    checkSession,
    getProfile,
    initialize,
    clearError,
    authenticatedRequest,
    hasPermission,
    requireAuth,
    
    // Utilidades
    apiRequest
  }
}

// Función para inicializar automáticamente
export const initAuth = async () => {
  const { initialize } = useAuth()
  await initialize()
}