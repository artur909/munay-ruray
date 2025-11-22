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

  // Usar fallback cuando la API no esté disponible
  const { 
    getExperienciaBySlug: getFallbackBySlug,
    getExperienciasRelacionadas: getFallbackRelacionadas,
    getAllExperiencias: getFallbackAll,
    getExperienciasByCategory: getFallbackByCategory
  } = useExperienciasFallback()

  // Función para verificar si la API está disponible
  const isAPIAvailable = async () => {
    try {
      const response = await $fetch(`${API_BASE}/experiencias.php?action=list&limit=1`)
      return response && response.success !== false
    } catch (error) {
      console.log('API no disponible, usando datos de fallback')
      return false
    }
  }

  // Obtener todas las experiencias
  const fetchExperiencias = async (options = {}) => {
    const { category = null, limit = 20, excludeFeatured = false } = options
    
    loading.value = true
    error.value = null
    
    try {
      const apiAvailable = await isAPIAvailable()
      
      if (!apiAvailable) {
        // Usar datos de fallback
        let data = getFallbackAll()
        
        if (category && category !== 'todas') {
          data = getFallbackByCategory(category)
        }
        
        if (excludeFeatured) {
          data = data.filter(exp => !exp.featured)
        }
        
        if (limit) {
          data = data.slice(0, limit)
        }
        
        experiencias.value = data
        return data
      }

      const params = new URLSearchParams()
      
      if (category && category !== 'todas') {
        params.append('category', category)
      }
      
      if (limit) {
        params.append('limit', limit)
      }
      
      if (excludeFeatured) {
        params.append('exclude_featured', 'true')
      }

      const url = `${API_BASE}/experiencias.php?action=list&${params.toString()}`
      const response = await $fetch(url)
      
      if (response.success) {
        experiencias.value = response.data.experiencias || response.data
        return response.data.experiencias || response.data
      } else {
        throw new Error(response.error || 'Error al obtener experiencias')
      }
    } catch (err) {
      error.value = err.message
      console.error('Error fetching experiencias:', err)
      
      // Fallback en caso de error
      let data = getFallbackAll()
      if (category && category !== 'todas') data = getFallbackByCategory(category)
      if (excludeFeatured) data = data.filter(exp => !exp.featured)
      if (limit) data = data.slice(0, limit)
      
      experiencias.value = data
      return data
    } finally {
      loading.value = false
    }
  }

  // Obtener experiencia por slug
  const fetchExperienciaBySlug = async (slug) => {
    loading.value = true
    error.value = null
    
    try {
      const apiAvailable = await isAPIAvailable()
      
      if (!apiAvailable) {
        // Usar datos de fallback
        const data = getFallbackBySlug(slug)
        return data
      }

      const url = `${API_BASE}/experiencias.php?action=get&slug=${encodeURIComponent(slug)}`
      const response = await $fetch(url)
      
      if (response.success) {
        return response.data
      } else {
        // Fallback si no se encuentra en la API
        return getFallbackBySlug(slug)
      }
    } catch (err) {
      error.value = err.message
      console.error('Error fetching experiencia:', err)
      
      // Fallback en caso de error
      return getFallbackBySlug(slug)
    } finally {
      loading.value = false
    }
  }

  // Obtener experiencia destacada
  const fetchExperienciaDestacada = async () => {
    loading.value = true
    error.value = null
    
    try {
      const apiAvailable = await isAPIAvailable()
      
      if (!apiAvailable) {
        // Usar datos de fallback
        const data = getFallbackAll().find(exp => exp.featured)
        experienciaDestacada.value = data || null
        return data || null
      }

      const url = `${API_BASE}/experiencias.php?action=featured`
      const response = await $fetch(url)
      
      if (response.success) {
        experienciaDestacada.value = response.data
        return response.data
      } else {
        // Fallback si no se encuentra en la API
        const data = getFallbackAll().find(exp => exp.featured)
        experienciaDestacada.value = data || null
        return data || null
      }
    } catch (err) {
      error.value = err.message
      console.error('Error fetching featured experiencia:', err)
      
      // Fallback en caso de error
      const data = getFallbackAll().find(exp => exp.featured)
      experienciaDestacada.value = data || null
      return data || null
    } finally {
      loading.value = false
    }
  }

  // Obtener categorías
  const fetchCategorias = async () => {
    try {
      const apiAvailable = await isAPIAvailable()
      
      if (!apiAvailable) {
        // Usar categorías de fallback
        const allExperiencias = getFallbackAll()
        const uniqueCategories = [...new Set(allExperiencias.map(exp => exp.category))]
        categorias.value = uniqueCategories
        return uniqueCategories.map(cat => ({ category: cat }))
      }

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
      
      // Fallback en caso de error
      const allExperiencias = getFallbackAll()
      const uniqueCategories = [...new Set(allExperiencias.map(exp => exp.category))]
      categorias.value = uniqueCategories
      return uniqueCategories.map(cat => ({ category: cat }))
    }
  }

  // Obtener experiencias relacionadas (excluyendo la actual)
  const fetchExperienciasRelacionadas = async (currentSlug, limit = 3) => {
    try {
      const apiAvailable = await isAPIAvailable()
      
      if (!apiAvailable) {
        return getFallbackRelacionadas(currentSlug, limit)
      }

      const response = await $fetch(`${API_BASE}/experiencias.php?action=related&slug=${encodeURIComponent(currentSlug)}&limit=${limit}`)
      
      if (response.success && response.data) {
        return response.data
      } else {
        return getFallbackRelacionadas(currentSlug, limit)
      }
    } catch (err) {
      console.error('Error fetching related experiencias:', err)
      return getFallbackRelacionadas(currentSlug, limit)
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