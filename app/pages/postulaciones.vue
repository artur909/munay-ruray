<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header del Panel -->
    <header class="bg-white shadow-sm border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-6">
          <div>
            <h1 class="text-3xl font-bold text-gray-900">Gestión de Postulaciones</h1>
            <p class="text-gray-600">Administra las solicitudes de voluntarios</p>
          </div>
          <div class="flex items-center space-x-4">
            <nuxt-link to="/alimentador" class="text-gray-500 hover:text-gray-700 flex items-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
              </svg>
              Experiencias
            </nuxt-link>
            <nuxt-link to="/" class="text-gray-500 hover:text-gray-700">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
              </svg>
            </nuxt-link>
          </div>
        </div>
      </div>
    </header>

    <!-- Contenido Principal -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Estadísticas -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6">
          <div class="flex items-center">
            <div class="p-2 bg-blue-100 rounded-lg">
              <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Total Postulaciones</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.total || 0 }}</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
          <div class="flex items-center">
            <div class="p-2 bg-yellow-100 rounded-lg">
              <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Pendientes</p>
              <p class="text-2xl font-bold text-gray-900">{{ getStatusCount('pending') }}</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
          <div class="flex items-center">
            <div class="p-2 bg-green-100 rounded-lg">
              <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Aceptadas</p>
              <p class="text-2xl font-bold text-gray-900">{{ getStatusCount('accepted') }}</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
          <div class="flex items-center">
            <div class="p-2 bg-purple-100 rounded-lg">
              <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Revisadas</p>
              <p class="text-2xl font-bold text-gray-900">{{ getStatusCount('reviewed') }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Filtros y Búsqueda -->
      <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
        <div class="flex flex-col lg:flex-row gap-4">
          <div class="flex-1">
            <input
              v-model="searchTerm"
              type="text"
              placeholder="Buscar por nombre, email o universidad..."
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"
            />
          </div>
          <select
            v-model="filterStatus"
            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"
          >
            <option value="">Todos los estados</option>
            <option value="pending">Pendiente</option>
            <option value="reviewed">Revisada</option>
            <option value="accepted">Aceptada</option>
            <option value="rejected">Rechazada</option>
          </select>
          <select
            v-model="filterUniversidad"
            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"
          >
            <option value="">Todas las universidades</option>
            <option v-for="uni in universidades" :key="uni" :value="uni">{{ uni }}</option>
          </select>
          <div class="flex items-center space-x-2">
            <label class="text-sm text-gray-600">Por página:</label>
            <select
              v-model="itemsPerPage"
              @change="loadPostulaciones"
              class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"
            >
              <option value="10">10</option>
              <option value="25">25</option>
              <option value="50">50</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Lista de Postulaciones -->
      <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
          <h2 class="text-lg font-semibold text-gray-900">
            Postulaciones ({{ pagination.total || 0 }})
          </h2>
        </div>

        <div v-if="loading" class="p-8 text-center">
          <div class="inline-flex items-center">
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Cargando postulaciones...
          </div>
        </div>

        <div v-else-if="postulaciones.length === 0" class="p-8 text-center text-gray-500">
          <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
          </svg>
          <p>No se encontraron postulaciones</p>
        </div>

        <div v-else class="divide-y divide-gray-200">
          <div
            v-for="postulacion in postulaciones"
            :key="postulacion.id"
            class="p-6 hover:bg-gray-50 transition-colors"
          >
            <div class="flex items-start justify-between">
              <div class="flex-1">
                <div class="flex items-center space-x-3 mb-2">
                  <h3 class="text-lg font-semibold text-gray-900">{{ postulacion.nombres }}</h3>
                  <span
                    :class="getStatusBadgeClass(postulacion.status)"
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                  >
                    {{ getStatusLabel(postulacion.status) }}
                  </span>
                </div>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4 mb-3">
                  <div class="flex items-center text-sm text-gray-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    {{ postulacion.email }}
                  </div>
                  <div class="flex items-center text-sm text-gray-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    {{ postulacion.telefono }}
                  </div>
                  <div class="flex items-center text-sm text-gray-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    {{ postulacion.universidad }}
                  </div>
                  <div class="flex items-center text-sm text-gray-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    {{ postulacion.carrera }} - {{ getAnioLabel(postulacion.anio_estudio) }}
                  </div>
                  <div class="flex items-center text-sm text-gray-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ getDisponibilidadLabel(postulacion.disponibilidad) }}
                  </div>
                  <div class="flex items-center text-sm text-gray-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    {{ formatDate(postulacion.created_at) }}
                  </div>
                </div>

                <div v-if="postulacion.experiencia_previa" class="mb-3">
                  <p class="text-sm text-gray-600 line-clamp-2">
                    <strong>Experiencia:</strong> {{ postulacion.experiencia_previa }}
                  </p>
                </div>

                <div v-if="postulacion.notas_admin" class="mb-3 p-3 bg-yellow-50 rounded-lg">
                  <p class="text-sm text-gray-700">
                    <strong>Notas del admin:</strong> {{ postulacion.notas_admin }}
                  </p>
                </div>
              </div>

              <div class="flex items-center space-x-2 ml-4">
                <button
                  @click="viewPostulacion(postulacion)"
                  class="p-2 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition-colors"
                  title="Ver detalles"
                >
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                  </svg>
                </button>

                <button
                  @click="downloadCV(postulacion)"
                  class="p-2 bg-green-100 text-green-600 rounded-lg hover:bg-green-200 transition-colors"
                  title="Descargar CV"
                >
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                  </svg>
                </button>

                <div class="relative">
                  <button
                    @click="toggleStatusMenu(postulacion.id)"
                    class="p-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition-colors"
                    title="Cambiar estado"
                  >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                    </svg>
                  </button>

                  <div
                    v-if="activeStatusMenu === postulacion.id"
                    class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-10"
                  >
                    <div class="py-1">
                      <button
                        v-for="status in statusOptions"
                        :key="status.value"
                        @click="updateStatus(postulacion, status.value)"
                        class="w-full text-left px-4 py-2 text-sm hover:bg-gray-50 flex items-center"
                        :class="{ 'bg-gray-50': postulacion.status === status.value }"
                      >
                        <span :class="status.color" class="w-2 h-2 rounded-full mr-3"></span>
                        {{ status.label }}
                      </button>
                    </div>
                  </div>
                </div>

                <button
                  @click="deletePostulacion(postulacion)"
                  class="p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors"
                  title="Eliminar"
                >
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Paginación -->
        <div v-if="pagination.pages > 1" class="px-6 py-4 border-t border-gray-200">
          <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
              Mostrando {{ ((pagination.page - 1) * itemsPerPage) + 1 }} a 
              {{ Math.min(pagination.page * itemsPerPage, pagination.total) }} 
              de {{ pagination.total }} resultados
            </div>
            <div class="flex items-center space-x-2">
              <button
                @click="changePage(pagination.page - 1)"
                :disabled="pagination.page <= 1"
                class="px-3 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
              >
                Anterior
              </button>
              
              <div class="flex space-x-1">
                <button
                  v-for="page in visiblePages"
                  :key="page"
                  @click="changePage(page)"
                  :class="[
                    'px-3 py-2 text-sm rounded-lg',
                    page === pagination.page
                      ? 'bg-primary text-white'
                      : 'border border-gray-300 hover:bg-gray-50'
                  ]"
                >
                  {{ page }}
                </button>
              </div>

              <button
                @click="changePage(pagination.page + 1)"
                :disabled="pagination.page >= pagination.pages"
                class="px-3 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
              >
                Siguiente
              </button>
            </div>
          </div>
        </div>
      </div>
    </main>

    <!-- Modal de Detalles de Postulación -->
    <Teleport to="body">
      <div
        v-if="showDetailModal"
        class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
        @click="closeDetailModal"
      >
        <div
          class="bg-white rounded-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto"
          @click.stop
        >
          <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 rounded-t-2xl">
            <div class="flex items-center justify-between">
              <h2 class="text-2xl font-bold text-gray-900">
                Detalles de Postulación
              </h2>
              <button
                @click="closeDetailModal"
                class="p-2 hover:bg-gray-100 rounded-lg transition-colors"
              >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
              </button>
            </div>
          </div>

          <div v-if="selectedPostulacion" class="p-6 space-y-6">
            <!-- Información Personal -->
            <div class="bg-gray-50 rounded-xl p-6">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Información Personal</h3>
              <div class="grid md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-600">Nombres Completos</label>
                  <p class="text-gray-900 font-medium">{{ selectedPostulacion.nombres }}</p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-600">Email</label>
                  <p class="text-gray-900">{{ selectedPostulacion.email }}</p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-600">Teléfono</label>
                  <p class="text-gray-900">{{ selectedPostulacion.telefono }}</p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-600">Edad</label>
                  <p class="text-gray-900">{{ selectedPostulacion.edad }}</p>
                </div>
              </div>
            </div>

            <!-- Información Académica -->
            <div class="bg-gray-50 rounded-xl p-6">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Información Académica</h3>
              <div class="grid md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-600">Universidad</label>
                  <p class="text-gray-900">
                    {{ selectedPostulacion.universidad === 'otros' ? selectedPostulacion.universidad_otros : selectedPostulacion.universidad }}
                  </p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-600">Carrera</label>
                  <p class="text-gray-900">
                    {{ selectedPostulacion.carrera === 'otro' ? selectedPostulacion.carrera_otro : selectedPostulacion.carrera }}
                  </p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-600">Año de Estudios</label>
                  <p class="text-gray-900">{{ getAnioLabel(selectedPostulacion.anio_estudio) }}</p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-600">Disponibilidad</label>
                  <p class="text-gray-900">{{ getDisponibilidadLabel(selectedPostulacion.disponibilidad) }}</p>
                </div>
              </div>
            </div>

            <!-- Experiencia Previa -->
            <div v-if="selectedPostulacion.experiencia_previa" class="bg-gray-50 rounded-xl p-6">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Experiencia Previa</h3>
              <p class="text-gray-700 leading-relaxed">{{ selectedPostulacion.experiencia_previa }}</p>
            </div>

            <!-- CV -->
            <div class="bg-gray-50 rounded-xl p-6">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Curriculum Vitae</h3>
              <div class="flex items-center justify-between p-4 bg-white rounded-lg border">
                <div class="flex items-center">
                  <svg class="w-8 h-8 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                  </svg>
                  <div>
                    <p class="font-medium text-gray-900">{{ selectedPostulacion.cv_original_name }}</p>
                    <p class="text-sm text-gray-500">Subido el {{ formatDate(selectedPostulacion.created_at) }}</p>
                  </div>
                </div>
                <button
                  @click="downloadCV(selectedPostulacion)"
                  class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors"
                >
                  Descargar
                </button>
              </div>
            </div>

            <!-- Notas del Administrador -->
            <div class="bg-gray-50 rounded-xl p-6">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Notas del Administrador</h3>
              <textarea
                v-model="adminNotes"
                rows="4"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none resize-none"
                placeholder="Agregar notas sobre esta postulación..."
              ></textarea>
              <div class="flex justify-end mt-3">
                <button
                  @click="saveAdminNotes"
                  :disabled="savingNotes"
                  class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors disabled:opacity-50"
                >
                  {{ savingNotes ? 'Guardando...' : 'Guardar Notas' }}
                </button>
              </div>
            </div>

            <!-- Estado y Acciones -->
            <div class="bg-gray-50 rounded-xl p-6">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Estado y Acciones</h3>
              <div class="flex items-center justify-between">
                <div>
                  <label class="block text-sm font-medium text-gray-600 mb-2">Estado Actual</label>
                  <span :class="getStatusBadgeClass(selectedPostulacion.status)" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium">
                    {{ getStatusLabel(selectedPostulacion.status) }}
                  </span>
                </div>
                <div class="flex space-x-3">
                  <select
                    v-model="newStatus"
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"
                  >
                    <option v-for="status in statusOptions" :key="status.value" :value="status.value">
                      {{ status.label }}
                    </option>
                  </select>
                  <button
                    @click="updateStatusFromModal"
                    :disabled="updatingStatus || newStatus === selectedPostulacion.status"
                    class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors disabled:opacity-50"
                  >
                    {{ updatingStatus ? 'Actualizando...' : 'Actualizar Estado' }}
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </Teleport>

    <!-- Modal de Confirmación de Eliminación -->
    <Teleport to="body">
      <div
        v-if="showDeleteModal"
        class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
      >
        <div class="bg-white rounded-2xl max-w-md w-full p-6">
          <div class="flex items-center mb-4">
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
              <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"></path>
              </svg>
            </div>
            <div>
              <h3 class="text-lg font-semibold text-gray-900">Confirmar eliminación</h3>
              <p class="text-gray-600">Esta acción no se puede deshacer</p>
            </div>
          </div>
          
          <p class="text-gray-700 mb-6">
            ¿Estás seguro de que quieres eliminar la postulación de "<strong>{{ postulacionToDelete?.nombres }}</strong>"?
          </p>
          
          <div class="flex justify-end space-x-4">
            <button
              @click="showDeleteModal = false"
              class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors"
            >
              Cancelar
            </button>
            <button
              @click="confirmDelete"
              :disabled="deleting"
              class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors disabled:opacity-50"
            >
              {{ deleting ? 'Eliminando...' : 'Eliminar' }}
            </button>
          </div>
        </div>
      </div>
    </Teleport>
  </div>
