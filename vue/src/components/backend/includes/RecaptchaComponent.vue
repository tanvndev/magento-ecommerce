<template>
  <div id="recaptcha" class="g-recaptcha mt-[16px]" :data-sitekey="siteKey"></div>
</template>

<script setup>
import { onMounted } from 'vue';

const siteKey = import.meta.env.VITE_RECAPTCHA_SITE_KEY;

onMounted(() => {
  if (typeof grecaptcha !== 'undefined') {
    // eslint-disable-next-line no-undef
    grecaptcha.ready(() => {
      // eslint-disable-next-line no-undef
      grecaptcha.render('recaptcha', {
        sitekey: siteKey
      });
    });
  } else {
    console.error('grecaptcha is not defined');
  }
});
</script>

<style scope></style>
