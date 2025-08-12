<template>
  <div class="organic-shapes-container">
    <div 
      v-for="(shape, index) in shapes" 
      :key="index"
      :class="getShapeClasses(shape, index)"
      :style="getShapeStyles(shape, index)"
    ></div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  // Número de formas a generar
  count: {
    type: Number,
    default: 3
  },
  
  // Colores disponibles
  colors: {
    type: Array,
    default: () => ['primary', 'secondary', 'white']
  },
  
  // Tamaños (en px)
  sizes: {
    type: Array,
    default: () => [120, 180, 250]
  },
  
  // Opacidades
  opacities: {
    type: Array,
    default: () => [0.04, 0.06, 0.08]
  },
  
  // Posiciones predefinidas o aleatorias
  positions: {
    type: Array,
    default: () => []
  },
  
  // Animación
  animated: {
    type: Boolean,
    default: true
  },
  
  // Z-index base
  zIndex: {
    type: Number,
    default: 0
  }
})

// Formas orgánicas predefinidas (border-radius)
const organicShapes = [
  '63% 37% 54% 46% / 55% 48% 52% 45%',
  '38% 62% 63% 37% / 70% 33% 67% 30%',
  '49% 51% 48% 52% / 62% 44% 56% 38%',
  '67% 33% 42% 58% / 48% 71% 29% 52%',
  '54% 46% 61% 39% / 35% 67% 33% 65%',
  '42% 58% 36% 64% / 59% 41% 59% 41%',
  '71% 29% 53% 47% / 44% 56% 44% 56%',
  '33% 67% 48% 52% / 68% 32% 68% 32%'
]

// Generar formas
const shapes = computed(() => {
  const result = []
  
  for (let i = 0; i < props.count; i++) {
    const shape = {
      id: i,
      color: props.colors[i % props.colors.length],
      size: props.sizes[i % props.sizes.length],
      opacity: props.opacities[i % props.opacities.length],
      borderRadius: organicShapes[i % organicShapes.length],
      position: props.positions[i] || generateRandomPosition(),
      animationDelay: i * 2,
      animationDuration: 8 + (i * 2)
    }
    result.push(shape)
  }
  
  return result
})

// Generar posición aleatoria
function generateRandomPosition() {
  return {
    top: Math.random() * 80 + 10, // 10% a 90%
    left: Math.random() * 80 + 10, // 10% a 90%
  }
}

// Obtener clases para cada forma
function getShapeClasses(shape, index) {
  const classes = ['organic-shape']
  
  if (props.animated) {
    classes.push('animate-float-organic')
  }
  
  return classes.join(' ')
}

// Obtener estilos para cada forma
function getShapeStyles(shape, index) {
  const colorMap = {
    primary: 'var(--color-primary)',
    secondary: 'var(--color-secondary)',
    white: '#ffffff',
    gray: '#f3f4f6'
  }
  
  return {
    position: 'absolute',
    width: `${shape.size}px`,
    height: `${shape.size}px`,
    background: colorMap[shape.color] || colorMap.primary,
    borderRadius: shape.borderRadius,
    opacity: shape.opacity,
    top: `${shape.position.top}%`,
    left: `${shape.position.left}%`,
    zIndex: props.zIndex,
    pointerEvents: 'none',
    animationDelay: `${shape.animationDelay}s`,
    animationDuration: `${shape.animationDuration}s`
  }
}
</script>

<style scoped>
.organic-shapes-container {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  overflow: hidden;
  pointer-events: none;
}

.organic-shape {
  will-change: transform;
}

/* Animación específica para formas orgánicas */
@keyframes float-organic-custom {
  0%, 100% { 
    transform: translate(0px, 0px) rotate(0deg) scale(1);
  }
  25% { 
    transform: translate(20px, -20px) rotate(90deg) scale(1.1);
  }
  50% { 
    transform: translate(-10px, 10px) rotate(180deg) scale(0.9);
  }
  75% { 
    transform: translate(-20px, -10px) rotate(270deg) scale(1.05);
  }
}

.animate-float-organic {
  animation: float-organic-custom ease-in-out infinite;
}
</style>