</template>
<script setup>
// Configurar layout y SEO
definePageMeta({
  layout: 'admin'
})

useHead({
  title: 'Gestión de Postulaciones - Munay Ruray',
  meta: [
    {
      name: 'robots',
      content: 'noindex, nofollow'
    }
  ]
})

// Estado reactivo
const postulaciones = ref([])
const stats = ref({})
const loading = ref(true)
const deleting = ref(false)
const savingNotes = ref(false)
const updatingStatus = ref(false)

// Filtros y búsqueda
const searchTerm = ref('')
const filterStatus = ref('')
const filterUniversidad = ref('')
const itemsPerPage = ref(25)
const currentPage = ref(1)

// Paginación
const pagination = ref({
  page: 1,
  pages: 1,
  total: 0
})

// Modales
const showDetailModal = ref(false)
const showDeleteModal = ref(false)
const selectedPostulacion = ref(null)
const postulacionToDelete = ref(null)

// Estados auxiliares
const activeStatusMenu = ref(null)
const adminNotes = ref('')
const newStatus = ref('')

// Opciones de estado
const statusOptions = [
  { value: 'pending', label: 'Pendiente', color: 'bg-yellow-500' },
  { value: 'reviewed', label: 'Revisada', color: 'bg-purple-500' },
  { value: 'accepted', label: 'Aceptada', color: 'bg-green-500' },
  { value: 'rejected', label: 'Rechazada', color: 'bg-red-500' }
]

