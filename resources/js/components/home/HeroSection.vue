<template>
  <!--
    📚 LEARNING NOTE: ref="heroSection" creates a "template ref"
    You can then access the DOM element via heroSection.value in script.
    This is how you directly manipulate DOM elements in Vue.
  -->
  <section class="hero-section" ref="heroSection">
    <div class="hero-bg-overlay"></div>

    <!-- Swiper Slider (integrated via mounted hook) -->
    <div class="swiper hero-swiper">
      <div class="swiper-wrapper">
        <!--
          📚 LEARNING NOTE: v-for renders a list of elements.
          :key is REQUIRED — Vue uses it to track which item is which
          when the list changes. Always use a unique ID as the key.
        -->
        <div
          v-for="slide in slides"
          :key="slide.id"
          class="swiper-slide hero-slide"
          :style="{ backgroundImage: `url(${slide.image})` }"
        >
          <div class="hero-content container">
            <div class="row align-items-center min-vh-100">
              <div class="col-lg-7">
                <div class="hero-text">
                  <!--
                    📚 LEARNING NOTE: v-html renders raw HTML from data.
                    Use carefully — never render untrusted user input with v-html!
                  -->
                  <span class="hero-subtitle wow fadeInUp" v-html="slide.subtitle"></span>
                  <h1 class="hero-title wow fadeInUp" data-wow-delay="0.3s">
                    {{ slide.title }}
                  </h1>
                  <p class="hero-desc wow fadeInUp" data-wow-delay="0.5s">
                    {{ slide.description }}
                  </p>
                  <div class="hero-btns wow fadeInUp" data-wow-delay="0.7s">
                    <RouterLink :to="slide.primaryLink" class="btn btn-primary btn-lg me-3">
                      <span>{{ slide.primaryLabel }}</span>
                    </RouterLink>
                    <button
                      v-if="slide.track"
                      class="btn btn-outline-light btn-lg"
                      @click="playSlideTrack(slide.track)"
                    >
                      <i class="fas fa-play me-2"></i>
                      <span>Listen Now</span>
                    </button>
                  </div>
                </div>
              </div>

              <div class="col-lg-5 d-none d-lg-block">
                <div class="hero-album-art wow zoomIn" data-wow-delay="0.5s">
                  <img :src="slide.albumArt" :alt="slide.title" class="img-fluid rounded" />
                  <div class="hero-vinyl">
                    <div class="vinyl-disc" :class="{ spinning: isPlayingSlide }">
                      <div class="vinyl-label">
                        <span>A</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Swiper controls -->
      <div class="swiper-button-prev hero-prev"></div>
      <div class="swiper-button-next hero-next"></div>
      <div class="swiper-pagination hero-pagination"></div>
    </div>

    <!-- Scroll indicator -->
    <div class="scroll-indicator">
      <div class="scroll-dot"></div>
      <span>Scroll Down</span>
    </div>

  </section>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue'
import { RouterLink } from 'vue-router'
import { useMusicPlayerStore } from '../../store/musicPlayer.js'

const player = useMusicPlayerStore()

const heroSection = ref(null)   // Template ref for the section element
let swiperInstance = null       // Swiper instance (not reactive — no need)

// ─── Data ─────────────────────────────────────────
const slides = [
  {
    id: 1,
    subtitle: 'New Release — 2025',
    title: 'Where Sound Meets Soul',
    description: 'Aurosunrise Records — crafting authentic music that resonates across generations. Discover our latest releases from South India\'s brightest artists.',
    image: '/assets/images/hero/hero1.jpg',
    albumArt: '/assets/images/albums/album-cover-1.jpg',
    primaryLink: '/albums',
    primaryLabel: 'Explore Albums',
    track: {
      id: 1,
      title: 'Golden Hour',
      artist: 'Riya Sen',
      audio_url: '/assets/song/song1.mp3',
      cover_image: '/assets/images/albums/album-cover-1.jpg'
    }
  },
  {
    id: 2,
    subtitle: 'Artist Spotlight',
    title: 'Voices That Move Mountains',
    description: 'Discover the talented roster of artists at Aurosunrise Records — from soulful vocalists to experimental instrumentalists.',
    image: '/assets/images/hero/hero2.jpg',
    albumArt: '/assets/images/albums/album-cover-2.jpg',
    primaryLink: '/artists',
    primaryLabel: 'Meet Our Artists',
    track: null
  },
  {
    id: 3,
    subtitle: 'Upcoming Events',
    title: 'Live. Feel. Remember.',
    description: 'Experience our artists live on stage. From intimate acoustic sessions to massive festival performances — find an event near you.',
    image: '/assets/images/hero/hero3.jpg',
    albumArt: '/assets/images/albums/album-cover-3.jpg',
    primaryLink: '/events',
    primaryLabel: 'View Events',
    track: null
  }
]

