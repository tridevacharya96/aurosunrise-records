<template>
  <div class="admin-layout">

    <!-- Sidebar -->
    <aside :class="['sidebar', { collapsed: sidebarCollapsed }]">
      <div class="sidebar-header">
        <div class="sidebar-logo">
          <div class="logo-icon">AR</div>
          <div v-if="!sidebarCollapsed" class="logo-text">
            <span class="logo-main">Aurosunrise</span>
            <span class="logo-sub">Admin Panel</span>
          </div>
        </div>
        <button class="collapse-btn" @click="sidebarCollapsed = !sidebarCollapsed">
          <i :class="sidebarCollapsed ? 'fas fa-chevron-right' : 'fas fa-chevron-left'"></i>
        </button>
      </div>

      <nav class="sidebar-nav">
        <RouterLink
          v-for="item in navItems"
          :key="item.path"
          :to="item.path"
          class="nav-item"
          :title="item.label"
        >
          <i :class="item.icon"></i>
          <span v-if="!sidebarCollapsed">{{ item.label }}</span>
          <span v-if="!sidebarCollapsed && item.badge" class="nav-badge">{{ item.badge }}</span>
        </RouterLink>
      </nav>

      <div class="sidebar-footer">
        <div v-if="!sidebarCollapsed" class="user-info">
          <div class="user-avatar">{{ userInitials }}</div>
          <div class="user-meta">
            <span class="user-name">{{ auth.user?.name }}</span>
            <span class="user-role">Administrator</span>
          </div>
        </div>
        <button class="logout-btn" @click="handleLogout" :title="sidebarCollapsed ? 'Logout' : ''">
          <i class="fas fa-sign-out-alt"></i>
          <span v-if="!sidebarCollapsed">Logout</span>
        </button>
      </div>
    </aside>

    <!-- Main -->
    <div class="admin-main">
      <!-- Top bar -->
      <header class="admin-topbar">
        <div class="topbar-left">
          <h2 class="page-title">{{ currentTitle }}</h2>
        </div>
        <div class="topbar-right">
          <RouterLink to="/" target="_blank" class="view-site-btn">
            <i class="fas fa-external-link-alt"></i> View Site
          </RouterLink>
        </div>
      </header>

      <!-- Page content -->
      <div class="admin-content">
        <RouterView />
      </div>
    </div>

  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { RouterLink, RouterView, useRoute, useRouter } from 'vue-router'
import { useAuthStore } from '../../store/auth.js'

const auth   = useAuthStore()
const route  = useRouter().currentRoute
const router = useRouter()

const sidebarCollapsed = ref(false)

const navItems = [
  { path: '/admin/dashboard', icon: 'fas fa-chart-line',     label: 'Dashboard'  },
  { path: '/admin/artists',   icon: 'fas fa-microphone',     label: 'Artists'    },
  { path: '/admin/albums',    icon: 'fas fa-compact-disc',   label: 'Albums'     },
  { path: '/admin/events',    icon: 'fas fa-calendar-alt',   label: 'Events'     },
]

const currentTitle = computed(() => {
  const r = useRoute ? useRoute() : null
  return r?.meta?.title || 'Dashboard'
})

const userInitials = computed(() => {
  if (!auth.user?.name) return 'A'
  return auth.user.name.split(' ').map(w => w[0]).join('').toUpperCase().slice(0,2)
})

