<template></template>
<script setup>
const config = useRuntimeConfig()
const urlLogin = `${config.public.vueUrl}/login`
onMounted(() => {
  window.location.href = urlLogin
})
</script>
