<template>
  <div>
    <!-- Hero Section -->
    <section class="relative py-24 wave-shape-primary text-white overflow-hidden">
      <!-- Formas orgánicas de fondo -->
      
      <div class="container-full relative z-10 text-white">
        <h1 class="font-display text-center mb-6">Únete a Munay Ruray</h1>
        <p class="text-xl md:text-2xl text-center max-w-3xl mx-auto text-white/90">
          Sé parte del cambio que quieres ver en el mundo
        </p>
      </div>
      
      <!-- Divisor ondulado inferior -->
      <SectionDivider type="wave2" color="primary" backgroundColor="gray" height="70px" />
    </section>

    <!-- Formulario de Postulación -->
    <section class="py-16 md:py-24 bg-gray-50 relative">
      <div class="container-full max-w-3xl relative z-10">
        <div class="card-enhanced relative z-20 form-interactive">
          <form @submit.prevent="enviarFormulario" class="space-y-8">
            <!-- Datos Personales -->
            <div class="space-y-6">
              <h2 class="text-2xl font-bold text-gray-900">Datos Personales</h2>

              <div class="grid md:grid-cols-2 gap-6">
                <!-- Nombres completos -->
                <div class="md:col-span-2">
                  <label for="nombres" class="block text-sm font-medium text-gray-700 mb-2">
                    Nombres completos *
                  </label>
                  <input type="text" id="nombres" v-model="formData.nombres" required
                    placeholder="Ingresa tus nombres completos"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-colors"
                    :class="{ 'border-red-500': errors.nombres }" />
                  <p v-if="errors.nombres" class="mt-1 text-sm text-red-500">
                    {{ errors.nombres }}
                  </p>
                </div>

                <!-- Número de contacto -->
                <div>
                  <label for="telefono" class="block text-sm font-medium text-gray-700 mb-2">
                    Número de contacto *
                  </label>
                  <input type="tel" id="telefono" v-model="formData.telefono" required placeholder="Ej: 987654321"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-colors"
                    :class="{ 'border-red-500': errors.telefono }" />
                  <p v-if="errors.telefono" class="mt-1 text-sm text-red-500">
                    {{ errors.telefono }}
                  </p>
                </div>

                <!-- Correo electrónico -->
                <div>
                  <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Correo electrónico *
                  </label>
                  <input type="email" id="email" v-model="formData.email" required placeholder="tu@email.com"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-colors"
                    :class="{ 'border-red-500': errors.email }" />
                  <p v-if="errors.email" class="mt-1 text-sm text-red-500">
                    {{ errors.email }}
                  </p>
                </div>

                <!-- Universidad -->
                <div>
                  <label for="universidad" class="block text-sm font-medium text-gray-700 mb-2">
                    Universidad *
                  </label>
                  <select id="universidad" v-model="formData.universidad" required @change="handleUniversidadChange"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-colors"
                    :class="{ 'border-red-500': errors.universidad }">
                    <option value="">Selecciona tu universidad</option>
                    <option value="Universidad Católica Santa María">Universidad Católica Santa María</option>
                    <option value="Universidad Nacional de San Agustín">Universidad Nacional de San Agustín</option>
                    <option value="Universidad Católica San Pablo">Universidad Católica San Pablo</option>
                    <option value="Universidad Continental">Universidad Continental</option>
                    <option value="Universidad Tecnológica del Perú">Universidad Tecnológica del Perú</option>
                    <option value="Universidad La Salle">Universidad La Salle</option>
                    <option value="Universidad de San Martín de Porres">Universidad de San Martín de Porres</option>
                    <option value="otros">Otros</option>
                  </select>
                  <p v-if="errors.universidad" class="mt-1 text-sm text-red-500">
                    {{ errors.universidad }}
                  </p>
                </div>

                <!-- Universidad otros (condicional) -->
                <div v-if="formData.universidad === 'otros'">
                  <label for="universidadOtros" class="block text-sm font-medium text-gray-700 mb-2">
                    Especifica tu universidad *
                  </label>
                  <input type="text" id="universidadOtros" v-model="formData.universidadOtros" required
                    placeholder="Nombre de tu universidad"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-colors"
                    :class="{ 'border-red-500': errors.universidadOtros }" />
                  <p v-if="errors.universidadOtros" class="mt-1 text-sm text-red-500">
                    {{ errors.universidadOtros }}
                  </p>
                </div>
              </div>

              <!-- Año que estás cursando -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">
                  Año que estás cursando *
                </label>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                  <label v-for="anio in aniosEstudio" :key="anio.value"
                    class="flex items-center p-3 border border-gray-300 rounded-xl cursor-pointer hover:border-primary transition-colors"
                    :class="{ 'border-primary bg-primary/5': formData.anioEstudio === anio.value }">
                    <input type="radio" :value="anio.value" v-model="formData.anioEstudio"
                      class="w-4 h-4 text-primary border-gray-300 focus:ring-primary" />
                    <span class="ml-3 text-sm font-medium">{{ anio.label }}</span>
                  </label>
                </div>
                <p v-if="errors.anioEstudio" class="mt-1 text-sm text-red-500">
                  {{ errors.anioEstudio }}
                </p>
              </div>

              <!-- Edad -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">
                  Edad *
                </label>
                <div class="grid grid-cols-2 gap-3">
                  <label v-for="rango in rangosEdad" :key="rango.value"
                    class="flex items-center p-3 border border-gray-300 rounded-xl cursor-pointer hover:border-primary transition-colors"
                    :class="{ 'border-primary bg-primary/5': formData.edad === rango.value }">
                    <input type="radio" :value="rango.value" v-model="formData.edad"
                      class="w-4 h-4 text-primary border-gray-300 focus:ring-primary" />
                    <span class="ml-3 text-sm font-medium">{{ rango.label }}</span>
                  </label>
                </div>
                <p v-if="errors.edad" class="mt-1 text-sm text-red-500">
                  {{ errors.edad }}
                </p>
              </div>

              <!-- Carrera Profesional -->
              <div>
                <label for="carrera" class="block text-sm font-medium text-gray-700 mb-2">
                  Carrera Profesional *
                </label>
                <select id="carrera" v-model="formData.carrera" required @change="handleCarreraChange"
                  class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-colors"
                  :class="{ 'border-red-500': errors.carrera }">
                  <option value="">Selecciona tu carrera</option>
                  <option value="Marketing">Marketing</option>
                  <option value="Ciencias de la Comunicación">Ciencias de la Comunicación</option>
                  <option value="Economía">Economía</option>
                  <option value="Administración">Administración</option>
                  <option value="Trabajo Social">Trabajo Social</option>
                  <option value="Sociología">Sociología</option>
                  <option value="otro">Otro</option>
                </select>
                <p v-if="errors.carrera" class="mt-1 text-sm text-red-500">
                  {{ errors.carrera }}
                </p>
              </div>

              <!-- Carrera otros (condicional) -->
              <div v-if="formData.carrera === 'otro'">
                <label for="carreraOtro" class="block text-sm font-medium text-gray-700 mb-2">
                  Especifica tu carrera *
                </label>
                <input type="text" id="carreraOtro" v-model="formData.carreraOtro" required
                  placeholder="Nombre de tu carrera"
                  class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-colors"
                  :class="{ 'border-red-500': errors.carreraOtro }" />
                <p v-if="errors.carreraOtro" class="mt-1 text-sm text-red-500">
                  {{ errors.carreraOtro }}
                </p>
              </div>

              <!-- Experiencia previa -->
              <div>
                <label for="experienciaPrevia" class="block text-sm font-medium text-gray-700 mb-2">
                  ¿Tienes alguna experiencia previa como voluntario? Si es así, describe brevemente
                </label>
                <textarea id="experienciaPrevia" v-model="formData.experienciaPrevia" rows="4"
                  placeholder="Describe tu experiencia previa como voluntario o escribe 'No tengo experiencia previa'"
                  class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-colors resize-none"
                  :class="{ 'border-red-500': errors.experienciaPrevia }"></textarea>
                <p v-if="errors.experienciaPrevia" class="mt-1 text-sm text-red-500">
                  {{ errors.experienciaPrevia }}
                </p>
              </div>

              <!-- Disponibilidad fines de semana -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">
                  ¿Cuál es tu disponibilidad para apoyarnos en el voluntariado? (fines de semana) *
                </label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                  <label v-for="disponibilidad in disponibilidadOpciones" :key="disponibilidad.value"
                    class="flex items-center p-3 border border-gray-300 rounded-xl cursor-pointer hover:border-primary transition-colors"
                    :class="{ 'border-primary bg-primary/5': formData.disponibilidad === disponibilidad.value }">
                    <input type="radio" :value="disponibilidad.value" v-model="formData.disponibilidad"
                      class="w-4 h-4 text-primary border-gray-300 focus:ring-primary" />
                    <span class="ml-3 text-sm font-medium">{{ disponibilidad.label }}</span>
                  </label>
                </div>
                <p v-if="errors.disponibilidad" class="mt-1 text-sm text-red-500">
                  {{ errors.disponibilidad }}
                </p>
              </div>

              <!-- Adjuntar CV -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Adjúntanos tu CV *
                </label>
                <div @drop="handleDrop" @dragover.prevent @dragenter.prevent
                  class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-primary transition-colors cursor-pointer"
                  :class="{ 'border-primary bg-primary/5': isDragging, 'border-red-500': errors.cv }"
                  @click="$refs.fileInput.click()">
                  <input ref="fileInput" type="file" accept=".pdf,.doc,.docx" @change="handleFileSelect"
                    class="hidden" />

                  <div v-if="!formData.cv" class="space-y-2">
                    <svg class="w-12 h-12 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    <div>
                      <p class="text-gray-600 font-medium">Arrastra y suelta tu CV aquí</p>
                      <p class="text-gray-500 text-sm">o haz clic para seleccionar</p>
                      <p class="text-gray-400 text-xs mt-1">PDF, DOC, DOCX (máx. 5MB)</p>
                    </div>
                  </div>

                  <div v-else class="space-y-2">
                    <svg class="w-12 h-12 text-primary mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                      <p class="text-primary font-medium">{{ formData.cv.name }}</p>
                      <p class="text-gray-500 text-sm">{{ formatFileSize(formData.cv.size) }}</p>
                      <button type="button" @click.stop="removeFile"
                        class="text-red-500 text-sm hover:text-red-700 mt-2">
                        Eliminar archivo
                      </button>
                    </div>
                  </div>
                </div>
                <p v-if="errors.cv" class="mt-1 text-sm text-red-500">
                  {{ errors.cv }}
                </p>
              </div>

              <!-- Términos y condiciones -->
              <div class="flex items-start">
                <div class="flex items-center h-5">
                  <input id="terminos" type="checkbox" v-model="formData.terminos" required
                    class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary"
                    :class="{ 'border-red-500': errors.terminos }" />
                </div>
                <label for="terminos" class="ml-3 text-sm text-gray-600">
                  Acepto los términos y condiciones del programa y autorizo el tratamiento de mis datos personales *
                </label>
              </div>
              <p v-if="errors.terminos" class="mt-1 text-sm text-red-500">
                {{ errors.terminos }}
              </p>
            </div>

            <div class="pt-6">
              <button type="submit" class="w-full cta-enhanced justify-center" :disabled="enviando">
                <span>{{ enviando ? 'Enviando...' : 'Postular' }}</span>
                <svg v-if="!enviando" class="w-5 h-5 ml-3 icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3">
                  </path>
                </svg>
              </button>
            </div>
          </form>
        </div>
      </div>
    </section>

    <!-- Modal de Éxito -->
    <Teleport to="body">
      <div v-if="modalExito" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 text-center">
          <div class="w-16 h-16 bg-secondary/10 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
          </div>
          <h3 class="text-2xl font-bold mb-4">¡Postulación enviada!</h3>
          <p class="text-gray-600 mb-6">
            Gracias por tu interés en Munay Ruray. Hemos recibido tu postulación y te contactaremos pronto.
          </p>
          <button @click="modalExito = false" class="cta-enhanced">
            <span>Entendido</span>
          </button>
        </div>
      </div>
    </Teleport>
  </div>