// ─── Computed ─────────────────────────────────────
const isPlayingSlide = computed(() =>
  player.isPlaying && player.currentTrack !== null
)

// ─── Methods ──────────────────────────────────────
function playSlideTrack(track) {
  player.play(track)
}

// ─── Lifecycle ────────────────────────────────────
onMounted(() => {
  /**
   * 📚 LEARNING NOTE: onMounted runs after Vue renders the component
   * into the DOM. This is the correct place to initialize third-party
   * libraries like Swiper that need actual DOM elements to work.
   *
   * Do NOT run DOM-dependent code at the top level of <script setup>
   * because the DOM doesn't exist yet when that code runs.
   */
  if (typeof Swiper !== 'undefined') {
    swiperInstance = new Swiper('.hero-swiper', {
      loop: true,
      autoplay: { delay: 6000, disableOnInteraction: false },
      effect: 'fade',
      navigation: {
        nextEl: '.hero-next',
        prevEl: '.hero-prev'
      },
      pagination: {
        el: '.hero-pagination',
        clickable: true
      }
    })
  }
})

onUnmounted(() => {
  // Destroy Swiper when component leaves the DOM
  if (swiperInstance) {
    swiperInstance.destroy()
    swiperInstance = null
  }
})
</script>

<style scoped>
.hero-section {
  position: relative;
  min-height: 100vh;
  overflow: hidden;
}

.hero-bg-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 100%);
  z-index: 1;
}

.hero-slide {
  background-size: cover;
  background-position: center;
  min-height: 100vh;
}

.hero-content {
  position: relative;
  z-index: 2;
}

.hero-subtitle {
  display: inline-block;
  font-size: 0.85rem;
  letter-spacing: 4px;
  text-transform: uppercase;
  color: #f5a623;
  margin-bottom: 1rem;
  background: rgba(245, 166, 35, 0.1);
  padding: 0.4rem 1rem;
  border-left: 3px solid #f5a623;
}

.hero-title {
  font-size: clamp(2.5rem, 6vw, 5rem);
  font-weight: 900;
  color: #fff;
  line-height: 1.1;
  margin-bottom: 1.5rem;
  text-shadow: 0 2px 30px rgba(0,0,0,0.5);
}

.hero-desc {
  font-size: 1.1rem;
  color: rgba(255,255,255,0.8);
  max-width: 500px;
  line-height: 1.8;
  margin-bottom: 2.5rem;
}

.hero-album-art {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
}

.hero-album-art img {
  border-radius: 16px;
  box-shadow: 0 30px 80px rgba(0,0,0,0.5);
  max-width: 320px;
}

.vinyl-disc {
  position: absolute;
  right: -60px;
  width: 200px;
  height: 200px;
  background: radial-gradient(circle, #333 30%, #111 100%);
  border-radius: 50%;
  box-shadow: 0 10px 40px rgba(0,0,0,0.6);
  display: flex;
  align-items: center;
  justify-content: center;
}

.vinyl-disc.spinning {
  animation: spin 4s linear infinite;
}

@keyframes spin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}

.vinyl-label {
  width: 60px;
  height: 60px;
  background: #f5a623;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 900;
  font-size: 1.2rem;
}

.scroll-indicator {
  position: absolute;
  bottom: 2rem;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.5rem;
  z-index: 5;
  color: rgba(255,255,255,0.6);
  font-size: 0.75rem;
  letter-spacing: 2px;
  text-transform: uppercase;
}

.scroll-dot {
  width: 6px;
  height: 6px;
  background: #f5a623;
  border-radius: 50%;
  animation: bounce 1.5s infinite;
}

@keyframes bounce {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(8px); }
}
</style>
