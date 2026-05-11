<template>
  <div class="artist-form-page">

    <div class="form-header">
      <RouterLink to="/admin/artists" class="back-btn">
        <i class="fas fa-arrow-left"></i> Back to Artists
      </RouterLink>
      <h2>{{ isEditing ? 'Edit Artist' : 'Add New Artist' }}</h2>
    </div>

    <div v-if="pageLoading" class="loading-state">
      <i class="fas fa-spinner fa-spin"></i> Loading...
    </div>

    <form v-else @submit.prevent="handleSubmit" enctype="multipart/form-data">
      <div class="form-grid">

        <!-- LEFT: Photo upload -->
        <div class="form-left">
          <div class="photo-upload" @click="$refs.photoInput.click()">
            <img v-if="photoPreview" :src="photoPreview" class="photo-preview" />
            <div v-else class="photo-placeholder">
              <i class="fas fa-camera"></i>
              <span>Upload Photo</span>
              <small>JPG, PNG — max 5MB</small>
            </div>
            <div class="photo-overlay">
              <i class="fas fa-camera"></i>
              <span>Change Photo</span>
            </div>
          </div>
          <input
            ref="photoInput"
            type="file"
            accept="image/*"
            class="hidden"
            @change="handlePhoto"
          />

          <!-- Toggles -->
          <div class="toggle-card">
            <div class="toggle-row">
              <div>
                <span class="toggle-label">Featured Artist</span>
                <small>Show on homepage</small>
              </div>
              <label class="toggle">
                <input type="checkbox" v-model="form.is_featured" />
                <span class="toggle-slider"></span>
              </label>
            </div>
            <div class="toggle-row">
              <div>
                <span class="toggle-label">Active</span>
                <small>Visible on website</small>
              </div>
              <label class="toggle">
                <input type="checkbox" v-model="form.is_active" />
                <span class="toggle-slider"></span>
              </label>
            </div>
          </div>
        </div>

        <!-- RIGHT: Fields -->
        <div class="form-right">

          <!-- Basic Info -->
          <div class="form-section">
            <h3 class="section-title"><i class="fas fa-user"></i> Basic Information</h3>
            <div class="field-row">
              <div class="field-group">
                <label>Artist Name <span class="required">*</span></label>
                <input v-model="form.name" type="text" placeholder="e.g. Riya Sen" required />
              </div>
              <div class="field-group">
                <label>Genre</label>
                <select v-model="form.genre">
                  <option value="">Select genre</option>
                  <option v-for="g in genreOptions" :key="g" :value="g">{{ g }}</option>
                </select>
              </div>
            </div>
            <div class="field-group">
              <label>Biography</label>
              <textarea v-model="form.bio" rows="5" placeholder="Tell the artist's story..."></textarea>
              <small>{{ form.bio?.length || 0 }} characters</small>
            </div>
          </div>

          <!-- Social Links -->
          <div class="form-section">
            <h3 class="section-title"><i class="fas fa-share-alt"></i> Social & Streaming Links</h3>
            <p class="section-desc">Add links to the artist's profiles. Icons will appear automatically on the website.</p>

            <div class="social-fields">
              <div v-for="social in socialFields" :key="social.field" class="social-field">
                <div class="social-icon-wrap" :style="{ background: social.color + '22', borderColor: social.color + '44' }">
                  <i :class="social.icon" :style="{ color: social.color }"></i>
                </div>
                <div class="social-input-wrap">
                  <label>{{ social.label }}</label>
                  <input
                    v-model="form[social.field]"
                    type="url"
                    :placeholder="social.placeholder"
                  />
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

      <!-- Submit -->
      <div class="form-actions">
        <RouterLink to="/admin/artists" class="cancel-btn">Cancel</RouterLink>
        <button type="submit" class="submit-btn" :disabled="saving">
          <span v-if="saving"><i class="fas fa-spinner fa-spin"></i> Saving...</span>
          <span v-else><i class="fas fa-check"></i> {{ isEditing ? 'Update Artist' : 'Create Artist' }}</span>
        </button>
      </div>

      <!-- Success/Error -->
      <transition name="fade">
        <div v-if="successMsg" class="success-alert"><i class="fas fa-check-circle"></i> {{ successMsg }}</div>
      </transition>
      <transition name="fade">
        <div v-if="errorMsg" class="error-alert"><i class="fas fa-exclamation-circle"></i> {{ errorMsg }}</div>
      </transition>
    </form>

  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { RouterLink, useRoute, useRouter } from 'vue-router'
import { useAuthStore } from '../../store/auth.js'

const route  = useRoute()
const router = useRouter()
const auth   = useAuthStore()

const isEditing  = computed(() => !!route.params.id)
const pageLoading = ref(false)
const saving     = ref(false)
const successMsg = ref('')
const errorMsg   = ref('')
const photoPreview = ref(null)
const photoFile    = ref(null)
const photoInput   = ref(null)

const form = ref({
  name: '', genre: '', bio: '',
  spotify_url: '', instagram_url: '', apple_music_url: '',
  youtube_url: '', facebook_url: '', twitter_url: '', soundcloud_url: '',
  is_featured: false, is_active: true,
})

