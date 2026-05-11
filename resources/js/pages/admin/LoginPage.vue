<template>
  <div class="login-page">
    <div class="login-liquid-1"></div>
    <div class="login-liquid-2"></div>

    <div class="login-card">
      <!-- Logo -->
      <div class="login-logo">
        <div class="logo-icon">AR</div>
        <div>
          <h1 class="logo-title">Aurosunrise</h1>
          <p class="logo-sub">Admin Panel</p>
        </div>
      </div>

      <h2 class="login-heading">Welcome back</h2>
      <p class="login-sub">Sign in to manage your label</p>

      <!-- Error -->
      <div v-if="error" class="error-alert">
        <i class="fas fa-exclamation-circle"></i>
        {{ error }}
      </div>

      <!-- Form -->
      <form @submit.prevent="handleLogin">
        <div class="form-group">
          <label>Email Address</label>
          <div class="input-wrap">
            <i class="fas fa-envelope"></i>
            <input
              v-model="form.email"
              type="email"
              placeholder="admin@aurosunrise.com"
              required
              autocomplete="email"
            />
          </div>
        </div>

        <div class="form-group">
          <label>Password</label>
          <div class="input-wrap">
            <i class="fas fa-lock"></i>
            <input
              v-model="form.password"
              :type="showPassword ? 'text' : 'password'"
              placeholder="Enter your password"
              required
              autocomplete="current-password"
            />
            <button type="button" class="toggle-pw" @click="showPassword = !showPassword">
              <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
            </button>
          </div>
        </div>

        <button type="submit" class="login-btn" :disabled="loading">
          <span v-if="loading"><i class="fas fa-spinner fa-spin"></i> Signing in...</span>
          <span v-else>Sign In →</span>
        </button>
      </form>

      <p class="login-hint">
        Default: admin@aurosunrise.com / admin@123
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../../store/auth.js'

const router   = useRouter()
const auth     = useAuthStore()

const form = ref({ email: '', password: '' })
const loading      = ref(false)
const error        = ref('')
const showPassword = ref(false)

async function handleLogin() {
  loading.value = true
  error.value   = ''
  try {
    await auth.login(form.value.email, form.value.password)
    router.push('/admin/dashboard')
  } catch (e) {
    error.value = e.message || 'Login failed. Please check your credentials.'
  } finally {
    loading.value = false
  }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap');

.login-page {
  min-height: 100vh;
  background: #0f0500;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 2rem;
  position: relative;
  overflow: hidden;
  font-family: 'Inter', sans-serif;
}

.login-liquid-1 {
  position: absolute; width: 600px; height: 600px; border-radius: 50%;
  background: radial-gradient(circle, rgba(255,107,0,0.25), transparent 70%);
  top: -200px; left: -200px; filter: blur(60px);
}
.login-liquid-2 {
  position: absolute; width: 500px; height: 500px; border-radius: 50%;
  background: radial-gradient(circle, rgba(255,215,0,0.15), transparent 70%);
  bottom: -150px; right: -150px; filter: blur(60px);
}

.login-card {
  position: relative; z-index: 2;
  background: rgba(30,12,0,0.8);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(255,107,0,0.2);
  border-radius: 24px;
  padding: 3rem 2.5rem;
  width: 100%;
  max-width: 420px;
  box-shadow: 0 40px 80px rgba(0,0,0,0.5);
}

.login-logo {
  display: flex;
  align-items: center;
  gap: 1rem;
  margin-bottom: 2rem;
}

.logo-icon {
  width: 50px; height: 50px;
  border-radius: 12px;
  background: linear-gradient(135deg, #ff6b00, #ffd700);
  display: flex; align-items: center; justify-content: center;
  font-family: 'Cinzel', serif;
  font-size: 1rem; font-weight: 700; color: #fff;
  flex-shrink: 0;
}

.logo-title { font-family: 'Cinzel', serif; font-size: 1.1rem; font-weight: 700; color: #fff; letter-spacing: 2px; margin: 0; }
.logo-sub   { font-size: .7rem; color: rgba(255,215,0,0.7); letter-spacing: 3px; text-transform: uppercase; margin: 2px 0 0; }

.login-heading { font-family: 'Cinzel', serif; font-size: 1.6rem; font-weight: 700; color: #fff; margin-bottom: .4rem; letter-spacing: 1px; }
.login-sub  { color: rgba(255,255,255,0.4); font-size: .9rem; margin-bottom: 2rem; }

.error-alert {
  background: rgba(220,38,38,0.15);
  border: 1px solid rgba(220,38,38,0.3);
  color: #fca5a5;
  padding: .75rem 1rem;
  border-radius: 10px;
  font-size: .88rem;
  margin-bottom: 1.5rem;
}
.error-alert i { margin-right: .5rem; }

.form-group { margin-bottom: 1.25rem; }
.form-group label { display: block; font-size: .8rem; font-weight: 500; color: rgba(255,255,255,0.6); margin-bottom: .5rem; letter-spacing: .5px; }

.input-wrap {
  position: relative;
  display: flex;
  align-items: center;
}
.input-wrap > i:first-child {
  position: absolute; left: 1rem;
  color: rgba(255,107,0,0.5); font-size: .9rem;
}
.input-wrap input {
  width: 100%;
  padding: .85rem 1rem .85rem 2.75rem;
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,107,0,0.2);
  border-radius: 12px;
  color: #fff;
  font-size: .9rem;
  outline: none;
  transition: border-color .2s;
  font-family: 'Inter', sans-serif;
}
.input-wrap input:focus { border-color: #ff6b00; background: rgba(255,107,0,0.05); }
.input-wrap input::placeholder { color: rgba(255,255,255,0.25); }

.toggle-pw {
  position: absolute; right: 1rem;
  background: none; border: none;
  color: rgba(255,255,255,0.3); cursor: pointer;
  font-size: .9rem; transition: color .2s;
}
.toggle-pw:hover { color: #ff6b00; }

.login-btn {
  width: 100%;
  padding: 1rem;
  background: linear-gradient(135deg, #ff6b00, #ff9500);
  color: #fff;
  border: none;
  border-radius: 12px;
  font-size: .95rem;
  font-weight: 700;
  letter-spacing: 1px;
  cursor: pointer;
  transition: all .3s;
  margin-top: .5rem;
  box-shadow: 0 8px 30px rgba(255,107,0,0.3);
  font-family: 'Inter', sans-serif;
}
.login-btn:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 14px 40px rgba(255,107,0,0.5); }
.login-btn:disabled { opacity: .6; cursor: not-allowed; }

.login-hint { text-align: center; margin-top: 1.5rem; font-size: .78rem; color: rgba(255,255,255,0.2); }
</style>
