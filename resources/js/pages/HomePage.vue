<template>
  <main>
    <!-- Hero Section -->
    <section class="hero">
      <div class="hero-bg">
        <div class="liquid liquid-1"></div>
        <div class="liquid liquid-2"></div>
        <div class="liquid liquid-3"></div>
        <div class="liquid liquid-4"></div>
        <div class="liquid liquid-5"></div>
      </div>
      <div class="hero-content">
        <p class="hero-eyebrow">✦ Est. 2015 · Bhubaneswar, Odisha ✦</p>
        <h1 class="hero-title">
          <span class="title-line">AURO</span>
          <span class="title-line accent">SUNRISE</span>
        </h1>
        <p class="hero-sub">RECORDS</p>
        <p class="hero-desc">Where South India's finest voices meet world-class sound. We don't just make music — we craft legacies.</p>
        <div class="hero-btns">
          <RouterLink to="/artists" class="btn-primary">Meet Our Artists</RouterLink>
          <RouterLink to="/albums" class="btn-outline">Explore Albums</RouterLink>
        </div>
        <div class="hero-stats">
          <div class="stat"><span class="stat-num">48+</span><span class="stat-label">Artists</span></div>
          <div class="stat-divider"></div>
          <div class="stat"><span class="stat-num">200+</span><span class="stat-label">Albums</span></div>
          <div class="stat-divider"></div>
          <div class="stat"><span class="stat-num">10M+</span><span class="stat-label">Streams</span></div>
        </div>
      </div>
      <div class="scroll-hint">
        <div class="scroll-line"></div>
        <span>Scroll</span>
      </div>
    </section>

    <!-- Marquee -->
    <div class="marquee-wrap">
      <div class="marquee-track">
        <span v-for="i in 8" :key="i">ARTISTS &nbsp;·&nbsp; ALBUMS &nbsp;·&nbsp; EVENTS &nbsp;·&nbsp; LIVE SHOWS &nbsp;·&nbsp; NEW RELEASES &nbsp;·&nbsp;</span>
      </div>
    </div>

    <!-- About Section -->
    <section class="about-section">
      <div class="about-grid">
        <div class="about-visual">
          <div class="vinyl-wrap">
            <div class="vinyl">
              <div class="vinyl-inner">
                <div class="vinyl-label">AR</div>
              </div>
            </div>
            <div class="vinyl-glow"></div>
          </div>
          <div class="about-badge">
            <span class="badge-num">9</span>
            <span class="badge-text">Years of<br>Excellence</span>
          </div>
        </div>
        <div class="about-text">
          <p class="section-eyebrow">✦ Our Story</p>
          <h2 class="section-title">Born From<br><span class="accent-text">Passion,</span><br>Built on Sound</h2>
          <p class="about-desc">Aurosunrise Records was founded with one mission — to give authentic South Indian music the global platform it deserves. From soulful Odia folk to cutting-edge electronic fusion, we nurture every genre with equal love.</p>
          <div class="about-features">
            <div class="feature"><span class="feature-icon">🎙</span><span>World-class recording studios</span></div>
            <div class="feature"><span class="feature-icon">🌏</span><span>Global distribution network</span></div>
            <div class="feature"><span class="feature-icon">🎵</span><span>Artist-first label philosophy</span></div>
          </div>
          <RouterLink to="/about" class="btn-primary">Our Full Story</RouterLink>
        </div>
      </div>
    </section>

    <!-- Featured Artists -->
    <section class="artists-section">
      <div class="section-head">
        <p class="section-eyebrow">✦ The Talent</p>
        <h2 class="section-title">Featured <span class="accent-text">Artists</span></h2>
      </div>
      <div class="artists-grid">
        <div v-for="artist in artists" :key="artist.name" class="artist-card">
          <div class="artist-img" :style="{ background: artist.color }">
            <span class="artist-initials">{{ artist.initials }}</span>
          </div>
          <div class="artist-info">
            <h3>{{ artist.name }}</h3>
            <span class="artist-genre">{{ artist.genre }}</span>
          </div>
        </div>
      </div>
      <div style="text-align:center; margin-top:3rem;">
        <RouterLink to="/artists" class="btn-outline">View All Artists</RouterLink>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
      <div class="cta-liquid-1"></div>
      <div class="cta-liquid-2"></div>
      <div class="cta-content">
        <p class="section-eyebrow">✦ Join The Family</p>
        <h2 class="cta-title">Ready to Make<br>Your Mark?</h2>
        <p class="cta-desc">Submit your demo and let's create something the world will remember.</p>
        <RouterLink to="/contact" class="btn-primary btn-large">Submit Your Demo</RouterLink>
      </div>
    </section>
  </main>
