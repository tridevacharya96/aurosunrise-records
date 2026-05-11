<template>
  <div class="dashboard">
    <div class="welcome">
      <h2>Welcome back, <span class="accent">{{ auth.user?.name?.split(' ')[0] }}</span> 👋</h2>
      <p>Here's what's happening at Aurosunrise Records today.</p>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
      <div v-for="stat in stats" :key="stat.label" class="stat-card" :style="{ borderColor: stat.color + '33' }">
        <div class="stat-icon" :style="{ background: stat.color + '22', color: stat.color }">
          <i :class="stat.icon"></i>
        </div>
        <div class="stat-info">
          <span class="stat-num">{{ stat.value }}</span>
          <span class="stat-label">{{ stat.label }}</span>
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
      <h3>Quick Actions</h3>
      <div class="actions-grid">
        <RouterLink to="/admin/artists/new" class="action-card">
          <i class="fas fa-microphone"></i>
          <span>Add Artist</span>
        </RouterLink>
        <RouterLink to="/admin/albums" class="action-card">
          <i class="fas fa-compact-disc"></i>
          <span>Add Album</span>
        </RouterLink>
        <RouterLink to="/admin/events" class="action-card">
          <i class="fas fa-calendar-plus"></i>
          <span>Add Event</span>
        </RouterLink>
        <RouterLink to="/" target="_blank" class="action-card">
          <i class="fas fa-eye"></i>
          <span>View Site</span>
        </RouterLink>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { RouterLink } from 'vue-router'
import { useAuthStore } from '../../store/auth.js'

const auth  = useAuthStore()
const stats = ref([
  { label: 'Total Artists', value: '—', icon: 'fas fa-microphone',   color: '#ff6b00' },
  { label: 'Total Albums',  value: '—', icon: 'fas fa-compact-disc', color: '#ffd700' },
  { label: 'Events',        value: '—', icon: 'fas fa-calendar-alt', color: '#ff9500' },
  { label: 'Featured',      value: '—', icon: 'fas fa-star',         color: '#ffcc00' },
])

onMounted(async () => {
  const res  = await fetch('/api/admin/artists?per_page=1', { headers: auth.authHeaders() })
  const data = await res.json()
  if (data.meta) stats.value[0].value = data.meta.total
})
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap');
* { font-family: 'Inter', sans-serif; }

.dashboard { max-width: 1000px; }
.welcome { margin-bottom: 2rem; }
.welcome h2 { font-family: 'Cinzel', serif; font-size: 1.6rem; color: #fff; margin-bottom: .4rem; }
.accent { color: #ff6b00; }
.welcome p { color: rgba(255,255,255,0.4); font-size: .95rem; }

.stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px,1fr)); gap: 1.25rem; margin-bottom: 2.5rem; }
.stat-card {
  background: rgba(255,107,0,0.03);
  border: 1px solid;
  border-radius: 16px;
  padding: 1.5rem;
  display: flex; align-items: center; gap: 1.25rem;
}
.stat-icon { width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0; }
.stat-num { display: block; font-family: 'Cinzel', serif; font-size: 2rem; font-weight: 700; color: #fff; line-height: 1; }
.stat-label { display: block; font-size: .75rem; color: rgba(255,255,255,0.35); text-transform: uppercase; letter-spacing: 1px; margin-top: .3rem; }

.quick-actions h3 { font-family: 'Cinzel', serif; font-size: 1rem; color: #fff; margin-bottom: 1rem; }
.actions-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px,1fr)); gap: 1rem; }
.action-card {
  background: rgba(255,107,0,0.05);
  border: 1px solid rgba(255,107,0,0.15);
  border-radius: 16px;
  padding: 1.5rem;
  display: flex; flex-direction: column; align-items: center; gap: .75rem;
  text-decoration: none; color: rgba(255,255,255,0.6);
  font-size: .88rem; font-weight: 500;
  transition: all .2s;
}
.action-card i { font-size: 1.5rem; color: #ff6b00; }
.action-card:hover { background: rgba(255,107,0,0.1); border-color: rgba(255,107,0,0.4); color: #fff; transform: translateY(-3px); }
</style>
