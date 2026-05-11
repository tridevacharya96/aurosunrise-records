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
        <p class="hero-eyebrow">✦ Est. 2015 &nbsp;·&nbsp; Bhubaneswar, Odisha ✦</p>
        <div class="hero-brand">
          <h1 class="hero-title">Aurosunrise</h1>
          <p class="hero-sub">R E C O R D S</p>
        </div>
        <p class="hero-desc">Where South India's finest voices meet world-class sound.<br>We don't just make music — we craft legacies.</p>
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
        <span v-for="i in 10" :key="i">ARTISTS &nbsp;·&nbsp; ALBUMS &nbsp;·&nbsp; EVENTS &nbsp;·&nbsp; LIVE SHOWS &nbsp;·&nbsp; NEW RELEASES &nbsp;·&nbsp;</span>
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
          <h2 class="section-title">Born From <span class="accent-text">Passion,</span><br>Built on Sound</h2>
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
      <div style="text-align:center;margin-top:3rem">
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
  { name: 'Riya Sen',   genre: 'Pop · Soul',        initials: 'RS', color: 'linear-gradient(135deg,#ff6b00,#ffd700)' },
  { name: 'Arjun Das',  genre: 'Hip-Hop',            initials: 'AD', color: 'linear-gradient(135deg,#ff8c00,#ff4500)' },
  { name: 'Priya Nair', genre: 'Classical Fusion',   initials: 'PN', color: 'linear-gradient(135deg,#ffa500,#ff6347)' },
  { name: 'Kiran Rao',  genre: 'Electronic',         initials: 'KR', color: 'linear-gradient(135deg,#ffd700,#ff8c00)' },
]
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Bodoni+Moda:ital,opsz,wght@0,6..96,400;0,6..96,700;0,6..96,900;1,6..96,400&family=Cinzel+Decorative:wght@400;700;900&family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&family=Inter:wght@300;400;500;600;700;800;900&display=swap');

/* ── Base ── */
main {
  background: #1a0800;
  min-height: 100vh;
  font-family: 'Inter', sans-serif;
}

