import { defineStore } from 'pinia'
import { ref, computed } from 'vue'

export const useMusicPlayerStore = defineStore('musicPlayer', () => {
  const currentTrack = ref(null)
  const isPlaying = ref(false)
  const volume = ref(0.8)
  const isMuted = ref(false)
  const currentTime = ref(0)
  const duration = ref(0)
  const queue = ref([])
  const queueIndex = ref(0)

  const progressPercent = computed(() => duration.value ? (currentTime.value / duration.value) * 100 : 0)
  const hasNext = computed(() => queueIndex.value < queue.value.length - 1)
  const hasPrev = computed(() => queueIndex.value > 0)
  const formattedCurrentTime = computed(() => formatTime(currentTime.value))
  const formattedDuration = computed(() => formatTime(duration.value))

  function formatTime(s) {
    const m = Math.floor(s / 60)
    return `${m}:${Math.floor(s % 60).toString().padStart(2, '0')}`
  }

  function play(track) { currentTrack.value = track; isPlaying.value = true }
  function pause() { isPlaying.value = false }
  function togglePlay() { isPlaying.value ? pause() : play() }
  function setVolume(v) { volume.value = v }
  function toggleMute() { isMuted.value = !isMuted.value }
  function nextTrack() { if (hasNext.value) { queueIndex.value++; play(queue.value[queueIndex.value]) } }
  function prevTrack() { if (hasPrev.value) { queueIndex.value--; play(queue.value[queueIndex.value]) } }
  function seek(p) { currentTime.value = (p / 100) * duration.value }
  function setQueue(tracks, i = 0) { queue.value = tracks; queueIndex.value = i; play(tracks[i]) }

  return {
    currentTrack, isPlaying, volume, isMuted, currentTime, duration, queue, queueIndex,
    progressPercent, hasNext, hasPrev, formattedCurrentTime, formattedDuration,
    play, pause, togglePlay, setVolume, toggleMute, nextTrack, prevTrack, seek, setQueue
  }
})