async function handleLogout() {
  await auth.logout()
  router.push('/admin/login')
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap');

* { font-family: 'Inter', sans-serif; }

.admin-layout {
  display: flex;
  min-height: 100vh;
  background: #0a0300;
}

/* Sidebar */
.sidebar {
  width: 260px;
  background: #120800;
  border-right: 1px solid rgba(255,107,0,0.1);
  display: flex;
  flex-direction: column;
  transition: width .3s ease;
  flex-shrink: 0;
  position: fixed;
  top: 0; left: 0; bottom: 0;
  z-index: 100;
  overflow: hidden;
}
.sidebar.collapsed { width: 70px; }

.sidebar-header {
  padding: 1.5rem 1.25rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  border-bottom: 1px solid rgba(255,107,0,0.1);
  min-height: 80px;
}

.sidebar-logo { display: flex; align-items: center; gap: .85rem; overflow: hidden; }

.logo-icon {
  width: 38px; height: 38px;
  border-radius: 10px;
  background: linear-gradient(135deg, #ff6b00, #ffd700);
  display: flex; align-items: center; justify-content: center;
  font-family: 'Cinzel', serif;
  font-size: .85rem; font-weight: 700; color: #fff;
  flex-shrink: 0;
}

.logo-text { display: flex; flex-direction: column; line-height: 1; }
.logo-main { font-family: 'Cinzel', serif; font-size: .9rem; font-weight: 700; color: #fff; letter-spacing: 1px; white-space: nowrap; }
.logo-sub  { font-size: .58rem; color: rgba(255,215,0,0.6); letter-spacing: 2px; text-transform: uppercase; margin-top: 2px; }

.collapse-btn {
  background: none; border: none;
  color: rgba(255,255,255,0.3);
  cursor: pointer; font-size: .8rem;
  padding: .35rem; border-radius: 6px;
  transition: all .2s; flex-shrink: 0;
}
.collapse-btn:hover { color: #ff6b00; background: rgba(255,107,0,0.1); }

.sidebar-nav {
  flex: 1;
  padding: 1rem .75rem;
  display: flex;
  flex-direction: column;
  gap: .25rem;
  overflow-y: auto;
}

.nav-item {
  display: flex;
  align-items: center;
  gap: .85rem;
  padding: .75rem 1rem;
  border-radius: 12px;
  text-decoration: none;
  color: rgba(255,255,255,0.5);
  font-size: .88rem;
  font-weight: 500;
  transition: all .2s;
  white-space: nowrap;
  position: relative;
}
.nav-item i { font-size: .95rem; flex-shrink: 0; width: 18px; text-align: center; }
.nav-item:hover { background: rgba(255,107,0,0.08); color: rgba(255,255,255,0.8); }
.nav-item.router-link-active { background: rgba(255,107,0,0.15); color: #ff6b00; }
.nav-badge {
  margin-left: auto;
  background: #ff6b00;
  color: #fff;
  font-size: .65rem;
  padding: .15rem .5rem;
  border-radius: 20px;
  font-weight: 600;
}

.sidebar-footer {
  padding: 1rem .75rem;
  border-top: 1px solid rgba(255,107,0,0.1);
  display: flex;
  flex-direction: column;
  gap: .75rem;
}

.user-info {
  display: flex; align-items: center; gap: .75rem;
  padding: .5rem .75rem;
  background: rgba(255,107,0,0.05);
  border-radius: 10px;
  overflow: hidden;
}
.user-avatar {
  width: 34px; height: 34px;
  border-radius: 50%;
  background: linear-gradient(135deg, #ff6b00, #ffd700);
  display: flex; align-items: center; justify-content: center;
  font-size: .75rem; font-weight: 700; color: #fff; flex-shrink: 0;
}
.user-name { display: block; font-size: .82rem; font-weight: 600; color: #fff; white-space: nowrap; }
.user-role { display: block; font-size: .68rem; color: rgba(255,107,0,0.7); text-transform: uppercase; letter-spacing: 1px; }

.logout-btn {
  display: flex; align-items: center; gap: .75rem;
  padding: .7rem 1rem;
  background: none; border: 1px solid rgba(255,107,0,0.15);
  border-radius: 10px;
  color: rgba(255,255,255,0.4);
  cursor: pointer; font-size: .85rem;
  transition: all .2s; white-space: nowrap;
  font-family: 'Inter', sans-serif;
}
.logout-btn:hover { background: rgba(220,38,38,0.1); border-color: rgba(220,38,38,0.3); color: #fca5a5; }
.logout-btn i { flex-shrink: 0; width: 18px; text-align: center; }

/* Main */
.admin-main {
  flex: 1;
  margin-left: 260px;
  transition: margin-left .3s;
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}
.sidebar.collapsed ~ .admin-main { margin-left: 70px; }

.admin-topbar {
  background: #120800;
  border-bottom: 1px solid rgba(255,107,0,0.1);
  padding: 1.25rem 2rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  position: sticky; top: 0; z-index: 50;
}
.page-title { font-family: 'Cinzel', serif; font-size: 1.1rem; font-weight: 600; color: #fff; margin: 0; }

.view-site-btn {
  font-size: .8rem; color: rgba(255,255,255,0.4);
  text-decoration: none; letter-spacing: 1px;
  border: 1px solid rgba(255,255,255,0.1);
  padding: .4rem 1rem; border-radius: 8px;
  transition: all .2s;
}
.view-site-btn:hover { color: #ff6b00; border-color: rgba(255,107,0,0.3); }

.admin-content { flex: 1; padding: 2rem; }
</style>