const genreOptions = [
  'Pop','Hip-Hop','Rock','Classical','Electronic','Folk',
  'Jazz','R&B','Classical Fusion','Indie','Devotional','World'
]

const socialFields = [
  { field:'spotify_url',     label:'Spotify',      icon:'fab fa-spotify',     color:'#1DB954', placeholder:'https://open.spotify.com/artist/...' },
  { field:'instagram_url',   label:'Instagram',    icon:'fab fa-instagram',   color:'#E1306C', placeholder:'https://instagram.com/...' },
  { field:'apple_music_url', label:'Apple Music',  icon:'fab fa-apple',       color:'#FC3C44', placeholder:'https://music.apple.com/...' },
  { field:'youtube_url',     label:'YouTube',      icon:'fab fa-youtube',     color:'#FF0000', placeholder:'https://youtube.com/@...' },
  { field:'facebook_url',    label:'Facebook',     icon:'fab fa-facebook-f',  color:'#1877F2', placeholder:'https://facebook.com/...' },
  { field:'twitter_url',     label:'Twitter / X',  icon:'fab fa-twitter',     color:'#1DA1F2', placeholder:'https://twitter.com/...' },
  { field:'soundcloud_url',  label:'SoundCloud',   icon:'fab fa-soundcloud',  color:'#FF5500', placeholder:'https://soundcloud.com/...' },
]

function handlePhoto(e) {
  const file = e.target.files[0]
  if (!file) return
  photoFile.value = file
  photoPreview.value = URL.createObjectURL(file)
}

async function handleSubmit() {
  saving.value   = true
  successMsg.value = ''
  errorMsg.value   = ''

  const fd = new FormData()
  Object.entries(form.value).forEach(([k,v]) => {
    if (v !== null && v !== undefined) fd.append(k, v)
  })
  if (photoFile.value) fd.append('photo', photoFile.value)

  const url = isEditing.value
    ? `/api/admin/artists/${route.params.id}`
    : '/api/admin/artists'

  try {
    const res = await fetch(url, {
      method: 'POST',
      headers: auth.authHeaders(),
      body: fd,
    })
    const data = await res.json()
    if (!res.ok) throw new Error(data.message || 'Error saving artist')

    successMsg.value = data.message
    setTimeout(() => router.push('/admin/artists'), 1500)
  } catch (e) {
    errorMsg.value = e.message
  } finally {
    saving.value = false
  }
}

async function loadArtist() {
  if (!isEditing.value) return
  pageLoading.value = true
  const res = await fetch(`/api/admin/artists/${route.params.id}`, {
    headers: auth.authHeaders()
  })
  const data = await res.json()
  const a = data.data
  Object.keys(form.value).forEach(k => { if (a[k] !== undefined) form.value[k] = a[k] })
  if (a.photo_url) photoPreview.value = a.photo_url
  pageLoading.value = false
}

onMounted(loadArtist)
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap');
* { font-family: 'Inter', sans-serif; }

.artist-form-page { max-width: 1100px; }

