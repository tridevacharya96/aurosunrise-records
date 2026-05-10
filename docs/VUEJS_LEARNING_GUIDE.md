# 🎵 Aurosunrise Records — Vue.js + Laravel Learning Guide

> A complete, practical guide to building the Aurosunrise Records website.
> Learn Vue.js by building a real music label website with Laravel.

---

## 📁 Project Folder Structure

```
aurosunrise-records/                    ← Laravel root
│
├── app/                                ← PHP application code
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── Api/                   ← API controllers (return JSON)
│   │   │       ├── ArtistController.php
│   │   │       ├── AlbumController.php
│   │   │       ├── EventController.php
│   │   │       └── ...
│   │   └── Middleware/
│   └── Models/                        ← Eloquent models (database tables)
│       ├── Artist.php
│       ├── Album.php
│       ├── Track.php
│       └── ...
│
├── database/
│   ├── migrations/                    ← Database schema definitions
│   └── seeders/                       ← Test data generators
│
├── routes/
│   ├── web.php                        ← Web routes (returns Vue app HTML)
│   └── api.php                        ← API routes (return JSON)
│
├── resources/
│   ├── views/
│   │   └── app.blade.php              ← The ONE HTML file Vue mounts into
│   │
│   ├── css/
│   │   └── app.css                    ← Global CSS
│   │
│   └── js/                            ← ALL your Vue.js code lives here
│       │
│       ├── app.js                     ← Entry point (creates & mounts Vue app)
│       ├── App.vue                    ← Root component (header + router-view + footer)
│       │
│       ├── router/
│       │   └── index.js               ← Vue Router config (all page routes)
│       │
│       ├── store/                     ← Pinia stores (global state)
│       │   ├── musicPlayer.js         ← Audio player state
│       │   └── cart.js                ← Shopping cart state
│       │
│       ├── composables/               ← Reusable logic (like custom hooks)
│       │   ├── useApi.js              ← Generic API fetch helper
│       │   └── useScroll.js           ← Scroll detection logic
│       │
│       ├── pages/                     ← Page components (1 per route)
│       │   ├── HomePage.vue
│       │   ├── ArtistsPage.vue
│       │   ├── ArtistDetailPage.vue
│       │   ├── AlbumsPage.vue
│       │   ├── EventsPage.vue
│       │   ├── ShopPage.vue
│       │   ├── CartPage.vue
│       │   ├── BlogPage.vue
│       │   ├── ContactPage.vue
│       │   └── NotFoundPage.vue
│       │
│       └── components/                ← Reusable UI components
│           ├── layout/
│           │   ├── AppHeader.vue      ← Navigation bar
│           │   ├── AppFooter.vue      ← Footer
│           │   ├── PageBanner.vue     ← Page title banner
│           │   └── GlobalMusicPlayer.vue ← Bottom audio player
│           ├── home/
│           │   ├── HeroSection.vue
│           │   ├── LatestReleasesSection.vue
│           │   ├── FeaturedArtistsSection.vue
│           │   └── ...
│           ├── artists/
│           │   └── ArtistCard.vue
│           ├── albums/
│           │   └── AlbumCard.vue
│           └── ui/
│               ├── BaseButton.vue     ← Reusable button
│               └── BaseModal.vue      ← Reusable modal
│
├── public/
│   └── assets/                        ← Static assets (images, fonts, songs)
│
├── vite.config.js                     ← Build tool configuration
└── package.json                       ← Node.js dependencies
```

---

## 🧩 Vue.js Core Concepts — Quick Reference

### 1. Single File Components (.vue files)

Every `.vue` file has three sections:

```vue
<template>
  <!-- Your HTML goes here -->
  <div>{{ message }}</div>
</template>

<script setup>
// Your JavaScript goes here
import { ref } from 'vue'
const message = ref('Hello Aurosunrise!')
</script>

<style scoped>
/* Your CSS goes here — scoped = only applies to THIS component */
div { color: #f5a623; }
</style>
```

### 2. Reactive Data with ref() and reactive()

```javascript
import { ref, reactive } from 'vue'

// ref() — for primitive values (string, number, boolean)
const trackTitle = ref('Golden Hour')        // Access: trackTitle.value
const isPlaying = ref(false)
const volume = ref(0.8)

// reactive() — for objects/arrays
const artist = reactive({
  name: 'Riya Sen',
  genre: 'Pop',
  albums: []
})

// Access reactive object: artist.name (no .value needed)

// In the template, Vue automatically unwraps ref:
// {{ trackTitle }}  ← works (no .value in template)
// In script: trackTitle.value = 'New Title'
```

### 3. Template Directives

