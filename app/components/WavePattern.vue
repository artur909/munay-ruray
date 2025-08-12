<template>
  <div :class="containerClasses" :style="containerStyles">
    <svg 
      class="wave-pattern-svg" 
      :width="width" 
      :height="height" 
      viewBox="0 0 1200 600" 
      preserveAspectRatio="none"
    >
      <defs>
        <linearGradient :id="`gradient-${uniqueId}`" x1="0%" y1="0%" x2="100%" y2="100%">
          <stop offset="0%" :stop-color="gradientStart" :stop-opacity="startOpacity" />
          <stop offset="100%" :stop-color="gradientEnd" :stop-opacity="endOpacity" />
        </linearGradient>
        
        <!-- Filtros para efectos -->
        <filter :id="`blur-${uniqueId}`" x="-50%" y="-50%" width="200%" height="200%">
          <feGaussianBlur in="SourceGraphic" :stdDeviation="blurAmount" />
        </filter>
      </defs>
      
      <!-- Múltiples capas de ondas -->
      <g v-for="(layer, index) in layers" :key="index">
        <path 
          :d="layer.path" 
          :fill="layer.fill"
          :opacity="layer.opacity"
          :filter="layer.blur ? `url(#blur-${uniqueId})` : ''"
          :class="layer.animated ? 'wave-animated-path' : ''"
          :style="{ 
            animationDelay: `${layer.animationDelay}s`,
            animationDuration: `${layer.animationDuration}s`
          }"
        />
      </g>
    </svg>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue'

const props = defineProps({
  // Tipo de patrón
  pattern: {
    type: String,
    default: 'layered',
    validator: (value) => ['layered', 'flowing', 'organic', 'geometric', 'abstract'].includes(value)
  },
  
  // Colores
  primaryColor: {
    type: String,
    default: '#e9b026'
  },
  
  secondaryColor: {
    type: String,
    default: '#66c7cb'
  },
  
  // Dimensiones
  width: {
    type: String,
    default: '100%'
  },
  
  height: {
    type: String,
    default: '400px'
  },
  
  // Posición
  position: {
    type: String,
    default: 'absolute',
    validator: (value) => ['absolute', 'relative', 'fixed'].includes(value)
  },
  
  // Z-index
  zIndex: {
    type: Number,
    default: -1
  },
  
  // Animación
  animated: {
    type: Boolean,
    default: true
  },
  
  // Opacidad general
  opacity: {
    type: Number,
    default: 0.1
  },
  
  // Efecto blur
  blurAmount: {
    type: Number,
    default: 0
  }
})

// ID único para evitar conflictos
const uniqueId = ref(Math.random().toString(36).substr(2, 9))