</template>

<script setup>
import { SectionDivider } from '#components'

// SEO
useHead({
  title: 'Únete - Munay Ruray',
  meta: [
    {
      name: 'description',
      content: 'Únete a Munay Ruray y sé parte del cambio. Postula para ser voluntario y transforma tu vocación en acción.'
    }
  ]
})

const formData = ref({
  nombres: '',
  telefono: '',
  email: '',
  universidad: '',
  universidadOtros: '',
  anioEstudio: '',
  edad: '',
  carrera: '',
  carreraOtro: '',
  experienciaPrevia: '',
  disponibilidad: '',
  cv: null,
  terminos: false
})

const errors = ref({})
const enviando = ref(false)
const modalExito = ref(false)
const isDragging = ref(false)

// Opciones para los campos
const aniosEstudio = [
  { value: 'primero', label: 'Primero' },
  { value: 'segundo', label: 'Segundo' },
  { value: 'tercero', label: 'Tercero' },
  { value: 'cuarto', label: 'Cuarto' },
  { value: 'quinto', label: 'Quinto' },
  { value: 'egresado', label: 'Egresado' }
]

const rangosEdad = [
  { value: '18-22', label: '18 a 22 años' },
  { value: '22-mas', label: '22 años a más' }
]

const disponibilidadOpciones = [
  { value: 'todo-dia', label: 'Todo el día' },
  { value: 'manana', label: 'Solo en la mañana' },
  { value: 'tarde', label: 'Solo en la tarde' }
]

