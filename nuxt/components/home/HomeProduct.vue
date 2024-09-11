<template>
  <div class="product-wrapper-1 mt-5 mb-5">
    <div class="title-link-wrapper pb-1 mb-4">
      <h2 class="title ls-normal mb-0">{{ title }}</h2>
      <NuxtLink
        to="category"
        class="font-size-normal font-weight-bold ls-25 mb-0"
        >Xem tất cả <i class="w-icon-long-arrow-right"></i
      ></NuxtLink>
    </div>
    <div class="row">
      <!-- End of Banner -->
      <div class="col-lg-12 col-sm-8">
        <div class="swiper-theme slider-wrapper">
          <swiper
            @swiper="onSwiper"
            :modules="modules"
            :slides-per-view="4"
            :loop="true"
            :navigation="false"
            :grid="{ rows: 2, fill: 'row' }"
            :space-between="20"
            :autoplay="{
              delay: 5000,
              pauseOnMouseEnter: true,
              disableOnInteraction: false,
            }"
          >
            <!-- <div class="row cols-xl-4 cols-lg-3 cols-2"> -->
            <swiper-slide v-for="item in items" :key="item.id">
              <div class="product-col">
                <div class="product-wrap product text-center">
                  <figure class="product-media">
                    <NuxtLink
                      :title="item?.name"
                      :to="`product/${item.slug}-${item.product_id}`"
                    >
                      <img
                        :src="resizeImage(item.image, 500, 400)"
                        :alt="item.name"
                        style="width: 300px; height: 280px; border-radius: 4px"
                      />
                    </NuxtLink>
                    <div class="product-action-vertical">
                      <a
                        href="#"
                        class="btn-product-icon btn-cart w-icon-cart"
                        title="Add to cart"
                      ></a>
                      <a
                        href="#"
                        class="btn-product-icon btn-wishlist w-icon-heart"
                        title="Add to wishlist"
                      ></a>
                    </div>
                    <div class="product-label-group" v-if="item?.discount">
                      <label class="product-label label-discount"
                        >Giảm {{ item?.discount }}%</label
                      >
                    </div>
                  </figure>
                  <div class="product-details">
                    <h4 class="product-name">
                      <NuxtLink
                        :title="item?.name"
                        :to="`product/${item.slug}-${item.product_id}`"
                        >{{ item.name }}</NuxtLink
                      >
                    </h4>
                    <div class="ratings-container">
                      <div class="ratings-full">
                        <span class="ratings" style="width: 60%"></span>
                        <span class="tooltiptext tooltip-top">3</span>
                      </div>
                      <a href="#" class="rating-reviews">(3 đánh giá)</a>
                    </div>
                    <div v-html="handleRenderPrice(item)"></div>
                  </div>
                </div>
              </div>
            </swiper-slide>
            <!-- </div> -->
          </swiper>
          <div>
            <button class="button-slide prev" @click.stop="slider.slidePrev()">
              <i class="w-icon-angle-left"></i>
            </button>
            <button class="button-slide next" @click.stop="slider.slideNext()">
              <i class="w-icon-angle-right"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { resizeImage, handleRenderPrice } from '#imports'
import { ref } from 'vue'
import { Swiper, SwiperSlide } from 'swiper/vue'
import { Navigation, Autoplay, Grid } from 'swiper/modules'
import 'swiper/css'

const props = defineProps({
  items: {
    type: [Array, Object],
    default: () => [],
  },
  title: {
    type: String,
    default: () => '',
  },
})

const modules = [Navigation, Grid, Autoplay]
const slider = ref(null)
const onSwiper = (swiper) => {
  slider.value = swiper
}
</script>
<style scoped></style>
