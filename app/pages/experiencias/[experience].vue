<template>
  <div class="min-h-screen bg-white">
    <!-- Loading State -->
    <div v-if="loading" class="min-h-screen flex items-center justify-center">
      <div class="text-center">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary mx-auto mb-4"></div>
        <p class="text-gray-600">Cargando experiencia...</p>
      </div>
    </div>

    <!-- Not Found State -->
    <div v-else-if="notFound || !experience" class="min-h-screen flex items-center justify-center">
      <div class="text-center max-w-md mx-auto px-4">
        <svg class="w-24 h-24 text-gray-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <h1 class="text-2xl font-bold text-gray-900 mb-4">Experiencia no encontrada</h1>
        <p class="text-gray-600 mb-8">La experiencia que buscas no existe o ha sido eliminada.</p>
        <nuxt-link to="/experiencias" class="cta-enhanced">
          <span>Ver todas las experiencias</span>
          <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
          </svg>
        </nuxt-link>
      </div>
    </div>

    <!-- Hero Section - Consistente con el diseño principal -->
    <section v-else class="relative min-h-screen overflow-hidden">
      <!-- Imagen de fondo -->
      <div class="absolute inset-0 z-0">
        <img :src="experience.cover" :alt="experience.title" class="w-full h-full object-cover" />
        <!-- Overlay oscuro para legibilidad -->
        <div class="absolute inset-0 bg-black/50"></div>
      </div>

      <!-- Formas orgánicas de fondo -->
      <OrganicShapes :count="3" :colors="['primary', 'secondary', 'primary']" :sizes="[300, 200, 150]"
        :opacities="[0.08, 0.06, 0.04]" :positions="[
          { top: 20, right: 10 },
          { bottom: 30, left: 15 },
          { top: 60, left: 70 }
        ]" :z-index="1" />

      <!-- Contenido principal -->
      <div class="container-full relative z-10 flex items-center min-h-screen">
        <div class="max-w-5xl space-y-8 text-white">
          <!-- Breadcrumb -->
          <nav class="mb-6 scroll-reveal" style="animation-delay: 0.2s">
            <div class="flex items-center space-x-2 text-white/70 text-sm">
              <nuxt-link to="/" class="hover:text-white transition-colors">Inicio</nuxt-link>
              <span>→</span>
              <nuxt-link to="/experiencias" class="hover:text-white transition-colors">Experiencias</nuxt-link>
              <span>→</span>
              <span class="text-white">{{ experience.title }}</span>
            </div>
          </nav>

          <!-- Categoría -->
          <div class="scroll-reveal" style="animation-delay: 0.4s">
            <span
              class="inline-block bg-primary/20 text-primary-light px-4 py-2 rounded-full text-sm font-semibold backdrop-blur-sm border border-primary/30">
              {{ getCategoriaLabel(experience.category) || 'Experiencia' }}
            </span>
          </div>

          <!-- Título principal con animación de palabras -->
          <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight scroll-reveal text-reveal-words">
            <span v-for="(word, index) in experience.title.split(' ')" :key="index" class="word inline-block mr-2"
              :style="{ animationDelay: `${(index + 1) * 0.1}s` }">
              {{ word }}
            </span>
          </h1>



          <!-- Metadata -->
          <div class="flex flex-wrap items-center gap-6 text-white/80 scroll-reveal-stagger"
            style="animation-delay: 0.8s">
            <div class="flex items-center space-x-2">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
              </svg>
              <span>{{ experience.date }}</span>
            </div>
            <div class="flex items-center space-x-2">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
              </svg>
              <span>{{ experience.author }}</span>
            </div>
            <div class="flex items-center space-x-2">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <span>{{ experience.readTime || '5' }} min lectura</span>
            </div>
          </div>

          <!-- Excerpt -->
          <p class="text-lg md:text-xl text-white/90 max-w-3xl scroll-reveal-stagger" style="animation-delay: 1s">
            {{ experience.excerpt }}
          </p>
        </div>
      </div>

      <!-- Scroll indicator -->
      <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <div class="w-6 h-10 border-2 border-white/50 rounded-full flex justify-center">
          <div class="w-1 h-3 bg-white rounded-full mt-2 animate-bounce"></div>
        </div>
      </div>

      <!-- Divisor ondulado inferior -->
      <SectionDivider type="curve2" color="white" backgroundColor="transparent" />
    </section>

    <!-- Contenido principal con efectos de scroll -->
    <main class="relative bg-white">
      <!-- Sección de contenido principal -->
      <section class="py-16 md:py-24 bg-white relative">
        <!-- Formas orgánicas de fondo -->
        <OrganicShapes :count="2" :colors="['primary', 'secondary']" :sizes="[250, 180]" :opacities="[0.04, 0.05]"
          :positions="[
            { top: 10, right: 5 },
            { bottom: 15, left: 8 }
          ]" :z-index="-1" />

        <div class="container-full max-w-12xl">
          <div class="grid lg:grid-cols-12 gap-16 items-start">
            <!-- Contenido principal -->
            <article class="lg:col-span-8 space-y-8">
              <!-- Contenido del artículo -->
              <div class="prose prose-lg prose-gray max-w-none scroll-reveal fade-in-left" v-html="experience.content">
              </div>

              <!-- Estadísticas de impacto -->
              <div v-if="experience.stats" class="grid md:grid-cols-3 gap-8 my-16 scroll-reveal">
                <div v-for="(stat, index) in experience.stats" :key="index"
                  class="text-center p-8 bg-gradient-to-br from-primary/5 to-secondary/5 rounded-2xl card-enhanced">
                  <div class="text-4xl font-bold text-primary mb-2">{{ stat.value }}</div>
                  <div class="text-gray-600">{{ stat.label }}</div>
                </div>
              </div>

              <!-- Galería mejorada -->
              <div v-if="experience.gallery?.length" class="my-16 scroll-reveal">
                <h3 class="text-2xl md:text-3xl font-bold mb-8 text-center text-gray-900">
                  Galería de <span class="text-secondary">momentos</span>
                </h3>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-2">
                  <div v-for="(img, idx) in experience.gallery" :key="idx"
                    class="group relative aspect-square overflow-hidden rounded-lg cursor-pointer card-enhanced"
                    @click="openGalleryModal(idx)">
                    <img :src="img" :alt="`Galería ${idx + 1}`"
                      class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />
                    <div
                      class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300 flex items-center justify-center">
                      <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                      </svg>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Video embebido mejorado -->
              <div v-if="experience.video" class="my-16 scroll-reveal">
                <h3 class="text-2xl md:text-3xl font-bold mb-8 text-center text-gray-900">
                  Video <span class="text-primary">testimonial</span>
                </h3>
                <div class="relative aspect-video rounded-2xl overflow-hidden shadow-2xl card-enhanced">
                  <iframe :src="experience.video" frameborder="0" allowfullscreen class="w-full h-full"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
                  </iframe>
                </div>
              </div>
            </article>

            <!-- Sidebar -->
            <aside class="lg:col-span-4 space-y-8 fade-in-right">
              <!-- Información del proyecto -->
              <div class="bg-gray-50 rounded-2xl p-8 sticky top-8 scroll-reveal card-enhanced">
                <h3 class="text-xl font-bold mb-6 text-gray-900">Detalles del proyecto</h3>
                <div class="space-y-4">
                  <div class="flex justify-between items-center">
                    <span class="text-gray-600 flex items-center">
                      <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                      </svg>
                      Fecha:
                    </span>
                    <span class="font-semibold text-gray-900">{{ experience.date }}</span>
                  </div>
                  <div class="flex justify-between items-center">
                    <span class="text-gray-600 flex items-center">
                      <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                      </svg>
                      Duración:
                    </span>
                    <span class="font-semibold text-gray-900">{{ experience.duration || '1 día' }}</span>
                  </div>
                  <div class="flex justify-between items-center">
                    <span class="text-gray-600 flex items-center">
                      <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                      </svg>
                      Participantes:
                    </span>
                    <span class="font-semibold text-gray-900">{{ experience.participants || '25 voluntarios' }}</span>
                  </div>
                  <div class="flex justify-between items-center">
                    <span class="text-gray-600 flex items-center">
                      <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                      </svg>
                      Ubicación:
                    </span>
                    <span class="font-semibold text-gray-900">{{ experience.location || 'Lima, Perú' }}</span>
                  </div>
                </div>

                <!-- Compartir -->
                <div class="mt-8 pt-8 border-t border-gray-200">
                  <h4 class="font-semibold mb-4 text-gray-900">Compartir experiencia</h4>
                  <ClientOnly>
                    <div class="flex gap-3 justify-center">
                      <!-- Facebook -->
                      <a :href="shareUrl('facebook')" target="_blank"
                        class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-700 transition-all duration-300 hover-scale relative z-10"
                        title="Compartir en Facebook">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                          <path
                            d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                        </svg>
                      </a>

                      <!-- Twitter -->
                      <a :href="shareUrl('twitter')" target="_blank"
                        class="w-12 h-12 bg-sky-500 text-white rounded-full flex items-center justify-center hover:bg-sky-600 transition-all duration-300 hover-scale relative z-10"
                        title="Compartir en Twitter">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                          <path
                            d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                        </svg>
                      </a>

                      <!-- LinkedIn -->
                      <a :href="shareUrl('linkedin')" target="_blank"
                        class="w-12 h-12 bg-blue-700 text-white rounded-full flex items-center justify-center hover:bg-blue-800 transition-all duration-300 hover-scale relative z-10"
                        title="Compartir en LinkedIn">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                          <path
                            d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                        </svg>
                      </a>

                      <!-- WhatsApp -->
                      <a :href="shareUrl('whatsapp')" target="_blank"
                        class="w-12 h-12 bg-green-500 text-white rounded-full flex items-center justify-center hover:bg-green-600 transition-all duration-300 hover-scale relative z-10"
                        title="Compartir en WhatsApp">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                          <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488" />
                        </svg>
                      </a>
                    </div>
                    <template #fallback>
                      <div class="flex gap-3 justify-center">
                        <div class="w-12 h-12 bg-gray-300 rounded-full animate-pulse"></div>
                        <div class="w-12 h-12 bg-gray-300 rounded-full animate-pulse"></div>
                        <div class="w-12 h-12 bg-gray-300 rounded-full animate-pulse"></div>
                        <div class="w-12 h-12 bg-gray-300 rounded-full animate-pulse"></div>
                      </div>
                    </template>
                  </ClientOnly>
                </div>
              </div>

              <!-- Experiencias relacionadas -->
              <div class="bg-white border border-gray-200 rounded-2xl p-8 scroll-reveal card-enhanced relative z-10">
                <h3 class="text-xl font-bold mb-6 text-gray-900">Experiencias relacionadas</h3>
                
                <!-- Loading state para relacionadas -->
                <div v-if="relatedExperiences.length === 0" class="space-y-4">
                  <div v-for="i in 3" :key="i" class="flex gap-4 p-4 animate-pulse">
                    <div class="w-16 h-16 bg-gray-300 rounded-lg flex-shrink-0"></div>
                    <div class="flex-1 space-y-2">
                      <div class="h-4 bg-gray-300 rounded w-3/4"></div>
                      <div class="h-3 bg-gray-300 rounded w-1/2"></div>
                    </div>
                  </div>
                </div>

                <!-- Experiencias relacionadas -->
                <div v-else class="space-y-4">
                  <div v-for="related in relatedExperiences" :key="related.slug"
                    class="group cursor-pointer relative z-20">
                    <nuxt-link :to="`/experiencias/${related.slug}`"
                      class="flex gap-4 p-4 rounded-xl hover:bg-gray-50 transition-all duration-300 hover-scale block relative z-30">
                      <img :src="related.cover" :alt="related.title"
                        class="w-16 h-16 object-cover rounded-lg flex-shrink-0" />
                      <div class="flex-1">
                        <h4 class="font-semibold text-sm group-hover:text-primary transition-colors line-clamp-2 mb-1">
                          {{ related.title }}
                        </h4>
                        <p class="text-xs text-gray-500">{{ related.date }}</p>
                      </div>
                      <div class="flex items-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                      </div>
                    </nuxt-link>
                  </div>
                </div>
              </div>
            </aside>
          </div>
        </div>
      </section>

      <!-- CTA final con diseño consistente -->
      <section class="py-16 md:py-24 wave-shape-primary text-white relative overflow-hidden">
        <div class="container-full relative z-2">
          <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-8 scroll-reveal text-reveal-words">
              <span class="word" style="animation-delay: 0.1s">¿Te</span> <span class="word"
                style="animation-delay: 0.2s">inspira</span> <span class="word"
                style="animation-delay: 0.3s">esta</span>
              <span class="text-white/90 word" style="animation-delay: 0.4s">experiencia?</span>
            </h2>
            <p class="text-lg md:text-xl mb-12 text-white/90 max-w-3xl mx-auto scroll-reveal-stagger"
              style="animation-delay: 0.6s">
              Únete a nuestra comunidad y crea tu propia historia de transformación
            </p>
            <div class="flex flex-col sm:flex-row gap-8 justify-center scroll-reveal-stagger"
              style="animation-delay: 0.8s">
              <nuxt-link to="/unete" class="cta-enhanced bg-white text-primary group">
                <span>Postula ahora</span>
                <svg class="w-5 h-5 ml-3 icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3">
                  </path>
                </svg>
              </nuxt-link>
              <nuxt-link to="/experiencias" class="cta-secondary-enhanced border-white text-white bg-white/10">
                <span>Ver más experiencias</span>
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                  </path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                  </path>
                </svg>
              </nuxt-link>
            </div>
          </div>
        </div>
      </section>
    </main>

    <!-- Modal de galería -->
    <Teleport to="body">
      <div v-if="galleryModalOpen" class="fixed inset-0 bg-black/90 z-50 flex items-center justify-center p-4"
        @click="closeGalleryModal">
        <div class="relative max-w-4xl w-full" @click.stop>
          <button @click="closeGalleryModal"
            class="absolute -top-12 right-0 text-white hover:text-gray-300 transition-colors">
            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
          <img :src="experience.gallery?.[currentGalleryIndex]" class="w-full rounded-lg" />
          <div class="flex justify-center mt-4 gap-4">
            <button @click="prevGalleryImage" class="text-white hover:text-gray-300 transition-colors">
              <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
              </svg>
            </button>
            <span class="text-white">{{ currentGalleryIndex + 1 }} / {{ experience.gallery?.length }}</span>
            <button @click="nextGalleryImage" class="text-white hover:text-gray-300 transition-colors">
              <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </Teleport>
  </div>
