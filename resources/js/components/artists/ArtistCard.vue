<template>
  <!--
    📚 LEARNING NOTE: This is a "presentational" (dumb) component.
    It only receives data via props and emits events up.
    It has NO business logic, NO API calls.
    The parent (ArtistsPage) owns the data; this just displays it.

    This separation makes components:
    - Easy to test
    - Reusable in different contexts
    - Easy to understand at a glance
  -->
  <div class="artist-card" @mouseenter="isHovered = true" @mouseleave="isHovered = false">
    <div class="card-media">
      <img
        :src="artist.photo || '/assets/images/artists/placeholder.jpg'"
        :alt="artist.name"
        class="card-img"
        loading="lazy"
      />
      <!--
        📚 LEARNING NOTE: <transition> animates elements when they
        appear/disappear from the DOM (v-if/v-show).
        The name="fade" corresponds to CSS classes like .fade-enter-active.
      -->
      <transition name="fade">
        <div v-if="isHovered" class="card-overlay">
          <div class="overlay-social">
            <a
              v-for="social in artist.socials"
              :key="social.platform"
              :href="social.url"
              target="_blank"
              :aria-label="social.platform"
              class="social-btn"
            >
              <i :class="social.icon"></i>
            </a>
          </div>
          <button class="btn btn-sm btn-warning" @click="listenLatest">
            <i class="fas fa-play me-1"></i> Listen
          </button>
        </div>
      </transition>
    </div>

    <div class="card-body">
      <RouterLink :to="`/artists/${artist.slug}`" class="artist-name">
        {{ artist.name }}
      </RouterLink>
      <span class="artist-genre">{{ artist.genre }}</span>
      <div class="artist-stats">
        <span><i class="fas fa-compact-disc me-1"></i>{{ artist.albums_count }} Albums</span>
        <span><i class="fas fa-music me-1"></i>{{ artist.tracks_count }} Tracks</span>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { RouterLink } from 'vue-router'
import { useMusicPlayerStore } from '../../store/musicPlayer.js'

/**
 * 📚 LEARNING NOTE: defineProps() declares what data this component
 * accepts from its parent. This is how parent → child communication works.
 *
 * Parent passes: <ArtistCard :artist="artistObject" />
 * Child receives: props.artist (or just "artist" in template)
 *
 * The type validation helps catch bugs early.
 * required: true means the parent MUST provide this prop.
 */
const props = defineProps({
  artist: {
    type: Object,
    required: true,
    // default() returns a fallback if prop not provided
    default: () => ({
      id: 0,
      name: 'Unknown Artist',
      slug: 'unknown',
      genre: 'Music',
      photo: null,
      albums_count: 0,
      tracks_count: 0,
      socials: []
    })
  }
})

/**
 * 📚 LEARNING NOTE: defineEmits() declares custom events this component
 * can send to its parent. This is child → parent communication.
 *
 * Usage in template: @emit-name="parentFunction"
 * Usage in script: emit('emit-name', data)
 */
const emit = defineEmits(['play-track'])

const player = useMusicPlayerStore()
const isHovered = ref(false)

function listenLatest() {
  if (props.artist.latest_track) {
    player.play(props.artist.latest_track)
    // Also notify parent if it cares
    emit('play-track', props.artist.latest_track)
  }
}
</script>

<style scoped>
.artist-card {
  border-radius: 12px;
  overflow: hidden;
  background: #141414;
  transition: transform 0.3s, box-shadow 0.3s;
  cursor: pointer;
}

.artist-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 20px 60px rgba(245, 166, 35, 0.2);
}

.card-media {
  position: relative;
  aspect-ratio: 1;
  overflow: hidden;
}

.card-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.4s;
}

.artist-card:hover .card-img {
  transform: scale(1.08);
}

.card-overlay {
  position: absolute;
  inset: 0;
  background: rgba(0,0,0,0.7);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 1rem;
}

.overlay-social {
  display: flex;
  gap: 0.75rem;
}

.social-btn {
  width: 36px;
  height: 36px;
  background: rgba(255,255,255,0.1);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  text-decoration: none;
  transition: background 0.2s;
}

.social-btn:hover { background: #f5a623; color: #000; }

.card-body {
  padding: 1.25rem;
}

.artist-name {
  display: block;
  font-size: 1.1rem;
  font-weight: 700;
  color: #fff;
  text-decoration: none;
  margin-bottom: 0.25rem;
  transition: color 0.2s;
}

.artist-name:hover { color: #f5a623; }

.artist-genre {
  font-size: 0.8rem;
  color: #f5a623;
  text-transform: uppercase;
  letter-spacing: 1px;
  display: block;
  margin-bottom: 0.75rem;
}

.artist-stats {
  display: flex;
  gap: 1rem;
  font-size: 0.75rem;
  color: rgba(255,255,255,0.4);
}

.fade-enter-active,
.fade-leave-active { transition: opacity 0.25s; }
.fade-enter-from,
.fade-leave-to { opacity: 0; }
</style>