/* ── Hero ── */
.hero {
  position: relative;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  background: #1a0800;
  padding-top: 100px;
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
  opacity: 0.55;
  animation: float 8s ease-in-out infinite;
}
.liquid-1 { width:600px;height:600px;background:radial-gradient(circle,#ff6b00 0%,#ff4500 60%,transparent 100%);top:-200px;left:-150px;animation-delay:0s }
.liquid-2 { width:500px;height:500px;background:radial-gradient(circle,#ffd700 0%,#ffaa00 60%,transparent 100%);top:-100px;right:-100px;animation-delay:2s }
.liquid-3 { width:400px;height:400px;background:radial-gradient(circle,#ff8c00 0%,#ff6b00 60%,transparent 100%);bottom:0;left:30%;animation-delay:4s }
.liquid-4 { width:300px;height:300px;background:radial-gradient(circle,#ffcc00 0%,#ff9500 60%,transparent 100%);bottom:100px;right:10%;animation-delay:1s }
.liquid-5 { width:250px;height:250px;background:radial-gradient(circle,#ff5500 0%,#cc3300 60%,transparent 100%);top:40%;left:10%;animation-delay:3s }

@keyframes float {
  0%,100% { transform: translateY(0) scale(1); }
  50%      { transform: translateY(-30px) scale(1.05); }
}

.hero-content {
  position: relative;
  z-index: 2;
  text-align: center;
  padding: 2rem;
  max-width: 1100px;
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.hero-eyebrow {
  font-family: 'Inter', sans-serif;
  font-size: .78rem;
  letter-spacing: 5px;
  color: #ffd700;
  margin-bottom: 2rem;
  text-transform: uppercase;
  font-weight: 400;
  opacity: .9;
}

.hero-brand {
  margin-bottom: 2rem;
  text-align: center;
  width: 100%;
}

.hero-title {
  font-family: 'Cinzel Decorative', serif;
  text-align: center;
  width: 100%;
  font-size: clamp(3.5rem, 10vw, 8rem);
  font-weight: 700;
  line-height: 1;
  margin: 0 0 .5rem;
  color: #fff;
  letter-spacing: 4px;
  text-align: center;
  width: 100%;
  text-shadow:
    0 0 80px rgba(255,107,0,0.6),
    0 4px 30px rgba(0,0,0,0.5);
}

.hero-sub {
  font-family: 'Inter', sans-serif;
  font-size: clamp(.7rem, 2vw, 1rem);
  letter-spacing: 12px;
  color: rgba(255,215,0,0.85);
  margin: 0;
  font-weight: 300;
  text-transform: uppercase;
}

.hero-desc {
  font-family: 'Playfair Display', serif;
  font-size: clamp(1.1rem, 2.5vw, 1.4rem);
  font-style: italic;
  max-width: 560px;
  margin: 0 auto 2.5rem;
  color: rgba(255,255,255,0.65);
  line-height: 1.9;
  font-weight: 300;
}

.hero-btns {
  display: flex;
  gap: 1rem;
  justify-content: center;
  flex-wrap: wrap;
  margin-bottom: 3.5rem;
}

.btn-primary {
  background: linear-gradient(135deg, #ff6b00, #ff9500);
  color: #fff;
  padding: .9rem 2.2rem;
  border-radius: 50px;
  text-decoration: none;
  font-weight: 600;
  font-size: .88rem;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  transition: all .3s;
  box-shadow: 0 8px 30px rgba(255,107,0,0.4);
  font-family: 'Inter', sans-serif;
}
.btn-primary:hover { transform: translateY(-3px); box-shadow: 0 16px 40px rgba(255,107,0,0.6); }

.btn-outline {
  background: transparent;
  color: #ffd700;
  padding: .9rem 2.2rem;
  border-radius: 50px;
  text-decoration: none;
  font-weight: 600;
  font-size: .88rem;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  border: 1.5px solid rgba(255,215,0,0.6);
  transition: all .3s;
  font-family: 'Inter', sans-serif;
}
.btn-outline:hover { background: rgba(255,215,0,0.1); border-color: #ffd700; transform: translateY(-3px); }

.btn-large { padding: 1.1rem 3rem; font-size: .95rem; }

.hero-stats {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 2.5rem;
}
.stat { display: flex; flex-direction: column; align-items: center; gap: .2rem; }
.stat-num {
  font-family: 'Cinzel Decorative', serif;
  font-size: 2rem;
  font-weight: 700;
  color: #ff6b00;
  line-height: 1;
}
.stat-label {
  font-size: .7rem;
  color: rgba(255,255,255,0.4);
  letter-spacing: 3px;
  text-transform: uppercase;
  font-weight: 400;
}
.stat-divider { width: 1px; height: 40px; background: rgba(255,107,0,0.25); }

.scroll-hint {
  position: absolute;
  bottom: 2rem;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: .5rem;
  color: rgba(255,255,255,0.3);
  font-size: .65rem;
  letter-spacing: 4px;
  text-align: center;
  width: 100%;
  text-transform: uppercase;
  font-family: 'Inter', sans-serif;
}
.scroll-line {
  width: 1px;
  height: 50px;
  background: linear-gradient(to bottom, #ff6b00, transparent);
  animation: scrollPulse 2s ease-in-out infinite;
}
@keyframes scrollPulse { 0%,100%{opacity:.3} 50%{opacity:1} }

/* ── Marquee ── */
.marquee-wrap {
  background: linear-gradient(135deg, #ff6b00, #ff8c00);
  padding: .9rem 0;
  overflow: hidden;
  white-space: nowrap;
}
.marquee-track {
  display: inline-block;
  animation: marquee 25s linear infinite;
  font-family: 'Inter', sans-serif;
  font-weight: 700;
  font-size: .78rem;
  letter-spacing: 4px;
  text-align: center;
  width: 100%;
  color: #fff;
  text-transform: uppercase;
}
@keyframes marquee { from{transform:translateX(0)} to{transform:translateX(-50%)} }

/* ── About ── */
.about-section {
  padding: 8rem 4rem;
  background: #1a0800;
}
.about-grid {
  max-width: 1100px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 6rem;
  align-items: center;
}
.about-visual { position: relative; display: flex; align-items: center; justify-content: center; }
.vinyl-wrap { position: relative; }
.vinyl {
  width: 300px; height: 300px;
  border-radius: 50%;
  background: radial-gradient(circle, #2a1000 30%, #1a0800 60%, #ff6b00 61%, #1a0800 62%, #2a1000 100%);
  display: flex; align-items: center; justify-content: center;
  animation: spin 12s linear infinite;
  box-shadow: 0 0 60px rgba(255,107,0,0.25);
}
.vinyl-inner {
  width: 100px; height: 100px;
  border-radius: 50%;
  background: linear-gradient(135deg, #ff6b00, #ffd700);
  display: flex; align-items: center; justify-content: center;
}
.vinyl-label {
  font-family: 'Cinzel Decorative', serif;
  font-size: 1.4rem;
  font-weight: 700;
  color: #fff;
}
.vinyl-glow {
  position: absolute;
  width: 340px; height: 340px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(255,107,0,0.15), transparent 70%);
  animation: pulse 3s ease-in-out infinite;
}
@keyframes spin  { from{transform:rotate(0)} to{transform:rotate(360deg)} }
@keyframes pulse { 0%,100%{transform:scale(1);opacity:.4} 50%{transform:scale(1.1);opacity:1} }

.about-badge {
  position: absolute;
  bottom: -20px; right: 10px;
  background: linear-gradient(135deg, #ff6b00, #ffd700);
  border-radius: 16px;
  padding: 1rem 1.5rem;
  display: flex; align-items: center; gap: .75rem;
  box-shadow: 0 10px 30px rgba(255,107,0,0.4);
}
.badge-num {
  font-family: 'Cinzel Decorative', serif;
  font-size: 2.5rem;
  font-weight: 700;
  color: #fff;
}
.badge-text { font-size: .78rem; color: rgba(255,255,255,0.9); line-height: 1.5; font-weight: 600; }

.section-eyebrow {
  font-family: 'Inter', sans-serif;
  font-size: .75rem;
  letter-spacing: 5px;
  color: #ff6b00;
  text-transform: uppercase;
  margin-bottom: .75rem;
  font-weight: 500;
}
.section-title {
  font-family: 'Cinzel Decorative', serif;
  font-size: clamp(1.8rem, 3.5vw, 2.8rem);
  font-weight: 700;
  color: #fff;
  line-height: 1.2;
  margin-bottom: 1.5rem;
  letter-spacing: 1px;
}
.accent-text { color: #ff6b00; }

.about-desc {
  font-family: 'Playfair Display', serif;
  color: rgba(255,255,255,0.6);
  line-height: 1.9;
  font-size: 1.15rem;
  margin-bottom: 2rem;
  font-weight: 300;
}
.about-features { display: flex; flex-direction: column; gap: .85rem; margin-bottom: 2.5rem; }
.feature {
  display: flex; align-items: center; gap: .85rem;
  color: rgba(255,255,255,0.75);
  font-size: .9rem;
  font-family: 'Inter', sans-serif;
}
.feature-icon { font-size: 1.1rem; }

/* ── Artists ── */
.artists-section { padding: 7rem 4rem; background: #0f0500; }
.section-head { text-align: center; margin-bottom: 4rem; }
.artists-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 1.5rem;
  max-width: 1000px;
  margin: 0 auto;
}
.artist-card {
  background: #1e0c00;
  border: 1px solid rgba(255,107,0,0.12);
  border-radius: 20px;
  overflow: hidden;
  transition: all .3s;
  cursor: pointer;
}
.artist-card:hover { transform: translateY(-10px); border-color: rgba(255,107,0,0.5); box-shadow: 0 24px 60px rgba(255,107,0,0.2); }
.artist-img { height: 200px; display: flex; align-items: center; justify-content: center; }
.artist-initials {
  font-family: 'Cinzel Decorative', serif;
  font-size: 3rem;
  font-weight: 700;
  color: #fff;
}
.artist-info { padding: 1.35rem; }
.artist-info h3 {
  font-family: 'Cinzel Decorative', serif;
  color: #fff;
  font-size: 1rem;
  font-weight: 600;
  margin-bottom: .3rem;
  letter-spacing: 1px;
}
.artist-genre {
  font-family: 'Inter', sans-serif;
  color: #ff6b00;
  font-size: .75rem;
  letter-spacing: 2px;
  text-transform: uppercase;
  font-weight: 500;
}

/* ── CTA ── */
.cta-section {
  position: relative;
  padding: 9rem 2rem;
  background: #1a0800;
  text-align: center;
  overflow: hidden;
}
.cta-liquid-1 {
  position: absolute;
  width: 600px; height: 600px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(255,107,0,0.25), transparent 70%);
  top: -200px; left: -100px;
  filter: blur(60px);
}
.cta-liquid-2 {
  position: absolute;
  width: 400px; height: 400px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(255,215,0,0.15), transparent 70%);
  bottom: -100px; right: -50px;
  filter: blur(60px);
}
.cta-content { position: relative; z-index: 2; }
.cta-title {
  font-family: 'Cinzel Decorative', serif;
  font-size: clamp(2.5rem, 5vw, 4.5rem);
  font-weight: 700;
  color: #fff;
  line-height: 1.15;
  margin-bottom: 1.5rem;
  letter-spacing: 2px;
}
.cta-desc {
  font-family: 'Playfair Display', serif;
  color: rgba(255,255,255,0.55);
  font-size: 1.25rem;
  max-width: 420px;
  margin: 0 auto 3rem;
  line-height: 1.9;
  font-style: italic;
  font-weight: 300;
}

@media (max-width: 768px) {
  .about-section { padding: 5rem 1.5rem; }
  .about-grid { grid-template-columns: 1fr; gap: 3rem; }
  .about-visual { display: none; }
  .artists-section { padding: 5rem 1.5rem; }
}
</style>
