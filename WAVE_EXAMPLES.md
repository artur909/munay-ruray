# Sistema de Formas Onduladas - Munay Ruray

Este documento muestra todas las variantes de formas onduladas disponibles para usar en la web de Munay Ruray.

## Componente WaveDivider

### Uso básico
```vue
<WaveDivider variant="fluid" position="bottom" color="white" />
```

### Propiedades disponibles

| Prop | Tipo | Default | Opciones | Descripción |
|------|------|---------|----------|-------------|
| `variant` | String | 'fluid' | 'soft', 'dynamic', 'organic', 'fluid', 'mountain', 'elegant', 'gradient-primary', 'gradient-secondary', 'animated' | Tipo de forma ondulada |
| `position` | String | 'bottom' | 'top', 'bottom' | Posición del divisor |
| `size` | String | 'md' | 'sm', 'md', 'lg', 'xl' | Altura de la onda |
| `color` | String | 'white' | 'white', 'primary', 'secondary', 'gray' | Color de relleno |
| `type` | String | 'css' | 'css', 'svg' | Método de renderizado |
| `height` | String | null | Cualquier valor CSS | Altura personalizada |

## Variantes disponibles

### 1. Soft (Suave)
Onda suave y elegante, perfecta para transiciones sutiles.
```vue
<WaveDivider variant="soft" position="bottom" color="white" />
```

### 2. Dynamic (Dinámica)
Onda con más movimiento, ideal para secciones energéticas.
```vue
<WaveDivider variant="dynamic" position="bottom" color="primary" />
```

### 3. Organic (Orgánica)
Forma muy natural y orgánica, perfecta para el estilo Munay Ruray.
```vue
<WaveDivider variant="organic" position="bottom" color="secondary" />
```

### 4. Fluid (Fluida)
La onda más versátil, funciona bien en cualquier contexto.
```vue
<WaveDivider variant="fluid" position="bottom" color="white" />
```

### 5. Mountain (Montañosa)
Onda compleja que simula montañas, ideal para secciones destacadas.
```vue
<WaveDivider variant="mountain" position="bottom" color="gray" />
```

### 6. Elegant (Elegante)
Curva simple y elegante, perfecta para diseños minimalistas.
```vue
<WaveDivider variant="elegant" position="bottom" color="white" />
```

### 7. Gradient Primary
Onda con gradiente usando el color primario.
```vue
<WaveDivider variant="gradient-primary" position="bottom" />
```

### 8. Gradient Secondary
Onda con gradiente usando el color secundario.
```vue
<WaveDivider variant="gradient-secondary" position="bottom" />
```

### 9. Animated (Animada)
Onda con animación de flujo continuo.
```vue
<WaveDivider variant="animated" position="bottom" color="white" />
```

## Clases CSS directas

También puedes usar las clases CSS directamente en tus elementos:

### Para la parte inferior de secciones:
```html
<section class="wave-soft bg-primary">
  <!-- Contenido -->
</section>

<section class="wave-dynamic bg-secondary">
  <!-- Contenido -->
</section>

<section class="wave-organic bg-white">
  <!-- Contenido -->
</section>
```

### Para la parte superior de secciones:
```html
<section class="wave-soft-top bg-primary">
  <!-- Contenido -->
</section>

<section class="wave-dynamic-top bg-secondary">
  <!-- Contenido -->
</section>
```

### Con colores específicos:
```html
<section class="wave-fluid wave-primary">
  <!-- Onda con color primario -->
</section>

<section class="wave-elegant wave-secondary">
  <!-- Onda con color secundario -->
</section>
```

### Ondas animadas:
```html
<section class="wave-animated bg-primary">
  <!-- Onda con animación de flujo -->
</section>
```

## Ejemplos de uso en secciones

### Hero con onda inferior
```vue
<template>
  <section class="hero-section bg-primary text-white">
    <div class="container">
      <h1>Título del Hero</h1>
      <p>Descripción</p>
    </div>
    <WaveDivider variant="organic" position="bottom" color="white" size="lg" />
  </section>
</template>
```

### Sección intermedia con ondas superior e inferior
```vue
<template>
  <section class="content-section bg-gray-50 relative">
    <WaveDivider variant="soft" position="top" color="gray" />
    
    <div class="container py-20">
      <h2>Contenido de la sección</h2>
      <p>Texto de la sección</p>
    </div>
    
    <WaveDivider variant="dynamic" position="bottom" color="white" />
  </section>
</template>
```

### CTA final con onda animada
```vue
<template>
  <section class="cta-section bg-secondary text-white relative">
    <WaveDivider variant="animated" position="top" color="secondary" />
    
    <div class="container py-16">
      <h2>Llamada a la acción</h2>
      <button class="btn-primary">Actuar ahora</button>
    </div>
  </section>
</template>
```

## Recomendaciones de uso

### Por tipo de sección:
- **Hero**: `organic`, `mountain`, `dynamic` (tamaño lg o xl)
- **Contenido**: `soft`, `elegant`, `fluid` (tamaño md)
- **CTA**: `animated`, `gradient-primary`, `gradient-secondary` (tamaño lg)
- **Footer**: `soft`, `elegant` (tamaño sm o md)

### Por color de fondo:
- **Fondo blanco**: Usar ondas `primary`, `secondary`, o `gray`
- **Fondo primario**: Usar ondas `white` o `secondary`
- **Fondo secundario**: Usar ondas `white` o `primary`
- **Fondo gris**: Usar ondas `white`, `primary`, o `secondary`

### Combinaciones recomendadas:
1. `variant="organic"` + `color="primary"` + `size="lg"` - Para heroes impactantes
2. `variant="soft"` + `color="white"` + `size="md"` - Para transiciones suaves
3. `variant="animated"` + `color="secondary"` + `size="lg"` - Para CTAs dinámicos
4. `variant="elegant"` + `color="gray"` + `size="sm"` - Para footers minimalistas

## Personalización adicional

### Altura personalizada:
```vue
<WaveDivider variant="fluid" height="150px" />
```

### Usando SVG para mayor control:
```vue
<WaveDivider variant="organic" type="svg" color="primary" size="xl" />
```

### Combinando con formas orgánicas de fondo:
```vue
<template>
  <section class="relative bg-primary section-with-shapes">
    <div class="container">
      <!-- Contenido -->
    </div>
    <WaveDivider variant="organic" position="bottom" color="white" size="lg" />
  </section>
</template>
```

Este sistema te proporciona una amplia variedad de formas onduladas que mantienen la coherencia visual de Munay Ruray mientras ofrecen flexibilidad para diferentes contextos y necesidades de diseño.