// Manejadores de eventos
const handleUniversidadChange = () => {
  if (formData.value.universidad !== 'otros') {
    formData.value.universidadOtros = ''
  }
  if (errors.value.universidad) {
    delete errors.value.universidad
  }
}

const handleCarreraChange = () => {
  if (formData.value.carrera !== 'otro') {
    formData.value.carreraOtro = ''
  }
  if (errors.value.carrera) {
    delete errors.value.carrera
  }
}

// Manejo de archivos
const handleFileSelect = (event) => {
  const file = event.target.files[0]
  if (file) {
    validateAndSetFile(file)
  }
}

const handleDrop = (event) => {
  event.preventDefault()
  isDragging.value = false

  const files = event.dataTransfer.files
  if (files.length > 0) {
    validateAndSetFile(files[0])
  }
}

const validateAndSetFile = (file) => {
  const maxSize = 5 * 1024 * 1024 // 5MB
  const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']

  // Verificar tipo de archivo por extensión también
  const fileName = file.name.toLowerCase()
  const validExtensions = ['.pdf', '.doc', '.docx']
  const hasValidExtension = validExtensions.some(ext => fileName.endsWith(ext))

  if (!allowedTypes.includes(file.type) && !hasValidExtension) {
    errors.value.cv = 'Solo se permiten archivos PDF, DOC o DOCX'
    return
  }

  if (file.size > maxSize) {
    errors.value.cv = `El archivo no debe superar los 5MB. Tu archivo tiene ${formatFileSize(file.size)}`
    return
  }

  // Verificación adicional para archivos muy pequeños (posibles archivos corruptos)
  if (file.size < 1024) { // 1KB
    errors.value.cv = 'El archivo parece estar corrupto o vacío'
    return
  }

  formData.value.cv = file
  if (errors.value.cv) {
    delete errors.value.cv
  }
}

