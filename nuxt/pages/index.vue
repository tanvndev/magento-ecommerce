<template>
  <section class="intro-section">
    <div
      class="nav-inner pg-inner animation-slider pg-xxl-hide nav-xxl-show nav-hide"
    >
      <swiper
        :modules="[EffectFade, Autoplay]"
        effect="fade"
        :slides-per-view="1"
        :autoplay="true"
        :loop="true"
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

  <div class="container">
    <div class="icon-box-wrapper br-sm mt-6 mb-6">
      <div class="row cols-md-4 cols-sm-3 cols-1">
        <div class="swiper-slide icon-box icon-box-side icon-box-primary">
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
        <div class="swiper-slide icon-box icon-box-side icon-box-primary">
          <span class="icon-box-icon icon-payment">
            <i class="w-icon-bag"></i>
          </span>
          <div class="icon-box-content">
            <h4 class="icon-box-title font-weight-bold mb-1">Secure Payment</h4>
            <p class="text-default">We ensure secure payment</p>
          </div>
        </div>
        <div
          class="swiper-slide icon-box icon-box-side icon-box-primary icon-box-money"
        >
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
        <div
          class="swiper-slide icon-box icon-box-side icon-box-primary icon-box-chat"
        >
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
    <!-- End of Iocn Box Wrapper -->

    <div class="row category-banner-wrapper pt-6 pb-8">
      <div class="col-md-6 mb-4">
        <div class="banner banner-fixed br-xs">
          <figure>
            <img
              src="~/assets/images/demos/demo1/categories/1-1.jpg"
              alt="Category Banner"
              width="610"
              height="160"
              style="background-color: #ecedec"
            />
          </figure>
          <div class="banner-content y-50 mt-0">
            <h5 class="banner-subtitle font-weight-normal text-dark">
              Get up to
              <span
                class="text-secondary font-weight-bolder text-uppercase ls-25"
                >20% Off</span
              >
            </h5>
            <h3 class="banner-title text-uppercase">
              Sports Outfits<br /><span
                class="font-weight-normal text-capitalize"
                >Collection</span
              >
            </h3>
            <div class="banner-price-info font-weight-normal">
              Starting at
              <span class="text-secondary font-weight-bolder">$170.00</span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 mb-4">
        <div class="banner banner-fixed br-xs">
          <figure>
            <img
              src="~/assets/images/demos/demo1/categories/1-2.jpg"
              alt="Category Banner"
              width="610"
              height="160"
              style="background-color: #636363"
            />
          </figure>
          <div class="banner-content y-50 mt-0">
            <h5 class="banner-subtitle font-weight-normal text-capitalize">
              New Arrivals
            </h5>
            <h3 class="banner-title text-white text-uppercase">
              Accessories<br /><span class="font-weight-normal text-capitalize"
                >Collection</span
              >
            </h3>
            <div
              class="banner-price-info text-white font-weight-normal text-capitalize"
            >
              Only From
              <span class="text-secondary font-weight-bolder">$90.00</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- End of .category-section top-category -->
    <div class="row deals-wrapper mb-8">
      <div class="col-lg-9 mb-4">
        <div class="single-product h-100 br-sm">
          <h4 class="title-sm title-underline font-weight-bolder ls-normal">
            Deals Hot of The Day
          </h4>
          <div class="swiper">
            <div class="swiper-theme nav-top swiper-nav-lg">
              <div class="row cols-1 gutter-no">
                <div class="swiper-slide">
                  <div class="product product-single row">
                    <div class="col-md-6">
                      <div
                        class="product-gallery product-gallery-sticky product-gallery-vertical"
                      >
                        <div
                          class="product-single-swiper swiper-theme nav-inner"
                        >
                          <div class="row cols-1 gutter-no">
                            <div class="swiper-slide">
                              <figure class="product-image">
                                <img
                                  src="~/assets/images/demos/demo1/products/1-1-600x675.jpg"
                                  data-zoom-image="~/assets/images/demos/demo1/products/1-1-800x900.jpg"
                                  alt="Product Image"
                                  width="800"
                                  height="900"
                                />
                              </figure>
                            </div>
                            <div class="swiper-slide">
                              <figure class="product-image">
                                <img
                                  src="~/assets/images/demos/demo1/products/1-2-600x675.jpg"
                                  data-zoom-image="~/assets/images/demos/demo1/products/1-2-800x900.jpg"
                                  alt="Product Image"
                                  width="800"
                                  height="900"
                                />
                              </figure>
                            </div>
                            <div class="swiper-slide">
                              <figure class="product-image">
                                <img
                                  src="~/assets/images/demos/demo1/products/1-3-600x675.jpg"
                                  data-zoom-image="~/assets/images/demos/demo1/products/1-3-800x900.jpg"
                                  alt="Product Image"
                                  width="800"
                                  height="900"
                                />
                              </figure>
                            </div>
                            <div class="swiper-slide">
                              <figure class="product-image">
                                <img
                                  src="~/assets/images/demos/demo1/products/1-4-600x675.jpg"
                                  data-zoom-image="~/assets/images/demos/demo1/products/1-4-800x900.jpg"
                                  alt="Product Image"
                                  width="800"
                                  height="900"
                                />
                              </figure>
                            </div>
                          </div>
                          <button class="swiper-button-next"></button>
                          <button class="swiper-button-prev"></button>
                          <div class="product-label-group">
                            <label class="product-label label-discount"
                              >25% Off</label
                            >
                          </div>
                        </div>
                        <div
                          class="product-thumbs-wrap"
                          data-swiper-options="{
                                                            'direction': 'vertical',
                                                            'breakpoints': {
                                                                '0': {
                                                                    'direction': 'horizontal',
                                                                    'slidesPerView': 4
                                                                },
                                                                '992': {
                                                                    'direction': 'vertical',
                                                                    'slidesPerView': 'auto'
                                                                }
                                                            }
                                                        }"
                        >
                          <div
                            class="product-thumbs row cols-lg-1 cols-4 gutter-sm"
                          >
                            <div class="product-thumb swiper-slide">
                              <img
                                src="~/assets/images/demos/demo1/products/1-1-600x675.jpg"
                                alt="Product thumb"
                                width="60"
                                height="68"
                              />
                            </div>
                            <div class="product-thumb swiper-slide">
                              <img
                                src="~/assets/images/demos/demo1/products/1-2-600x675.jpg"
                                alt="Product thumb"
                                width="60"
                                height="68"
                              />
                            </div>
                            <div class="product-thumb swiper-slide">
                              <img
                                src="~/assets/images/demos/demo1/products/1-3-600x675.jpg"
                                alt="Product thumb"
                                width="60"
                                height="68"
                              />
                            </div>
                            <div class="product-thumb swiper-slide">
                              <img
                                src="~/assets/images/demos/demo1/products/1-4-600x675.jpg"
                                alt="Product thumb"
                                width="60"
                                height="68"
                              />
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="product-details scrollable">
                        <h2 class="product-title mb-1">
                          <a href="product-default.html"
                            >Coat Pool Comfort Jacket</a
                          >
                        </h2>

                        <hr class="product-divider" />

                        <div class="product-price">
                          <ins class="new-price ls-50">$150.00 - $180.00</ins>
                        </div>

                        <div class="product-countdown-container flex-wrap">
                          <label class="mr-2 text-default"
                            >Offer Ends In:</label
                          >
                          <div
                            class="product-countdown countdown-compact"
                            data-until="2022, 12, 31"
                            data-compact="true"
                          >
                            629 days, 11: 59: 52
                          </div>
                        </div>

                        <div class="ratings-container">
                          <div class="ratings-full">
                            <span class="ratings" style="width: 80%"></span>
                            <span class="tooltiptext tooltip-top"></span>
                          </div>
                          <a href="#" class="rating-reviews">(3 Reviews)</a>
                        </div>

                        <div
                          class="product-form product-variation-form product-size-swatch mb-3"
                        >
                          <label class="mb-1">Size:</label>
                          <div
                            class="flex-wrap d-flex align-items-center product-variations"
                          >
                            <a href="#" class="size">Extra Large</a>
                            <a href="#" class="size">Large</a>
                            <a href="#" class="size">Medium</a>
                            <a href="#" class="size">Small</a>
                          </div>
                          <a href="#" class="product-variation-clean"
                            >Clean All</a
                          >
                        </div>

                        <div class="product-variation-price">
                          <span></span>
                        </div>

                        <div class="product-form pt-4">
                          <div class="product-qty-form mb-2 mr-2">
                            <div class="input-group">
                              <input
                                class="quantity form-control"
                                type="number"
                                min="1"
                                max="10000000"
                              />
                              <button
                                class="quantity-plus w-icon-plus"
                              ></button>
                              <button
                                class="quantity-minus w-icon-minus"
                              ></button>
                            </div>
                          </div>
                          <button class="btn btn-primary btn-cart">
                            <i class="w-icon-cart"></i>
                            <span>Add to Cart</span>
                          </button>
                        </div>

                        <div class="social-links-wrapper mt-1">
                          <div class="social-links">
                            <div
                              class="social-icons social-no-color border-thin"
                            >
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
                            ></a>
                            <a
                              href="#"
                              class="btn-product-icon btn-compare btn-icon-left w-icon-compare"
                            ></a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="product product-single row">
                    <div class="col-md-6">
                      <div
                        class="product-gallery product-gallery-sticky product-gallery-vertical"
                      >
                        <div
                          class="product-single-swiper swiper-theme nav-inner"
                        >
                          <div class="row cols-1 gutter-no">
                            <div class="swiper-slide">
                              <figure class="product-image">
                                <img
                                  src="~/assets/images/demos/demo1/products/2-1-600x675.jpg"
                                  data-zoom-image="~/assets/images/demos/demo1/products/2-1-800x900.jpg"
                                  alt="Product Image"
                                  width="800"
                                  height="900"
                                />
                              </figure>
                            </div>
                            <div class="swiper-slide">
                              <figure class="product-image">
                                <img
                                  src="~/assets/images/demos/demo1/products/2-2-600x675.jpg"
                                  data-zoom-image="~/assets/images/demos/demo1/products/2-2-800x900.jpg"
                                  alt="Product Image"
                                  width="800"
                                  height="900"
                                />
                              </figure>
                            </div>
                            <div class="swiper-slide">
                              <figure class="product-image">
                                <img
                                  src="~/assets/images/demos/demo1/products/2-3-600x675.jpg"
                                  data-zoom-image="~/assets/images/demos/demo1/products/2-3-800x900.jpg"
                                  alt="Product Image"
                                  width="800"
                                  height="900"
                                />
                              </figure>
                            </div>
                            <div class="swiper-slide">
                              <figure class="product-image">
                                <img
                                  src="~/assets/images/demos/demo1/products/2-4-600x675.jpg"
                                  data-zoom-image="~/assets/images/demos/demo1/products/2-4-800x900.jpg"
                                  alt="Product Image"
                                  width="800"
                                  height="900"
                                />
                              </figure>
                            </div>
                          </div>
                          <button class="swiper-button-next"></button>
                          <button class="swiper-button-prev"></button>
                          <div class="product-label-group">
                            <label class="product-label label-discount"
                              >25% Off</label
                            >
                          </div>
                        </div>
                        <div class="product-thumbs-wrap">
                          <div
                            class="product-thumbs row cols-lg-1 cols-4 gutter-sm"
                          >
                            <div class="product-thumb swiper-slide">
                              <img
                                src="~/assets/images/demos/demo1/products/2-1-600x675.jpg"
                                alt="Product thumb"
                                width="60"
                                height="68"
                              />
                            </div>
                            <div class="product-thumb swiper-slide">
                              <img
                                src="~/assets/images/demos/demo1/products/2-2-600x675.jpg"
                                alt="Product thumb"
                                width="60"
                                height="68"
                              />
                            </div>
                            <div class="product-thumb swiper-slide">
                              <img
                                src="~/assets/images/demos/demo1/products/2-3-600x675.jpg"
                                alt="Product thumb"
                                width="60"
                                height="68"
                              />
                            </div>
                            <div class="product-thumb swiper-slide">
                              <img
                                src="~/assets/images/demos/demo1/products/2-4-600x675.jpg"
                                alt="Product thumb"
                                width="60"
                                height="68"
                              />
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="product-details scrollable">
                        <h2 class="product-title mb-1">
                          <a href="product-default.html"
                            >Coat Pool Comfort Jacket</a
                          >
                        </h2>

                        <hr class="product-divider" />

                        <div class="product-price">
                          <ins class="new-price ls-50">$150.00 - $180.00</ins>
                        </div>

                        <div class="product-countdown-container flex-wrap">
                          <label class="mr-2 text-default"
                            >Offer Ends In:</label
                          >
                          <div
                            class="product-countdown countdown-compact"
                            data-until="2022, 12, 31"
                            data-compact="true"
                          >
                            629 days, 11: 59: 52
                          </div>
                        </div>

                        <div class="ratings-container">
                          <div class="ratings-full">
                            <span class="ratings" style="width: 80%"></span>
                            <span class="tooltiptext tooltip-top"></span>
                          </div>
                          <a href="#" class="rating-reviews">(3 Reviews)</a>
                        </div>

                        <div
                          class="product-form product-variation-form product-size-swatch mb-3"
                        >
                          <label class="mb-1">Size:</label>
                          <div
                            class="flex-wrap d-flex align-items-center product-variations"
                          >
                            <a href="#" class="size">Extra Large</a>
                            <a href="#" class="size">Large</a>
                            <a href="#" class="size">Medium</a>
                            <a href="#" class="size">Small</a>
                          </div>
                          <a href="#" class="product-variation-clean"
                            >Clean All</a
                          >
                        </div>

                        <div class="product-variation-price">
                          <span></span>
                        </div>

                        <div class="product-form pt-4">
                          <div class="product-qty-form mb-2 mr-2">
                            <div class="input-group">
                              <input
                                class="quantity form-control"
                                type="number"
                                min="1"
                                max="10000000"
                              />
                              <button
                                class="quantity-plus w-icon-plus"
                              ></button>
                              <button
                                class="quantity-minus w-icon-minus"
                              ></button>
                            </div>
                          </div>
                          <button class="btn btn-primary btn-cart">
                            <i class="w-icon-cart"></i>
                            <span>Add to Cart</span>
                          </button>
                        </div>

                        <div class="social-links-wrapper mt-1">
                          <div class="social-links">
                            <div
                              class="social-icons social-no-color border-thin"
                            >
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
                            ></a>
                            <a
                              href="#"
                              class="btn-product-icon btn-compare btn-icon-left w-icon-compare"
                            ></a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <button class="swiper-button-prev"></button>
              <button class="swiper-button-next"></button>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 mb-4">
        <div class="widget widget-products widget-products-bordered h-100">
          <div class="widget-body br-sm h-100">
            <h4
              class="title-sm title-underline font-weight-bolder ls-normal mb-2"
            >
              Top 20 Best Seller
            </h4>
            <div class="swiper">
              <div class="swiper-theme nav-top">
                <div class="row cols-lg-1 cols-md-3">
                  <div class="swiper-slide product-widget-wrap">
                    <div class="product product-widget bb-no">
                      <figure class="product-media">
                        <a href="product-default.html">
                          <img
                            src="~/assets/images/demos/demo1/products/2-1.jpg"
                            alt="Product"
                            width="105"
                            height="118"
                          />
                        </a>
                      </figure>
                      <div class="product-details">
                        <h4 class="product-name">
                          <a href="product-default.html">Kitchen Cooker</a>
                        </h4>
                        <div class="ratings-container">
                          <div class="ratings-full">
                            <span class="ratings" style="width: 60%"></span>
                            <span class="tooltiptext tooltip-top"></span>
                          </div>
                        </div>
                        <div class="product-price">
                          <ins class="new-price">$150.60</ins>
                        </div>
                      </div>
                    </div>
                    <div class="product product-widget bb-no">
                      <figure class="product-media">
                        <a href="product-default.html">
                          <img
                            src="~/assets/images/demos/demo1/products/2-2.jpg"
                            alt="Product"
                            width="105"
                            height="118"
                          />
                        </a>
                      </figure>
                      <div class="product-details">
                        <h4 class="product-name">
                          <a href="product-default.html"
                            >Professional Pixel Camera</a
                          >
                        </h4>
                        <div class="ratings-container">
                          <div class="ratings-full">
                            <span class="ratings" style="width: 60%"></span>
                            <span class="tooltiptext tooltip-top"></span>
                          </div>
                        </div>
                        <div class="product-price">
                          <ins class="new-price">$215.68</ins
                          ><del class="old-price">$230.45</del>
                        </div>
                      </div>
                    </div>
                    <div class="product product-widget">
                      <figure class="product-media">
                        <a href="product-default.html">
                          <img
                            src="~/assets/images/demos/demo1/products/2-3.jpg"
                            alt="Product"
                            width="105"
                            height="118"
                          />
                        </a>
                      </figure>
                      <div class="product-details">
                        <h4 class="product-name">
                          <a href="product-default.html">Sport Women’s Wear</a>
                        </h4>
                        <div class="ratings-container">
                          <div class="ratings-full">
                            <span class="ratings" style="width: 60%"></span>
                            <span class="tooltiptext tooltip-top"></span>
                          </div>
                        </div>
                        <div class="product-price">
                          <ins class="new-price">$220.20</ins
                          ><del class="old-price">$300.62</del>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide product-widget-wrap">
                    <div class="product product-widget bb-no">
                      <figure class="product-media">
                        <a href="product-default.html">
                          <img
                            src="~/assets/images/demos/demo1/products/2-4.jpg"
                            alt="Product"
                            width="105"
                            height="118"
                          />
                        </a>
                      </figure>
                      <div class="product-details">
                        <h4 class="product-name">
                          <a href="product-default.html">Latest Speaker</a>
                        </h4>
                        <div class="ratings-container">
                          <div class="ratings-full">
                            <span class="ratings" style="width: 60%"></span>
                            <span class="tooltiptext tooltip-top"></span>
                          </div>
                        </div>
                        <div class="product-price">
                          <ins class="new-price">$250.68</ins>
                        </div>
                      </div>
                    </div>
                    <div class="product product-widget bb-no">
                      <figure class="product-media">
                        <a href="product-default.html">
                          <img
                            src="~/assets/images/demos/demo1/products/2-5.jpg"
                            alt="Product"
                            width="105"
                            height="118"
                          />
                        </a>
                      </figure>
                      <div class="product-details">
                        <h4 class="product-name">
                          <a href="product-default.html"
                            >Men's Black Wrist Watch</a
                          >
                        </h4>
                        <div class="ratings-container">
                          <div class="ratings-full">
                            <span class="ratings" style="width: 100%"></span>
                            <span class="tooltiptext tooltip-top"></span>
                          </div>
                        </div>
                        <div class="product-price">
                          <ins class="new-price">$135.60</ins
                          ><del class="old-price">$155.70</del>
                        </div>
                      </div>
                    </div>
                    <div class="product product-widget">
                      <figure class="product-media">
                        <a href="product-default.html">
                          <img
                            src="~/assets/images/demos/demo1/products/2-6.jpg"
                            alt="Product"
                            width="105"
                            height="118"
                          />
                        </a>
                      </figure>
                      <div class="product-details">
                        <h4 class="product-name">
                          <a href="product-default.html">Wash Machine</a>
                        </h4>
                        <div class="ratings-container">
                          <div class="ratings-full">
                            <span class="ratings" style="width: 100%"></span>
                            <span class="tooltiptext tooltip-top"></span>
                          </div>
                        </div>
                        <div class="product-price">
                          <ins class="new-price">$215.68</ins>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide product-widget-wrap">
                    <div class="product product-widget bb-no">
                      <figure class="product-media">
                        <a href="product-default.html">
                          <img
                            src="~/assets/images/demos/demo1/products/2-7.jpg"
                            alt="Product"
                            width="105"
                            height="118"
                          />
                        </a>
                      </figure>
                      <div class="product-details">
                        <h4 class="product-name">
                          <a href="product-default.html">Security Guard</a>
                        </h4>
                        <div class="ratings-container">
                          <div class="ratings-full">
                            <span class="ratings" style="width: 100%"></span>
                            <span class="tooltiptext tooltip-top"></span>
                          </div>
                        </div>
                        <div class="product-price">
                          <ins class="new-price">$320.00</ins>
                        </div>
                      </div>
                    </div>
                    <div class="product product-widget bb-no">
                      <figure class="product-media">
                        <a href="product-default.html">
                          <img
                            src="~/assets/images/demos/demo1/products/2-8.jpg"
                            alt="Product"
                            width="105"
                            height="118"
                          />
                        </a>
                      </figure>
                      <div class="product-details">
                        <h4 class="product-name">
                          <a href="product-default.html">Apple Super Notecom</a>
                        </h4>
                        <div class="ratings-container">
                          <div class="ratings-full">
                            <span class="ratings" style="width: 100%"></span>
                            <span class="tooltiptext tooltip-top"></span>
                          </div>
                        </div>
                        <div class="product-price">
                          <ins class="new-price">$243.30</ins
                          ><del class="old-price">$253.50</del>
                        </div>
                      </div>
                    </div>
                    <div class="product product-widget">
                      <figure class="product-media">
                        <a href="product-default.html">
                          <img
                            src="~/assets/images/demos/demo1/products/2-9.jpg"
                            alt="Product"
                            width="105"
                            height="118"
                          />
                        </a>
                      </figure>
                      <div class="product-details">
                        <h4 class="product-name">
                          <a href="product-default.html">HD Television</a>
                        </h4>
                        <div class="ratings-container">
                          <div class="ratings-full">
                            <span class="ratings" style="width: 60%"></span>
                            <span class="tooltiptext tooltip-top"></span>
                          </div>
                        </div>
                        <div class="product-price">
                          <ins class="new-price">$450.68</ins
                          ><del class="old-price">$500.00</del>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <button class="swiper-button-next"></button>
                <button class="swiper-button-prev"></button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End of Deals Wrapper -->
  </div>

  <!-- End of Category Banner Wrapper -->
  <section class="category-section top-category bg-grey pt-10 pb-10">
    <div class="container pb-2">
      <h2 class="title justify-content-center pt-1 ls-normal mb-5">
        Top Categories Of The Month
      </h2>
      <div class="swiper">
        <div class="swiper-container swiper-theme pg-show">
          <div class="swiper-wrapper row cols-lg-6 cols-md-5 cols-sm-3 cols-2">
            <div
              class="swiper-slide category category-classic category-absolute overlay-zoom br-xs"
            >
              <a href="shop-banner-sidebar.html" class="category-media">
                <img
                  src="assets/images/demos/demo1/categories/2-1.jpg"
                  alt="Category"
                  width="130"
                  height="130"
                />
              </a>
              <div class="category-content">
                <h4 class="category-name">Fashion</h4>
                <a
                  href="shop-banner-sidebar.html"
                  class="btn btn-primary btn-link btn-underline"
                  >Shop Now</a
                >
              </div>
            </div>
            <div
              class="swiper-slide category category-classic category-absolute overlay-zoom br-xs"
            >
              <a href="shop-banner-sidebar.html" class="category-media">
                <img
                  src="assets/images/demos/demo1/categories/2-2.jpg"
                  alt="Category"
                  width="130"
                  height="130"
                />
              </a>
              <div class="category-content">
                <h4 class="category-name">Furniture</h4>
                <a
                  href="shop-banner-sidebar.html"
                  class="btn btn-primary btn-link btn-underline"
                  >Shop Now</a
                >
              </div>
            </div>
            <div
              class="swiper-slide category category-classic category-absolute overlay-zoom br-xs"
            >
              <a href="shop-banner-sidebar.html" class="category-media">
                <img
                  src="assets/images/demos/demo1/categories/2-3.jpg"
                  alt="Category"
                  width="130"
                  height="130"
                />
              </a>
              <div class="category-content">
                <h4 class="category-name">Shoes</h4>
                <a
                  href="shop-banner-sidebar.html"
                  class="btn btn-primary btn-link btn-underline"
                  >Shop Now</a
                >
              </div>
            </div>
            <div
              class="swiper-slide category category-classic category-absolute overlay-zoom br-xs"
            >
              <a href="shop-banner-sidebar.html" class="category-media">
                <img
                  src="assets/images/demos/demo1/categories/2-4.jpg"
                  alt="Category"
                  width="130"
                  height="130"
                />
              </a>
              <div class="category-content">
                <h4 class="category-name">Sports</h4>
                <a
                  href="shop-banner-sidebar.html"
                  class="btn btn-primary btn-link btn-underline"
                  >Shop Now</a
                >
              </div>
            </div>
            <div
              class="swiper-slide category category-classic category-absolute overlay-zoom br-xs"
            >
              <a href="shop-banner-sidebar.html" class="category-media">
                <img
                  src="assets/images/demos/demo1/categories/2-5.jpg"
                  alt="Category"
                  width="130"
                  height="130"
                />
              </a>
              <div class="category-content">
                <h4 class="category-name">Games</h4>
                <a
                  href="shop-banner-sidebar.html"
                  class="btn btn-primary btn-link btn-underline"
                  >Shop Now</a
                >
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script setup>
import { EffectFade, Autoplay } from 'swiper/modules'
import { Swiper, SwiperSlide } from 'swiper/vue'
import 'swiper/css'
import 'swiper/css/effect-fade'
</script>
