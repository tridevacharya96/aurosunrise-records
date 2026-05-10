import { defineStore } from 'pinia'
import { ref, computed } from 'vue'

export const useCartStore = defineStore('cart', () => {
  const items = ref([])
  const itemCount = computed(() => items.value.reduce((s, i) => s + i.quantity, 0))
  function addItem(product, quantity = 1) {
    const existing = items.value.find(i => i.product.id === product.id)
    if (existing) existing.quantity += quantity
    else items.value.push({ product, quantity })
  }
  function removeItem(id) { items.value = items.value.filter(i => i.product.id !== id) }
  function clearCart() { items.value = [] }
  return { items, itemCount, addItem, removeItem, clearCart }
})
