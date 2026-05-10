<template>
  <header :class="['site-header', { scrolled: isScrolled }]">
    <RouterLink to="/" class="logo">
      AURO<span>SUNRISE</span> <em>RECORDS</em>
    </RouterLink>
    <nav class="nav">
      <RouterLink v-for="item in nav" :key="item.path" :to="item.path" class="nav-link">
        {{ item.label }}
      </RouterLink>
    </nav>
    <RouterLink to="/contact" class="nav-cta">Get In Touch</RouterLink>
  </header>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { RouterLink } from 'vue-router'

const isScrolled = ref(false)
const nav = [
  { path: '/', label: 'Home' },
  { path: '/artists', label: 'Artists' },
  { path: '/albums', label: 'Albums' },
  { path: '/events', label: 'Events' },
  { path: '/shop', label: 'Shop' },
]

function onScroll() { isScrolled.value = window.scrollY > 60 }
onMounted(() => window.addEventListener('scroll', onScroll))
onUnmounted(() => window.removeEventListener('scroll', onScroll))
</script>

<style scoped>
.site-header {
  position: fixed;
  top: 0; left: 0; right: 0;
  padding: 1.5rem 3rem;
  display: flex;
  align-items: center;
  gap: 3rem;
  z-index: 999;
  transition: all .3s;
}
.site-header.scrolled {
  background: rgba(26,8,0,0.95);
  backdrop-filter: blur(20px);
  padding: 1rem 3rem;
  border-bottom: 1px solid rgba(255,107,0,0.2);
}
.logo {
  text-decoration: none;
  font-size: 1.1rem;
  font-weight: 900;
  color: #fff;
  letter-spacing: 2px;
  white-space: nowrap;
}
.logo span { color: #ff6b00; }
.logo em { font-style: normal; font-size: .65rem; letter-spacing: 5px; color: rgba(255,215,0,0.7); margin-left: .5rem; }
.nav { display: flex; gap: 2rem; margin-left: auto; }
.nav-link {
  color: rgba(255,255,255,0.7);
  text-decoration: none;
  font-size: .9rem;
  letter-spacing: 1px;
  transition: color .2s;
}
.nav-link:hover, .nav-link.router-link-active { color: #ff6b00; }
.nav-cta {
  background: linear-gradient(135deg, #ff6b00, #ff9500);
  color: #fff;
  padding: .55rem 1.4rem;
  border-radius: 50px;
  text-decoration: none;
  font-size: .85rem;
  font-weight: 700;
  transition: all .3s;
  white-space: nowrap;
  box-shadow: 0 4px 15px rgba(255,107,0,0.3);
}
.nav-cta:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(255,107,0,0.5); }
</style>
