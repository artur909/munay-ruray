<template>
  <NuxtLayout>
    <NuxtPage />
  </NuxtLayout>
</template>

<script setup>
// Configuración de metadatos globales
useHead({
  titleTemplate: '%s - Munay Ruray',
  meta: [
    { charset: 'utf-8' },
    { name: 'viewport', content: 'width=device-width, initial-scale=1' },
    {
      name: 'description',
      content: 'Munay Ruray - Programa de voluntariado universitario que genera impacto social, cultural, ambiental y digital'
    }
  ],
  link: [
    {
      rel: 'stylesheet',
      href: 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Manrope:wght@700;800&family=Poppins:ital,wght@0,700;0,800;1,300&display=swap'
    }
  ]
})
</script>

<style>
/* @import '@/assets/css/main.css'; */


</style>