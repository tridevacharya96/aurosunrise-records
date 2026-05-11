<template>
  <div class="admin-artists">

    <div class="page-top">
      <div>
        <h2 class="page-heading">Artists</h2>
        <p class="page-sub">{{ meta.total || 0 }} artists in your roster</p>
      </div>
      <RouterLink to="/admin/artists/new" class="add-btn">
        <i class="fas fa-plus"></i> Add Artist
      </RouterLink>
    </div>

    <!-- Search -->
    <div class="search-bar">
      <i class="fas fa-search"></i>
      <input v-model="search" type="text" placeholder="Search artists..." @input="debouncedFetch" />
    </div>

    <!-- Loading -->
    <div v-if="loading" class="loading-state">
      <i class="fas fa-spinner fa-spin"></i> Loading artists...
    </div>

    <!-- Table -->
    <div v-else class="table-wrap">
      <table class="artists-table">
        <thead>
          <tr>
            <th>Artist</th>
            <th>Genre</th>
            <th>Albums</th>
            <th>Streaming</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="artist in artists" :key="artist.id" class="artist-row">
            <td>
              <div class="artist-cell">
                <div class="artist-thumb">
                  <img v-if="artist.photo_url" :src="artist.photo_url" :alt="artist.name" />
                  <span v-else>{{ initials(artist.name) }}</span>
                </div>
                <div>
                  <p class="artist-name">{{ artist.name }}</p>
                  <p class="artist-slug">/artists/{{ artist.slug }}</p>
                </div>
              </div>
            </td>
            <td><span class="genre-tag">{{ artist.genre || '—' }}</span></td>
            <td><span class="albums-count">{{ artist.albums_count }}</span></td>
            <td>
              <div class="social-icons">
                <a v-for="s in artist.socials.slice(0,4)" :key="s.label" :href="s.url" target="_blank" :title="s.label" class="social-icon">
                  <i :class="s.icon" :style="{ color: getSocialColor(s.label) }"></i>
                </a>
                <span v-if="artist.socials.length === 0" class="no-socials">None</span>
              </div>
            </td>
            <td>
              <div class="status-badges">
                <span :class="['status-badge', artist.is_active ? 'active' : 'inactive']">
                  {{ artist.is_active ? 'Active' : 'Inactive' }}
                </span>
                <span v-if="artist.is_featured" class="featured-badge">
                  <i class="fas fa-star"></i> Featured
                </span>
              </div>
            </td>
            <td>
              <div class="action-btns">
                <RouterLink :to="`/admin/artists/${artist.id}/edit`" class="action-btn edit" title="Edit">
                  <i class="fas fa-pen"></i>
                </RouterLink>
                <button class="action-btn feature" @click="toggleFeatured(artist)" :title="artist.is_featured ? 'Unfeature' : 'Feature'">
                  <i :class="artist.is_featured ? 'fas fa-star' : 'far fa-star'"></i>
                </button>
                <button class="action-btn delete" @click="confirmDelete(artist)" title="Delete">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>

      <div v-if="artists.length === 0" class="empty-state">
        <i class="fas fa-microphone-slash"></i>
        <p>No artists yet.</p>
        <RouterLink to="/admin/artists/new" class="add-btn">Add your first artist</RouterLink>
      </div>
    </div>

    <!-- Pagination -->
    <div v-if="meta.last_page > 1" class="pagination">
      <button :disabled="meta.current_page === 1" @click="goPage(meta.current_page-1)" class="page-btn">
        <i class="fas fa-chevron-left"></i>
      </button>
      <span>{{ meta.current_page }} of {{ meta.last_page }}</span>
      <button :disabled="meta.current_page === meta.last_page" @click="goPage(meta.current_page+1)" class="page-btn">
        <i class="fas fa-chevron-right"></i>
      </button>
    </div>

    <!-- Delete Modal -->
    <div v-if="deleteTarget" class="modal-overlay" @click.self="deleteTarget = null">
      <div class="modal">
        <h3>Delete Artist?</h3>
        <p>Are you sure you want to delete <strong>{{ deleteTarget.name }}</strong>? This cannot be undone.</p>
        <div class="modal-actions">
          <button @click="deleteTarget = null" class="cancel-btn">Cancel</button>
          <button @click="doDelete" class="confirm-delete-btn" :disabled="deleting">
            <span v-if="deleting"><i class="fas fa-spinner fa-spin"></i></span>
            <span v-else>Delete</span>
          </button>
        </div>
      </div>
    </div>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { RouterLink } from 'vue-router'
