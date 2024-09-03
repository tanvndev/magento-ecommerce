<template>
  <div class="tab tab-nav-boxed tab-nav-underline product-tabs">
    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item" v-for="tab in tabs" :key="tab.name">
        <a
          href="#"
          class="nav-link"
          :class="{ active: tab.name === activeTab }"
          @click.prevent="selectTab(tab.name)"
        >
          {{ tab.label }}
        </a>
      </li>
    </ul>
    <div class="tab-content">
      <div
        id="product-tab-description"
        class="tab-pane"
        :class="{ active: activeTab == 'description' }"
        v-show="activeTab == 'description'"
      >
        <h4 class="title tab-pane-title font-weight-bold mb-2">Detail</h4>
        <p class="mb-6">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
          eiusmod tempor incididunt ut labore et dolore magna aliqua. Venenatis
          tellus in metus vulputate eu scelerisque felis. Vel pretium lectus
          quam id leo in vitae turpis massa. Nunc id cursus metus aliquam.
          Libero id faucibus nisl tincidunt eget. Aliquam id diam maecenas
          ultricies mi eget mauris.
        </p>
        <div class="row align-items-center mb-4">
          <div class="col-md-6 mb-4">
            <div class="banner banner-video product-video br-xs">
              <figure class="banner-media">
                <a href="#">
                  <img
                    src="assets/images/products/video-banner-610x300.jpg"
                    alt="banner"
                    width="610"
                    height="300"
                    style="background-color: #bebebe"
                  />
                </a>
                <a
                  class="btn-play-video btn-iframe"
                  href="assets/video/memory-of-a-woman.mp4"
                ></a>
              </figure>
            </div>
          </div>
          <div class="col-md-6 mb-4">
            <h4 class="title tab-pane-title font-weight-bold mb-2">Features</h4>
            <ul class="list-style-none list-type-check">
              <li>
                Nunc nec porttitor turpis. In eu risus enim. In vitae mollis
                elit.
              </li>
              <li>Vivamus finibus vel mauris ut vehicula.</li>
              <li>
                Nullam a magna porttitor, dictum risus nec, faucibus sapien.
              </li>
              <li>
                Ultrices eros in cursus turpis massa tincidunt ante in nibh
                mauris.
              </li>
              <li>
                Cras ornare arcu dui vivamus arcu felis bibendum ut tristique.
              </li>
              <li>Pulvinar elementum integer enim neque volutpat.</li>
            </ul>
          </div>
        </div>
        <div class="row align-items-center mb-4">
          <div class="col-md-6 mb-4">
            <h4 class="title tab-pane-title font-weight-bold mb-2">
              Product Education
            </h4>
            <p class="mb-4">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
              eiusmod tempor incididunt ut labore et dolore magna aliqua.
            </p>
            <p>
              Venenatis tellus in metus vulputate eu scelerisque felis. Vel
              pretium lectus quam id leo in vitae turpis massa. Nunc id cursus
              metus aliquam. Libero id faucibus nisl tincidunt eget.
            </p>
          </div>
          <div class="col-md-6 mb-4">
            <figure>
              <img
                src="assets/images/products/banner-1.jpg"
                alt="Banner"
                width="455"
                height="230"
                style="background-color: #e6e6e6"
                class="w-100"
              />
            </figure>
          </div>
        </div>
        <div class="banner hotspot-banner mb-4">
          <figure>
            <img
              src="assets/images/products/banner-2.jpg"
              alt="Banner"
              width="930"
              height="450"
            />
          </figure>
          <div class="hotspot-product hotspot-product-1 hotspot-right">
            <a href="#" class="btn-hotspot btn-quickview"
              ><i class="fas fa-circle"></i
            ></a>
            <div class="product text-center">
              <figure class="product-media">
                <a href="product-default.html">
                  <img
                    src="assets/images/products/extended/1.jpg"
                    alt="Product"
                    width="180"
                    height="203"
                  />
                </a>
                <div class="product-action-vertical">
                  <a
                    href="#"
                    class="btn-product-icon btn-cart"
                    title="Add To Cart"
                  >
                    <i class="w-icon-cart"></i
                  ></a>
                </div>
              </figure>
              <div class="product-details">
                <h4 class="product-name">
                  <a href="product-default.html">Alarm Clock With Lamp</a>
                </h4>
                <div class="product-price">
                  <ins class="new-price">$30.00</ins
                  ><del class="old-price">$60.00</del>
                </div>
              </div>
            </div>
          </div>
          <div class="hotspot-product hotspot-product-2 hotspot-top">
            <a href="#" class="btn-hotspot btn-quickview"
              ><i class="fas fa-circle"></i
            ></a>
            <div class="product text-center">
              <figure class="product-media">
                <a href="product-default.html">
                  <img
                    src="assets/images/products/extended/2.jpg"
                    alt="Product"
                    width="180"
                    height="203"
                  />
                </a>
                <div class="product-action-vertical">
                  <a
                    href="#"
                    class="btn-product-icon btn-cart"
                    title="Add To Cart"
                  >
                    <i class="w-icon-cart"></i
                  ></a>
                </div>
              </figure>
              <div class="product-details">
                <h4 class="product-name">
                  <a href="product-default.html">Table-tennis Shoes</a>
                </h4>
                <div class="product-price">
                  <ins class="new-price">$65.00</ins>
                </div>
              </div>
            </div>
          </div>
          <div class="hotspot-product hotspot-product-3 hotspot-left">
            <a href="#" class="btn-hotspot btn-quickview"
              ><i class="fas fa-circle"></i
            ></a>
            <div class="product text-center">
              <figure class="product-media">
                <a href="product-default.html">
                  <img
                    src="assets/images/products/extended/3.jpg"
                    alt="Product"
                    width="180"
                    height="203"
                  />
                </a>
                <div class="product-action-vertical">
                  <a
                    href="#"
                    class="btn-product-icon btn-cart"
                    title="Add To Cart"
                  >
                    <i class="w-icon-cart"></i
                  ></a>
                </div>
              </figure>
              <div class="product-details">
                <h4 class="product-name">
                  <a href="product-default.html">Clean Cotten T-shirt</a>
                </h4>
                <div class="product-price">
                  <ins class="new-price">$45.00</ins>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div
        id="product-tab-specifications"
        class="tab-pane"
        :class="{ active: activeTab == 'specifications' }"
        v-show="activeTab == 'specifications'"
      >
        <div class="row mb-3">
          <div class="col-md-6 mb-4">
            <figure class="vendor-banner br-sm">
              <img
                src="assets/images/products/vendor-banner.jpg"
                alt="Vendor Banner"
                width="610"
                height="295"
                style="background-color: #353b55"
              />
            </figure>
          </div>
          <div class="col-md-6 pl-2 pl-md-6 mb-4">
            <div class="vendor-user">
              <figure class="vendor-logo mr-4">
                <a href="#">
                  <img
                    src="assets/images/products/vendor-logo.jpg"
                    alt="Vendor Logo"
                    width="80"
                    height="80"
                  />
                </a>
              </figure>
              <div>
                <div class="vendor-name"><a href="#">Jone Doe</a></div>
                <div class="ratings-container">
                  <div class="ratings-full">
                    <span class="ratings" style="width: 90%"></span>
                    <span class="tooltiptext tooltip-top"></span>
                  </div>
                  <a href="#" class="rating-reviews">(32 Reviews)</a>
                </div>
              </div>
            </div>
            <ul class="vendor-info list-style-none">
              <li class="store-name">
                <label>Store Name:</label>
                <span class="detail">OAIO Store</span>
              </li>
              <li class="store-address">
                <label>Address:</label>
                <span class="detail"
                  >Steven Street, El Carjon, CA 92020, United States (US)</span
                >
              </li>
              <li class="store-phone">
                <label>Phone:</label>
                <a href="#tel:">1234567890</a>
              </li>
            </ul>
            <a
              href="vendor-dokan-store.html"
              class="btn btn-dark btn-link btn-underline btn-icon-right"
              >Visit Store<i class="w-icon-long-arrow-right"></i
            ></a>
          </div>
        </div>
        <p class="mb-5">
          <strong class="text-dark">L</strong>orem ipsum dolor sit amet,
          consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
          labore et dolore magna aliqua. Venenatis tellus in metus vulputate eu
          scelerisque felis. Vel pretium lectus quam id leo in vitae turpis
          massa. Nunc id cursus metus aliquam. Libero id faucibus nisl tincidunt
          eget. Aliquam id diam maecenas ultricies mi eget mauris. Volutpat ac
          tincidunt vitae semper quis lectus. Vestibulum mattis ullamcorper
          velit sed. A arcu cursus vitae congue mauris.
        </p>
        <p class="mb-2">
          <strong class="text-dark">A</strong> arcu cursus vitae congue mauris.
          Sagittis id consectetur purus ut. Tellus rutrum tellus pellentesque eu
          tincidunt tortor aliquam nulla. Diam in arcu cursus euismod quis. Eget
          sit amet tellus cras adipiscing enim eu. In fermentum et sollicitudin
          ac orci phasellus. A condimentum vitae sapien pellentesque habitant
          morbi tristique senectus et. In dictum non consectetur a erat. Nunc
          scelerisque viverra mauris in aliquam sem fringilla.
        </p>
      </div>
      <div
        id="product-tab-reviews"
        class="tab-pane"
        :class="{ active: activeTab == 'reviews' }"
        v-show="activeTab == 'reviews'"
      >
        <div class="row mb-4">
          <div class="col-xl-4 col-lg-5 mb-4">
            <div class="ratings-wrapper">
              <div class="avg-rating-container">
                <h4 class="avg-mark font-weight-bolder ls-50">3.3</h4>
                <div class="avg-rating">
                  <p class="text-dark mb-1">Average Rating</p>
                  <div class="ratings-container">
                    <div class="ratings-full">
                      <span class="ratings" style="width: 60%"></span>
                      <span class="tooltiptext tooltip-top"></span>
                    </div>
                    <a href="#" class="rating-reviews">(3 Reviews)</a>
                  </div>
                </div>
              </div>
              <div
                class="ratings-value d-flex align-items-center text-dark ls-25"
              >
                <span class="text-dark font-weight-bold">66.7%</span
                >Recommended<span class="count">(2 of 3)</span>
              </div>
              <div class="ratings-list">
                <div class="ratings-container">
                  <div class="ratings-full">
                    <span class="ratings" style="width: 100%"></span>
                    <span class="tooltiptext tooltip-top"></span>
                  </div>
                  <div class="progress-bar progress-bar-sm">
                    <span></span>
                  </div>
                  <div class="progress-value">
                    <mark>70%</mark>
                  </div>
                </div>
                <div class="ratings-container">
                  <div class="ratings-full">
                    <span class="ratings" style="width: 80%"></span>
                    <span class="tooltiptext tooltip-top"></span>
                  </div>
                  <div class="progress-bar progress-bar-sm">
                    <span></span>
                  </div>
                  <div class="progress-value">
                    <mark>30%</mark>
                  </div>
                </div>
                <div class="ratings-container">
                  <div class="ratings-full">
                    <span class="ratings" style="width: 60%"></span>
                    <span class="tooltiptext tooltip-top"></span>
                  </div>
                  <div class="progress-bar progress-bar-sm">
                    <span></span>
                  </div>
                  <div class="progress-value">
                    <mark>40%</mark>
                  </div>
                </div>
                <div class="ratings-container">
                  <div class="ratings-full">
                    <span class="ratings" style="width: 40%"></span>
                    <span class="tooltiptext tooltip-top"></span>
                  </div>
                  <div class="progress-bar progress-bar-sm">
                    <span></span>
                  </div>
                  <div class="progress-value">
                    <mark>0%</mark>
                  </div>
                </div>
                <div class="ratings-container">
                  <div class="ratings-full">
                    <span class="ratings" style="width: 20%"></span>
                    <span class="tooltiptext tooltip-top"></span>
                  </div>
                  <div class="progress-bar progress-bar-sm">
                    <span></span>
                  </div>
                  <div class="progress-value">
                    <mark>0%</mark>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-8 col-lg-7 mb-4">
            <div class="review-form-wrapper">
              <h3 class="title tab-pane-title font-weight-bold mb-1">
                Submit Your Review
              </h3>
              <p class="mb-3">
                Your email address will not be published. Required fields are
                marked *
              </p>
              <form action="#" method="POST" class="review-form">
                <div class="rating-form">
                  <label for="rating">Your Rating Of This Product :</label>
                  <span class="rating-stars">
                    <a class="star-1" href="#">1</a>
                    <a class="star-2" href="#">2</a>
                    <a class="star-3" href="#">3</a>
                    <a class="star-4" href="#">4</a>
                    <a class="star-5" href="#">5</a>
                  </span>
                  <select
                    name="rating"
                    id="rating"
                    required
                    style="display: none"
                  >
                    <option value="">Rate…</option>
                    <option value="5">Perfect</option>
                    <option value="4">Good</option>
                    <option value="3">Average</option>
                    <option value="2">Not that bad</option>
                    <option value="1">Very poor</option>
                  </select>
                </div>
                <textarea
                  cols="30"
                  rows="6"
                  placeholder="Write Your Review Here..."
                  class="form-control"
                  id="review"
                ></textarea>
                <div class="row gutter-md">
                  <div class="col-md-6">
                    <input
                      type="text"
                      class="form-control"
                      placeholder="Your Name"
                      id="author"
                    />
                  </div>
                  <div class="col-md-6">
                    <input
                      type="text"
                      class="form-control"
                      placeholder="Your Email"
                      id="email_1"
                    />
                  </div>
                </div>
                <div class="form-group">
                  <input
                    type="checkbox"
                    class="custom-checkbox"
                    id="save-checkbox"
                  />
                  <label for="save-checkbox"
                    >Save my name, email, and website in this browser for the
                    next time I comment.</label
                  >
                </div>
                <button type="submit" class="btn btn-dark">
                  Submit Review
                </button>
              </form>
            </div>
          </div>
        </div>

        <div class="tab tab-nav-boxed tab-nav-outline tab-nav-center">
          <div class="tab-content">
            <div class="tab-pane active" id="show-all">
              <ul class="comments list-style-none">
                <li class="comment" v-for="n in 4" :key="n">
                  <div class="comment-body">
                    <figure class="comment-avatar">
                      <img
                        src="assets/images/agents/1-100x100.png"
                        alt="Commenter Avatar"
                        width="90"
                        height="90"
                      />
                    </figure>
                    <div class="comment-content">
                      <h4 class="comment-author">
                        <a href="#">John Doe</a>
                        <span class="comment-date"
                          >March 22, 2021 at 1:54 pm</span
                        >
                      </h4>
                      <div class="ratings-container comment-rating">
                        <div class="ratings-full">
                          <span class="ratings" style="width: 60%"></span>
                          <span class="tooltiptext tooltip-top"></span>
                        </div>
                      </div>
                      <p>
                        pellentesque habitant morbi tristique senectus et. In
                        dictum non consectetur a erat. Nunc ultrices eros in
                        cursus turpis massa tincidunt ante in nibh mauris cursus
                        mattis. Cras ornare arcu dui vivamus arcu felis bibendum
                        ut tristique.
                      </p>
                      <div class="comment-action">
                        <a
                          href="#"
                          class="btn btn-secondary btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize"
                        >
                          <i class="far fa-thumbs-up"></i>Helpful (1)
                        </a>
                        <a
                          href="#"
                          class="btn btn-dark btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize"
                        >
                          <i class="far fa-thumbs-down"></i>Unhelpful (0)
                        </a>
                      </div>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'

const tabs = reactive([
  { name: 'description', label: 'Mô tả' },
  { name: 'specifications', label: 'Thông số kĩ thuật' },
  { name: 'reviews', label: 'Đánh giá' },
])

const activeTab = ref('reviews')

const selectTab = (tabName) => {
  activeTab.value = tabName
}
</script>
