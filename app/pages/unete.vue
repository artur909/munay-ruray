<template>
  <div>
    <!-- Hero Section -->
    <section class="relative py-24 bg-rich-black">
      <div class="container relative z-10 text-white">
        <h1 class="font-display text-center mb-6">Únete a Munay Ruray</h1>
        <p class="text-xl md:text-2xl text-center max-w-3xl mx-auto">
          Sé parte del cambio que quieres ver en el mundo
        </p>
      </div>
    </section>

    <!-- Formulario de Postulación -->
    <section class="section bg-antiflash-white">
      <div class="container max-w-3xl">
        <div class="bg-white rounded-2xl p-8 md:p-12 shadow-sm">
          <form @submit.prevent="enviarFormulario" class="space-y-8">
            <!-- Datos Personales -->
            <div class="space-y-6">
              <h2 class="text-2xl font-bold">Datos Personales</h2>
              
              <div class="grid md:grid-cols-2 gap-6">
                <div>
                  <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                    Nombre completo *
                  </label>
                  <input
                    type="text"
                    id="nombre"
                    v-model="formData.nombre"
                    required
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-turquoise focus:ring-2 focus:ring-turquoise/20 outline-none transition-colors"
                    :class="{ 'border-red-500': errors.nombre }"
                  />
                  <p v-if="errors.nombre" class="mt-1 text-sm text-red-500">
                    {{ errors.nombre }}
                  </p>
                </div>

                <div>
                  <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Correo electrónico *
                  </label>
                  <input
                    type="email"
                    id="email"
                    v-model="formData.email"
                    required
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-turquoise focus:ring-2 focus:ring-turquoise/20 outline-none transition-colors"
                    :class="{ 'border-red-500': errors.email }"
                  />
                  <p v-if="errors.email" class="mt-1 text-sm text-red-500">
                    {{ errors.email }}
                  </p>
                </div>

                <div>
                  <label for="telefono" class="block text-sm font-medium text-gray-700 mb-2">
                    Teléfono *
                  </label>
                  <input
                    type="tel"
                    id="telefono"
                    v-model="formData.telefono"
                    required
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-turquoise focus:ring-2 focus:ring-turquoise/20 outline-none transition-colors"
                    :class="{ 'border-red-500': errors.telefono }"
                  />
                  <p v-if="errors.telefono" class="mt-1 text-sm text-red-500">
                    {{ errors.telefono }}
                  </p>
                </div>

                <div>
                  <label for="universidad" class="block text-sm font-medium text-gray-700 mb-2">
                    Universidad y carrera *
                  </label>
                  <input
                    type="text"
                    id="universidad"
                    v-model="formData.universidad"
                    required
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-turquoise focus:ring-2 focus:ring-turquoise/20 outline-none transition-colors"
                    :class="{ 'border-red-500': errors.universidad }"
                  />
                  <p v-if="errors.universidad" class="mt-1 text-sm text-red-500">
                    {{ errors.universidad }}
                  </p>
                </div>

                <div>
                  <label for="anioEstudios" class="block text-sm font-medium text-gray-700 mb-2">
                    Año de estudios *
                  </label>
                  <select
                    id="anioEstudios"
                    v-model="formData.anioEstudios"
                    required
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-turquoise focus:ring-2 focus:ring-turquoise/20 outline-none transition-colors"
                    :class="{ 'border-red-500': errors.anioEstudios }"
                  >
                    <option value="">Selecciona un año</option>
                    <option v-for="anio in 5" :key="anio" :value="anio">
                      {{ anio }}° año
                    </option>
                  </select>
                  <p v-if="errors.anioEstudios" class="mt-1 text-sm text-red-500">
                    {{ errors.anioEstudios }}
                  </p>
                </div>

                <div>
                  <label for="disponibilidad" class="block text-sm font-medium text-gray-700 mb-2">
                    Disponibilidad horaria *
                  </label>
                  <select
                    id="disponibilidad"
                    v-model="formData.disponibilidad"
                    required
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-turquoise focus:ring-2 focus:ring-turquoise/20 outline-none transition-colors"
                    :class="{ 'border-red-500': errors.disponibilidad }"
                  >
                    <option value="">Selecciona tu disponibilidad</option>
                    <option value="manana">Mañana</option>
                    <option value="tarde">Tarde</option>
                    <option value="fines">Fines de semana</option>
                    <option value="flexible">Flexible</option>
                  </select>
                  <p v-if="errors.disponibilidad" class="mt-1 text-sm text-red-500">
                    {{ errors.disponibilidad }}
                  </p>
                </div>
              </div>

              <div>
                <label for="motivacion" class="block text-sm font-medium text-gray-700 mb-2">
                  ¿Por qué quieres participar? *
                </label>
                <textarea
                  id="motivacion"
                  v-model="formData.motivacion"
                  required
                  rows="4"
                  class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-turquoise focus:ring-2 focus:ring-turquoise/20 outline-none transition-colors"
                  :class="{ 'border-red-500': errors.motivacion }"
                ></textarea>
                <p v-if="errors.motivacion" class="mt-1 text-sm text-red-500">
                  {{ errors.motivacion }}
                </p>
              </div>

              <div class="flex items-start">
                <div class="flex items-center h-5">
                  <input
                    id="terminos"
                    type="checkbox"
                    v-model="formData.terminos"
                    required
                    class="w-4 h-4 text-turquoise border-gray-300 rounded focus:ring-turquoise"
                    :class="{ 'border-red-500': errors.terminos }"
                  />
                </div>
                <label for="terminos" class="ml-3 text-sm text-gray-600">
                  Acepto los términos y condiciones del programa *
                </label>
              </div>
              <p v-if="errors.terminos" class="mt-1 text-sm text-red-500">
                {{ errors.terminos }}
              </p>
            </div>

            <div class="pt-6">
              <button
                type="submit"
                class="w-full btn-primary"
                :disabled="enviando"
              >
                {{ enviando ? 'Enviando...' : 'Postular' }}
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
          <div class="w-16 h-16 bg-turquoise/10 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-turquoise" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
          </div>
          <h3 class="text-2xl font-bold mb-4">¡Postulación enviada!</h3>
          <p class="text-gray-600 mb-6">
            Gracias por tu interés en Munay Ruray. Hemos recibido tu postulación y te contactaremos pronto.
          </p>
          <button
            @click="modalExito = false"
            class="btn-primary"
          >
            Entendido
          </button>
        </div>
      </div>
    </Teleport>
  </div>
