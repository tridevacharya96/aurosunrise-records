<template>
  <main class="artists-page">
    <div class="page-banner">
      <div class="banner-liquid-1"></div>
      <div class="banner-liquid-2"></div>
      <div class="banner-content">
        <p class="eyebrow">✦ The Talent</p>
        <h1>Our <span class="accent">Artists</span></h1>
        <p class="banner-desc">South India's finest voices, all under one roof.</p>
      </div>
    </div>

    <div class="content">
      <div class="container">

        <!-- Search & Filter -->
        <div class="filters">
          <div class="search-wrap">
            <i class="fas fa-search"></i>
            <input
              v-model="search"
              type="text"
              placeholder="Search artists..."
              class="search-input"
              @input="debouncedFetch"
            />
          </div>
          <div class="genre-tabs">
            <button
              v-for="g in ['All', ...genres]"
              :key="g"
              class="genre-btn"
              :class="{ active: activeGenre === g }"
              @click="setGenre(g)"
            >{{ g }}</button>
          </div>
        </div>

        <!-- Loading -->
        <div v-if="loading" class="loading-grid">
          <div v-for="i in 8" :key="i" class="skeleton-card"></div>
        </div>

        <!-- Empty -->
        <div v-else-if="artists.length === 0" class="empty-state">
          <i class="fas fa-microphone-slash"></i>
          <p>No artists found.</p>
        </div>

        <!-- Artists Grid -->
        <div v-else class="artists-grid">
          <RouterLink
            v-for="artist in artists"
            :key="artist.id"
            :to="`/artists/${artist.slug}`"
            class="artist-card"
          >
            <div class="card-photo">
              <img v-if="artist.photo_url" :src="artist.photo_url" :alt="artist.name" />
              <div v-else class="photo-placeholder">
                <span>{{ initials(artist.name) }}</span>
              </div>
              <div class="card-overlay">
                <div class="overlay-socials">
                  <a
                    v-for="s in artist.socials.slice(0,3)"
                    :key="s.label"
                    :href="s.url"
                    target="_blank"
                    :title="s.label"
                    class="social-dot"
                    @click.prevent.stop="openLink(s.url)"
                  >
                    <i :class="s.icon"></i>
                  </a>
                </div>
                <span class="view-btn">View Profile →</span>
              </div>
            </div>
            <div class="card-body">
              <h3 class="card-name">{{ artist.name }}</h3>
              <span class="card-genre">{{ artist.genre }}</span>
              <div class="card-meta">
                <span><i class="fas fa-compact-disc"></i> {{ artist.albums_count }} Albums</span>
              </div>
            </div>
          </RouterLink>
        </div>

        <!-- Pagination -->
        <div v-if="meta.last_page > 1" class="pagination">
          <button :disabled="meta.current_page === 1" @click="goPage(meta.current_page - 1)" class="page-btn">
            <i class="fas fa-chevron-left"></i>
          </button>
          <span class="page-info">{{ meta.current_page }} / {{ meta.last_page }}</span>
          <button :disabled="meta.current_page === meta.last_page" @click="goPage(meta.current_page + 1)" class="page-btn">
            <i class="fas fa-chevron-right"></i>
          </button>
        </div>

      </div>
    </div>
  </main>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { RouterLink } from 'vue-router'

const artists     = ref([])
const genres      = ref([])
const loading     = ref(true)
const search      = ref('')
const activeGenre = ref('All')
const page        = ref(1)
const meta        = ref({ current_page: 1, last_page: 1, total: 0 })

let debounceTimer = null

async function fetchArtists() {
  loading.value = true
  const params = new URLSearchParams({ page: page.value, per_page: 12 })
  if (search.value)                  params.append('search', search.value)
  if (activeGenre.value !== 'All')   params.append('genre', activeGenre.value)

  const res  = await fetch(`/api/artists?${params}`)
  const data = await res.json()
  artists.value = data.data
  meta.value    = data.meta
  loading.value = false
}

async function fetchGenres() {
  const res  = await fetch('/api/artists/genres')
  const data = await res.json()
  genres.value = data.data
}

function debouncedFetch() {
  clearTimeout(debounceTimer)
  debounceTimer = setTimeout(fetchArtists, 400)
}

function setGenre(g) {
  activeGenre.value = g
  page.value = 1
  fetchArtists()
}

function goPage(p) { page.value = p; fetchArtists() }

function initials(name) {
  return name.split(' ').map(w => w[0]).join('').toUpperCase().slice(0,2)
}

function openLink(url) { window.open(url, '_blank') }

onMounted(() => {
  fetchGenres()
  fetchArtists()
})
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap');
* { font-family: 'Inter', sans-serif; }

