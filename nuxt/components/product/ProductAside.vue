<template>
  <aside
    class="sidebar product-sidebar sidebar-fixed right-sidebar sticky-sidebar-wrapper"
  >
    <div class="sidebar-overlay"></div>
    <a class="sidebar-close" href="#"><i class="close-icon"></i></a>
    <div class="sidebar-content scrollable">
      <div class="sticky-sidebar">
        <div class="widget widget-icon-box mb-6">
          <div class="icon-box icon-box-side">
            <span class="icon-box-icon text-dark">
              <i class="w-icon-truck"></i>
            </span>
            <div class="icon-box-content">
              <h4 class="icon-box-title">Free Shipping & Returns</h4>
              <p>For all orders over $99</p>
            </div>
          </div>
          <div class="icon-box icon-box-side">
            <span class="icon-box-icon text-dark">
              <i class="w-icon-bag"></i>
            </span>
            <div class="icon-box-content">
              <h4 class="icon-box-title">Secure Payment</h4>
              <p>We ensure secure payment</p>
            </div>
          </div>
          <div class="icon-box icon-box-side">
            <span class="icon-box-icon text-dark">
              <i class="w-icon-money"></i>
            </span>
            <div class="icon-box-content">
              <h4 class="icon-box-title">Money Back Guarantee</h4>
              <p>Any back within 30 days</p>
            </div>
          </div>
        </div>
        <!-- End of Widget Icon Box -->

        <div class="widget widget-banner mb-9">
          <div class="banner banner-fixed br-sm">
            <figure>
              <img
                src="assets/images/shop/banner3.jpg"
                alt="Banner"
                width="266"
                height="220"
                style="background-color: #1d2d44"
              />
            </figure>
            <div class="banner-content">
              <div
                class="banner-price-info font-weight-bolder text-white lh-1 ls-25"
              >
                40<sup class="font-weight-bold">%</sup
                ><sub class="font-weight-bold text-uppercase ls-25">Off</sub>
              </div>
              <h4
                class="banner-subtitle text-white font-weight-bolder text-uppercase mb-0"
              >
                Ultimate Sale
              </h4>
            </div>
          </div>
        </div>
        <!-- End of Widget Banner -->

        <div class="widget widget-products">
          <div
            class="title-link-wrapper mb-2 d-flex justify-between items-center"
          >
            <h4 class="title title-link font-weight-bold">More Products</h4>
            <div>
              <button
                class="button-slide-2 prev"
                @click.stop="slider.slidePrev()"
              >
                <i class="w-icon-angle-left"></i>
              </button>
              <button
                class="button-slide-2 next"
                @click.stop="slider.slideNext()"
              >
                <i class="w-icon-angle-right"></i>
              </button>
            </div>
          </div>

          <div class="nav-top">
            <div class="swiper-theme nav-top">
              <Swiper
                @swiper="onSwiper"
                :modules="modules"
                :slides-per-view="1"
                :space-between="10"
                :navigation="false"
                :loop="true"
              >
                <SwiperSlide>
                  <div class="widget-col">
                    <div class="product product-widget">
                      <figure class="product-media">
                        <a href="#">
                          <img
                            src="assets/images/shop/13.jpg"
                            alt="Product"
                            width="100"
                            height="113"
                          />
                        </a>
                      </figure>
                      <div class="product-details">
                        <h4 class="product-name">
                          <a href="#">Smart Watch</a>
                        </h4>
                        <div class="ratings-container">
                          <div class="ratings-full">
                            <span class="ratings" style="width: 100%"></span>
                            <span class="tooltiptext tooltip-top"></span>
                          </div>
                        </div>
                        <div class="product-price">$80.00 - $90.00</div>
                      </div>
                    </div>
                    <div class="product product-widget">
                      <figure class="product-media">
                        <a href="#">
                          <img
                            src="assets/images/shop/14.jpg"
                            alt="Product"
                            width="100"
                            height="113"
                          />
                        </a>
                      </figure>
                      <div class="product-details">
                        <h4 class="product-name">
                          <a href="#">Sky Medical Facility</a>
                        </h4>
                        <div class="ratings-container">
                          <div class="ratings-full">
                            <span class="ratings" style="width: 80%"></span>
                            <span class="tooltiptext tooltip-top"></span>
                          </div>
                        </div>
                        <div class="product-price">$58.00</div>
                      </div>
                    </div>
                    <div class="product product-widget">
                      <figure class="product-media">
                        <a href="#">
                          <img
                            src="assets/images/shop/15.jpg"
                            alt="Product"
                            width="100"
                            height="113"
                          />
                        </a>
                      </figure>
                      <div class="product-details">
                        <h4 class="product-name">
                          <a href="#">Black Stunt Motor</a>
                        </h4>
                        <div class="ratings-container">
                          <div class="ratings-full">
                            <span class="ratings" style="width: 60%"></span>
                            <span class="tooltiptext tooltip-top"></span>
                          </div>
                        </div>
                        <div class="product-price">$374.00</div>
                      </div>
                    </div>
                  </div>
                </SwiperSlide>
                <SwiperSlide>
                  <div class="widget-col">
                    <div class="product product-widget">
                      <figure class="product-media">
                        <a href="#">
                          <img
                            src="assets/images/shop/16.jpg"
                            alt="Product"
                            width="100"
                            height="113"
                          />
                        </a>
                      </figure>
                      <div class="product-details">
                        <h4 class="product-name">
                          <a href="#">Skate Pan</a>
                        </h4>
                        <div class="ratings-container">
                          <div class="ratings-full">
                            <span class="ratings" style="width: 100%"></span>
                            <span class="tooltiptext tooltip-top"></span>
                          </div>
                        </div>
                        <div class="product-price">$278.00</div>
                      </div>
                    </div>
                    <div class="product product-widget">
                      <figure class="product-media">
                        <a href="#">
                          <img
                            src="assets/images/shop/17.jpg"
                            alt="Product"
                            width="100"
                            height="113"
                          />
                        </a>
                      </figure>
                      <div class="product-details">
                        <h4 class="product-name">
                          <a href="#">Modern Cooker</a>
                        </h4>
                        <div class="ratings-container">
                          <div class="ratings-full">
                            <span class="ratings" style="width: 80%"></span>
                            <span class="tooltiptext tooltip-top"></span>
                          </div>
                        </div>
                        <div class="product-price">$324.00</div>
                      </div>
                    </div>
                    <div class="product product-widget">
                      <figure class="product-media">
                        <a href="#">
                          <img
                            src="assets/images/shop/18.jpg"
                            alt="Product"
                            width="100"
                            height="113"
                          />
                        </a>
                      </figure>
                      <div class="product-details">
                        <h4 class="product-name">
                          <a href="#">CT Machine</a>
                        </h4>
                        <div class="ratings-container">
                          <div class="ratings-full">
                            <span class="ratings" style="width: 100%"></span>
                            <span class="tooltiptext tooltip-top"></span>
                          </div>
                        </div>
                        <div class="product-price">$236.00</div>
                      </div>
                    </div>
                  </div>
                </SwiperSlide>
              </Swiper>
            </div>
          </div>
        </div>
      </div>
    </div>
  </aside>
</template>
<script setup>
import { Swiper, SwiperSlide } from 'swiper/vue'
import { Navigation, Autoplay } from 'swiper/modules'
import 'swiper/css'
const modules = [Navigation, Autoplay]
const slider = ref(null)

const onSwiper = (swiper) => {
  slider.value = swiper
}
</script>
<style scoped></style>
