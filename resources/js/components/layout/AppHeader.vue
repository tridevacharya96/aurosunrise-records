<template>
  <header :class="['site-header', { scrolled: isScrolled }]">
    <RouterLink to="/" class="logo">
      <span class="logo-main">Aurosunrise</span>
      <span class="logo-sub">Records</span>
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
  { path: '/artists', label: 'Artists' },
  { path: '/albums',  label: 'Albums'  },
  { path: '/events',  label: 'Events'  },
  { path: '/shop',    label: 'Shop'    },
  { path: '/blog',    label: 'Blog'    },
]

function onScroll() { isScrolled.value = window.scrollY > 60 }
onMounted(() => window.addEventListener('scroll', onScroll))
onUnmounted(() => window.removeEventListener('scroll', onScroll))
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap');

.site-header {
  position: fixed;
  top: 0; left: 0; right: 0;
  padding: 1.4rem 3rem;
  display: flex;
  align-items: center;
  gap: 3rem;
  z-index: 999;
  transition: all .35s ease;
}

.site-header.scrolled {
  background: rgba(20, 6, 0, 0.92);
  backdrop-filter: blur(24px);
  -webkit-backdrop-filter: blur(24px);
  padding: 1rem 3rem;
  border-bottom: 1px solid rgba(255, 107, 0, 0.15);
  box-shadow: 0 4px 30px rgba(0,0,0,0.4);
}

/* Logo */
.logo {
  text-decoration: none;
  display: flex;
  flex-direction: column;
  line-height: 1;
  flex-shrink: 0;
}
.logo-main {
  font-family: 'Cinzel', serif;
  font-size: 1.25rem;
  font-weight: 700;
  color: #fff;
  letter-spacing: 3px;
  text-transform: uppercase;
}
.logo-sub {
  font-family: 'Inter', sans-serif;
  font-size: .55rem;
  font-weight: 400;
  color: rgba(255, 215, 0, 0.75);
  letter-spacing: 7px;
  text-transform: uppercase;
  margin-top: 2px;
}

/* Nav */
.nav {
  display: flex;
  gap: 2.5rem;
  margin-left: auto;
}

.nav-link {
  font-family: 'Inter', sans-serif;
  color: rgba(255, 255, 255, 0.65);
  text-decoration: none;
  font-size: .82rem;
  letter-spacing: 2px;
  text-transform: uppercase;
  font-weight: 500;
  transition: color .2s;
  position: relative;
}
.nav-link::after {
  content: '';
  position: absolute;
  bottom: -4px; left: 0; right: 0;
  height: 1px;
  background: #ff6b00;
  transform: scaleX(0);
  transition: transform .25s;
}
.nav-link:hover,
.nav-link.router-link-active {
  color: #fff;
}
.nav-link:hover::after,
.nav-link.router-link-active::after {
  transform: scaleX(1);
}

/* CTA Button */
.nav-cta {
  font-family: 'Inter', sans-serif;
  background: linear-gradient(135deg, #ff6b00, #ff9500);
  color: #fff;
  padding: .6rem 1.5rem;
  border-radius: 50px;
  text-decoration: none;
  font-size: .78rem;
  font-weight: 600;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  transition: all .3s;
  white-space: nowrap;
  flex-shrink: 0;
  box-shadow: 0 4px 20px rgba(255,107,0,0.3);
}
.nav-cta:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 28px rgba(255,107,0,0.55);
}

@media (max-width: 768px) {
  .site-header { padding: 1rem 1.5rem; gap: 1rem; }
  .nav { display: none; }
  .nav-cta { font-size: .72rem; padding: .5rem 1.1rem; }
}
</style>