.artists-page { background: #0f0500; min-height: 100vh; }

/* Banner */
.page-banner {
  position: relative;
  padding: 10rem 2rem 5rem;
  overflow: hidden;
  text-align: center;
  background: #1a0800;
}
.banner-liquid-1 {
  position: absolute; width: 500px; height: 500px; border-radius: 50%;
  background: radial-gradient(circle, rgba(255,107,0,0.3), transparent 70%);
  top: -200px; left: -100px; filter: blur(60px);
}
.banner-liquid-2 {
  position: absolute; width: 400px; height: 400px; border-radius: 50%;
  background: radial-gradient(circle, rgba(255,215,0,0.2), transparent 70%);
  top: -100px; right: -50px; filter: blur(60px);
}
.banner-content { position: relative; z-index: 2; }
.eyebrow { font-size: .75rem; letter-spacing: 5px; color: #ff6b00; text-transform: uppercase; margin-bottom: .75rem; }
.page-banner h1 { font-family: 'Cinzel', serif; font-size: clamp(2.5rem,6vw,5rem); font-weight: 700; color: #fff; margin-bottom: 1rem; }
.accent { color: #ff6b00; }
.banner-desc { color: rgba(255,255,255,0.5); font-size: 1.05rem; }

/* Filters */
.content { padding: 4rem 2rem; }
.container { max-width: 1200px; margin: 0 auto; }
.filters { display: flex; flex-direction: column; gap: 1.25rem; margin-bottom: 3rem; }
.search-wrap {
  position: relative;
  max-width: 400px;
}
.search-wrap i { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: rgba(255,255,255,0.3); }
.search-input {
  width: 100%; padding: .85rem 1rem .85rem 2.75rem;
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,107,0,0.2);
  border-radius: 50px; color: #fff; font-size: .9rem;
  outline: none; transition: border-color .2s;
}
.search-input:focus { border-color: #ff6b00; }
.search-input::placeholder { color: rgba(255,255,255,0.3); }
.genre-tabs { display: flex; gap: .5rem; flex-wrap: wrap; }
.genre-btn {
  padding: .45rem 1.2rem;
  border: 1px solid rgba(255,107,0,0.2);
  border-radius: 50px; background: transparent;
  color: rgba(255,255,255,0.5); font-size: .8rem;
  letter-spacing: 1px; text-transform: uppercase;
  cursor: pointer; transition: all .2s;
}
.genre-btn.active, .genre-btn:hover { background: #ff6b00; border-color: #ff6b00; color: #fff; }

/* Grid */
.artists-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px,1fr)); gap: 1.5rem; }
.artist-card { background: #1e0c00; border: 1px solid rgba(255,107,0,0.1); border-radius: 20px; overflow: hidden; text-decoration: none; transition: all .3s; display: block; }
.artist-card:hover { transform: translateY(-10px); border-color: rgba(255,107,0,0.5); box-shadow: 0 24px 60px rgba(255,107,0,0.2); }
.card-photo { position: relative; aspect-ratio: 1; overflow: hidden; }
.card-photo img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
.artist-card:hover .card-photo img { transform: scale(1.08); }
.photo-placeholder {
  width: 100%; height: 100%;
  background: linear-gradient(135deg, #ff6b00, #ffd700);
  display: flex; align-items: center; justify-content: center;
}
.photo-placeholder span { font-family: 'Cinzel', serif; font-size: 3rem; font-weight: 700; color: #fff; }
.card-overlay {
  position: absolute; inset: 0;
  background: rgba(0,0,0,0.7);
  display: flex; flex-direction: column;
  align-items: center; justify-content: center;
  gap: 1rem;
  opacity: 0; transition: opacity .3s;
}
.artist-card:hover .card-overlay { opacity: 1; }
.overlay-socials { display: flex; gap: .75rem; }
.social-dot {
  width: 38px; height: 38px; border-radius: 50%;
  background: rgba(255,255,255,0.1);
  display: flex; align-items: center; justify-content: center;
  color: #fff; text-decoration: none; font-size: .95rem;
  transition: background .2s;
}
.social-dot:hover { background: #ff6b00; }
.view-btn { color: #ffd700; font-size: .8rem; letter-spacing: 2px; text-transform: uppercase; font-weight: 600; }
.card-body { padding: 1.25rem; }
.card-name { font-family: 'Cinzel', serif; color: #fff; font-size: 1rem; font-weight: 600; margin-bottom: .3rem; letter-spacing: 1px; }
.card-genre { color: #ff6b00; font-size: .72rem; letter-spacing: 2px; text-transform: uppercase; font-weight: 500; display: block; margin-bottom: .5rem; }
.card-meta { font-size: .75rem; color: rgba(255,255,255,0.3); display: flex; gap: 1rem; }
.card-meta i { margin-right: .3rem; color: #ff6b00; }

/* Skeleton */
.loading-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px,1fr)); gap: 1.5rem; }
.skeleton-card { height: 320px; border-radius: 20px; background: linear-gradient(90deg, #1e0c00 25%, #2a1000 50%, #1e0c00 75%); background-size: 200% 100%; animation: shimmer 1.5s infinite; }
@keyframes shimmer { 0%{background-position:200% 0} 100%{background-position:-200% 0} }

/* Empty */
.empty-state { text-align: center; padding: 5rem 0; color: rgba(255,255,255,0.3); }
.empty-state i { font-size: 3rem; margin-bottom: 1rem; display: block; }

/* Pagination */
.pagination { display: flex; align-items: center; justify-content: center; gap: 1rem; margin-top: 3rem; }
.page-btn { width: 40px; height: 40px; border-radius: 50%; background: rgba(255,107,0,0.1); border: 1px solid rgba(255,107,0,0.3); color: #ff6b00; cursor: pointer; transition: all .2s; }
.page-btn:hover:not(:disabled) { background: #ff6b00; color: #fff; }
.page-btn:disabled { opacity: .3; cursor: not-allowed; }
.page-info { color: rgba(255,255,255,0.5); font-size: .9rem; }

@media (max-width: 768px) {
  .page-banner { padding: 8rem 1.5rem 3rem; }
  .content { padding: 2rem 1rem; }
}
</style>
