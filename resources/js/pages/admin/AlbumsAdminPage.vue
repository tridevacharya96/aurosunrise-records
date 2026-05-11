<template>
  <div style="color:#fff;font-family:'Inter',sans-serif">
    <h2 style="font-family:'Cinzel',serif;font-size:1.5rem;margin-bottom:1rem">Albums <span style="color:#ff6b00">— Coming Soon</span></h2>
    <p style="color:rgba(255,255,255,0.4)">Album management will be available here. Artists and their albums are already linked in the database.</p>
    <RouterLink to="/admin/artists" style="color:#ff6b00;margin-top:1rem;display:inline-block">← Go to Artists</RouterLink>
  </div>
</template>
<script setup>
import { RouterLink } from 'vue-router'
</script>