import { useAuthStore } from '../../store/auth.js'

const auth    = useAuthStore()
const artists = ref([])
const loading = ref(true)
const search  = ref('')
const page    = ref(1)
const meta    = ref({ current_page:1, last_page:1, total:0 })
const deleteTarget = ref(null)
const deleting     = ref(false)

let debounceTimer = null

const socialColors = {
  Spotify:'#1DB954', Instagram:'#E1306C', 'Apple Music':'#FC3C44',
  YouTube:'#FF0000', Facebook:'#1877F2', Twitter:'#1DA1F2', SoundCloud:'#FF5500'
}
function getSocialColor(label) { return socialColors[label] || '#fff' }

async function fetchArtists() {
  loading.value = true
  const params = new URLSearchParams({ page: page.value, per_page: 15 })
  if (search.value) params.append('search', search.value)
  const res  = await fetch(`/api/admin/artists?${params}`, { headers: auth.authHeaders() })
  const data = await res.json()
  artists.value = data.data
  meta.value    = data.meta
  loading.value = false
}

function debouncedFetch() {
  clearTimeout(debounceTimer)
  debounceTimer = setTimeout(fetchArtists, 400)
}

function goPage(p) { page.value = p; fetchArtists() }

function initials(name) { return name.split(' ').map(w=>w[0]).join('').toUpperCase().slice(0,2) }

async function toggleFeatured(artist) {
  await fetch(`/api/admin/artists/${artist.id}/featured`, {
    method: 'PATCH', headers: auth.authHeaders()
  })
  artist.is_featured = !artist.is_featured
}

function confirmDelete(artist) { deleteTarget.value = artist }

async function doDelete() {
  deleting.value = true
  await fetch(`/api/admin/artists/${deleteTarget.value.id}`, {
    method: 'DELETE', headers: auth.authHeaders()
  })
  deleteTarget.value = null
  deleting.value = false
  fetchArtists()
}

onMounted(fetchArtists)
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap');
* { font-family: 'Inter', sans-serif; }

