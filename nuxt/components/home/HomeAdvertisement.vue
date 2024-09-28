<template>
  <div class="row category-banner-wrapper pt-6 pb-8">
    <div class="col-md-6 mb-4" v-for="item in items" :key="item.url">
      <div class="banner banner-fixed br-xs">
        <figure>
          <NuxtLink :to="item.url">
            <img
              :src="resizeImage(item.image, 1300)"
              :alt="item.alt"
              width="610"
              height="160"
              style="background-color: #ecedec; height: 200px"
            />
          </NuxtLink>
        </figure>
        <div class="banner-content y-50 pt-1">
          <div v-if="item?.content" v-html="item.content"></div>
          <NuxtLink
            v-if="item?.button"
            :to="item.url"
            class="btn btn-white btn-link btn-underline btn-icon-right"
            >Shop Now <i class="w-icon-long-arrow-right"></i
          ></NuxtLink>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { resizeImage } from '#imports'
const props = defineProps({
  items: {
    type: [Array, Object],
    default: () => [],
  },
})
</script>

<style scoped>
.banner.banner-fixed {
  box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
  border-radius: 15px !important;
  overflow: hidden;
}
.banner.banner-fixed img{
  border-radius: 15px !important;

}
</style>
