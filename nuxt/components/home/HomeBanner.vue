<template>
  <section class="intro-section">
    <div class="nav-inner pg-inner pg-xxl-hide nav-xxl-show nav-hide">
      <swiper
        :modules="modules"
        :slides-per-view="1"
        :autoplay="true"
        :loop="true"
        :infinite="true"
        :pagination="{ clickable: true }"
        :navigation="true"
      >
        <swiper-slide>
          <div
            class="banner banner-fixed intro-slide intro-slide1"
            style="background-color: #ebeef2"
          >
            <div class="container">
              <figure class="slide-image skrollable">
                <img
                  src="~/assets/images/demos/demo1/sliders/shoes.png"
                  alt="Banner"
                  width="474"
                  height="397"
                />
              </figure>
              <div class="banner-content y-50 text-right">
                <h5
                  class="banner-subtitle font-weight-normal text-default ls-50 lh-1 mb-2"
                >
                  Custom <span class="p-relative d-inline-block">Men’s</span>
                </h5>
                <h3 class="banner-title font-weight-bolder ls-25 lh-1">
                  RUNNING SHOES
                </h3>
                <p class="font-weight-normal text-default">
                  Sale up to
                  <span class="font-weight-bolder text-secondary">30% OFF</span>
                </p>

                <a
                  href="shop-list.html"
                  class="btn btn-dark btn-outline btn-rounded btn-icon-right"
                  >SHOP NOW<i class="w-icon-long-arrow-right"></i
                ></a>
              </div>
              <!-- End of .banner-content -->
            </div>
            <!-- End of .container -->
          </div>
          <!-- End of .intro-slide1 -->
        </swiper-slide>
        <swiper-slide>
          <div
            class="banner banner-fixed intro-slide intro-slide2"
            style="background-color: #ebeef2"
          >
            <div class="container">
              <figure class="slide-image skrollable slide-animate">
                <img
                  src="~/assets/images/demos/demo1/sliders/men.png"
                  alt="Banner"
                  width="480"
                  height="633"
                />
              </figure>
              <div class="banner-content d-inline-block y-50">
                <h5
                  class="banner-subtitle font-weight-normal text-default ls-50 slide-animate"
                >
                  Mountain-<span class="text-secondary">Climbing</span>
                </h5>
                <h3
                  class="banner-title font-weight-bolder text-dark mb-0 ls-25 slide-animate"
                >
                  Hot & Packback
                </h3>
                <p class="font-weight-normal text-default slide-animate">
                  Only until the end of this week.
                </p>
                <a
                  href="shop-banner-sidebar.html"
                  class="btn btn-dark btn-outline btn-rounded btn-icon-right slide-animate"
                >
                  SHOP NOW<i class="w-icon-long-arrow-right"></i>
                </a>
              </div>
              <!-- End of .banner-content -->
            </div>
            <!-- End of .container -->
          </div>
          <!-- End of .intro-slide2 -->
        </swiper-slide>

        <swiper-slide>
          <div
            class="banner banner-fixed intro-slide intro-slide3"
            style="background-color: #f0f1f2"
          >
            <div class="container">
              <figure class="slide-image skrollable slide-animate">
                <img
                  src="~/assets/images/demos/demo1/sliders/skate.png"
                  alt="Banner"
                  width="310"
                  height="444"
                />
              </figure>
              <div class="banner-content text-right y-50">
                <p
                  class="font-weight-normal text-default text-uppercase mb-0 slide-animate"
                >
                  Top weekly Seller
                </p>
                <h5
                  class="banner-subtitle font-weight-normal text-default ls-25 slide-animate"
                >
                  Trending Collection
                </h5>
                <h3
                  class="banner-title p-relative font-weight-bolder ls-50 slide-animate"
                >
                  <span class="text-white mr-4">Roller</span>-skate
                </h3>
                <div class="btn-group slide-animate">
                  <a
                    href="shop-list.html"
                    class="btn btn-dark btn-outline btn-rounded btn-icon-right"
                    >SHOP NOW<i class="w-icon-long-arrow-right"></i
                  ></a>
                </div>
                <!-- End of .banner-content -->
              </div>
              <!-- End of .container -->
            </div>
          </div>
          <!-- End of .intro-slide3 -->
        </swiper-slide>
      </swiper>
    </div>
    <!-- End of . -->
  </section>
</template>
<script setup>
import { Swiper, SwiperSlide } from 'swiper/vue'
import { Autoplay, Pagination, Navigation } from 'swiper/modules'
import 'swiper/css'

const modules = [Autoplay, Pagination, Navigation]
</script>