// Computed
const universidades = computed(() => {
  const unis = [...new Set(postulaciones.value.map(p => p.universidad).filter(Boolean))]
  return unis.sort()
})

const visiblePages = computed(() => {
  const current = pagination.value.page
  const total = pagination.value.pages
  const delta = 2
  
  let start = Math.max(1, current - delta)
  let end = Math.min(total, current + delta)
  
  if (end - start < 4) {
    if (start === 1) {
      end = Math.min(total, start + 4)
    } else if (end === total) {
      start = Math.max(1, end - 4)
    }
  }
  
  const pages = []
  for (let i = start; i <= end; i++) {
    pages.push(i)
  }
  
  return pages
})

// Watchers para filtros
watch([searchTerm, filterStatus, filterUniversidad], () => {
  currentPage.value = 1
  loadPostulaciones()
}, { debounce: 300 })

// Métodos principales
const loadPostulaciones = async () => {
  try {
    loading.value = true
    
    const params = new URLSearchParams({
      page: currentPage.value.toString(),
      limit: itemsPerPage.value.toString()
    })
    
    if (searchTerm.value) params.append('search', searchTerm.value)
    if (filterStatus.value) params.append('status', filterStatus.value)
    
    const response = await $fetch(`/api/postulaciones.php?action=list&${params.toString()}`)
    
    if (response.success) {
      postulaciones.value = response.data
      pagination.value = response.pagination
    } else {
      throw new Error(response.error || 'Error al cargar postulaciones')
    }
  } catch (error) {
    console.error('Error cargando postulaciones:', error)
    // Aquí podrías mostrar una notificación de error
  } finally {
    loading.value = false
  }
}

