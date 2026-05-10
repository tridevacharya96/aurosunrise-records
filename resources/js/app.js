/**
 * =====================================================
 * AUROSUNRISE RECORDS — Vue.js App Entry Point
 * =====================================================
 *
 * 📚 LEARNING NOTE: This is the main entry file for
 * the Vue.js application. It:
 *   1. Imports Vue core
 *   2. Imports the Router (for page navigation)
 *   3. Imports Pinia (for state/data management)
 *   4. Mounts the root App component into index.html's <div id="app">
 *
 * Think of this as the "ignition key" of your Vue app.
 */

import { createApp } from 'vue'         // Vue 3 core
import { createPinia } from 'pinia'      // State management (like a global data store)
import router from './router'            // Vue Router (handles URL navigation)
import App from './App.vue'              // Root component

// Create the Vue application instance
const app = createApp(App)

// Register plugins
app.use(createPinia())   // Enable global state store
app.use(router)          // Enable client-side routing

// Mount the app to the DOM element with id="app" in app.blade.php
app.mount('#app')