```vue
<template>
  <!-- v-bind (:) — dynamic attribute -->
  <img :src="artist.photo" :alt="artist.name" />

  <!-- v-model — two-way binding -->
  <input v-model="searchQuery" placeholder="Search..." />
  <input type="range" v-model.number="volume" min="0" max="1" step="0.1" />

  <!-- v-if / v-else-if / v-else — conditional rendering -->
  <div v-if="loading">Loading...</div>
  <div v-else-if="error">Error: {{ error }}</div>
  <div v-else>{{ data }}</div>

  <!-- v-show — toggle visibility (keeps in DOM) -->
  <div v-show="isPlayerVisible">Music Player</div>

  <!-- v-for — list rendering (always use :key!) -->
  <div v-for="track in tracks" :key="track.id">
    {{ track.title }} — {{ track.artist }}
  </div>

  <!-- v-on (@) — event listeners -->
  <button @click="playTrack">Play</button>
  <button @click="volume += 0.1">Volume Up</button>
  <input @keyup.enter="search" />      <!-- .enter modifier -->
  <div @click.stop="handleClick" />   <!-- .stop prevents propagation -->
  <form @submit.prevent="onSubmit" /> <!-- .prevent stops form reload -->
</template>
```

### 4. Computed Properties

```javascript
import { ref, computed } from 'vue'

const tracks = ref([
  { title: 'Golden Hour', duration: 245 },
  { title: 'Sunrise', duration: 198 }
])

// Computed auto-updates when tracks changes
const totalDuration = computed(() => {
  return tracks.value.reduce((sum, t) => sum + t.duration, 0)
})

const formattedDuration = computed(() => {
  const mins = Math.floor(totalDuration.value / 60)
  const secs = totalDuration.value % 60
  return `${mins}:${secs.toString().padStart(2, '0')}`
})

// Writable computed (for v-model with stores)
const volumeModel = computed({
  get: () => player.volume,
  set: (val) => player.setVolume(val)
})
```

### 5. Lifecycle Hooks

```javascript
import { onMounted, onUnmounted, onUpdated, onBeforeMount } from 'vue'

// Order of execution:
// 1. setup() runs (all your <script setup> code)
// 2. onBeforeMount → DOM doesn't exist yet
// 3. Component renders to DOM
// 4. onMounted → DOM exists! Initialize libraries here
// 5. (data changes → component updates)
// 6. onUpdated → after DOM update
// 7. onUnmounted → component removed from DOM (cleanup!)

onMounted(() => {
  // ✅ Safe to access DOM
  // ✅ Initialize Swiper, third-party libs
  // ✅ Fetch initial data
  // ✅ Add event listeners
  fetchArtists()
  window.addEventListener('scroll', handleScroll)
})

onUnmounted(() => {
  // ✅ Clean up to prevent memory leaks
  window.removeEventListener('scroll', handleScroll)
  swiperInstance?.destroy()
})
```

### 6. watch() — React to Changes

```javascript
import { ref, watch, watchEffect } from 'vue'

const searchQuery = ref('')
const genre = ref('All')

// Watch a single value
watch(searchQuery, (newValue, oldValue) => {
  console.log(`Search changed from "${oldValue}" to "${newValue}"`)
  fetchArtists()
})

// Watch multiple values
watch([searchQuery, genre], ([newSearch, newGenre]) => {
  fetchArtists({ search: newSearch, genre: newGenre })
})

// Watch with options
watch(searchQuery, fetchArtists, {
  immediate: true,  // Run immediately on mount too
  deep: true        // Watch nested object changes
})

// watchEffect — automatically tracks its dependencies
watchEffect(() => {
  // Runs whenever searchQuery OR genre changes
  console.log(`Filtering: ${searchQuery.value} in ${genre.value}`)
})
```

### 7. Props — Parent to Child Communication

```vue
<!-- Parent (ArtistsPage.vue) -->
<template>
  <ArtistCard
    :artist="artist"
    :show-actions="true"
    size="large"
    @play-track="handlePlay"
  />
</template>

<!-- Child (ArtistCard.vue) -->
<script setup>
// defineProps — declare what data the parent can send
const props = defineProps({
  artist: {
    type: Object,
    required: true
  },
  showActions: {
    type: Boolean,
    default: false
  },
  size: {
    type: String,
    default: 'medium',
    validator: (val) => ['small', 'medium', 'large'].includes(val)
  }
})

// defineEmits — declare events this component sends to parent
const emit = defineEmits(['play-track', 'add-to-cart'])

function playTrack(track) {
  emit('play-track', track)  // Sends event + data UP to parent
}
</script>
```

### 8. Slots — Parent Injects Content Into Child

```vue
<!-- BaseCard.vue (child) -->
<template>
  <div class="card">
    <div class="card-header">
      <!-- Named slot: parent provides the header -->
      <slot name="header">Default Header</slot>
    </div>
    <div class="card-body">
      <!-- Default slot -->
      <slot />
    </div>
    <div class="card-footer">
      <slot name="footer" />
    </div>
  </div>
</template>

<!-- Usage (parent) -->
<BaseCard>
  <template #header>
    <h3>Golden Hour Album</h3>
  </template>

  <p>Description of the album goes here...</p>

  <template #footer>
    <button>Listen Now</button>
  </template>
</BaseCard>
```

