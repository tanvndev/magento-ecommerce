<template>
  <div class="product-wrapper-1 mt-5 mb-5">
    <div class="title-link-wrapper pb-1 mb-4">
      <h2 class="title ls-normal mb-0">Sản phẩm mới nhất</h2>
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
            :autoplay="{
              delay: 3000,
              disableOnInteraction: false,
              pauseOnMouseEnter: true,
            }"
          >
            <!-- <div class="row cols-xl-4 cols-lg-3 cols-2"> -->
            <swiper-slide v-for="item in 8" :key="item">
              <div class="product-col mx-2">
                <div class="product-wrap product text-center">
                  <figure class="product-media">
                    <NuxtLink to="detail">
                      <img
                        src="~/assets/images/demos/demo1/products/4-1.jpg"
                        alt="Product"
                        width="216"
                        height="243"
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
                  </figure>
                  <div class="product-details">
                    <h4 class="product-name">
                      <NuxtLink to="detail">iPhone 12 promax 512GB</NuxtLink>
                    </h4>
                    <div class="ratings-container">
                      <div class="ratings-full">
                        <span class="ratings" style="width: 60%"></span>
                        <span class="tooltiptext tooltip-top">3</span>
                      </div>
                      <a href="#" class="rating-reviews">(3 đánh giá)</a>
                    </div>
                    <div class="product-price">
                      <ins class="new-price">2.0000.000 đ</ins>
                      <del class="old-price">4.0000.000 đ</del>
                    </div>
                  </div>
                </div>
                <div class="product-wrap product text-center">
                  <figure class="product-media">
                    <NuxtLink to="detail">
                      <img
                        src="~/assets/images/demos/demo1/products/4-5-1.jpg"
                        alt="Product"
                        width="216"
                        height="243"
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
                  </figure>
                  <div class="product-details">
                    <h4 class="product-name">
                      <NuxtLink to="detail">iPhone 12 promax 512GB</NuxtLink>
                    </h4>
                    <div class="ratings-container">
                      <div class="ratings-full">
                        <span class="ratings" style="width: 60%"></span>
                        <span class="tooltiptext tooltip-top">3</span>
                      </div>
                      <a href="#" class="rating-reviews">(3 đánh giá)</a>
                    </div>
                    <div class="product-price">
                      <ins class="new-price">2.0000.000 đ</ins>
                      <del class="old-price">4.0000.000 đ</del>
                    </div>
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
import { ref } from 'vue'
import { Swiper, SwiperSlide, useSwiper } from 'swiper/vue'
import { Navigation, Autoplay } from 'swiper/modules'
import 'swiper/css'
// const swiper = useSwiper();

const modules = [Navigation, Autoplay]
const slider = ref(null)
const onSwiper = (swiper) => {
  slider.value = swiper
}
</script>
<style scoped></style>
