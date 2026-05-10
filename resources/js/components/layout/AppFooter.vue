<template>
  <footer style="background:#080808; padding:2rem; text-align:center; color:rgba(255,255,255,0.3); font-size:.85rem;">
    © {{ year }} Aurosunrise Records. All Rights Reserved.
  </footer>
</template>
<script setup>
const year = new Date().getFullYear()
</script>
