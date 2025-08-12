# SectionDivider - Guía de Uso

Componente simple para crear divisores ondulados entre secciones.

## Uso Básico

```vue
<SectionDivider type="wave1" color="white" position="bottom" height="60px" />
```

## Uso Avanzado con Color de Fondo

```vue
<SectionDivider 
  type="organic1" 
  color="primary" 
  backgroundColor="white"
  position="bottom" 
  height="80px" 
  :flip="true"
/>
```

## Propiedades

| Prop | Tipo | Default | Opciones | Descripción |
|------|------|---------|----------|-------------|
| `type` | String | 'wave1' | Ver tipos disponibles | Tipo de forma ondulada |
| `color` | String | 'white' | 'white', 'primary', 'secondary', 'gray', 'transparent' | Color del relleno del SVG |
| `backgroundColor` | String | 'transparent' | 'transparent', 'white', 'primary', 'secondary', 'gray' | Color de fondo del contenedor |
| `position` | String | 'bottom' | 'top', 'bottom' | Posición del divisor |
| `height` | String | '60px' | Cualquier valor CSS | Altura del divisor |
| `flip` | Boolean | false | true, false | Voltear horizontalmente para más variedad |

## Tipos de Formas Disponibles

### Ondas Básicas
- **`wave1`** - Onda fluida clásica
- **`wave2`** - Onda suave y elegante  
- **`wave3`** - Onda dinámica
- **`wave4`** - Onda compleja tipo montaña
- **`wave5`** - Onda simple y minimalista

### Curvas
- **`curve1`** - Curva elegante invertida
- **`curve2`** - Curva geométrica

### Formas Orgánicas
- **`organic1`** - Forma orgánica suave (estilo Munay Ruray)
- **`organic2`** - Forma orgánica irregular (para variedad)
- **`organic3`** - Forma orgánica fluida (muy natural)

## Ejemplos de Uso

### Divisor inferior básico
```vue
<section class="bg-primary text-white relative">
  <div class="container py-20">
    <h2>Mi Sección</h2>
  </div>
  <SectionDivider type="wave1" color="white" position="bottom" />
</section>
```

### Divisor superior
```vue
<section class="bg-gray-50 relative">
  <SectionDivider type="wave2" color="white" position="top" />
  <div class="container py-20">
    <h2>Mi Sección</h2>
  </div>
</section>
```

### Sección con divisores superior e inferior
```vue
<section class="bg-secondary text-white relative">
  <SectionDivider type="organic1" color="gray" position="top" height="80px" />
  
  <div class="container py-20">
    <h2>Mi Sección</h2>
  </div>
  
  <SectionDivider type="curve1" color="white" position="bottom" height="70px" />
</section>
```

### Diferentes alturas para responsive
```vue
<!-- Altura grande para desktop, se ajusta automáticamente en móvil -->
<SectionDivider type="wave4" color="primary" position="bottom" height="100px" />
```

### Control total de colores
```vue
<!-- Divisor primario sobre fondo blanco -->
<SectionDivider 
  type="organic1" 
  color="primary" 
  backgroundColor="white"
  position="bottom" 
  height="80px" 
/>

<!-- Divisor blanco sobre fondo primario -->
<SectionDivider 
  type="curve1" 
  color="white" 
  backgroundColor="primary"
  position="top" 
  height="70px" 
/>
```

### Usando flip para más variedad
```vue
<!-- Forma normal -->
<SectionDivider type="organic2" color="secondary" position="bottom" />

<!-- Misma forma pero volteada -->
<SectionDivider type="organic2" color="secondary" position="top" :flip="true" />
```

### Transiciones complejas entre secciones
```vue
<!-- Sección 1: Fondo primario -->
<section class="bg-primary text-white relative">
  <div class="container py-20">
    <h2>Sección Primaria</h2>
  </div>
  <!-- Divisor blanco que "corta" hacia la siguiente sección -->
  <SectionDivider 
    type="organic1" 
    color="white" 
    backgroundColor="transparent"
    position="bottom" 
    height="80px" 
  />
</section>

<!-- Sección 2: Fondo blanco -->
<section class="bg-white relative">
  <div class="container py-20">
    <h2>Sección Blanca</h2>
  </div>
  <!-- Divisor gris que prepara la siguiente sección -->
  <SectionDivider 
    type="wave3" 
    color="gray" 
    backgroundColor="transparent"
    position="bottom" 
    height="60px" 
  />
</section>

<!-- Sección 3: Fondo gris -->
<section class="bg-gray-50 relative">
  <div class="container py-20">
    <h2>Sección Gris</h2>
  </div>
</section>
```

## Colores Disponibles

- **`white`** - #ffffff (por defecto)
- **`primary`** - #e9b026 (amarillo Munay Ruray)
- **`secondary`** - #66c7cb (turquesa Munay Ruray)  
- **`gray`** - #f9fafb (gris claro)

## Recomendaciones de Uso

### Por tipo de sección:
- **Hero sections**: `organic1`, `wave4`, `curve1` con altura 80-100px
- **Contenido general**: `wave1`, `wave2`, `wave3` con altura 60-70px
- **CTAs importantes**: `organic2`, `curve2` con altura 70-80px
- **Footer**: `wave5`, `curve1` con altura 50-60px

### Combinaciones recomendadas:
1. **Fondo primario → Blanco**: `color="white"`
2. **Fondo blanco → Gris**: `color="gray"`  
3. **Fondo gris → Blanco**: `color="white"`
4. **Fondo secundario → Blanco**: `color="white"`

## Responsive

El componente es automáticamente responsive:
- **Desktop**: Altura especificada
- **Tablet (≤768px)**: Altura reducida a 40px
- **Móvil (≤480px)**: Altura reducida a 30px

## Ventajas de este componente

✅ **Simple y directo** - Solo 4 props necesarias
✅ **9 tipos de formas** diferentes
✅ **4 colores** predefinidos del tema
✅ **Automáticamente responsive**
✅ **Fácil de usar** - Una línea de código
✅ **Consistente** con el diseño de Munay Ruray
✅ **Sin interferencias** con otros elementos