</template>

<script setup>
import { RouterLink } from 'vue-router'

const artists = [
  { name: 'Riya Sen', genre: 'Pop · Soul', initials: 'RS', color: 'linear-gradient(135deg, #ff6b00, #ffd700)' },
  { name: 'Arjun Das', genre: 'Hip-Hop', initials: 'AD', color: 'linear-gradient(135deg, #ff8c00, #ff4500)' },
  { name: 'Priya Nair', genre: 'Classical Fusion', initials: 'PN', color: 'linear-gradient(135deg, #ffa500, #ff6347)' },
  { name: 'Kiran Rao', genre: 'Electronic', initials: 'KR', color: 'linear-gradient(135deg, #ffd700, #ff8c00)' },
]
</script>

<style scoped>
/* ── Base ── */
main { background: #1a0a00; min-height: 100vh; }

/* ── Hero ── */
.hero {
  position: relative;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  background: #1a0800;
}

.hero-bg {
  position: absolute;
  inset: 0;
  overflow: hidden;
}

.liquid {
  position: absolute;
  border-radius: 50%;
  filter: blur(80px);
  opacity: 0.6;
  animation: float 8s ease-in-out infinite;
}

.liquid-1 { width: 600px; height: 600px; background: radial-gradient(circle, #ff6b00 0%, #ff4500 60%, transparent 100%); top: -200px; left: -150px; animation-delay: 0s; }
.liquid-2 { width: 500px; height: 500px; background: radial-gradient(circle, #ffd700 0%, #ffaa00 60%, transparent 100%); top: -100px; right: -100px; animation-delay: 2s; }
.liquid-3 { width: 400px; height: 400px; background: radial-gradient(circle, #ff8c00 0%, #ff6b00 60%, transparent 100%); bottom: 0; left: 30%; animation-delay: 4s; }
.liquid-4 { width: 300px; height: 300px; background: radial-gradient(circle, #ffcc00 0%, #ff9500 60%, transparent 100%); bottom: 100px; right: 10%; animation-delay: 1s; }
.liquid-5 { width: 250px; height: 250px; background: radial-gradient(circle, #ff5500 0%, #cc3300 60%, transparent 100%); top: 40%; left: 10%; animation-delay: 3s; }

@keyframes float {
  0%, 100% { transform: translateY(0) scale(1); }
  50% { transform: translateY(-30px) scale(1.05); }
}

.hero-content {
  position: relative;
  z-index: 2;
  text-align: center;
  padding: 2rem;
}

.hero-eyebrow {
  font-size: .85rem;
  letter-spacing: 4px;
  color: #ffd700;
  margin-bottom: 1.5rem;
  text-transform: uppercase;
}

.hero-title {
  font-size: clamp(5rem, 15vw, 12rem);
  font-weight: 900;
  line-height: .9;
  margin: 0;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.title-line { color: #fff; text-shadow: 0 0 80px rgba(255,107,0,0.5); }
.accent { color: #ff6b00; -webkit-text-stroke: 2px #ff6b00; color: transparent; text-shadow: 0 0 40px rgba(255,107,0,0.8); }

.hero-sub {
  font-size: 1.1rem;
  letter-spacing: 14px;
  color: rgba(255,215,0,0.8);
  margin: 1rem 0 1.5rem;
  text-transform: uppercase;
}

.hero-desc {
  max-width: 500px;
  margin: 0 auto 2.5rem;
  color: rgba(255,255,255,0.65);
  font-size: 1.05rem;
  line-height: 1.8;
}

.hero-btns { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; margin-bottom: 3rem; }

.btn-primary {
  background: linear-gradient(135deg, #ff6b00, #ff9500);
  color: #fff;
  padding: .85rem 2rem;
  border-radius: 50px;
  text-decoration: none;
  font-weight: 700;
  font-size: .95rem;
  letter-spacing: 1px;
  transition: all .3s;
  box-shadow: 0 8px 30px rgba(255,107,0,0.4);
}
.btn-primary:hover { transform: translateY(-3px); box-shadow: 0 14px 40px rgba(255,107,0,0.6); }

.btn-outline {
  background: transparent;
  color: #ffd700;
  padding: .85rem 2rem;
  border-radius: 50px;
  text-decoration: none;
  font-weight: 700;
  font-size: .95rem;
  letter-spacing: 1px;
  border: 2px solid #ffd700;
  transition: all .3s;
}
.btn-outline:hover { background: #ffd700; color: #1a0800; transform: translateY(-3px); }

.btn-large { padding: 1.1rem 3rem; font-size: 1.05rem; }

.hero-stats { display: flex; align-items: center; justify-content: center; gap: 2rem; }
.stat { display: flex; flex-direction: column; align-items: center; }
.stat-num { font-size: 2rem; font-weight: 900; color: #ff6b00; }
.stat-label { font-size: .75rem; color: rgba(255,255,255,0.5); letter-spacing: 2px; text-transform: uppercase; }
.stat-divider { width: 1px; height: 40px; background: rgba(255,107,0,0.3); }

.scroll-hint {
  position: absolute;
  bottom: 2rem;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: .5rem;
  color: rgba(255,255,255,0.4);
  font-size: .75rem;
  letter-spacing: 3px;
  text-transform: uppercase;
}
.scroll-line {
  width: 1px;
  height: 50px;
  background: linear-gradient(to bottom, #ff6b00, transparent);
  animation: scrollPulse 2s ease-in-out infinite;
}
@keyframes scrollPulse { 0%,100%{opacity:.3;transform:scaleY(1)} 50%{opacity:1;transform:scaleY(1.2)} }

/* ── Marquee ── */
.marquee-wrap {
  background: linear-gradient(135deg, #ff6b00, #ff9500);
  padding: 1rem 0;
  overflow: hidden;
  white-space: nowrap;
}
.marquee-track {
  display: inline-block;
  animation: marquee 20s linear infinite;
  font-weight: 800;
  font-size: .85rem;
  letter-spacing: 3px;
  color: #fff;
  text-transform: uppercase;
}
@keyframes marquee { from{transform:translateX(0)} to{transform:translateX(-50%)} }

/* ── About ── */
.about-section {
  padding: 7rem 2rem;
  background: #1a0800;
}
.about-grid {
  max-width: 1100px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 5rem;
  align-items: center;
}
.about-visual { position: relative; display: flex; align-items: center; justify-content: center; }
.vinyl-wrap { position: relative; }
.vinyl {
  width: 300px;
  height: 300px;
  border-radius: 50%;
  background: radial-gradient(circle, #2a1000 30%, #1a0800 60%, #ff6b00 61%, #1a0800 62%, #2a1000 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  animation: spin 12s linear infinite;
  box-shadow: 0 0 60px rgba(255,107,0,0.3);
}
.vinyl-inner {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  background: linear-gradient(135deg, #ff6b00, #ffd700);
  display: flex;
  align-items: center;
  justify-content: center;
}
.vinyl-label { font-size: 1.5rem; font-weight: 900; color: #fff; }
.vinyl-glow {
  position: absolute;
  width: 320px;
  height: 320px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(255,107,0,0.2), transparent 70%);
  animation: pulse 3s ease-in-out infinite;
}
@keyframes spin { from{transform:rotate(0)} to{transform:rotate(360deg)} }
@keyframes pulse { 0%,100%{transform:scale(1);opacity:.5} 50%{transform:scale(1.1);opacity:1} }

.about-badge {
  position: absolute;
  bottom: -20px;
  right: 20px;
  background: linear-gradient(135deg, #ff6b00, #ffd700);
  border-radius: 16px;
  padding: 1rem 1.5rem;
  display: flex;
  align-items: center;
  gap: .75rem;
  box-shadow: 0 10px 30px rgba(255,107,0,0.4);
}
.badge-num { font-size: 2.5rem; font-weight: 900; color: #fff; }
.badge-text { font-size: .8rem; color: rgba(255,255,255,0.9); line-height: 1.4; font-weight: 600; }

.section-eyebrow { font-size: .8rem; letter-spacing: 4px; color: #ff6b00; text-transform: uppercase; margin-bottom: .75rem; }
.section-title { font-size: clamp(2rem, 4vw, 3rem); font-weight: 900; color: #fff; line-height: 1.1; margin-bottom: 1.5rem; }
.accent-text { color: #ff6b00; }

.about-desc { color: rgba(255,255,255,0.6); line-height: 1.9; font-size: 1rem; margin-bottom: 2rem; }

.about-features { display: flex; flex-direction: column; gap: .75rem; margin-bottom: 2rem; }
.feature { display: flex; align-items: center; gap: .75rem; color: rgba(255,255,255,0.8); font-size: .95rem; }
.feature-icon { font-size: 1.2rem; }

/* ── Artists ── */
.artists-section {
  padding: 6rem 2rem;
  background: #0f0500;
}
.section-head { text-align: center; margin-bottom: 3.5rem; }
.artists-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 1.5rem;
  max-width: 1000px;
  margin: 0 auto;
}
.artist-card {
  background: #1e0c00;
  border: 1px solid rgba(255,107,0,0.15);
  border-radius: 16px;
  overflow: hidden;
  transition: all .3s;
  cursor: pointer;
}
.artist-card:hover { transform: translateY(-8px); border-color: rgba(255,107,0,0.5); box-shadow: 0 20px 50px rgba(255,107,0,0.2); }
.artist-img {
  height: 200px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.artist-initials { font-size: 3rem; font-weight: 900; color: #fff; }
.artist-info { padding: 1.25rem; }
.artist-info h3 { color: #fff; font-size: 1.1rem; font-weight: 700; margin-bottom: .25rem; }
.artist-genre { color: #ff6b00; font-size: .8rem; letter-spacing: 1px; text-transform: uppercase; }

/* ── CTA ── */
.cta-section {
  position: relative;
  padding: 8rem 2rem;
  background: #1a0800;
  text-align: center;
  overflow: hidden;
}
.cta-liquid-1 {
  position: absolute;
  width: 500px; height: 500px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(255,107,0,0.3), transparent 70%);
  top: -200px; left: -100px;
  filter: blur(60px);
}
.cta-liquid-2 {
  position: absolute;
  width: 400px; height: 400px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(255,215,0,0.2), transparent 70%);
  bottom: -100px; right: -50px;
  filter: blur(60px);
}
.cta-content { position: relative; z-index: 2; }
.cta-title { font-size: clamp(2.5rem, 5vw, 4rem); font-weight: 900; color: #fff; line-height: 1.1; margin-bottom: 1.25rem; }
.cta-desc { color: rgba(255,255,255,0.6); font-size: 1.05rem; max-width: 400px; margin: 0 auto 2.5rem; line-height: 1.8; }

@media (max-width: 768px) {
  .about-grid { grid-template-columns: 1fr; gap: 3rem; }
  .vinyl { width: 220px; height: 220px; }
  .about-visual { display: none; }
}
</style>
