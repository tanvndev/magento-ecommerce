<template>
  <!-- Start of Page Content -->
  <div class="page-content mt-5">
    <div class="container">
      <div class="row gutter-lg">
        <div class="main-content">
          <div class="product product-single mb-4">
            <div class="mb-4 position-relative">
              <!-- Start of Product Gallery -->
              <div class="product-single-swiper swiper-theme nav-inner -mx-2">
                <swiper
                  :modules="modules"
                  :slides-per-view="2"
                  :loop="true"
                  :navigation="true"
                  :autoplay="{
                    delay: 5000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                  }"
                >
                  <swiper-slide v-for="(image, index) in images" :key="image">
                    <figure
                      class="product-image mx-2"
                      @click="() => showImg(index)"
                    >
                      <img
                        width="455"
                        height="512"
                        :src="image"
                        alt="White Sofa"
                      />
                    </figure>
                  </swiper-slide>
                </swiper>
                <VueEasyLightbox
                  :visible="visibleRef"
                  :imgs="images"
                  :index="indexRef"
                  @hide="onHide"
                />
                <a
                  href="#"
                  @click="() => showImg(0)"
                  class="product-gallery-btn product-image-full"
                  ><i class="w-icon-zoom"></i
                ></a>
              </div>
              <!-- End of Product Gallery -->
            </div>
            <!-- Start of Product Details -->
            <div class="product-details row pl-0">
              <div class="col-md-6">
                <h1 class="product-title">White Sofa</h1>
                <div class="product-bm-wrapper">
                  <figure class="brand">
                    <img
                      src="assets/images/products/brand/brand-1.jpg"
                      alt="Brand"
                      width="102"
                      height="48"
                    />
                  </figure>
                  <div class="product-meta">
                    <div class="product-categories">
                      Category:
                      <span class="product-category"
                        ><a href="#">Furniture</a></span
                      >
                    </div>
                    <div class="product-sku">SKU: <span>MS46891353</span></div>
                  </div>
                </div>

                <div class="product-price">
                  <ins class="new-price">$730.00</ins>
                </div>

                <div class="ratings-container">
                  <div class="ratings-full">
                    <span class="ratings" style="width: 80%"></span>
                    <span class="tooltiptext tooltip-top"></span>
                  </div>
                  <a href="#product-tab-reviews" class="rating-reviews"
                    >(3 Reviews)</a
                  >
                </div>

                <div class="product-short-desc">
                  <ul class="list-type-check list-style-none">
                    <li>Ultrices eros in cursus turpis massa cursus mattis.</li>
                    <li>Volutpat ac tincidunt vitae semper quis lectus.</li>
                    <li>Aliquam id diam maecenas ultricies mi eget mauris.</li>
                  </ul>
                </div>
              </div>
              <div class="col-md-6 mt-1">
                <div
                  class="product-form product-variation-form product-color-swatch product-variations mt-1"
                >
                  <label>Color:</label>
                  <div class="d-flex align-items-center">
                    <a
                      href="#"
                      class="color"
                      style="background-color: #ffcc01"
                    ></a>
                    <a
                      href="#"
                      class="color"
                      style="background-color: #ca6d00"
                    ></a>
                    <a
                      href="#"
                      class="color"
                      style="background-color: #1c93cb"
                    ></a>
                    <a
                      href="#"
                      class="color"
                      style="background-color: #ccc"
                    ></a>
                    <a
                      href="#"
                      class="color"
                      style="background-color: #333"
                    ></a>
                  </div>
                </div>
                <div
                  class="product-form product-variation-form product-size-swatch"
                >
                  <label class="mb-1">Size:</label>
                  <div
                    class="product-variations flex-wrap d-flex align-items-center"
                  >
                    <a href="#" class="size">Small</a>
                    <a href="#" class="size">Medium</a>
                    <a href="#" class="size">Large</a>
                    <a href="#" class="size">Extra Large</a>
                  </div>
                </div>

                <div class="product-variation-price">
                  <span></span>
                </div>

                <hr class="product-divider mb-5" />
                <div class="fix-bottom product-sticky-content sticky-content">
                  <div class="product-form container">
                    <div class="product-qty-form">
                      <div class="input-group">
                        <input
                          class="quantity form-control"
                          type="number"
                          min="1"
                          max="10000000"
                        />
                        <button class="quantity-plus w-icon-plus"></button>
                        <button class="quantity-minus w-icon-minus"></button>
                      </div>
                    </div>
                    <button class="btn btn-primary btn-cart">
                      <i class="w-icon-cart"></i>
                      <span>Add to Cart</span>
                    </button>
                  </div>
                </div>

                <div class="social-links-wrapper">
                  <div class="social-links">
                    <div class="social-icons social-no-color border-thin">
                      <a
                        href="#"
                        class="social-icon social-facebook w-icon-facebook"
                      ></a>
                      <a
                        href="#"
                        class="social-icon social-twitter w-icon-twitter"
                      ></a>
                      <a
                        href="#"
                        class="social-icon social-pinterest fab fa-pinterest-p"
                      ></a>
                      <a
                        href="#"
                        class="social-icon social-whatsapp fab fa-whatsapp"
                      ></a>
                      <a
                        href="#"
                        class="social-icon social-youtube fab fa-linkedin-in"
                      ></a>
                    </div>
                  </div>
                  <span class="divider d-xs-show"></span>
                  <div class="product-link-wrapper d-flex">
                    <a
                      href="#"
                      class="btn-product-icon btn-wishlist w-icon-heart"
                      ><span></span
                    ></a>
                    <a
                      href="#"
                      class="btn-product-icon btn-compare btn-icon-left w-icon-compare"
                      ><span></span
                    ></a>
                  </div>
                </div>
              </div>
            </div>
            <!-- End of Product Details -->
          </div>

          <!-- Start of MoreInfomation -->
          <MoreInfomation />
          <!-- End of MoreInfomation -->

          <section class="vendor-product-section">
            <div class="title-link-wrapper mb-4">
              <h4 class="title text-left">More Products From This Vendor</h4>
              <a
                href="#"
                class="btn btn-dark btn-link btn-slide-right btn-icon-right"
                >More Products<i class="w-icon-long-arrow-right"></i
              ></a>
            </div>
            <div
              class="swiper-theme"
              data-swiper-options="{
                                    'spaceBetween': 20,
                                    'slidesPerView': 2,
                                    'breakpoints': {
                                        '576': {
                                            'slidesPerView': 3
                                        },
                                        '768': {
                                            'slidesPerView': 4
                                        },
                                        '992': {
                                            'slidesPerView': 3
                                        }
                                    }
                                }"
            >
              <div class="row cols-lg-3 cols-md-4 cols-sm-3 cols-2">
                <div class="swiper-slide product">
                  <figure class="product-media">
                    <a href="product-default.html">
                      <img
                        src="assets/images/products/default/1-1.jpg"
                        alt="Product"
                        width="300"
                        height="338"
                      />
                      <img
                        src="assets/images/products/default/1-2.jpg"
                        alt="Product"
                        width="300"
                        height="338"
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
                        class="btn-product-icon btn-compare w-icon-compare"
                        title="Add to Compare"
                      ></a>
                    </div>
                    <div class="product-action">
                      <a
                        href="#"
                        class="btn-product btn-quickview"
                        title="Quick View"
                        >Quick View</a
                      >
                    </div>
                  </figure>
                  <div class="product-details">
                    <div class="product-cat">
                      <a href="shop-banner-sidebar.html">Accessories</a>
                    </div>
                    <h4 class="product-name">
                      <a href="product-default.html">Sticky Pencil</a>
                    </h4>
                    <div class="ratings-container">
                      <div class="ratings-full">
                        <span class="ratings" style="width: 100%"></span>
                        <span class="tooltiptext tooltip-top"></span>
                      </div>
                      <a href="product-default.html" class="rating-reviews"
                        >(3 reviews)</a
                      >
                    </div>
                    <div class="product-pa-wrapper">
                      <div class="product-price">$20.00</div>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide product">
                  <figure class="product-media">
                    <a href="product-default.html">
                      <img
                        src="assets/images/products/default/2.jpg"
                        alt="Product"
                        width="300"
                        height="338"
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
                        class="btn-product-icon btn-compare w-icon-compare"
                        title="Add to Compare"
                      ></a>
                    </div>
                    <div class="product-action">
                      <a
                        href="#"
                        class="btn-product btn-quickview"
                        title="Quick View"
                        >Quick View</a
                      >
                    </div>
                  </figure>
                  <div class="product-details">
                    <div class="product-cat">
                      <a href="shop-banner-sidebar.html">Electronics</a>
                    </div>
                    <h4 class="product-name">
                      <a href="product-default.html"
                        >Mini Multi-Functional Cooker</a
                      >
                    </h4>
                    <div class="ratings-container">
                      <div class="ratings-full">
                        <span class="ratings" style="width: 80%"></span>
                        <span class="tooltiptext tooltip-top"></span>
                      </div>
                      <a href="product-default.html" class="rating-reviews"
                        >(5 reviews)</a
                      >
                    </div>
                    <div class="product-pa-wrapper">
                      <div class="product-price">
                        <ins class="new-price">$480.00</ins
                        ><del class="old-price">$534.00</del>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide product">
                  <figure class="product-media">
                    <a href="product-default.html">
                      <img
                        src="assets/images/products/default/3.jpg"
                        alt="Product"
                        width="300"
                        height="338"
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
                        class="btn-product-icon btn-compare w-icon-compare"
                        title="Add to Compare"
                      ></a>
                    </div>
                    <div class="product-action">
                      <a
                        href="#"
                        class="btn-product btn-quickview"
                        title="Quick View"
                        >Quick View</a
                      >
                    </div>
                  </figure>
                  <div class="product-details">
                    <div class="product-cat">
                      <a href="shop-banner-sidebar.html">Sports</a>
                    </div>
                    <h4 class="product-name">
                      <a href="product-default.html">Skate Pan</a>
                    </h4>
                    <div class="ratings-container">
                      <div class="ratings-full">
                        <span class="ratings" style="width: 100%"></span>
                        <span class="tooltiptext tooltip-top"></span>
                      </div>
                      <a href="product-default.html" class="rating-reviews"
                        >(3 reviews)</a
                      >
                    </div>
                    <div class="product-pa-wrapper">
                      <div class="product-price">
                        <ins class="new-price">$278.00</ins
                        ><del class="old-price">$310.00</del>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide product">
                  <figure class="product-media">
                    <a href="product-default.html">
                      <img
                        src="assets/images/products/default/4-1.jpg"
                        alt="Product"
                        width="300"
                        height="338"
                      />
                      <img
                        src="assets/images/products/default/4-2.jpg"
                        alt="Product"
                        width="300"
                        height="338"
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
                        class="btn-product-icon btn-compare w-icon-compare"
                        title="Add to Compare"
                      ></a>
                    </div>
                    <div class="product-action">
                      <a
                        href="#"
                        class="btn-product btn-quickview"
                        title="Quick View"
                        >Quick View</a
                      >
                    </div>
                  </figure>
                  <div class="product-details">
                    <div class="product-cat">
                      <a href="shop-banner-sidebar.html">Accessories</a>
                    </div>
                    <h4 class="product-name">
                      <a href="product-default.html">Clip Attachment</a>
                    </h4>
                    <div class="ratings-container">
                      <div class="ratings-full">
                        <span class="ratings" style="width: 100%"></span>
                        <span class="tooltiptext tooltip-top"></span>
                      </div>
                      <a href="product-default.html" class="rating-reviews"
                        >(5 reviews)</a
                      >
                    </div>
                    <div class="product-pa-wrapper">
                      <div class="product-price">$40.00</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <section class="related-product-section">
            <div class="title-link-wrapper mb-4">
              <h4 class="title">Related Products</h4>
              <a
                href="#"
                class="btn btn-dark btn-link btn-slide-right btn-icon-right"
                >More Products<i class="w-icon-long-arrow-right"></i
              ></a>
            </div>
            <div
              class="swiper-theme"
              data-swiper-options="{
                                    'spaceBetween': 20,
                                    'slidesPerView': 2,
                                    'breakpoints': {
                                        '576': {
                                            'slidesPerView': 3
                                        },
                                        '768': {
                                            'slidesPerView': 4
                                        },
                                        '992': {
                                            'slidesPerView': 3
                                        }
                                    }
                                }"
            >
              <div class="row cols-lg-3 cols-md-4 cols-sm-3 cols-2">
                <div class="swiper-slide product">
                  <figure class="product-media">
                    <a href="product-default.html">
                      <img
                        src="assets/images/products/default/5.jpg"
                        alt="Product"
                        width="300"
                        height="338"
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
                        class="btn-product-icon btn-compare w-icon-compare"
                        title="Add to Compare"
                      ></a>
                    </div>
                    <div class="product-action">
                      <a
                        href="#"
                        class="btn-product btn-quickview"
                        title="Quick View"
                        >Quick View</a
                      >
                    </div>
                  </figure>
                  <div class="product-details">
                    <h4 class="product-name">
                      <a href="product-default.html">Drone</a>
                    </h4>
                    <div class="ratings-container">
                      <div class="ratings-full">
                        <span class="ratings" style="width: 100%"></span>
                        <span class="tooltiptext tooltip-top"></span>
                      </div>
                      <a href="product-default.html" class="rating-reviews"
                        >(3 reviews)</a
                      >
                    </div>
                    <div class="product-pa-wrapper">
                      <div class="product-price">$632.00</div>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide product">
                  <figure class="product-media">
                    <a href="product-default.html">
                      <img
                        src="assets/images/products/default/6.jpg"
                        alt="Product"
                        width="300"
                        height="338"
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
                        class="btn-product-icon btn-compare w-icon-compare"
                        title="Add to Compare"
                      ></a>
                    </div>
                    <div class="product-action">
                      <a
                        href="#"
                        class="btn-product btn-quickview"
                        title="Quick View"
                        >Quick View</a
                      >
                    </div>
                  </figure>
                  <div class="product-details">
                    <h4 class="product-name">
                      <a href="product-default.html">Official Camera</a>
                    </h4>
                    <div class="ratings-container">
                      <div class="ratings-full">
                        <span class="ratings" style="width: 100%"></span>
                        <span class="tooltiptext tooltip-top"></span>
                      </div>
                      <a href="product-default.html" class="rating-reviews"
                        >(3 reviews)</a
                      >
                    </div>
                    <div class="product-pa-wrapper">
                      <div class="product-price">
                        <ins class="new-price">$263.00</ins
                        ><del class="old-price">$300.00</del>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide product">
                  <figure class="product-media">
                    <a href="product-default.html">
                      <img
                        src="assets/images/products/default/7-1.jpg"
                        alt="Product"
                        width="300"
                        height="338"
                      />
                      <img
                        src="assets/images/products/default/7-2.jpg"
                        alt="Product"
                        width="300"
                        height="338"
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
                        class="btn-product-icon btn-compare w-icon-compare"
                        title="Add to Compare"
                      ></a>
                    </div>
                    <div class="product-action">
                      <a
                        href="#"
                        class="btn-product btn-quickview"
                        title="Quick View"
                        >Quick View</a
                      >
                    </div>
                  </figure>
                  <div class="product-details">
                    <h4 class="product-name">
                      <a href="product-default.html">Phone Charge Pad</a>
                    </h4>
                    <div class="ratings-container">
                      <div class="ratings-full">
                        <span class="ratings" style="width: 80%"></span>
                        <span class="tooltiptext tooltip-top"></span>
                      </div>
                      <a href="product-default.html" class="rating-reviews"
                        >(8 reviews)</a
                      >
                    </div>
                    <div class="product-pa-wrapper">
                      <div class="product-price">$23.00</div>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide product">
                  <figure class="product-media">
                    <a href="product-default.html">
                      <img
                        src="assets/images/products/default/8.jpg"
                        alt="Product"
                        width="300"
                        height="338"
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
                        class="btn-product-icon btn-compare w-icon-compare"
                        title="Add to Compare"
                      ></a>
                    </div>
                    <div class="product-action">
                      <a
                        href="#"
                        class="btn-product btn-quickview"
                        title="Quick View"
                        >Quick View</a
                      >
                    </div>
                  </figure>
                  <div class="product-details">
                    <h4 class="product-name">
                      <a href="product-default.html">Fashionalble Pencil</a>
                    </h4>
                    <div class="ratings-container">
                      <div class="ratings-full">
                        <span class="ratings" style="width: 100%"></span>
                        <span class="tooltiptext tooltip-top"></span>
                      </div>
                      <a href="product-default.html" class="rating-reviews"
                        >(9 reviews)</a
                      >
                    </div>
                    <div class="product-pa-wrapper">
                      <div class="product-price">$50.00</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
        <!-- End of Main Content -->

        <!-- Start of Sidebar -->
        <ProductAside />
        <!-- End of Sidebar -->
      </div>
    </div>
  </div>
  <!-- End of Page Content -->
</template>
<script setup>
import { Swiper, SwiperSlide } from 'swiper/vue'
import { Navigation, Autoplay } from 'swiper/modules'
import { MoreInfomation, ProductAside } from '~/components'
import 'swiper/css'

const modules = [Navigation, Autoplay]

const visibleRef = ref(false)
const indexRef = ref(0)
const images = [
  '/_nuxt/assets/images/products/extended/1-800x900.jpg',
  '/_nuxt/assets/images/products/extended/2-800x900.jpg',
  '/_nuxt/assets/images/products/extended/3-800x900.jpg',
  '/_nuxt/assets/images/products/extended/4-800x900.jpg',
]
const showImg = (index) => {
  indexRef.value = index
  visibleRef.value = true
}
const onHide = () => (visibleRef.value = false)
</script>