.form-header { display: flex; align-items: center; gap: 1.5rem; margin-bottom: 2rem; }
.back-btn { color: rgba(255,255,255,0.4); text-decoration: none; font-size: .85rem; transition: color .2s; }
.back-btn:hover { color: #ff6b00; }
.form-header h2 { font-family: 'Cinzel', serif; color: #fff; font-size: 1.4rem; font-weight: 600; margin: 0; }

.loading-state { text-align: center; padding: 4rem; color: rgba(255,255,255,0.4); font-size: 1rem; }

.form-grid { display: grid; grid-template-columns: 280px 1fr; gap: 2rem; margin-bottom: 2rem; }

/* Left */
.form-left { display: flex; flex-direction: column; gap: 1.5rem; }

.photo-upload {
  position: relative;
  aspect-ratio: 1;
  border-radius: 20px;
  overflow: hidden;
  cursor: pointer;
  border: 2px dashed rgba(255,107,0,0.3);
  background: rgba(255,107,0,0.03);
  transition: border-color .2s;
}
.photo-upload:hover { border-color: #ff6b00; }

.photo-preview { width: 100%; height: 100%; object-fit: cover; }

.photo-placeholder {
  display: flex; flex-direction: column; align-items: center; justify-content: center;
  height: 100%; gap: .75rem; color: rgba(255,255,255,0.3);
}
.photo-placeholder i { font-size: 2.5rem; color: rgba(255,107,0,0.4); }
.photo-placeholder span { font-size: .9rem; }
.photo-placeholder small { font-size: .75rem; }

.photo-overlay {
  position: absolute; inset: 0;
  background: rgba(0,0,0,0.6);
  display: flex; flex-direction: column; align-items: center; justify-content: center;
  gap: .5rem; color: #fff; opacity: 0; transition: opacity .2s;
}
.photo-upload:hover .photo-overlay { opacity: 1; }

.hidden { display: none; }

.toggle-card {
  background: rgba(255,107,0,0.05);
  border: 1px solid rgba(255,107,0,0.1);
  border-radius: 16px;
  padding: 1.25rem;
  display: flex; flex-direction: column; gap: 1rem;
}
.toggle-row { display: flex; align-items: center; justify-content: space-between; gap: 1rem; }
.toggle-label { display: block; font-size: .9rem; font-weight: 500; color: #fff; }
.toggle-row small { font-size: .75rem; color: rgba(255,255,255,0.3); }

.toggle { position: relative; width: 44px; height: 24px; flex-shrink: 0; }
.toggle input { opacity: 0; width: 0; height: 0; }
.toggle-slider {
  position: absolute; inset: 0;
  background: rgba(255,255,255,0.1);
  border-radius: 24px;
  cursor: pointer;
  transition: .3s;
}
.toggle-slider::before {
  content: '';
  position: absolute;
  width: 18px; height: 18px;
  border-radius: 50%;
  background: #fff;
  left: 3px; top: 3px;
  transition: .3s;
}
.toggle input:checked + .toggle-slider { background: #ff6b00; }
.toggle input:checked + .toggle-slider::before { transform: translateX(20px); }

/* Right */
.form-right { display: flex; flex-direction: column; gap: 2rem; }

.form-section {
  background: rgba(255,107,0,0.03);
  border: 1px solid rgba(255,107,0,0.1);
  border-radius: 20px;
  padding: 1.75rem;
}
.section-title {
  font-family: 'Cinzel', serif;
  font-size: .95rem; font-weight: 600;
  color: #ff6b00;
  margin-bottom: 1.25rem;
  display: flex; align-items: center; gap: .6rem;
}
.section-desc { font-size: .85rem; color: rgba(255,255,255,0.35); margin-bottom: 1.25rem; }

.field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem; }
.field-group { display: flex; flex-direction: column; gap: .5rem; }
.field-group:not(:last-child) { margin-bottom: 1.25rem; }
.field-group label { font-size: .8rem; font-weight: 500; color: rgba(255,255,255,0.5); }
.required { color: #ff6b00; }

input[type="text"],
input[type="url"],
input[type="email"],
select,
textarea {
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,107,0,0.15);
  border-radius: 10px;
  color: #fff;
  padding: .75rem 1rem;
  font-size: .9rem;
  outline: none;
  transition: border-color .2s;
  font-family: 'Inter', sans-serif;
  width: 100%;
  resize: vertical;
}
input:focus, select:focus, textarea:focus { border-color: #ff6b00; }
input::placeholder, textarea::placeholder { color: rgba(255,255,255,0.2); }
select option { background: #1a0800; }
.field-group small { font-size: .72rem; color: rgba(255,255,255,0.25); text-align: right; }

/* Socials */
.social-fields { display: flex; flex-direction: column; gap: 1rem; }
.social-field { display: flex; align-items: center; gap: 1rem; }
.social-icon-wrap {
  width: 46px; height: 46px;
  border-radius: 12px;
  border: 1px solid;
  display: flex; align-items: center; justify-content: center;
  font-size: 1.1rem; flex-shrink: 0;
}
.social-input-wrap { flex: 1; }
.social-input-wrap label { display: block; font-size: .72rem; font-weight: 500; color: rgba(255,255,255,0.4); margin-bottom: .3rem; letter-spacing: .5px; }
.social-input-wrap input { margin: 0; }

/* Actions */
.form-actions {
  display: flex; align-items: center; gap: 1rem;
  justify-content: flex-end;
  padding-top: 1.5rem;
  border-top: 1px solid rgba(255,107,0,0.1);
}
.cancel-btn {
  padding: .8rem 2rem;
  border: 1px solid rgba(255,255,255,0.1);
  border-radius: 12px;
  color: rgba(255,255,255,0.5);
  text-decoration: none;
  font-size: .9rem;
  transition: all .2s;
}
.cancel-btn:hover { border-color: rgba(255,255,255,0.2); color: #fff; }

.submit-btn {
  padding: .85rem 2.5rem;
  background: linear-gradient(135deg, #ff6b00, #ff9500);
  color: #fff; border: none;
  border-radius: 12px;
  font-size: .9rem; font-weight: 700;
  cursor: pointer;
  transition: all .3s;
  box-shadow: 0 8px 24px rgba(255,107,0,0.3);
  font-family: 'Inter', sans-serif;
}
.submit-btn:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(255,107,0,0.5); }
.submit-btn:disabled { opacity: .6; cursor: not-allowed; }

.success-alert {
  margin-top: 1rem; padding: .85rem 1.25rem;
  background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.3);
  color: #86efac; border-radius: 10px; font-size: .9rem;
}
.error-alert {
  margin-top: 1rem; padding: .85rem 1.25rem;
  background: rgba(220,38,38,0.1); border: 1px solid rgba(220,38,38,0.3);
  color: #fca5a5; border-radius: 10px; font-size: .9rem;
}
.fade-enter-active, .fade-leave-active { transition: opacity .3s; }
.fade-enter-from, .fade-leave-to { opacity: 0; }

@media (max-width: 768px) {
  .form-grid { grid-template-columns: 1fr; }
  .field-row { grid-template-columns: 1fr; }
}
</style>