const removeFile = () => {
  formData.value.cv = null
  if (errors.value.cv) {
    delete errors.value.cv
  }
}

const formatFileSize = (bytes) => {
  if (bytes === 0) return '0 Bytes'
  const k = 1024
  const sizes = ['Bytes', 'KB', 'MB', 'GB']
  const i = Math.floor(Math.log(bytes) / Math.log(k))
  return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i]
}

// Validación del formulario
const validarFormulario = () => {
  const nuevosErrores = {}

  if (!formData.value.nombres.trim()) {
    nuevosErrores.nombres = 'Los nombres completos son requeridos'
  }

  if (!formData.value.telefono.trim()) {
    nuevosErrores.telefono = 'El número de contacto es requerido'
  } else if (!/^\d{9}$/.test(formData.value.telefono.replace(/\s/g, ''))) {
    nuevosErrores.telefono = 'Ingresa un número de teléfono válido (9 dígitos)'
  }

  if (!formData.value.email.trim()) {
    nuevosErrores.email = 'El correo electrónico es requerido'
  } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(formData.value.email)) {
    nuevosErrores.email = 'Ingresa un correo electrónico válido'
  }

  if (!formData.value.universidad) {
    nuevosErrores.universidad = 'La universidad es requerida'
  }

  if (formData.value.universidad === 'otros' && !formData.value.universidadOtros.trim()) {
    nuevosErrores.universidadOtros = 'Especifica el nombre de tu universidad'
  }

  if (!formData.value.anioEstudio) {
    nuevosErrores.anioEstudio = 'El año de estudios es requerido'
  }

  if (!formData.value.edad) {
    nuevosErrores.edad = 'La edad es requerida'
  }

  if (!formData.value.carrera) {
    nuevosErrores.carrera = 'La carrera profesional es requerida'
  }

  if (formData.value.carrera === 'otro' && !formData.value.carreraOtro.trim()) {
    nuevosErrores.carreraOtro = 'Especifica el nombre de tu carrera'
  }

  if (!formData.value.disponibilidad) {
    nuevosErrores.disponibilidad = 'La disponibilidad es requerida'
  }

  if (!formData.value.cv) {
    nuevosErrores.cv = 'El CV es requerido'
  }

  if (!formData.value.terminos) {
    nuevosErrores.terminos = 'Debes aceptar los términos y condiciones'
  }

  errors.value = nuevosErrores
  return Object.keys(nuevosErrores).length === 0
}