const loadStats = async () => {
  try {
    const response = await $fetch('/api/postulaciones.php?action=stats')
    if (response.success) {
      stats.value = response.data
    }
  } catch (error) {
    console.error('Error cargando estadísticas:', error)
  }
}

// Funciones de utilidad
const getStatusCount = (status) => {
  if (!stats.value.by_status) return 0
  const statusData = stats.value.by_status.find(s => s.status === status)
  return statusData ? statusData.count : 0
}

const getStatusLabel = (status) => {
  const option = statusOptions.find(opt => opt.value === status)
  return option ? option.label : status
}

const getStatusBadgeClass = (status) => {
  const classes = {
    pending: 'bg-yellow-100 text-yellow-800',
    reviewed: 'bg-purple-100 text-purple-800',
    accepted: 'bg-green-100 text-green-800',
    rejected: 'bg-red-100 text-red-800'
  }
  return classes[status] || 'bg-gray-100 text-gray-800'
}

const getAnioLabel = (anio) => {
  const labels = {
    primero: 'Primer año',
    segundo: 'Segundo año',
    tercero: 'Tercer año',
    cuarto: 'Cuarto año',
    quinto: 'Quinto año',
    egresado: 'Egresado'
  }
  return labels[anio] || anio
}

const getDisponibilidadLabel = (disponibilidad) => {
  const labels = {
    'todo-dia': 'Todo el día',
    'manana': 'Solo mañanas',
    'tarde': 'Solo tardes'
  }
  return labels[disponibilidad] || disponibilidad
}

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('es-ES', {
    day: 'numeric',
    month: 'short',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

// Acciones de postulaciones
const viewPostulacion = (postulacion) => {
  selectedPostulacion.value = postulacion
  adminNotes.value = postulacion.notas_admin || ''
  newStatus.value = postulacion.status
  showDetailModal.value = true
}

const closeDetailModal = () => {
  showDetailModal.value = false
  selectedPostulacion.value = null
  adminNotes.value = ''
  newStatus.value = ''
}

const downloadCV = (postulacion) => {
  // Crear enlace de descarga
  const link = document.createElement('a')
  link.href = `../assets/postulaciones/cv/${postulacion.cv_filename}`
  link.download = postulacion.cv_original_name
  link.target = '_blank'
  document.body.appendChild(link)
  link.click()
  document.body.removeChild(link)
}

// Gestión de estados
const toggleStatusMenu = (postulacionId) => {
  activeStatusMenu.value = activeStatusMenu.value === postulacionId ? null : postulacionId
}

const updateStatus = async (postulacion, newStatus) => {
  try {
    activeStatusMenu.value = null
    
    //const formData = new FormData()
    //formData.append('status', newStatus)
    
    const response = await $fetch(`/api/postulaciones.php?action=update-status&id=${postulacion.id}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        status: newStatus
      })
    })
    
    if (response.success) {
      // Actualizar el estado local
      postulacion.status = newStatus
      
      // Recargar estadísticas
      await loadStats()
      
      console.log('Estado actualizado exitosamente')
    } else {
      throw new Error(response.error || 'Error al actualizar estado')
    }
  } catch (error) {
    console.error('Error actualizando estado:', error)
  }
}

const updateStatusFromModal = async () => {
  if (!selectedPostulacion.value || newStatus.value === selectedPostulacion.value.status) return
  
  try {
    updatingStatus.value = true
    
    //const formData = new FormData()
    //formData.append('status', newStatus.value)

    const response = await $fetch(`/api/postulaciones.php?action=update-status&id=${selectedPostulacion.value.id}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        status: newStatus.value
      })
    })

    if (response.success) {
      // Actualizar el estado local
      selectedPostulacion.value.status = newStatus.value
      
      // Actualizar en la lista
      const index = postulaciones.value.findIndex(p => p.id === selectedPostulacion.value.id)
      if (index !== -1) {
        postulaciones.value[index].status = newStatus.value
      }
      
      // Recargar estadísticas
      await loadStats()
      
      console.log('Estado actualizado exitosamente')
    } else {
      throw new Error(response.error || 'Error al actualizar estado')
    }
  } catch (error) {
    console.error('Error actualizando estado:', error)
  } finally {
    updatingStatus.value = false
  }
}