</template>

<script setup>
const formData = ref({
  nombre: '',
  email: '',
  telefono: '',
  universidad: '',
  anioEstudios: '',
  disponibilidad: '',
  motivacion: '',
  terminos: false
})

const errors = ref({})
const enviando = ref(false)
const modalExito = ref(false)

const validarFormulario = () => {
  const nuevosErrores = {}
  
  if (!formData.value.nombre) {
    nuevosErrores.nombre = 'El nombre es requerido'
  }
  
  if (!formData.value.email) {
    nuevosErrores.email = 'El correo electrónico es requerido'
  } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(formData.value.email)) {
    nuevosErrores.email = 'Ingresa un correo electrónico válido'
  }
  
  if (!formData.value.telefono) {
    nuevosErrores.telefono = 'El teléfono es requerido'
  }
  
  if (!formData.value.universidad) {
    nuevosErrores.universidad = 'La universidad y carrera son requeridas'
  }
  
  if (!formData.value.anioEstudios) {
    nuevosErrores.anioEstudios = 'El año de estudios es requerido'
  }
  
  if (!formData.value.disponibilidad) {
    nuevosErrores.disponibilidad = 'La disponibilidad horaria es requerida'
  }
  
  if (!formData.value.motivacion) {
    nuevosErrores.motivacion = 'Este campo es requerido'
  }
  
  if (!formData.value.terminos) {
    nuevosErrores.terminos = 'Debes aceptar los términos y condiciones'
  }
  
  errors.value = nuevosErrores
  return Object.keys(nuevosErrores).length === 0
}

const enviarFormulario = async () => {
  if (!validarFormulario()) {
    return
  }

  enviando.value = true
  
  try {
    // Aquí iría la lógica de envío del formulario
    await new Promise(resolve => setTimeout(resolve, 2000)) // Simulación de envío
    
    modalExito.value = true
    formData.value = {
      nombre: '',
      email: '',
      telefono: '',
      universidad: '',
      anioEstudios: '',
      disponibilidad: '',
      motivacion: '',
      terminos: false
    }
  } catch (error) {
    console.error('Error al enviar el formulario:', error)
  } finally {
    enviando.value = false
  }
}
</script>
