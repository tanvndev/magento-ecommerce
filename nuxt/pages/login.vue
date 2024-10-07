<template></template>
<script setup>
const config = useRuntimeConfig()
const urlLogin = `${config.public.VUE_APP_URL}/login`
onMounted(() => {
  window.location.href = urlLogin
})
</script>