// Gestión de notas
const saveAdminNotes = async () => {
  if (!selectedPostulacion.value) return
  
  try {
    savingNotes.value = true
    
    const formData = new FormData()
    formData.append('notas', adminNotes.value)
    
    const response = await $fetch(`/api/postulaciones.php?action=add-notes&id=${selectedPostulacion.value.id}`, {
      method: 'PUT',
      body: formData
    })
    
    if (response.success) {
      // Actualizar las notas localmente
      selectedPostulacion.value.notas_admin = adminNotes.value
      
      // Actualizar en la lista
      const index = postulaciones.value.findIndex(p => p.id === selectedPostulacion.value.id)
      if (index !== -1) {
        postulaciones.value[index].notas_admin = adminNotes.value
      }
      
      console.log('Notas guardadas exitosamente')
    } else {
      throw new Error(response.error || 'Error al guardar notas')
    }
  } catch (error) {
    console.error('Error guardando notas:', error)
  } finally {
    savingNotes.value = false
  }
}

// Eliminación
const deletePostulacion = (postulacion) => {
  postulacionToDelete.value = postulacion
  showDeleteModal.value = true
}

const confirmDelete = async () => {
  if (!postulacionToDelete.value) return
  
  try {
    deleting.value = true
    
    const response = await $fetch(`/api/postulaciones.php?action=delete&id=${postulacionToDelete.value.id}`, {
      method: 'DELETE'
    })
    
    if (response.success) {
      // Remover de la lista local
      const index = postulaciones.value.findIndex(p => p.id === postulacionToDelete.value.id)
      if (index !== -1) {
        postulaciones.value.splice(index, 1)
      }
      
      // Recargar estadísticas
      await loadStats()
      
      showDeleteModal.value = false
      postulacionToDelete.value = null
      
      console.log('Postulación eliminada exitosamente')
    } else {
      throw new Error(response.error || 'Error al eliminar postulación')
    }
  } catch (error) {
    console.error('Error eliminando postulación:', error)
  } finally {
    deleting.value = false
  }
}