</template>

<script setup>
import { SectionDivider } from '#components'
import { onMounted, onBeforeUnmount, ref, computed } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()
const slug = route.params.experience

// Estado para modal de galería
const galleryModalOpen = ref(false)
const currentGalleryIndex = ref(0)

// Usar el composable de experiencias API
const { 
  loading,
  error,
  fetchExperienciaBySlug,
  fetchExperienciasRelacionadas,
  getCategoriaLabel
} = useExperienciasAPI()

// Estado de la experiencia
const experience = ref(null)
const relatedExperiences = ref([])
const notFound = ref(false)

// Cargar experiencia al montar
onMounted(async () => {
  try {
    const experienceData = await fetchExperienciaBySlug(slug)
    
    if (experienceData) {
      experience.value = experienceData
      
      // Cargar experiencias relacionadas
      const related = await fetchExperienciasRelacionadas(slug, 3)
      relatedExperiences.value = related
    } else {
      notFound.value = true
    }
  } catch (err) {
    console.error('Error loading experience:', err)
    notFound.value = true
  }
})

// Animaciones de scroll y parallax (consistente con index.vue)
let scrollAnimationFrame = null

const initScrollAnimations = () => {
  if (import.meta.client) {
    // Intersection Observer para animaciones de scroll
    const observerOptions = {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    }

    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible')

          // Animación especial para palabras
          if (entry.target.classList.contains('text-reveal-words')) {
            const words = entry.target.querySelectorAll('.word')
            words.forEach((word, index) => {
              setTimeout(() => {
                word.style.animationPlayState = 'running'
              }, index * 100)
            })
          }
        }
      })
    }, observerOptions)

    // Observar elementos con animaciones
    const elementsToObserve = document.querySelectorAll('.scroll-reveal, .scroll-reveal-stagger, .text-reveal-words')
    elementsToObserve.forEach(el => observer.observe(el))

    // Efectos parallax simples
    const handleScroll = () => {
      if (scrollAnimationFrame) return

      scrollAnimationFrame = requestAnimationFrame(() => {
        const scrolled = window.scrollY
        const parallaxElements = document.querySelectorAll('.parallax-element')

        parallaxElements.forEach((element, index) => {
          const speed = 0.5 + (index * 0.1)
          const yPos = -(scrolled * speed)
          element.style.transform = `translateY(${yPos}px)`
        })

        scrollAnimationFrame = null
      })
    }

    // Event listeners
    window.addEventListener('scroll', handleScroll, { passive: true })

    // Cleanup function
    return () => {
      window.removeEventListener('scroll', handleScroll)
      observer.disconnect()
      if (scrollAnimationFrame) {
        cancelAnimationFrame(scrollAnimationFrame)
      }
    }
  }
}