const enviarFormulario = async () => {
  if (!validarFormulario()) {
    // Scroll al primer error
    const firstError = Object.keys(errors.value)[0]
    const element = document.getElementById(firstError)
    if (element) {
      element.scrollIntoView({ behavior: 'smooth', block: 'center' })
    }
    return
  }

  enviando.value = true

  try {
    // Crear FormData para envío con archivo
    const formDataToSend = new FormData()

    // Agregar todos los campos del formulario
    Object.keys(formData.value).forEach(key => {
      if (key === 'cv' && formData.value.cv) {
        formDataToSend.append('cv', formData.value.cv)
      } else if (key !== 'cv') {
        formDataToSend.append(key, formData.value[key])
      }
    })

    // Verificar tamaño del archivo antes de enviar
    if (formData.value.cv && formData.value.cv.size > 8 * 1024 * 1024) { // 8MB
      throw new Error('El archivo CV es demasiado grande. El tamaño máximo permitido es 8MB.')
    }

    // Enviar formulario
    const response = await $fetch('https://munay.roomstudio.pe/api/postulaciones.php', {
      method: 'POST',
      body: formDataToSend
    })

    if (response.success) {
      modalExito.value = true

      // Limpiar formulario
      formData.value = {
        nombres: '',
        telefono: '',
        email: '',
        universidad: '',
        universidadOtros: '',
        anioEstudio: '',
        edad: '',
        carrera: '',
        carreraOtro: '',
        experienciaPrevia: '',
        disponibilidad: '',
        cv: null,
        terminos: false
      }

      errors.value = {}
    } else {
      throw new Error(response.error || 'Error al enviar la postulación')
    }

  } catch (error) {
    console.error('Error al enviar el formulario:', error)
    
    let errorMessage = 'Error al enviar el formulario. '
    
    if (error.message.includes('413') || error.message.includes('Content Too Large')) {
      errorMessage += 'El archivo es demasiado grande. Por favor, reduce el tamaño de tu CV a menos de 5MB.'
    } else if (error.message.includes('timeout')) {
      errorMessage += 'La conexión tardó demasiado. Verifica tu conexión a internet e intenta nuevamente.'
    } else if (error.message) {
      errorMessage += error.message
    } else {
      errorMessage += 'Por favor, intenta nuevamente.'
    }
    
    // Mostrar error al usuario
    alert(errorMessage)
    
  } finally {
    enviando.value = false
  }
}

// Eventos de drag and drop
onMounted(() => {
  const dropZone = document.querySelector('.border-dashed')
  if (dropZone) {
    dropZone.addEventListener('dragenter', () => {
      isDragging.value = true
    })

    dropZone.addEventListener('dragleave', (e) => {
      if (!dropZone.contains(e.relatedTarget)) {
        isDragging.value = false
      }
    })
  }
})
</script>
