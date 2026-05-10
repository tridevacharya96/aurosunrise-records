import { ref, computed } from 'vue'

export function useApi(baseUrl) {
  const data = ref(null)
  const loading = ref(false)
  const error = ref(null)

  async function get(url = null, params = {}) {
    loading.value = true
    error.value = null
    try {
      let endpoint = url || baseUrl
      if (Object.keys(params).length) endpoint += '?' + new URLSearchParams(params)
      const res = await fetch(endpoint, {
        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' }
      })
      const json = await res.json()
      data.value = json.data !== undefined ? json.data : json
    } catch (e) {
      error.value = e.message
    } finally {
      loading.value = false
    }
  }

  async function post(payload, url = null) {
    loading.value = true
    error.value = null
    try {
      const res = await fetch(url || baseUrl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
        body: JSON.stringify(payload)
      })
      const json = await res.json()
      data.value = json.data !== undefined ? json.data : json
      return data.value
    } catch (e) {
      error.value = e.message
      return null
    } finally {
      loading.value = false
    }
  }

  return { data, loading, error, get, post }
}
