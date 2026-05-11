import { defineStore } from 'pinia'
import { ref, computed } from 'vue'

export const useAuthStore = defineStore('auth', () => {
  const token = ref(localStorage.getItem('auth_token') || null)
  const user  = ref(JSON.parse(localStorage.getItem('auth_user') || 'null'))

  const isLoggedIn = computed(() => !!token.value)
  const isAdmin    = computed(() => user.value?.role === 'admin')

  async function login(email, password) {
    const res = await fetch('/api/auth/login', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
      body: JSON.stringify({ email, password })
    })
    const data = await res.json()
    if (!res.ok) throw new Error(data.message || 'Login failed')

    token.value = data.token
    user.value  = data.user
    localStorage.setItem('auth_token', data.token)
    localStorage.setItem('auth_user',  JSON.stringify(data.user))
    return data
  }

  async function logout() {
    await fetch('/api/auth/logout', {
      method: 'POST',
      headers: { 'Authorization': `Bearer ${token.value}`, 'Accept': 'application/json' }
    })
    token.value = null
    user.value  = null
    localStorage.removeItem('auth_token')
    localStorage.removeItem('auth_user')
  }

  function authHeaders() {
    return {
      'Authorization': `Bearer ${token.value}`,
      'Accept': 'application/json',
    }
  }

  return { token, user, isLoggedIn, isAdmin, login, logout, authHeaders }
})