.admin-artists { max-width: 1200px; }
.page-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem; }
.page-heading { font-family: 'Cinzel', serif; font-size: 1.5rem; font-weight: 700; color: #fff; margin: 0 0 .25rem; }
.page-sub { font-size: .85rem; color: rgba(255,255,255,0.35); margin: 0; }

.add-btn {
  display: inline-flex; align-items: center; gap: .6rem;
  padding: .75rem 1.5rem;
  background: linear-gradient(135deg, #ff6b00, #ff9500);
  color: #fff; text-decoration: none; border-radius: 12px;
  font-size: .88rem; font-weight: 600;
  transition: all .3s;
  box-shadow: 0 6px 20px rgba(255,107,0,0.3);
  white-space: nowrap;
}
.add-btn:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(255,107,0,0.5); }

.search-bar {
  position: relative; margin-bottom: 1.5rem;
}
.search-bar i { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: rgba(255,255,255,0.3); }
.search-bar input {
  width: 100%; max-width: 400px;
  padding: .85rem 1rem .85rem 2.75rem;
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,107,0,0.15);
  border-radius: 12px; color: #fff; font-size: .9rem; outline: none;
  transition: border-color .2s;
}
.search-bar input:focus { border-color: #ff6b00; }
.search-bar input::placeholder { color: rgba(255,255,255,0.25); }

.loading-state { text-align: center; padding: 4rem; color: rgba(255,255,255,0.3); }

.table-wrap { overflow-x: auto; border-radius: 16px; border: 1px solid rgba(255,107,0,0.1); }
.artists-table { width: 100%; border-collapse: collapse; }
.artists-table th {
  padding: 1rem 1.25rem; text-align: left;
  font-size: .72rem; font-weight: 600;
  color: rgba(255,107,0,0.7);
  text-transform: uppercase; letter-spacing: 1px;
  background: rgba(255,107,0,0.05);
  border-bottom: 1px solid rgba(255,107,0,0.1);
}
.artist-row { border-bottom: 1px solid rgba(255,255,255,0.04); transition: background .2s; }
.artist-row:last-child { border-bottom: none; }
.artist-row:hover { background: rgba(255,107,0,0.03); }
.artist-row td { padding: 1rem 1.25rem; vertical-align: middle; }

.artist-cell { display: flex; align-items: center; gap: 1rem; }
.artist-thumb {
  width: 44px; height: 44px; border-radius: 10px; overflow: hidden; flex-shrink: 0;
  background: linear-gradient(135deg, #ff6b00, #ffd700);
  display: flex; align-items: center; justify-content: center;
  font-size: .85rem; font-weight: 700; color: #fff;
}
.artist-thumb img { width: 100%; height: 100%; object-fit: cover; }
.artist-name { color: #fff; font-size: .92rem; font-weight: 500; margin: 0 0 2px; }
.artist-slug { color: rgba(255,255,255,0.25); font-size: .72rem; margin: 0; }

.genre-tag {
  background: rgba(255,107,0,0.1);
  color: #ff6b00;
  padding: .25rem .75rem;
  border-radius: 20px;
  font-size: .75rem;
  font-weight: 500;
  white-space: nowrap;
}
.albums-count { color: rgba(255,255,255,0.5); font-size: .9rem; font-weight: 500; }

.social-icons { display: flex; gap: .5rem; align-items: center; }
.social-icon { font-size: 1rem; transition: transform .2s; }
.social-icon:hover { transform: scale(1.2); }
.no-socials { font-size: .75rem; color: rgba(255,255,255,0.2); }

.status-badges { display: flex; flex-direction: column; gap: .35rem; }
.status-badge {
  display: inline-block; font-size: .72rem; font-weight: 600;
  padding: .2rem .7rem; border-radius: 20px;
}
.status-badge.active { background: rgba(34,197,94,0.15); color: #86efac; }
.status-badge.inactive { background: rgba(239,68,68,0.15); color: #fca5a5; }
.featured-badge { display: inline-flex; align-items: center; gap: .3rem; font-size: .68rem; color: #ffd700; }

.action-btns { display: flex; gap: .5rem; }
.action-btn {
  width: 32px; height: 32px;
  border-radius: 8px; border: none;
  display: flex; align-items: center; justify-content: center;
  font-size: .8rem; cursor: pointer;
  transition: all .2s; text-decoration: none;
  background: rgba(255,255,255,0.05);
  color: rgba(255,255,255,0.5);
}
.action-btn.edit:hover   { background: rgba(255,107,0,0.2); color: #ff6b00; }
.action-btn.feature:hover { background: rgba(255,215,0,0.2); color: #ffd700; }
.action-btn.delete:hover  { background: rgba(239,68,68,0.2); color: #f87171; }
.action-btn.feature.active { color: #ffd700; }

.empty-state { text-align: center; padding: 4rem; color: rgba(255,255,255,0.3); }
.empty-state i { font-size: 2.5rem; margin-bottom: 1rem; display: block; }
.empty-state p { margin-bottom: 1rem; }

.pagination { display: flex; align-items: center; justify-content: center; gap: 1rem; margin-top: 1.5rem; color: rgba(255,255,255,0.4); font-size: .9rem; }
.page-btn { width: 36px; height: 36px; border-radius: 8px; background: rgba(255,107,0,0.1); border: 1px solid rgba(255,107,0,0.2); color: #ff6b00; cursor: pointer; transition: all .2s; }
.page-btn:hover:not(:disabled) { background: #ff6b00; color: #fff; }
.page-btn:disabled { opacity: .3; cursor: not-allowed; }

/* Modal */
.modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.7); display: flex; align-items: center; justify-content: center; z-index: 9999; }
.modal { background: #1e0c00; border: 1px solid rgba(255,107,0,0.2); border-radius: 20px; padding: 2rem; max-width: 420px; width: 90%; }
.modal h3 { font-family: 'Cinzel', serif; color: #fff; font-size: 1.1rem; margin-bottom: .75rem; }
.modal p { color: rgba(255,255,255,0.5); font-size: .9rem; line-height: 1.6; margin-bottom: 1.5rem; }
.modal p strong { color: #fff; }
.modal-actions { display: flex; gap: .75rem; justify-content: flex-end; }
.cancel-btn { padding: .65rem 1.5rem; border: 1px solid rgba(255,255,255,0.1); border-radius: 10px; background: none; color: rgba(255,255,255,0.5); cursor: pointer; font-size: .88rem; transition: all .2s; font-family: 'Inter', sans-serif; }
.cancel-btn:hover { color: #fff; border-color: rgba(255,255,255,0.2); }
.confirm-delete-btn { padding: .65rem 1.5rem; border-radius: 10px; border: none; background: rgba(239,68,68,0.8); color: #fff; cursor: pointer; font-size: .88rem; font-weight: 600; transition: all .2s; font-family: 'Inter', sans-serif; }
.confirm-delete-btn:hover { background: rgb(239,68,68); }
.confirm-delete-btn:disabled { opacity: .6; }
</style>
