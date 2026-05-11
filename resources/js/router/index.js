import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  // Public
  { path: '/',              component: () => import('../pages/HomePage.vue') },
  { path: '/artists',       component: () => import('../pages/ArtistsPage.vue'),     meta: { title: 'Artists' } },
  { path: '/artists/:slug', component: () => import('../pages/ArtistDetailPage.vue'),meta: { title: 'Artist' } },
  { path: '/albums',        component: () => import('../pages/AlbumsPage.vue'),      meta: { title: 'Albums' } },
  { path: '/albums/:slug',  component: () => import('../pages/AlbumDetailPage.vue'), meta: { title: 'Album' } },
  { path: '/events',        component: () => import('../pages/EventsPage.vue'),      meta: { title: 'Events' } },
  { path: '/shop',          component: () => import('../pages/ShopPage.vue'),        meta: { title: 'Shop' } },
  { path: '/contact',       component: () => import('../pages/ContactPage.vue'),     meta: { title: 'Contact' } },
  { path: '/blog',          component: () => import('../pages/BlogPage.vue'),        meta: { title: 'Blog' } },

  // Auth
  { path: '/admin/login',   component: () => import('../pages/admin/LoginPage.vue'), meta: { title: 'Admin Login', guestOnly: true } },

  // Admin — protected
  {
    path: '/admin',
    component: () => import('../pages/admin/AdminLayout.vue'),
    meta: { requiresAuth: true },
    children: [
      { path: '',        redirect: '/admin/dashboard' },
      { path: 'dashboard', component: () => import('../pages/admin/DashboardPage.vue'), meta: { title: 'Dashboard' } },
      { path: 'artists',   component: () => import('../pages/admin/ArtistsPage.vue'),   meta: { title: 'Manage Artists' } },
      { path: 'artists/new', component: () => import('../pages/admin/ArtistFormPage.vue'), meta: { title: 'Add Artist' } },
      { path: 'artists/:id/edit', component: () => import('../pages/admin/ArtistFormPage.vue'), meta: { title: 'Edit Artist' } },
      { path: 'albums',    component: () => import('../pages/admin/AlbumsAdminPage.vue'),  meta: { title: 'Manage Albums' } },
      { path: 'events',    component: () => import('../pages/admin/EventsAdminPage.vue'),  meta: { title: 'Manage Events' } },
    ]
  },

  { path: '/:pathMatch(.*)*', component: () => import('../pages/NotFoundPage.vue') }
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior() { return { top: 0, behavior: 'smooth' } }
})

// Navigation guard
router.beforeEach((to, from, next) => {
  document.title = `${to.meta.title || 'Home'} — Aurosunrise Records`

  const token = localStorage.getItem('auth_token')

  if (to.meta.requiresAuth && !token) {
    return next('/admin/login')
  }
  if (to.meta.guestOnly && token) {
    return next('/admin/dashboard')
  }
  next()
})

export default router
