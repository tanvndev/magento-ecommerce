<template>
  <div class="row category-banner-wrapper pt-6 pb-8">
    <div class="col-md-6 mb-4" v-for="item in items" :key="item.url">
      <div class="banner banner-fixed br-xs">
        <figure>
          <img
            :src="resizeImage(item.image, 800, 400)"
            :alt="item.alt"
            width="610"
            height="160"
            style="background-color: #ecedec; height: 200px"
          />
        </figure>
        <div class="banner-content y-50 pt-1">
          <!-- <h5 class="banner-subtitle font-weight-bold text-uppercase">
            Natural Process
          </h5>
          <h3
            class="banner-title font-weight-bolder text-capitalize text-white"
          >
            Cosmetic Makeup<br />Professional
          </h3> -->
          <div v-html="item.content"></div>
          <a
            href="shop-banner-sidebar.html"
            class="btn btn-white btn-link btn-underline btn-icon-right"
            >Shop Now<i class="w-icon-long-arrow-right"></i
          ></a>
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
