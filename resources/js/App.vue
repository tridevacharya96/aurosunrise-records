<template>
  <!--
    📚 LEARNING NOTE: <template> is the HTML structure of every Vue component.
    Think of it as the "view" layer.

    <RouterView> is a special Vue Router component that renders whatever
    page/component matches the current URL route.
    e.g. if URL is /artists, it renders ArtistsPage.vue
  -->
  <div class="page-wraper">
    <!-- The AppHeader and AppFooter appear on every page -->
    <AppHeader />

    <!-- RouterView swaps in the correct page component based on the URL -->
    <RouterView />

    <!-- Global music player persists across all pages -->
    <GlobalMusicPlayer />

    <AppFooter />
  </div>
</template>

<script setup>
/**
 * 📚 LEARNING NOTE: <script setup> is Vue 3's Composition API syntax.
 * It's the modern, recommended way to write Vue components.
 * Everything you declare here is automatically available in <template>.
 *
 * "import" brings in child components to use inside this template.
 */
import AppHeader from './components/layout/AppHeader.vue'
import AppFooter from './components/layout/AppFooter.vue'
import GlobalMusicPlayer from './components/layout/GlobalMusicPlayer.vue'

import { onMounted } from 'vue'

onMounted(() => {
  // Hide loading screen after app is ready
  const loader = document.getElementById('loading-area')
  if (loader) {
    setTimeout(() => {
      loader.style.opacity = '0'
      loader.style.transition = 'opacity 0.5s'
      setTimeout(() => loader.remove(), 500)
    }, 800)
  }
})
</script>
