import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  { path: '/', name: 'home', component: () => import('../pages/HomePage.vue') },
  { path: '/about', name: 'about', component: () => import('../pages/AboutPage.vue') },
  { path: '/artists', name: 'artists', component: () => import('../pages/ArtistsPage.vue') },
  { path: '/artists/:slug', name: 'artist-detail', component: () => import('../pages/ArtistDetailPage.vue') },
  { path: '/albums', name: 'albums', component: () => import('../pages/AlbumsPage.vue') },
  { path: '/albums/:slug', name: 'album-detail', component: () => import('../pages/AlbumDetailPage.vue') },
  { path: '/events', name: 'events', component: () => import('../pages/EventsPage.vue') },
  { path: '/events/:id', name: 'event-detail', component: () => import('../pages/EventDetailPage.vue') },
  { path: '/shop', name: 'shop', component: () => import('../pages/ShopPage.vue') },
  { path: '/shop/:id', name: 'product-detail', component: () => import('../pages/ProductDetailPage.vue') },
  { path: '/cart', name: 'cart', component: () => import('../pages/CartPage.vue') },
  { path: '/contact', name: 'contact', component: () => import('../pages/ContactPage.vue') },
  { path: '/blog', name: 'blog', component: () => import('../pages/BlogPage.vue') },
  { path: '/blog/:slug', name: 'blog-detail', component: () => import('../pages/BlogDetailPage.vue') },
  { path: '/:pathMatch(.*)*', name: 'not-found', component: () => import('../pages/NotFoundPage.vue') },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior() { return { top: 0, behavior: 'smooth' } }
})

router.beforeEach((to, from, next) => {
  document.title = to.meta.title || 'Aurosunrise Records'
  next()
})

export default router
