<template>
  <div>
    <!-- Hero -->
    <section class="py-16 bg-primary text-white text-center">
      <div class="container">
        <h1 class="text-4xl font-bold mb-4">SectionDivider - Demo</h1>
        <p class="text-xl">Todas las formas disponibles para separar secciones</p>
      </div>
      <SectionDivider type="wave1" color="white" position="bottom" height="80px" />
    </section>

    <!-- Wave 1 -->
    <section class="py-12 bg-white text-center relative">
      <div class="container">
        <h2 class="text-2xl font-bold mb-2">Wave 1 - Clásica</h2>
        <p class="text-gray-600">Onda fluida perfecta para separar secciones</p>
        <code class="text-sm bg-gray-100 px-2 py-1 rounded">type="wave1"</code>
      </div>
      <SectionDivider type="wave2" color="gray" position="bottom" height="70px" />
    </section>

    <!-- Wave 2 -->
    <section class="py-12 bg-gray-50 text-center relative">
      <div class="container">
        <h2 class="text-2xl font-bold mb-2">Wave 2 - Suave</h2>
        <p class="text-gray-600">Ideal para transiciones elegantes</p>
        <code class="text-sm bg-white px-2 py-1 rounded">type="wave2"</code>
      </div>
      <SectionDivider type="wave3" color="secondary" position="bottom" height="75px" />
    </section>

    <!-- Wave 3 -->
    <section class="py-12 bg-white text-center relative">
      <div class="container">
        <h2 class="text-2xl font-bold mb-2">Wave 3 - Dinámica</h2>
        <p class="text-gray-600">Para secciones con energía</p>
        <code class="text-sm bg-gray-100 px-2 py-1 rounded">type="wave3"</code>
      </div>
      <SectionDivider type="wave4" color="primary" position="bottom" height="90px" />
    </section>

    <!-- Wave 4 -->
    <section class="py-12 bg-white text-center relative">
      <div class="container">
        <h2 class="text-2xl font-bold mb-2">Wave 4 - Compleja</h2>
        <p class="text-gray-600">Para secciones destacadas</p>
        <code class="text-sm bg-gray-100 px-2 py-1 rounded">type="wave4"</code>
      </div>
      <SectionDivider type="wave5" color="gray" position="bottom" height="60px" />
    </section>

    <!-- Wave 5 -->
    <section class="py-12 bg-gray-50 text-center relative">
      <div class="container">
        <h2 class="text-2xl font-bold mb-2">Wave 5 - Minimalista</h2>
        <p class="text-gray-600">Para diseños limpios</p>
        <code class="text-sm bg-white px-2 py-1 rounded">type="wave5"</code>
      </div>
      <SectionDivider type="curve1" color="white" position="bottom" height="80px" />
    </section>

    <!-- Curve 1 -->
    <section class="py-12 bg-white text-center relative">
      <div class="container">
        <h2 class="text-2xl font-bold mb-2">Curve 1 - Elegante</h2>
        <p class="text-gray-600">Perfecta para CTAs</p>
        <code class="text-sm bg-gray-100 px-2 py-1 rounded">type="curve1"</code>
      </div>
      <SectionDivider type="curve2" color="secondary" position="bottom" height="70px" />
    </section>

    <!-- Curve 2 -->
    <section class="py-12 bg-white text-center relative">
      <div class="container">
        <h2 class="text-2xl font-bold mb-2">Curve 2 - Geométrica</h2>
        <p class="text-gray-600">Para diseños modernos</p>
        <code class="text-sm bg-gray-100 px-2 py-1 rounded">type="curve2"</code>
      </div>
      <SectionDivider type="organic1" color="primary" position="bottom" height="75px" />
    </section>

    <!-- Organic 1 -->
    <section class="py-12 bg-white text-center relative">
      <div class="container">
        <h2 class="text-2xl font-bold mb-2">Organic 1 - Suave</h2>
        <p class="text-gray-600">Estilo Munay Ruray</p>
        <code class="text-sm bg-gray-100 px-2 py-1 rounded">type="organic1"</code>
      </div>
      <SectionDivider type="organic2" color="gray" position="bottom" height="70px" />
    </section>

    <!-- Organic 2 -->
    <section class="py-12 bg-gray-50 text-center relative">
      <div class="container">
        <h2 class="text-2xl font-bold mb-2">Organic 2 - Irregular</h2>
        <p class="text-gray-600">Para variedad</p>
        <code class="text-sm bg-white px-2 py-1 rounded">type="organic2"</code>
      </div>
      <SectionDivider type="organic3" color="secondary" position="bottom" height="80px" />
    </section>

    <!-- Organic 3 -->
    <section class="py-12 bg-white text-center relative">
      <div class="container">
        <h2 class="text-2xl font-bold mb-2">Organic 3 - Fluida</h2>
        <p class="text-gray-600">Muy natural</p>
        <code class="text-sm bg-gray-100 px-2 py-1 rounded">type="organic3"</code>
      </div>
      <SectionDivider type="wave1" color="primary" position="bottom" height="80px" />
    </section>

    <!-- Ejemplos con backgroundColor -->
    <section class="py-16 bg-white text-center relative">
      <div class="container">
        <h2 class="text-3xl font-bold mb-8">Ejemplos con backgroundColor</h2>
        
        <div class="grid md:grid-cols-2 gap-8 mb-12">
          <div class="bg-gray-100 p-6 rounded-lg">
            <h3 class="font-bold mb-2">Sin backgroundColor</h3>
            <code class="text-xs">color="primary"</code>
            <div class="mt-4 h-20 bg-white relative">
              <SectionDivider type="organic1" color="primary" position="bottom" height="60px" />
            </div>
          </div>
          
          <div class="bg-gray-100 p-6 rounded-lg">
            <h3 class="font-bold mb-2">Con backgroundColor</h3>
            <code class="text-xs">color="primary" backgroundColor="white"</code>
            <div class="mt-4 h-20 bg-gray-300 relative">
              <SectionDivider type="organic1" color="primary" backgroundColor="white" position="bottom" height="60px" />
            </div>
          </div>
        </div>

        <div class="grid md:grid-cols-2 gap-8">
          <div class="bg-gray-100 p-6 rounded-lg">
            <h3 class="font-bold mb-2">Forma Normal</h3>
            <code class="text-xs">:flip="false"</code>
            <div class="mt-4 h-20 bg-white relative">
              <SectionDivider type="organic2" color="secondary" position="bottom" height="60px" />
            </div>
          </div>
          
          <div class="bg-gray-100 p-6 rounded-lg">
            <h3 class="font-bold mb-2">Forma Volteada</h3>
            <code class="text-xs">:flip="true"</code>
            <div class="mt-4 h-20 bg-white relative">
              <SectionDivider type="organic2" color="secondary" position="bottom" height="60px" :flip="true" />
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <section class="py-16 bg-primary text-white text-center">
      <div class="container">
        <h2 class="text-2xl font-bold mb-4">¡Listo para usar!</h2>
        <p class="text-lg">Elige la forma que mejor se adapte a tu diseño</p>
      </div>
    </section>
  </div>
</template>

<script setup>
useHead({
  title: 'SectionDivider Demo - Munay Ruray',
  meta: [
    {
      name: 'description',
      content: 'Demostración de todas las formas disponibles en el componente SectionDivider'
    }
  ]
})
</script>