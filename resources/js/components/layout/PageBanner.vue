<template>
  <div style="padding:8rem 2rem 3rem; background:#111; text-align:center;">
    <h1 style="color:#fff; font-size:2.5rem; font-weight:900;">{{ title }}</h1>
  </div>
</template>
<script setup>
defineProps({ title: String, breadcrumb: String })
</script>