// Paginación
const changePage = (page) => {
  if (page >= 1 && page <= pagination.value.pages) {
    currentPage.value = page
    loadPostulaciones()
  }
}

// Cerrar menús al hacer clic fuera
const handleClickOutside = (event) => {
  if (!event.target.closest('.relative')) {
    activeStatusMenu.value = null
  }
}

// Lifecycle
onMounted(async () => {
  await Promise.all([
    loadPostulaciones(),
    loadStats()
  ])
  
  // Agregar listener para cerrar menús
  document.addEventListener('click', handleClickOutside)
})

onBeforeUnmount(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>

<style scoped>
/* Utilidades adicionales */
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* Transiciones suaves */
.transition-colors {
  transition-property: color, background-color, border-color;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  transition-duration: 150ms;
}

/* Estados de focus mejorados */
input:focus,
textarea:focus,
select:focus {
  outline: none;
  border-color: #02b2a2;
  box-shadow: 0 0 0 3px rgba(2, 178, 162, 0.1);
}

/* Animaciones de carga */
@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

.animate-spin {
  animation: spin 1s linear infinite;
}

/* Mejoras de accesibilidad */
@media (prefers-reduced-motion: reduce) {
  .transition-colors,
  .animate-spin {
    animation: none;
    transition: none;
  }
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .max-w-4xl {
    max-width: calc(100vw - 2rem);
  }
  
  .grid-cols-3 {
    grid-template-columns: repeat(1, minmax(0, 1fr));
  }
}

/* Dropdown menu z-index fix */
.relative {
  position: relative;
}

/* Hover effects para botones */
button:hover:not(:disabled) {
  transform: translateY(-1px);
}

button:active:not(:disabled) {
  transform: translateY(0);
}
</style>