<template>
  <div :class="waveClasses" :style="waveStyles">
    <svg 
      v-if="type === 'svg'" 
      :class="svgClasses" 
      xmlns="http://www.w3.org/2000/svg" 
      viewBox="0 0 1200 120" 
      preserveAspectRatio="none"
    >
      <path :d="pathData" :fill="fillColor" />
    </svg>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  // Tipo de onda
  variant: {
    type: String,
    default: 'fluid',
    validator: (value) => [
      'soft', 'dynamic', 'organic', 'fluid', 'mountain', 'elegant', 
      'gradient-primary', 'gradient-secondary', 'animated'
    ].includes(value)
  },
  
  // Posición (top o bottom)
  position: {
    type: String,
    default: 'bottom',
    validator: (value) => ['top', 'bottom'].includes(value)
  },
  
  // Tamaño
  size: {
    type: String,
    default: 'md',
    validator: (value) => ['sm', 'md', 'lg', 'xl'].includes(value)
  },
  
  // Color
  color: {
    type: String,
    default: 'white',
    validator: (value) => ['white', 'primary', 'secondary', 'gray'].includes(value)
  },
  
  // Usar SVG en lugar de CSS
  type: {
    type: String,
    default: 'css',
    validator: (value) => ['css', 'svg'].includes(value)
  },
  
  // Altura personalizada
  height: {
    type: String,
    default: null
  }
})

// Datos de path para diferentes variantes de SVG
const pathVariants = {
  soft: "M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z",
  dynamic: "M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z",
  organic: "M0,0V7.23C0,65.52,268.63,112.77,600,112.77S1200,65.52,1200,7.23V0Z",
  fluid: "M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z",
  mountain: "M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z",
  elegant: "M600,112.77C268.63,112.77,0,65.52,0,7.23V120H1200V7.23C1200,65.52,931.37,112.77,600,112.77Z"
}

// Colores para SVG
const colorMap = {
  white: '#ffffff',
  primary: '#e9b026',
  secondary: '#66c7cb',
  gray: '#f9fafb'
}

// Clases computadas
const waveClasses = computed(() => {
  const classes = []
  
  if (props.type === 'css') {
    // Usar clases CSS
    if (props.variant.includes('gradient')) {
      classes.push(`wave-${props.variant}`)
    } else {
      classes.push(`wave-${props.variant}`)
      if (props.position === 'top') {
        classes.push(`wave-${props.variant}-top`)
      }
      if (props.color !== 'white') {
        classes.push(`wave-${props.color}`)
      }
    }
  } else {
    // Usar SVG
    classes.push(`wave-divider-${props.position}`)
    classes.push(`wave-${props.size}`)
  }
  
  return classes.join(' ')
})

const svgClasses = computed(() => {
  return `wave-${props.size}`
})

const waveStyles = computed(() => {
  const styles = {}
  if (props.height) {
    styles.height = props.height
  }
  return styles
})

const pathData = computed(() => {
  return pathVariants[props.variant] || pathVariants.fluid
})

const fillColor = computed(() => {
  return colorMap[props.color] || colorMap.white
})
</script>

<style scoped>
/* Estilos específicos del componente si son necesarios */
</style>