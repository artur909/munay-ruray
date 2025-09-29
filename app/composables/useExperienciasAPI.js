// Composable para manejar experiencias desde la API
export const useExperienciasAPI = () => {
  const config = useRuntimeConfig()
  
  // URL base de la API
  const API_BASE = '/api'

  // Estado reactivo
  const experiencias = ref([])
  const experienciaDestacada = ref(null)
  const categorias = ref([])
  const loading = ref(false)
  const error = ref(null)

  // Obtener todas las experiencias
  const fetchExperiencias = async (options = {}) => {
    loading.value = true
    error.value = null
    
    try {
      const params = new URLSearchParams()
      
      if (options.category && options.category !== 'todas') {
        params.append('category', options.category)
      }
      
      if (options.limit) {
        params.append('limit', options.limit)
      }
      
      if (options.excludeFeatured) {
        params.append('exclude_featured', 'true')
      }

      const url = `${API_BASE}/experiencias.php?action=list&${params.toString()}`
      const response = await $fetch(url)
      
      if (response.success) {
        experiencias.value = response.data
        return response.data
      } else {
        throw new Error(response.error || 'Error al obtener experiencias')
      }
    } catch (err) {
      error.value = err.message
      console.error('Error fetching experiencias:', err)
      return []
    } finally {
      loading.value = false
    }
  }

  // Obtener experiencia por slug
  const fetchExperienciaBySlug = async (slug) => {
    loading.value = true
    error.value = null
    
    try {
      const url = `${API_BASE}/experiencias.php?action=get&slug=${encodeURIComponent(slug)}`
      const response = await $fetch(url)
      
      if (response.success) {
        return response.data
      } else {
        throw new Error(response.error || 'Experiencia no encontrada')
      }
    } catch (err) {
      error.value = err.message
      console.error('Error fetching experiencia:', err)
      return null
    } finally {
      loading.value = false
    }
  }

  // Obtener experiencia destacada
  const fetchExperienciaDestacada = async () => {
    loading.value = true
    error.value = null
    
    try {
      const url = `${API_BASE}/experiencias.php?action=featured`
      const response = await $fetch(url)
      
      if (response.success) {
        experienciaDestacada.value = response.data
        return response.data
      } else {
        throw new Error(response.error || 'Error al obtener experiencia destacada')
      }
    } catch (err) {
      error.value = err.message
      console.error('Error fetching featured experiencia:', err)
      return null
    } finally {
      loading.value = false
    }
  }

  // Obtener categorías
  const fetchCategorias = async () => {
    try {
      const url = `${API_BASE}/experiencias.php?action=categories`
      const response = await $fetch(url)
      
      if (response.success) {
        categorias.value = response.data.map(cat => cat.category)
        return response.data
      } else {
        throw new Error(response.error || 'Error al obtener categorías')
      }
    } catch (err) {
      error.value = err.message
      console.error('Error fetching categories:', err)
      return []
    }
  }

  // Obtener experiencias relacionadas (excluyendo la actual)
  const fetchExperienciasRelacionadas = async (currentSlug, limit = 3) => {
    try {
      const allExperiencias = await fetchExperiencias({ limit: 10 })
      return allExperiencias
        .filter(exp => exp.slug !== currentSlug)
        .slice(0, limit)
    } catch (err) {
      console.error('Error fetching related experiencias:', err)
      return []
    }
  }

  // Funciones de utilidad
  const getExperienciasFiltradas = (filtro = 'todas', excludeFeatured = false) => {
    let filtered = experiencias.value

    if (excludeFeatured) {
      filtered = filtered.filter(exp => !exp.featured)
    }

    if (filtro === 'todas') {
      return filtered
    }

    return filtered.filter(exp => exp.category === filtro)
  }

  const getCategoriaLabel = (categoria) => {
    const labels = {
      'ambiental': 'Ambiental',
      'educacion': 'Educación',
      'salud': 'Salud',
      'cultura': 'Cultura',
      'social': 'Social'
    }
    return labels[categoria] || categoria
  }

  // Función para formatear fecha
  const formatDate = (dateString) => {
    if (!dateString) return ''
    
    try {
      const date = new Date(dateString)
      return date.toLocaleDateString('es-ES', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      })
    } catch {
      return dateString // Retornar la fecha original si no se puede parsear
    }
  }

  return {
    // Estado
    experiencias: readonly(experiencias),
    experienciaDestacada: readonly(experienciaDestacada),
    categorias: readonly(categorias),
    loading: readonly(loading),
    error: readonly(error),
    
    // Funciones
    fetchExperiencias,
    fetchExperienciaBySlug,
    fetchExperienciaDestacada,
    fetchCategorias,
    fetchExperienciasRelacionadas,
    getExperienciasFiltradas,
    getCategoriaLabel,
    formatDate
  }
}