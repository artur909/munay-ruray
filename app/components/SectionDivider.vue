<template>
  <div :class="dividerClasses" :style="dividerStyles">
    <svg 
      xmlns="http://www.w3.org/2000/svg" 
      viewBox="0 0 1200 120" 
      preserveAspectRatio="none"
      :class="svgClasses"
    >
      <path :d="pathData" :fill="fillColor" />
    </svg>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  // Tipo de forma
  type: {
    type: String,
    default: 'wave1',
    validator: (value) => [
      'wave1', 'wave2', 'wave3', 'wave4', 'wave5', 
      'curve1', 'curve2', 'organic1', 'organic2', 'organic3'
    ].includes(value)
  },
  
  // Color de la forma (el relleno del SVG)
  color: {
    type: String,
    default: 'white',
    validator: (value) => ['white', 'primary', 'secondary', 'gray', 'transparent'].includes(value)
  },
  
  // Color de fondo del contenedor (opcional)
  backgroundColor: {
    type: String,
    default: 'transparent',
    validator: (value) => ['transparent', 'white', 'primary', 'secondary', 'gray'].includes(value)
  },
  
  // Posición (superior o inferior)
  position: {
    type: String,
    default: 'bottom',
    validator: (value) => ['top', 'bottom'].includes(value)
  },
  
  // Altura del divisor
  height: {
    type: String,
    default: '60px'
  },
  
  // Flip horizontal (para más variedad)
  flip: {
    type: Boolean,
    default: false
  }
})

// Definir los paths para cada tipo de forma
const shapePaths = {
  // Ondas clásicas - perfectas para separar secciones
  wave1: "M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z",
  
  // Onda suave - ideal para transiciones elegantes
  wave2: "M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z",
  
  // Onda dinámica - para secciones con energía
  wave3: "M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z",
  
  // Onda compleja - para secciones destacadas
  wave4: "M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z",
  
  // Onda minimalista - para diseños limpios
  wave5: "M0,0V7.23C0,65.52,268.63,112.77,600,112.77S1200,65.52,1200,7.23V0Z",
  
  // Curva elegante - perfecta para CTAs
  curve1: "M600,112.77C268.63,112.77,0,65.52,0,7.23V120H1200V7.23C1200,65.52,931.37,112.77,600,112.77Z",
  
  // Curva geométrica - para diseños modernos
  curve2: "M0,60L50,50C100,40,200,20,300,26.7C400,33,500,67,600,80C700,93,800,87,900,70C1000,53,1100,27,1150,13.3L1200,0V120H1150C1100,120,1000,120,900,120C800,120,700,120,600,120C500,120,400,120,300,120C200,120,100,120,50,120L0,120Z",
  
  // Forma orgánica suave - estilo Munay Ruray
  organic1: "M0,40L48,46.7C96,53,192,67,288,73.3C384,80,480,80,576,70C672,60,768,40,864,33.3C960,27,1056,33,1152,46.7C1200,60,1248,80,1272,90L1296,100V120H1248C1200,120,1104,120,1008,120C912,120,816,120,720,120C624,120,528,120,432,120C336,120,240,120,144,120C48,120,0,120,0,120Z",
  
  // Forma orgánica irregular - para variedad
  organic2: "M0,80L48,73.3C96,67,192,53,288,50C384,47,480,53,576,66.7C672,80,768,100,864,93.3C960,87,1056,53,1152,40C1200,27,1248,33,1272,36.7L1296,40V120H1248C1200,120,1104,120,1008,120C912,120,816,120,720,120C624,120,528,120,432,120C336,120,240,120,144,120C48,120,0,120,0,120Z",
  
  // Forma orgánica fluida - muy natural
  organic3: "M0,50L48,56.7C96,63,192,77,288,83.3C384,90,480,90,576,83.3C672,77,768,63,864,56.7C960,50,1056,50,1152,56.7C1200,63,1248,77,1272,83.3L1296,90V120H1248C1200,120,1104,120,1008,120C912,120,816,120,720,120C624,120,528,120,432,120C336,120,240,120,144,120C48,120,0,120,0,120Z"
}

// Mapeo de colores
const colorMap = {
  white: '#ffffff',
  primary: '#e9b026',
  secondary: '#66c7cb',
  gray: '#f9fafb',
  transparent: 'transparent'
}

const backgroundColorMap = {
  transparent: 'transparent',
  white: '#ffffff',
  primary: '#e9b026',
  secondary: '#66c7cb',
  gray: '#f9fafb'
}

// Clases computadas para el contenedor
const dividerClasses = computed(() => {
  const classes = ['section-divider']
  classes.push(`divider-${props.position}`)
  return classes.join(' ')
})

// Estilos del contenedor
const dividerStyles = computed(() => {
  return {
    height: props.height,
    backgroundColor: backgroundColorMap[props.backgroundColor] || 'transparent'
  }
})

// Clases para el SVG
const svgClasses = computed(() => {
  const classes = ['divider-svg']
  
  // Rotación para posición superior
  if (props.position === 'top') {
    classes.push('rotate-180')
  }
  
  // Flip horizontal para más variedad
  if (props.flip) {
    classes.push('scale-x-[-1]')
  }
  
  return classes.join(' ')
})

// Path de la forma
const pathData = computed(() => {
  return shapePaths[props.type] || shapePaths.wave1
})

// Color de relleno
const fillColor = computed(() => {
  return colorMap[props.color] || colorMap.white
})
</script>

<style scoped>
.section-divider {
  position: absolute;
  left: 0;
  width: 100%;
  overflow: hidden;
  line-height: 0;
  z-index: 1;
}

.divider-top {
  top: 0;
}

.divider-bottom {
  bottom: 0;
}

.divider-svg {
  position: relative;
  display: block;
  width: calc(100% + 1.3px);
  height: 100%;
}

.rotate-180 {
  transform: rotate(180deg);
}

/* Responsive */
@media (max-width: 768px) {
  .section-divider {
    height: 40px !important;
  }
}

@media (max-width: 480px) {
  .section-divider {
    height: 30px !important;
  }
}
</style>