// Patrones de ondas predefinidos
const wavePatterns = {
  layered: [
    {
      path: "M0,300 C300,200 600,400 1200,250 L1200,600 L0,600 Z",
      fill: `url(#gradient-${uniqueId.value})`,
      opacity: 0.3,
      animated: true,
      animationDelay: 0,
      animationDuration: 20,
      blur: false
    },
    {
      path: "M0,350 C400,250 800,450 1200,300 L1200,600 L0,600 Z",
      fill: props.secondaryColor,
      opacity: 0.2,
      animated: true,
      animationDelay: 5,
      animationDuration: 25,
      blur: false
    },
    {
      path: "M0,400 C200,300 1000,500 1200,350 L1200,600 L0,600 Z",
      fill: props.primaryColor,
      opacity: 0.15,
      animated: true,
      animationDelay: 10,
      animationDuration: 30,
      blur: true
    }
  ],
  
  flowing: [
    {
      path: "M0,200 Q300,100 600,200 T1200,150 L1200,600 L0,600 Z",
      fill: `url(#gradient-${uniqueId.value})`,
      opacity: 0.4,
      animated: true,
      animationDelay: 0,
      animationDuration: 15,
      blur: false
    },
    {
      path: "M0,300 Q400,200 800,300 T1200,250 L1200,600 L0,600 Z",
      fill: props.secondaryColor,
      opacity: 0.25,
      animated: true,
      animationDelay: 3,
      animationDuration: 18,
      blur: false
    }
  ],
  
  organic: [
    {
      path: "M0,250 C150,150 300,350 450,250 C600,150 750,350 900,250 C1050,150 1200,350 1200,250 L1200,600 L0,600 Z",
      fill: props.primaryColor,
      opacity: 0.2,
      animated: true,
      animationDelay: 0,
      animationDuration: 25,
      blur: false
    },
    {
      path: "M0,350 C200,250 400,450 600,350 C800,250 1000,450 1200,350 L1200,600 L0,600 Z",
      fill: props.secondaryColor,
      opacity: 0.15,
      animated: true,
      animationDelay: 8,
      animationDuration: 30,
      blur: true
    }
  ],
  
  geometric: [
    {
      path: "M0,300 L200,200 L400,300 L600,200 L800,300 L1000,200 L1200,300 L1200,600 L0,600 Z",
      fill: props.primaryColor,
      opacity: 0.3,
      animated: false,
      animationDelay: 0,
      animationDuration: 0,
      blur: false
    },
    {
      path: "M0,400 L300,300 L600,400 L900,300 L1200,400 L1200,600 L0,600 Z",
      fill: props.secondaryColor,
      opacity: 0.2,
      animated: false,
      animationDelay: 0,
      animationDuration: 0,
      blur: false
    }
  ],
  
  abstract: [
    {
      path: "M0,200 C100,100 200,300 400,200 C500,150 700,250 800,200 C900,150 1100,300 1200,200 L1200,600 L0,600 Z",
      fill: `url(#gradient-${uniqueId.value})`,
      opacity: 0.35,
      animated: true,
      animationDelay: 0,
      animationDuration: 20,
      blur: false
    },
    {
      path: "M0,350 C200,250 300,450 500,350 C700,250 800,450 1000,350 C1100,300 1200,400 1200,350 L1200,600 L0,600 Z",
      fill: props.secondaryColor,
      opacity: 0.2,
      animated: true,
      animationDelay: 7,
      animationDuration: 28,
      blur: true
    }
  ]
}

// Capas computadas
const layers = computed(() => {
  return wavePatterns[props.pattern] || wavePatterns.layered
})

// Colores de gradiente
const gradientStart = computed(() => props.primaryColor)
const gradientEnd = computed(() => props.secondaryColor)
const startOpacity = computed(() => props.opacity * 2)
const endOpacity = computed(() => props.opacity)

// Clases del contenedor
const containerClasses = computed(() => {
  const classes = ['wave-pattern-container']
  if (props.animated) {
    classes.push('wave-pattern-animated')
  }
  return classes.join(' ')
})

// Estilos del contenedor
const containerStyles = computed(() => {
  return {
    position: props.position,
    top: 0,
    left: 0,
    width: '100%',
    height: '100%',
    zIndex: props.zIndex,
    pointerEvents: 'none',
    opacity: props.opacity
  }
})
</script>

<style scoped>
.wave-pattern-container {
  overflow: hidden;
}

.wave-pattern-svg {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.wave-animated-path {
  animation: wave-morph ease-in-out infinite;
}

@keyframes wave-morph {
  0%, 100% {
    d: path("M0,300 C300,200 600,400 1200,250 L1200,600 L0,600 Z");
  }
  25% {
    d: path("M0,250 C350,150 650,350 1200,200 L1200,600 L0,600 Z");
  }
  50% {
    d: path("M0,350 C250,250 550,450 1200,300 L1200,600 L0,600 Z");
  }
  75% {
    d: path("M0,280 C400,180 700,380 1200,230 L1200,600 L0,600 Z");
  }
}

/* Animación de flujo horizontal */
@keyframes wave-flow-horizontal {
  0% {
    transform: translateX(0);
  }
  100% {
    transform: translateX(-50px);
  }
}

.wave-pattern-animated .wave-animated-path {
  animation: wave-flow-horizontal linear infinite;
}
</style>