// Funciones para modal de galería
const openGalleryModal = (index) => {
  currentGalleryIndex.value = index
  galleryModalOpen.value = true
}

const closeGalleryModal = () => {
  galleryModalOpen.value = false
}

const nextGalleryImage = () => {
  if (experience.value.gallery) {
    currentGalleryIndex.value = (currentGalleryIndex.value + 1) % experience.value.gallery.length
  }
}

const prevGalleryImage = () => {
  if (experience.value.gallery) {
    currentGalleryIndex.value = (currentGalleryIndex.value - 1 + experience.value.gallery.length) % experience.value.gallery.length
  }
}

// URLs de compartir
const shareUrl = (network) => {
  if (!import.meta.client) return '#'

  const url = encodeURIComponent(window.location.href)
  const text = encodeURIComponent(experience.value.title)

  const urls = {
    facebook: `https://www.facebook.com/sharer/sharer.php?u=${url}`,
    twitter: `https://twitter.com/intent/tweet?url=${url}&text=${text}`,
    linkedin: `https://www.linkedin.com/sharing/share-offsite/?url=${url}`,
    whatsapp: `https://wa.me/?text=${text}%20${url}`
  }

  return urls[network] || '#'
}

// SEO dinámico
useHead({
  title: () => experience.value ? `${experience.value.title} - Munay Ruray` : 'Experiencia - Munay Ruray',
  meta: [
    {
      name: 'description',
      content: () => experience.value?.excerpt || 'Experiencia de Munay Ruray'
    },
    {
      property: 'og:title',
      content: () => experience.value?.title || 'Experiencia - Munay Ruray'
    },
    {
      property: 'og:description',
      content: () => experience.value?.excerpt || 'Experiencia de Munay Ruray'
    },
    {
      property: 'og:image',
      content: () => experience.value?.cover || 'https://placehold.co/1200x630/02b2a2/ffffff?text=Munay+Ruray'
    }
  ]
})

