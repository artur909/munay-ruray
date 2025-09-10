<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header del Panel -->
    <header class="bg-white shadow-sm border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-6">
          <div>
            <h1 class="text-3xl font-bold text-gray-900">Panel de Administración</h1>
            <p class="text-gray-600">Gestión de experiencias y contenido</p>
          </div>
          <div class="flex items-center space-x-4">
            <nuxt-link to="/postulaciones" class="text-gray-500 hover:text-gray-700 flex items-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                </path>
              </svg>
              Postulaciones
            </nuxt-link>
            <button @click="openCreateModal" class="btn-primary">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
              </svg>
              Nueva Experiencia
            </button>
            <nuxt-link to="/" class="text-gray-500 hover:text-gray-700">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
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
            <div class="p-2 bg-primary/10 rounded-lg">
              <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                </path>
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Total Experiencias</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.total }}</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
          <div class="flex items-center">
            <div class="p-2 bg-secondary/10 rounded-lg">
              <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                </path>
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Destacadas</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.featured }}</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
          <div class="flex items-center">
            <div class="p-2 bg-green-100 rounded-lg">
              <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Publicadas</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.published }}</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
          <div class="flex items-center">
            <div class="p-2 bg-yellow-100 rounded-lg">
              <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Borradores</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.drafts }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Filtros y Búsqueda -->
      <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
        <div class="flex flex-col sm:flex-row gap-4">
          <div class="flex-1">
            <input v-model="searchTerm" type="text" placeholder="Buscar experiencias..."
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none" />
          </div>
          <select v-model="filterCategory"
            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
            <option value="">Todas las categorías</option>
            <option value="ambiental">Ambiental</option>
            <option value="educacion">Educación</option>
            <option value="salud">Salud</option>
            <option value="cultura">Cultura</option>
            <option value="social">Social</option>
          </select>
          <select v-model="filterStatus"
            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
            <option value="">Todos los estados</option>
            <option value="published">Publicado</option>
            <option value="draft">Borrador</option>
          </select>
        </div>
      </div>

      <!-- Lista de Experiencias -->
      <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
          <h2 class="text-lg font-semibold text-gray-900">Experiencias ({{ filteredExperiencias.length }})</h2>
        </div>

        <div v-if="loading" class="p-8 text-center">
          <div class="inline-flex items-center">
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
              </path>
            </svg>
            Cargando experiencias...
          </div>
        </div>

        <div v-else-if="filteredExperiencias.length === 0" class="p-8 text-center text-gray-500">
          <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
            </path>
          </svg>
          <p>No se encontraron experiencias</p>
        </div>

        <div v-else class="divide-y divide-gray-200">
          <div v-for="experiencia in filteredExperiencias" :key="experiencia.id"
            class="p-6 hover:bg-gray-50 transition-colors">
            <div class="flex items-start justify-between">
              <div class="flex-1">
                <div class="flex items-center space-x-3 mb-2">
                  <h3 class="text-lg font-semibold text-gray-900">{{ experiencia.title }}</h3>
                  <span v-if="experiencia.featured"
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                      <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                      </path>
                    </svg>
                    Destacada
                  </span>
                  <span :class="[
                    'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                    experiencia.status === 'published'
                      ? 'bg-green-100 text-green-800'
                      : 'bg-gray-100 text-gray-800'
                  ]">
                    {{ experiencia.status === 'published' ? 'Publicado' : 'Borrador' }}
                  </span>
                  <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 capitalize">
                    {{ experiencia.category }}
                  </span>
                </div>

                <p class="text-gray-600 mb-3 line-clamp-2">{{ experiencia.excerpt }}</p>

                <div class="flex items-center text-sm text-gray-500 space-x-4">
                  <span>{{ experiencia.date }}</span>
                  <span>{{ experiencia.location }}</span>
                  <span>{{ experiencia.read_time }} min lectura</span>
                  <span>Creado: {{ formatDate(experiencia.created_at) }}</span>
                </div>
              </div>

              <div class="flex items-center space-x-2 ml-4">
                <button @click="toggleFeatured(experiencia)" :class="[
                  'p-2 rounded-lg transition-colors',
                  experiencia.featured
                    ? 'bg-yellow-100 text-yellow-600 hover:bg-yellow-200'
                    : 'bg-gray-100 text-gray-400 hover:bg-gray-200'
                ]" title="Marcar como destacada">
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                      d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                    </path>
                  </svg>
                </button>

                <button @click="editExperiencia(experiencia)"
                  class="p-2 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition-colors" title="Editar">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                    </path>
                  </svg>
                </button>

                <button @click="deleteExperiencia(experiencia)"
                  class="p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors" title="Eliminar">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                    </path>
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <!-- Modal de Crear/Editar Experiencia -->
    <Teleport to="body">
      <div v-if="showCreateModal || showEditModal"
        class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" @click="closeModals">
        <div class="bg-white rounded-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto" @click.stop>
          <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 rounded-t-2xl">
            <div class="flex items-center justify-between">
              <h2 class="text-2xl font-bold text-gray-900">
                {{ showEditModal ? 'Editar Experiencia' : 'Nueva Experiencia' }}
              </h2>
              <button @click="closeModals" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
              </button>
            </div>
          </div>

          <form @submit.prevent="submitForm" class="p-6 space-y-6">
            <!-- Información básica -->
            <div class="grid md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Título *
                </label>
                <input v-model="formData.title" type="text" required
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"
                  placeholder="Título de la experiencia" />
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Fecha
                </label>
                <input v-model="formData.date" type="text"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"
                  placeholder="Ej: 12 Ago 2025" />
              </div>
            </div>

            <!-- Extracto -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Extracto *
              </label>
              <textarea v-model="formData.excerpt" required rows="3"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none resize-none"
                placeholder="Breve descripción de la experiencia"></textarea>
            </div>

            <!-- Detalles -->
            <div class="grid md:grid-cols-3 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Categoría *
                </label>
                <select v-model="formData.category" required
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                  <option value="">Seleccionar categoría</option>
                  <option value="ambiental">Ambiental</option>
                  <option value="educacion">Educación</option>
                  <option value="salud">Salud</option>
                  <option value="cultura">Cultura</option>
                  <option value="social">Social</option>
                </select>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Duración
                </label>
                <input v-model="formData.duration" type="text"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"
                  placeholder="Ej: 2 días" />
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Tiempo de lectura
                </label>
                <input v-model="formData.read_time" type="text"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"
                  placeholder="Ej: 5" />
              </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Participantes
                </label>
                <input v-model="formData.participants" type="text"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"
                  placeholder="Ej: 45 voluntarios" />
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Ubicación
                </label>
                <input v-model="formData.location" type="text"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"
                  placeholder="Ej: Alto Mayo, San Martín" />
              </div>
            </div>

            <!-- Contenido -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Contenido *
              </label>

              <!-- Barra de herramientas del editor -->
              <div class="border border-gray-300 rounded-t-lg bg-gray-50 p-2 flex flex-wrap gap-2">
                <button type="button" @click="formatText('bold')"
                  class="px-3 py-1 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100" title="Negrita">
                  <strong>B</strong>
                </button>
                <button type="button" @click="formatText('italic')"
                  class="px-3 py-1 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100" title="Cursiva">
                  <em>I</em>
                </button>
                <button type="button" @click="formatText('underline')"
                  class="px-3 py-1 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100" title="Subrayado">
                  <u>U</u>
                </button>
                <div class="w-px bg-gray-300"></div>
                <button type="button" @click="formatText('formatBlock', 'h3')"
                  class="px-3 py-1 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100" title="Título">
                  H3
                </button>
                <button type="button" @click="formatText('formatBlock', 'p')"
                  class="px-3 py-1 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100" title="Párrafo">
                  P
                </button>
                <div class="w-px bg-gray-300"></div>
                <button type="button" @click="formatText('insertUnorderedList')"
                  class="px-3 py-1 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100" title="Lista">
                  • Lista
                </button>
                <button type="button" @click="formatText('insertOrderedList')"
                  class="px-3 py-1 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100"
                  title="Lista numerada">
                  1. Lista
                </button>
              </div>

              <!-- Editor de contenido -->
              <div ref="contentEditor" contenteditable="true" @input="updateContent" @paste="handlePaste"
                class="w-full min-h-[300px] px-4 py-3 border border-gray-300 border-t-0 rounded-b-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"
                style="white-space: pre-wrap;"></div>

              <!-- Vista previa HTML (opcional) -->
              <div class="mt-2">
                <button type="button" @click="showHtmlPreview = !showHtmlPreview"
                  class="text-sm text-gray-500 hover:text-gray-700">
                  {{ showHtmlPreview ? 'Ocultar' : 'Ver' }} HTML
                </button>
                <div v-if="showHtmlPreview" class="mt-2 p-3 bg-gray-100 rounded-lg">
                  <pre class="text-xs text-gray-600 whitespace-pre-wrap">{{ formData.content }}</pre>
                </div>
              </div>
            </div>

            <!-- Imagen de portada -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Imagen de portada *
              </label>
              <div @drop="handleCoverDrop" @dragover.prevent @dragenter.prevent
                class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary transition-colors cursor-pointer"
                :class="{ 'border-primary bg-primary/5': isDraggingCover }" @click="$refs.coverInput.click()">
                <input ref="coverInput" type="file" accept="image/*" @change="handleCoverSelect" class="hidden" />

                <div v-if="!formData.coverPreview" class="space-y-2">
                  <svg class="w-12 h-12 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                  </svg>
                  <p class="text-gray-600">Arrastra una imagen o haz clic para seleccionar</p>
                  <p class="text-gray-400 text-sm">JPG, PNG, WebP (máx. 5MB)</p>
                </div>

                <div v-else class="space-y-2">
                  <img :src="formData.coverPreview" alt="Preview" class="w-32 h-32 object-cover rounded-lg mx-auto" />
                  <p class="text-primary font-medium">{{ formData.coverFile?.name }}</p>
                  <button type="button" @click.stop="removeCover" class="text-red-500 text-sm hover:text-red-700">
                    Eliminar imagen
                  </button>
                </div>
              </div>
            </div>

            <!-- Galería de imágenes -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Galería de imágenes (opcional)
              </label>
              <div @drop="handleGalleryDrop" @dragover.prevent @dragenter.prevent
                class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary transition-colors cursor-pointer"
                :class="{ 'border-primary bg-primary/5': isDraggingGallery }" @click="$refs.galleryInput.click()">
                <input ref="galleryInput" type="file" accept="image/*" multiple @change="handleGallerySelect"
                  class="hidden" />

                <div v-if="formData.galleryFiles.length === 0" class="space-y-2">
                  <svg class="w-12 h-12 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                  </svg>
                  <p class="text-gray-600">Arrastra imágenes o haz clic para seleccionar</p>
                  <p class="text-gray-400 text-sm">JPG, PNG, WebP (máx. 5MB cada una)</p>
                </div>

                <div v-else class="space-y-4">
                  <p class="text-primary font-medium">{{ formData.galleryFiles.length }} imagen(es) seleccionada(s)</p>
                  <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div v-for="(file, index) in formData.galleryPreviews" :key="index" class="relative">
                      <img :src="file" alt="Preview" class="w-full h-20 object-cover rounded-lg" />
                      <button type="button" @click.stop="removeGalleryImage(index)"
                        class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center text-xs hover:bg-red-600">
                        ×
                      </button>
                    </div>
                  </div>
                  <button type="button" @click.stop="clearGallery" class="text-red-500 text-sm hover:text-red-700">
                    Limpiar galería
                  </button>
                </div>
              </div>
            </div>

            <!-- Video (opcional) -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Video (YouTube embed URL)
              </label>
              <input v-model="formData.video" type="url"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"
                placeholder="https://www.youtube.com/embed/..." />
            </div>

            <!-- Estadísticas -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Estadísticas
              </label>
              <div class="space-y-3">
                <div v-for="(stat, index) in formData.stats" :key="index" class="flex gap-3 items-center">
                  <input v-model="stat.value" type="text" placeholder="Valor (ej: 1,000+)"
                    class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none" />
                  <input v-model="stat.label" type="text" placeholder="Etiqueta (ej: Árboles plantados)"
                    class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none" />
                  <button type="button" @click="removeStat(index)" class="p-2 text-red-500 hover:bg-red-50 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                      </path>
                    </svg>
                  </button>
                </div>
                <button type="button" @click="addStat" class="text-primary hover:text-primary/80 text-sm font-medium">
                  + Agregar estadística
                </button>
              </div>
            </div>

            <!-- Opciones -->
            <div class="flex items-center space-x-6">
              <label class="flex items-center">
                <input v-model="formData.featured" type="checkbox"
                  class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary" />
                <span class="ml-2 text-sm text-gray-700">Marcar como destacada</span>
              </label>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                <select v-model="formData.status"
                  class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                  <option value="published">Publicado</option>
                  <option value="draft">Borrador</option>
                </select>
              </div>
            </div>

            <!-- Botones -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
              <button type="button" @click="closeModals"
                class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                Cancelar
              </button>
              <button type="submit" :disabled="submitting"
                class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors disabled:opacity-50">
                {{ submitting ? 'Guardando...' : (showEditModal ? 'Actualizar' : 'Crear') }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </Teleport>

    <!-- Modal de Confirmación de Eliminación -->
    <Teleport to="body">
      <div v-if="showDeleteModal"
        class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6">
          <div class="flex items-center mb-4">
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
              <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z">
                </path>
              </svg>
            </div>
            <div>
              <h3 class="text-lg font-semibold text-gray-900">Confirmar eliminación</h3>
              <p class="text-gray-600">Esta acción no se puede deshacer</p>
            </div>
          </div>

          <p class="text-gray-700 mb-6">
            ¿Estás seguro de que quieres eliminar la experiencia "<strong>{{ experienciaToDelete?.title }}</strong>"?
          </p>

          <div class="flex justify-end space-x-4">
            <button @click="showDeleteModal = false"
              class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
              Cancelar
            </button>
            <button @click="confirmDelete" :disabled="deleting"
              class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors disabled:opacity-50">
              {{ deleting ? 'Eliminando...' : 'Eliminar' }}
            </button>
          </div>
        </div>
      </div>
    </Teleport>
  </div>
</template>
<script setup>
definePageMeta({
  layout: 'admin'
})
// SEO y configuración
useHead({
  title: 'Panel de Administración - Munay Ruray',
  meta: [
    {
      name: 'robots',
      content: 'noindex, nofollow'
    }
  ]
})

// Estado reactivo
const experiencias = ref([])
const loading = ref(true)
const submitting = ref(false)
const deleting = ref(false)

// Modales
const showCreateModal = ref(false)
const showEditModal = ref(false)
const showDeleteModal = ref(false)

// Filtros y búsqueda
const searchTerm = ref('')
const filterCategory = ref('')
const filterStatus = ref('')

// Formulario
const formData = ref({
  title: '',
  excerpt: '',
  content: '',
  date: '',
  category: '',
  read_time: '5',
  duration: '',
  participants: '',
  location: '',
  video: '',
  featured: false,
  status: 'published',
  coverFile: null,
  coverPreview: '',
  galleryFiles: [],
  galleryPreviews: [],
  stats: []
})

// Estados auxiliares
const isDraggingCover = ref(false)
const isDraggingGallery = ref(false)
const experienciaToDelete = ref(null)
const editingExperiencia = ref(null)
const showHtmlPreview = ref(false)

// Computed
const stats = computed(() => {
  const total = experiencias.value.length
  const featured = experiencias.value.filter(exp => exp.featured).length
  const published = experiencias.value.filter(exp => exp.status === 'published').length
  const drafts = experiencias.value.filter(exp => exp.status === 'draft').length

  return { total, featured, published, drafts }
})

const filteredExperiencias = computed(() => {
  let filtered = experiencias.value

  // Filtrar por búsqueda
  if (searchTerm.value) {
    const term = searchTerm.value.toLowerCase()
    filtered = filtered.filter(exp =>
      exp.title.toLowerCase().includes(term) ||
      exp.excerpt.toLowerCase().includes(term) ||
      exp.location?.toLowerCase().includes(term)
    )
  }

  // Filtrar por categoría
  if (filterCategory.value) {
    filtered = filtered.filter(exp => exp.category === filterCategory.value)
  }

  // Filtrar por estado
  if (filterStatus.value) {
    filtered = filtered.filter(exp => exp.status === filterStatus.value)
  }

  return filtered
})

// Métodos
const loadExperiencias = async () => {
  try {
    loading.value = true
    const response = await $fetch('/api/alimentador.php?action=list')

    if (response.success) {
      experiencias.value = response.data
    } else {
      throw new Error(response.error || 'Error al cargar experiencias')
    }
  } catch (error) {
    console.error('Error cargando experiencias:', error)
    // Aquí podrías mostrar una notificación de error
  } finally {
    loading.value = false
  }
}

const resetForm = () => {
  formData.value = {
    title: '',
    excerpt: '',
    content: '',
    date: new Date().toLocaleDateString('es-ES', {
      day: 'numeric',
      month: 'short',
      year: 'numeric'
    }),
    category: '',
    read_time: '5',
    duration: '',
    participants: '',
    location: '',
    video: '',
    featured: false,
    status: 'published',
    coverFile: null,
    coverPreview: '',
    galleryFiles: [],
    galleryPreviews: [],
    stats: []
  }
  showHtmlPreview.value = false
}

const closeModals = () => {
  showCreateModal.value = false
  showEditModal.value = false
  editingExperiencia.value = null
  resetForm()
}

const openCreateModal = () => {
  resetForm()
  showCreateModal.value = true

  // Inicializar el editor de contenido
  initializeEditor('')
}

const editExperiencia = (experiencia) => {
  editingExperiencia.value = experiencia

  // Llenar el formulario con los datos existentes
  formData.value = {
    title: experiencia.title,
    excerpt: experiencia.excerpt,
    content: experiencia.content,
    date: experiencia.date,
    category: experiencia.category,
    read_time: experiencia.read_time,
    duration: experiencia.duration || '',
    participants: experiencia.participants || '',
    location: experiencia.location || '',
    video: experiencia.video || '',
    featured: experiencia.featured,
    status: experiencia.status,
    coverFile: null,
    coverPreview: experiencia.cover,
    galleryFiles: [],
    galleryPreviews: experiencia.gallery || [],
    stats: experiencia.stats || []
  }

  // Actualizar el editor de contenido
  initializeEditor(experiencia.content || '')

  showEditModal.value = true
}

const submitForm = async () => {
  try {
    submitting.value = true

    // Validar que hay imagen de portada para nuevas experiencias
    if (!showEditModal.value && !formData.value.coverFile) {
      alert('La imagen de portada es requerida')
      submitting.value = false
      return
    }

    // Validar campos requeridos
    if (!formData.value.title.trim()) {
      alert('El título es requerido')
      submitting.value = false
      return
    }

    if (!formData.value.excerpt.trim()) {
      alert('El extracto es requerido')
      submitting.value = false
      return
    }

    if (!formData.value.category) {
      alert('La categoría es requerida')
      submitting.value = false
      return
    }

    // Crear FormData para envío con archivos
    const formDataToSend = new FormData()

    // Agregar campos básicos
    Object.keys(formData.value).forEach(key => {
      if (key === 'coverFile' || key === 'coverPreview') return

      if (key === 'stats') {
        // Enviar estadísticas como array
        formData.value.stats.forEach((stat, index) => {
          formDataToSend.append(`stats[${index}][value]`, stat.value)
          formDataToSend.append(`stats[${index}][label]`, stat.label)
        })
      } else if (key === 'featured') {
        formDataToSend.append(key, formData.value[key] ? '1' : '0')
      } else {
        formDataToSend.append(key, formData.value[key])
      }
    })

    // Agregar archivo de portada si existe
    if (formData.value.coverFile) {
      formDataToSend.append('cover', formData.value.coverFile)
    }

    // Agregar archivos de galería si existen
    if (formData.value.galleryFiles.length > 0) {
      formData.value.galleryFiles.forEach((file) => {
        formDataToSend.append('gallery[]', file)
      })
    }

    // Determinar URL y método
    let url = '/api/alimentador.php?action=create'
    let method = 'POST'
    
    if (showEditModal.value && editingExperiencia.value) {
      url = `/api/alimentador.php?action=update&id=${editingExperiencia.value.id}`
      formDataToSend.append('id', editingExperiencia.value.id)
      method = 'POST' // Mantener POST para compatibilidad con el servidor
    }

    const response = await $fetch(url, {
      method: method,
      body: formDataToSend
    })

    if (response.success) {
      // Recargar experiencias
      await loadExperiencias()

      // Cerrar modal
      closeModals()

      // Mostrar mensaje de éxito (podrías usar una librería de notificaciones)
      console.log('Experiencia guardada exitosamente')
    } else {
      throw new Error(response.error || 'Error al guardar experiencia')
    }
  } catch (error) {
    console.error('Error guardando experiencia:', error)
    let errorMessage = 'Error al guardar la experiencia'
    
    if (error.data && error.data.error) {
      errorMessage = error.data.error
    } else if (error.message) {
      errorMessage = error.message
    }
    
    alert(errorMessage)
  } finally {
    submitting.value = false
  }
}

const toggleFeatured = async (experiencia) => {
  try {
    const response = await $fetch(`/api/alimentador.php?action=toggle-featured&id=${experiencia.id}`, {
      method: 'PUT'
    })

    if (response.success) {
      await loadExperiencias()
    } else {
      throw new Error(response.error || 'Error al actualizar destacada')
    }
  } catch (error) {
    console.error('Error actualizando destacada:', error)
  }
}

const deleteExperiencia = (experiencia) => {
  experienciaToDelete.value = experiencia
  showDeleteModal.value = true
}

const confirmDelete = async () => {
  if (!experienciaToDelete.value) return

  try {
    deleting.value = true

    const response = await $fetch(`/api/alimentador.php?action=delete&id=${experienciaToDelete.value.id}`, {
      method: 'DELETE'
    })

    if (response.success) {
      await loadExperiencias()
      showDeleteModal.value = false
      experienciaToDelete.value = null
      console.log('Experiencia eliminada exitosamente')
    } else {
      throw new Error(response.error || 'Error al eliminar experiencia')
    }
  } catch (error) {
    console.error('Error eliminando experiencia:', error)
  } finally {
    deleting.value = false
  }
}

// Manejo de archivos
const handleCoverSelect = (event) => {
  const file = event.target.files[0]
  if (file) {
    validateAndSetCoverFile(file)
  }
}

const handleCoverDrop = (event) => {
  event.preventDefault()
  isDraggingCover.value = false

  const files = event.dataTransfer.files
  if (files.length > 0) {
    validateAndSetCoverFile(files[0])
  }
}

const validateAndSetCoverFile = (file) => {
  const maxSize = 5 * 1024 * 1024 // 5MB
  const allowedTypes = ['image/jpeg', 'image/png', 'image/webp']

  if (!allowedTypes.includes(file.type)) {
    alert('Solo se permiten archivos JPG, PNG o WebP')
    return
  }

  if (file.size > maxSize) {
    alert('El archivo no debe superar los 5MB')
    return
  }

  formData.value.coverFile = file

  // Crear preview
  const reader = new FileReader()
  reader.onload = (e) => {
    formData.value.coverPreview = e.target.result
  }
  reader.readAsDataURL(file)
}

const removeCover = () => {
  formData.value.coverFile = null
  formData.value.coverPreview = ''
}

// Manejo de estadísticas
const addStat = () => {
  formData.value.stats.push({ value: '', label: '' })
}

const removeStat = (index) => {
  formData.value.stats.splice(index, 1)
}

// Manejo de galería
const handleGallerySelect = (event) => {
  const files = Array.from(event.target.files)
  files.forEach(file => validateAndAddGalleryFile(file))
}

const handleGalleryDrop = (event) => {
  event.preventDefault()
  isDraggingGallery.value = false

  const files = Array.from(event.dataTransfer.files)
  files.forEach(file => validateAndAddGalleryFile(file))
}

const validateAndAddGalleryFile = (file) => {
  const maxSize = 5 * 1024 * 1024 // 5MB
  const allowedTypes = ['image/jpeg', 'image/png', 'image/webp']

  if (!allowedTypes.includes(file.type)) {
    alert('Solo se permiten archivos JPG, PNG o WebP')
    return
  }

  if (file.size > maxSize) {
    alert('El archivo no debe superar los 5MB')
    return
  }

  formData.value.galleryFiles.push(file)

  // Crear preview
  const reader = new FileReader()
  reader.onload = (e) => {
    formData.value.galleryPreviews.push(e.target.result)
  }
  reader.readAsDataURL(file)
}

const removeGalleryImage = (index) => {
  formData.value.galleryFiles.splice(index, 1)
  formData.value.galleryPreviews.splice(index, 1)
}

const clearGallery = () => {
  formData.value.galleryFiles = []
  formData.value.galleryPreviews = []
}

// Editor de texto enriquecido
const contentEditor = ref(null)

const formatText = (command, value = null) => {
  document.execCommand(command, false, value)
  updateContent()
}

const updateContent = () => {
  if (contentEditor.value) {
    formData.value.content = contentEditor.value.innerHTML
  }
}

// Función para inicializar el contenido del editor
const initializeEditor = (content = '') => {
  nextTick(() => {
    if (contentEditor.value) {
      contentEditor.value.innerHTML = content
      formData.value.content = content
    }
  })
}

const handlePaste = (event) => {
  event.preventDefault()
  const text = event.clipboardData.getData('text/plain')
  document.execCommand('insertText', false, text)
}

// Utilidades
const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('es-ES', {
    day: 'numeric',
    month: 'short',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

// Eventos de drag and drop
onMounted(() => {
  loadExperiencias()

  // Event listeners para drag and drop
  const handleDragEnter = () => {
    isDraggingCover.value = true
  }

  const handleDragLeave = (e) => {
    if (!e.currentTarget.contains(e.relatedTarget)) {
      isDraggingCover.value = false
    }
  }

  const handleGalleryDragEnter = () => {
    isDraggingGallery.value = true
  }

  const handleGalleryDragLeave = (e) => {
    if (!e.currentTarget.contains(e.relatedTarget)) {
      isDraggingGallery.value = false
    }
  }

  // Agregar listeners globales si es necesario
  document.addEventListener('dragenter', handleDragEnter)
  document.addEventListener('dragleave', handleDragLeave)

  // Cleanup
  onBeforeUnmount(() => {
    document.removeEventListener('dragenter', handleDragEnter)
    document.removeEventListener('dragleave', handleDragLeave)
  })
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

/* Botones */
/* .btn-primary { */
/* @apply inline-flex items-center px-4 py-2 bg-primary text-white font-semibold rounded-lg hover:bg-primary/90 transition-colors; */
/* } */

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

/* Editor de contenido */
[contenteditable="true"] {
  min-height: 300px;
  max-height: 500px;
  overflow-y: auto;
}

[contenteditable="true"]:focus {
  outline: none;
  border-color: #02b2a2;
  box-shadow: 0 0 0 3px rgba(2, 178, 162, 0.1);
}

[contenteditable="true"] h3 {
  font-size: 1.25rem;
  font-weight: 700;
  margin: 1rem 0 0.5rem 0;
  color: #111827;
}

[contenteditable="true"] p {
  margin: 0.75rem 0;
  line-height: 1.6;
}

[contenteditable="true"] ul,
[contenteditable="true"] ol {
  margin: 0.75rem 0;
  padding-left: 1.5rem;
}

[contenteditable="true"] li {
  margin: 0.25rem 0;
}

[contenteditable="true"] strong {
  font-weight: 600;
  color: #02b2a2;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .max-w-4xl {
    max-width: calc(100vw - 2rem);
  }
}
</style>