### 9. Pinia Store — Global State

```javascript
// store/musicPlayer.js
import { defineStore } from 'pinia'
import { ref, computed } from 'vue'

export const useMusicPlayerStore = defineStore('player', () => {
  // State
  const currentTrack = ref(null)
  const isPlaying = ref(false)

  // Getters (computed)
  const trackTitle = computed(() => currentTrack.value?.title || 'No track')

  // Actions
  function play(track) {
    currentTrack.value = track
    isPlaying.value = true
  }

  return { currentTrack, isPlaying, trackTitle, play }
})

// In ANY component:
import { useMusicPlayerStore } from '@/store/musicPlayer.js'
const player = useMusicPlayerStore()
player.play(myTrack)            // Call action
console.log(player.isPlaying)  // Read state
```

### 10. Vue Router — Navigation

```javascript
import { useRouter, useRoute } from 'vue-router'

const router = useRouter()  // For navigation
const route = useRoute()    // For reading current URL info

// Navigate programmatically
router.push('/artists')
router.push({ name: 'artist-detail', params: { slug: 'riya-sen' } })
router.push({ path: '/artists', query: { genre: 'pop' } })
router.back()  // Like browser back button

// Read current URL info
console.log(route.path)           // '/artists/riya-sen'
console.log(route.params.slug)    // 'riya-sen'
console.log(route.query.genre)    // 'pop'
```

---

## 🚀 How to Set Up & Run

### Prerequisites
- PHP 8.2+
- Composer
- Node.js 20+
- MySQL or PostgreSQL

### Step-by-Step Setup

```bash
# 1. Install PHP dependencies
composer install

# 2. Install Node.js dependencies
npm install

# 3. Copy environment file
cp .env.example .env

# 4. Generate app key
php artisan key:generate

# 5. Configure your database in .env:
DB_DATABASE=aurosunrise_records
DB_USERNAME=root
DB_PASSWORD=yourpassword

# 6. Run database migrations (creates tables)
php artisan migrate

# 7. Seed test data
php artisan db:seed

# 8. Create storage symlink (for file uploads)
php artisan storage:link

# 9. Start Laravel server on port 8001
#    (port 8000 is already used by Auromax Digital)
php artisan serve --port=8001
# → http://localhost:8001

# 10. Start Vite dev server (Terminal 2)
npm run dev
# → Vite HMR runs on http://localhost:5174
# → Save any .vue file → browser updates instantly
```

---

## 📚 Learning Path — Step by Step

### Week 1: Vue Basics
1. Read `resources/js/App.vue` — understand component structure
2. Read `resources/js/components/artists/ArtistCard.vue` — props, events
3. Try modifying the template, add a new data field
4. Read `resources/js/store/cart.js` — understand reactive state

### Week 2: Vue Router & API
1. Read `resources/js/router/index.js` — how routes work
2. Read `resources/js/pages/ArtistsPage.vue` — see v-for, v-if, API calls
3. Add a new route (e.g. /gallery)
4. Create a new page component for that route

### Week 3: Laravel Backend
1. Read `routes/api.php` — see how routes map to controllers
2. Read `app/Http/Controllers/Api/ArtistController.php`
3. Read `app/Models/Artist.php` — Eloquent model
4. Run `php artisan tinker` and try `Artist::all()`

### Week 4: Build a Feature
1. Add a "Favorite Artists" feature
2. Create a Pinia store for favorites
3. Add a toggle button to ArtistCard
4. Persist favorites to localStorage

---

## 🎯 Common Commands Reference

```bash
# Laravel
php artisan serve              # Start dev server
php artisan migrate            # Run migrations
php artisan make:model Album -m -c -r  # Model + migration + controller + routes
php artisan make:controller Api/AlbumController --api
php artisan tinker             # Laravel REPL (test Eloquent queries)
php artisan route:list         # See all registered routes

# Vue / Node
npm run dev          # Start Vite dev server with HMR
npm run build        # Build for production
npm run preview      # Preview production build
```

---

## 🔑 Key Differences: Vue Options API vs Composition API

This project uses **Composition API** (modern, recommended).

```javascript
// ❌ Options API (older style — still valid, but less flexible)
export default {
  data() {
    return { count: 0 }
  },
  computed: {
    doubled() { return this.count * 2 }
  },
  methods: {
    increment() { this.count++ }
  },
  mounted() {
    console.log('mounted!')
  }
}

// ✅ Composition API (this project uses this)
import { ref, computed, onMounted } from 'vue'

const count = ref(0)
const doubled = computed(() => count.value * 2)
function increment() { count.value++ }
onMounted(() => console.log('mounted!'))
```

The Composition API groups related logic TOGETHER instead of splitting it across
data/computed/methods/lifecycle sections. Much easier to maintain!
