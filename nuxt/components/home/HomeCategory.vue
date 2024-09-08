<template>
  <div class="container">
    <div class="icon-box-wrapper br-sm mt-6 mb-6">
      <div class="row cols-md-4 cols-sm-3 cols-1">
        <div class="icon-box icon-box-side icon-box-primary">
          <span class="icon-box-icon icon-shipping">
            <i class="w-icon-truck"></i>
          </span>
          <div class="icon-box-content">
            <h4 class="icon-box-title font-weight-bold mb-1">
              Free Shipping & Returns
            </h4>
            <p class="text-default">For all orders over $99</p>
          </div>
        </div>
        <div class="icon-box icon-box-side icon-box-primary">
          <span class="icon-box-icon icon-payment">
            <i class="w-icon-bag"></i>
          </span>
          <div class="icon-box-content">
            <h4 class="icon-box-title font-weight-bold mb-1">Secure Payment</h4>
            <p class="text-default">We ensure secure payment</p>
          </div>
        </div>
        <div class="icon-box icon-box-side icon-box-primary icon-box-money">
          <span class="icon-box-icon icon-money">
            <i class="w-icon-money"></i>
          </span>
          <div class="icon-box-content">
            <h4 class="icon-box-title font-weight-bold mb-1">
              Money Back Guarantee
            </h4>
            <p class="text-default">Any back within 30 days</p>
          </div>
        </div>
        <div class="icon-box icon-box-side icon-box-primary icon-box-chat">
          <span class="icon-box-icon icon-chat">
            <i class="w-icon-chat"></i>
          </span>
          <div class="icon-box-content">
            <h4 class="icon-box-title font-weight-bold mb-1">
              Customer Support
            </h4>
            <p class="text-default">Call or email us 24/7</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Categories -->
  <section class="category-section top-category bg-grey pt-10 pb-10">
    <div class="container pb-2">
      <h2 class="title justify-content-center pt-1 ls-normal mb-5">
        Top Categories Of The Month
      </h2>
      <div class="category-wrapper">
        <div class="swiper-theme pg-show">
          <swiper
            :modules="modules"
            :slides-per-view="6"
            :loop="true"
            :navigation="false"
            :autoplay="{
              delay: 3000,
              disableOnInteraction: false,
              pauseOnMouseEnter: true,
            }"
          >
            <swiper-slide v-for="item in 24" :key="item">
              <div
                class="category category-classic category-absolute overlay-zoom br-xs mx-2"
              >
                <a href="#" class="category-media">
                  <img
                    src="~/assets/images/demos/demo1/categories/2-6.jpg"
                    alt="Category"
                    width="130"
                    height="130"
                  />
                </a>
                <div class="category-content">
                  <h4 class="category-name">Computers</h4>
                  <a href="#" class="btn btn-primary btn-link btn-underline"
                    >Shop Now</a
                  >
                </div>
              </div>
            </swiper-slide>
          </swiper>
        </div>
      </div>
    </div>
  </section>
</template>
<script setup>
import { Swiper, SwiperSlide } from 'swiper/vue'
import { Navigation, Autoplay } from 'swiper/modules'
import 'swiper/css'
const config = useRuntimeConfig()
const apiBaseUrl = config.public.apiBaseUrl

const modules = [Navigation, Autoplay]

const {
  data: productCatalogues,
  pending,
  error,
} = useFetch(apiBaseUrl + '/products/catalogues/list')
console.log(productCatalogues)

// if (error.value) {
//   console.error('Failed to fetch data:', error.value)
// }
</script>