// Lifecycle
onMounted(() => {
  const cleanup = initScrollAnimations()

  // Inicializar palabras con animación pausada
  const words = document.querySelectorAll('.word')
  words.forEach(word => {
    word.style.animationPlayState = 'paused'
  })

  // Cleanup en unmount
  onBeforeUnmount(() => {
    if (cleanup) cleanup()
  })
})
</script>

<style scoped>
/* Animaciones consistentes con index.vue */
.scroll-reveal {
  opacity: 0;
  transform: translateY(50px);
  transition: all 0.8s ease-out;
}

.scroll-reveal.visible {
  opacity: 1;
  transform: translateY(0);
}

.scroll-reveal-stagger {
  opacity: 0;
  transform: translateY(30px);
  transition: all 0.6s ease-out;
}

.scroll-reveal-stagger.visible {
  opacity: 1;
  transform: translateY(0);
}

.fade-in-left {
  opacity: 0;
  transform: translateX(-50px);
  transition: all 0.8s ease-out;
}

.fade-in-left.visible {
  opacity: 1;
  transform: translateX(0);
}

.fade-in-right {
  opacity: 0;
  transform: translateX(50px);
  transition: all 0.8s ease-out;
}

.fade-in-right.visible {
  opacity: 1;
  transform: translateX(0);
}

