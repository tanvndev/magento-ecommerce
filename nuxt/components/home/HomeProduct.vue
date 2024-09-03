<template>
  <div class="product-wrapper-1 mt-5 mb-5">
    <div class="title-link-wrapper pb-1 mb-4">
      <h2 class="title ls-normal mb-0">Clothing & Apparel</h2>
      <a
        href="shop-boxed-banner.html"
        class="font-size-normal font-weight-bold ls-25 mb-0"
        >More Products<i class="w-icon-long-arrow-right"></i
      ></a>
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
                    <a href="#">
                      <img
                        src="~/assets/images/demos/demo1/products/4-1.jpg"
                        alt="Product"
                        width="216"
                        height="243"
                      />
                    </a>
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
                      <a
                        href="#"
                        class="btn-product-icon btn-quickview w-icon-search"
                        title="Quickview"
                      ></a>
                      <a
                        href="#"
                        class="btn-product-icon btn-compare w-icon-compare"
                        title="Add to Compare"
                      ></a>
                    </div>
                  </figure>
                  <div class="product-details">
                    <h4 class="product-name">
                      <a href="product-default.html">Men’s Clothing</a>
                    </h4>
                    <div class="ratings-container">
                      <div class="ratings-full">
                        <span class="ratings" style="width: 60%"></span>
                        <span class="tooltiptext tooltip-top"></span>
                      </div>
                      <a href="product-default.html" class="rating-reviews"
                        >(3 reviews)</a
                      >
                    </div>
                    <div class="product-price">
                      <ins class="new-price">$23.99</ins
                      ><del class="old-price">$25.68</del>
                    </div>
                  </div>
                </div>
                <div class="product-wrap product text-center">
                  <figure class="product-media">
                    <a href="#">
                      <img
                        src="~/assets/images/demos/demo1/products/4-5-1.jpg"
                        alt="Product"
                        width="216"
                        height="243"
                      />
                      <img
                        src="~/assets/images/demos/demo1/products/4-5-2.jpg"
                        alt="Product"
                        width="216"
                        height="243"
                      />
                    </a>
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
                      <a
                        href="#"
                        class="btn-product-icon btn-quickview w-icon-search"
                        title="Quickview"
                      ></a>
                      <a
                        href="#"
                        class="btn-product-icon btn-compare w-icon-compare"
                        title="Add to Compare"
                      ></a>
                    </div>
                  </figure>
                  <div class="product-details">
                    <h4 class="product-name">
                      <a href="product-default.html">Best Travel Bag</a>
                    </h4>
                    <div class="ratings-container">
                      <div class="ratings-full">
                        <span class="ratings" style="width: 60%"></span>
                        <span class="tooltiptext tooltip-top"></span>
                      </div>
                      <a href="product-default.html" class="rating-reviews"
                        >(3 reviews)</a
                      >
                    </div>
                    <div class="product-price">
                      <ins class="new-price">$25.68</ins
                      ><del class="old-price">$28.99</del>
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
<style scoped>

</style>