/* Animación de palabras */
.text-reveal-words .word {
  display: inline-block;
  opacity: 0;
  transform: translateY(20px);
  animation: wordReveal 0.6s ease-out forwards;
  animation-play-state: paused;
}

@keyframes wordReveal {
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Cards mejoradas */
.card-enhanced {
  transition: all 0.3s ease;
  border: 1px solid transparent;
}

.card-enhanced:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
  border-color: rgba(2, 178, 162, 0.1);
}

/* Hover effects */
.hover-scale {
  transition: transform 0.2s ease;
}

.hover-scale:hover {
  transform: scale(1.02);
}

.card-enhanced:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
  border-color: rgba(2, 178, 162, 0.1);
}

/* Hover effects */
.hover-scale {
  transition: transform 0.2s ease;
}

.hover-scale:hover {
  transform: scale(1.02);
}

/* Prose mejorado */
.prose {
  color: #374151;
  line-height: 1.75;
}

.prose .lead {
  font-size: 1.25rem;
  line-height: 1.6;
  color: #4b5563;
  margin-bottom: 2rem;
  font-weight: 400;
}

.prose h3 {
  color: #111827;
  font-weight: 700;
  font-size: 1.5rem;
  margin-top: 2.5rem;
  margin-bottom: 1rem;
  line-height: 1.3;
}

.prose p {
  margin-bottom: 1.5rem;
}

.prose ul {
  margin: 1.5rem 0;
  padding-left: 1.5rem;
}

.prose li {
  margin-bottom: 0.5rem;
  line-height: 1.6;
}

.prose li strong {
  color: #02b2a2;
  font-weight: 600;
}

.prose img {
  border-radius: 1rem;
  box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
}

/* Efectos hover mejorados */
.group:hover .group-hover\:scale-110 {
  transform: scale(1.1);
}

.group:hover .group-hover\:opacity-100 {
  opacity: 1;
}

/* Utilidades adicionales */
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .container-full {
    padding-left: 1rem;
    padding-right: 1rem;
  }
}

/* Mejoras de accesibilidad */
@media (prefers-reduced-motion: reduce) {

  .scroll-reveal,
  .scroll-reveal-stagger,
  .fade-in-left,
  .fade-in-right,
  .word {
    animation: none;
    opacity: 1;
    transform: none !important;
  }
}

/* Estados de focus para accesibilidad */
button:focus,
a:focus {
  outline: 2px solid #02b2a2;
  outline-offset: 2px;
}

/* Transiciones suaves */
* {
  transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  transition-duration: 150ms;
}
</style>