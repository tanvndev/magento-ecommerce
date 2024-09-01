<template>
  <!-- Start of Header -->
  <header class="header">
    <div class="header-top">
      <div class="container">
        <div class="header-left">
          <p class="welcome-msg">
            Welcome to Wolmart Store message or remove it!
          </p>
        </div>
        <div class="header-right">
          <!-- End of Dropdown Menu -->
          <span class="d-lg-show"></span>
          <a href="blog.html" class="d-lg-show">Blog</a>
          <a href="contact-us.html" class="d-lg-show">Contact Us</a>
          <a href="my-account.html" class="d-lg-show">My Account</a>
          <a href="assets/ajax/login.html" class="d-lg-show login sign-in"
            ><i class="w-icon-account"></i>Sign In</a
          >
          <span class="delimiter d-lg-show">/</span>
          <a href="assets/ajax/login.html" class="ml-0 d-lg-show login register"
            >Register</a
          >
        </div>
      </div>
    </div>
    <!-- End of Header Top -->

    <div class="header-middle">
      <div class="container">
        <div class="header-left mr-md-4">
          <a
            href="#"
            class="mobile-menu-toggle w-icon-hamburger"
            aria-label="menu-toggle"
          >
          </a>
          <a href="demo1.html" class="logo ml-lg-0">
            <img
              src="assets/images/logo.png"
              alt="logo"
              width="144"
              height="45"
            />
          </a>
          <form
            method="get"
            action="#"
            class="header-search hs-expanded hs-round d-none d-md-flex input-wrapper"
          >
            <div class="select-box">
              <select id="category" name="category">
                <option value="">All Categories</option>
                <option value="4">Fashion</option>
                <option value="5">Furniture</option>
                <option value="6">Shoes</option>
                <option value="7">Sports</option>
                <option value="8">Games</option>
                <option value="9">Computers</option>
                <option value="10">Electronics</option>
                <option value="11">Kitchen</option>
                <option value="12">Clothing</option>
              </select>
            </div>
            <input
              type="text"
              class="form-control"
              name="search"
              id="search"
              placeholder="Search in..."
              required
            />
            <button class="btn btn-search" type="submit">
              <i class="w-icon-search"></i>
            </button>
          </form>
        </div>
        <div class="header-right ml-4">
          <div class="header-call d-xs-show d-lg-flex align-items-center">
            <a href="tel:#" class="w-icon-call"></a>
            <div class="call-info d-lg-show">
              <h4
                class="chat font-weight-normal font-size-md text-normal ls-normal text-light mb-0"
              >
                <a
                  href="https://portotheme.com/cdn-cgi/l/email-protection#b390"
                  class="text-capitalize"
                  >Live Chat</a
                >
                or :
              </h4>
              <a href="tel:#" class="phone-number font-weight-bolder ls-50"
                >0(800)123-456</a
              >
            </div>
          </div>
          <a class="wishlist label-down link d-xs-show" href="wishlist.html">
            <i class="w-icon-heart"></i>
            <span class="wishlist-label d-lg-show">Wishlist</span>
          </a>
          <a class="compare label-down link d-xs-show" href="compare.html">
            <i class="w-icon-compare"></i>
            <span class="compare-label d-lg-show">Compare</span>
          </a>
          <div class="dropdown cart-dropdown cart-offcanvas mr-0 mr-lg-2">
            <div class="cart-overlay"></div>
            <a href="#" class="cart-toggle label-down link">
              <i class="w-icon-cart">
                <span class="cart-count">2</span>
              </i>
              <span class="cart-label">Cart</span>
            </a>
          </div>
        </div>
      </div>
    </div>

    <div
      class="header-bottom sticky-content fix-top sticky-header has-dropdown"
    >
      <div class="container">
        <div class="inner-wrap">
          <div class="header-left">
            <div
              class="dropdown category-dropdown has-border"
              data-visible="true"
            >
              <a
                href="#"
                class="category-toggle text-dark"
                title="Browse Categories"
              >
                <i class="w-icon-category"></i>
                <span>Browse Categories</span>
              </a>

              <div class="dropdown-box">
                <ul class="menu vertical-menu category-menu">
                  <li>
                    <a href="shop-fullwidth-banner.html">
                      <i class="w-icon-tshirt2"></i>Fashion
                    </a>
                    <ul class="megamenu">
                      <li>
                        <h4 class="menu-title">Women</h4>
                        <hr class="divider" />
                        <ul>
                          <li>
                            <a href="shop-fullwidth-banner.html"
                              >New Arrivals</a
                            >
                          </li>
                          <li>
                            <a href="shop-fullwidth-banner.html"
                              >Best Sellers</a
                            >
                          </li>
                          <li>
                            <a href="shop-fullwidth-banner.html">Trending</a>
                          </li>
                          <li>
                            <a href="shop-fullwidth-banner.html">Clothing</a>
                          </li>
                          <li>
                            <a href="shop-fullwidth-banner.html">Shoes</a>
                          </li>
                          <li><a href="shop-fullwidth-banner.html">Bags</a></li>
                          <li>
                            <a href="shop-fullwidth-banner.html">Accessories</a>
                          </li>
                          <li>
                            <a href="shop-fullwidth-banner.html"
                              >Jewlery & Watches</a
                            >
                          </li>
                        </ul>
                      </li>
                      <li>
                        <h4 class="menu-title">Men</h4>
                        <hr class="divider" />
                        <ul>
                          <li>
                            <a href="shop-fullwidth-banner.html"
                              >New Arrivals</a
                            >
                          </li>
                          <li>
                            <a href="shop-fullwidth-banner.html"
                              >Best Sellers</a
                            >
                          </li>
                          <li>
                            <a href="shop-fullwidth-banner.html">Trending</a>
                          </li>
                          <li>
                            <a href="shop-fullwidth-banner.html">Clothing</a>
                          </li>
                          <li>
                            <a href="shop-fullwidth-banner.html">Shoes</a>
                          </li>
                          <li><a href="shop-fullwidth-banner.html">Bags</a></li>
                          <li>
                            <a href="shop-fullwidth-banner.html">Accessories</a>
                          </li>
                          <li>
                            <a href="shop-fullwidth-banner.html"
                              >Jewlery & Watches</a
                            >
                          </li>
                        </ul>
                      </li>
                      <li>
                        <div class="banner-fixed menu-banner menu-banner2">
                          <figure>
                            <img
                              src="assets/images/menu/banner-2.jpg"
                              alt="Menu Banner"
                              width="235"
                              height="347"
                            />
                          </figure>
                          <div class="banner-content">
                            <div class="banner-price-info mb-1 ls-normal">
                              Get up to
                              <strong class="text-primary text-uppercase"
                                >20%Off</strong
                              >
                            </div>
                            <h3 class="banner-title ls-normal">Hot Sales</h3>
                            <a
                              href="shop-banner-sidebar.html"
                              class="btn btn-dark btn-sm btn-link btn-slide-right btn-icon-right"
                            >
                              Shop Now<i class="w-icon-long-arrow-right"></i>
                            </a>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </li>
                  <li>
                    <a href="shop-fullwidth-banner.html">
                      <i class="w-icon-home"></i>Home & Garden
                    </a>
                    <ul class="megamenu">
                      <li>
                        <h4 class="menu-title">Bedroom</h4>
                        <hr class="divider" />
                        <ul>
                          <li>
                            <a href="shop-fullwidth-banner.html"
                              >Beds, Frames & Bases</a
                            >
                          </li>
                          <li>
                            <a href="shop-fullwidth-banner.html">Dressers</a>
                          </li>
                          <li>
                            <a href="shop-fullwidth-banner.html">Nightstands</a>
                          </li>
                          <li>
                            <a href="shop-fullwidth-banner.html"
                              >Kid's Beds & Headboards</a
                            >
                          </li>
                          <li>
                            <a href="shop-fullwidth-banner.html">Armoires</a>
                          </li>
                        </ul>

                        <h4 class="menu-title mt-1">Living Room</h4>
                        <hr class="divider" />
                        <ul>
                          <li>
                            <a href="shop-fullwidth-banner.html"
                              >Coffee Tables</a
                            >
                          </li>
                          <li>
                            <a href="shop-fullwidth-banner.html">Chairs</a>
                          </li>
                          <li>
                            <a href="shop-fullwidth-banner.html">Tables</a>
                          </li>
                          <li>
                            <a href="shop-fullwidth-banner.html"
                              >Futons & Sofa Beds</a
                            >
                          </li>
                          <li>
                            <a href="shop-fullwidth-banner.html"
                              >Cabinets & Chests</a
                            >
                          </li>
                        </ul>
                      </li>
                      <li>
                        <h4 class="menu-title">Office</h4>
                        <hr class="divider" />
                        <ul>
                          <li>
                            <a href="shop-fullwidth-banner.html"
                              >Office Chairs</a
                            >
                          </li>
                          <li>
                            <a href="shop-fullwidth-banner.html">Desks</a>
                          </li>
                          <li>
                            <a href="shop-fullwidth-banner.html">Bookcases</a>
                          </li>
                          <li>
                            <a href="shop-fullwidth-banner.html"
                              >File Cabinets</a
                            >
                          </li>
                          <li>
                            <a href="shop-fullwidth-banner.html"
                              >Breakroom Tables</a
                            >
                          </li>
                        </ul>

                        <h4 class="menu-title mt-1">Kitchen & Dining</h4>
                        <hr class="divider" />
                        <ul>
                          <li>
                            <a href="shop-fullwidth-banner.html">Dining Sets</a>
                          </li>
                          <li>
                            <a href="shop-fullwidth-banner.html"
                              >Kitchen Storage Cabinets</a
                            >
                          </li>
                          <li>
                            <a href="shop-fullwidth-banner.html"
                              >Bashers Racks</a
                            >
                          </li>
                          <li>
                            <a href="shop-fullwidth-banner.html"
                              >Dining Chairs</a
                            >
                          </li>
                          <li>
                            <a href="shop-fullwidth-banner.html"
                              >Dining Room Tables</a
                            >
                          </li>
                          <li>
                            <a href="shop-fullwidth-banner.html">Bar Stools</a>
                          </li>
                        </ul>
                      </li>
                      <li>
                        <div class="menu-banner banner-fixed menu-banner3">
                          <figure>
                            <img
                              src="assets/images/menu/banner-3.jpg"
                              alt="Menu Banner"
                              width="235"
                              height="461"
                            />
                          </figure>
                          <div class="banner-content">
                            <h4
                              class="banner-subtitle font-weight-normal text-white mb-1"
                            >
                              Restroom
                            </h4>
                            <h3
                              class="banner-title font-weight-bolder text-white ls-normal"
                            >
                              Furniture Sale
                            </h3>
                            <div
                              class="banner-price-info text-white font-weight-normal ls-25"
                            >
                              Up to
                              <span
                                class="text-secondary text-uppercase font-weight-bold"
                                >25% Off</span
                              >
                            </div>
                            <a
                              href="shop-banner-sidebar.html"
                              class="btn btn-white btn-link btn-sm btn-slide-right btn-icon-right"
                            >
                              Shop Now<i class="w-icon-long-arrow-right"></i>
                            </a>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </li>

                  <li>
                    <a href="shop-fullwidth-banner.html">
                      <i class="w-icon-ios"></i>Smart Phones
                    </a>
                  </li>
                  <li>
                    <a href="shop-fullwidth-banner.html">
                      <i class="w-icon-camera"></i>Cameras & Photo
                    </a>
                  </li>
                  <li>
                    <a href="shop-fullwidth-banner.html">
                      <i class="w-icon-ruby"></i>Accessories
                    </a>
                  </li>
                  <li>
                    <a
                      href="shop-banner-sidebar.html"
                      class="font-weight-bold text-primary text-uppercase ls-25"
                    >
                      View All Categories<i class="w-icon-angle-right"></i>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            <nav class="main-nav">
              <ul class="menu active-underline">
                <li class="active">
                  <a href="demo1.html">Home</a>
                </li>
                <li>
                  <a href="shop-banner-sidebar.html">Shop</a>

                  <!-- Start of Megamenu -->
                  <ul class="megamenu">
                    <li>
                      <h4 class="menu-title">Shop Pages</h4>
                      <ul>
                        <li>
                          <a href="shop-banner-sidebar.html"
                            >Banner With Sidebar</a
                          >
                        </li>
                        <li>
                          <a href="shop-boxed-banner.html">Boxed Banner</a>
                        </li>
                        <li>
                          <a href="shop-fullwidth-banner.html"
                            >Full Width Banner</a
                          >
                        </li>
                        <li>
                          <a href="shop-horizontal-filter.html"
                            >Horizontal Filter<span class="tip tip-hot"
                              >Hot</span
                            ></a
                          >
                        </li>
                        <li>
                          <a href="shop-off-canvas.html"
                            >Off Canvas Sidebar<span class="tip tip-new"
                              >New</span
                            ></a
                          >
                        </li>
                        <li>
                          <a href="shop-infinite-scroll.html"
                            >Infinite Ajax Scroll</a
                          >
                        </li>
                        <li>
                          <a href="shop-right-sidebar.html">Right Sidebar</a>
                        </li>
                        <li>
                          <a href="shop-both-sidebar.html">Both Sidebar</a>
                        </li>
                      </ul>
                    </li>
                    <li>
                      <h4 class="menu-title">Shop Layouts</h4>
                      <ul>
                        <li>
                          <a href="shop-grid-3cols.html">3 Columns Mode</a>
                        </li>
                        <li>
                          <a href="shop-grid-4cols.html">4 Columns Mode</a>
                        </li>
                        <li>
                          <a href="shop-grid-5cols.html">5 Columns Mode</a>
                        </li>
                        <li>
                          <a href="shop-grid-6cols.html">6 Columns Mode</a>
                        </li>
                        <li>
                          <a href="shop-grid-7cols.html">7 Columns Mode</a>
                        </li>
                        <li>
                          <a href="shop-grid-8cols.html">8 Columns Mode</a>
                        </li>
                        <li><a href="shop-list.html">List Mode</a></li>
                        <li>
                          <a href="shop-list-sidebar.html"
                            >List Mode With Sidebar</a
                          >
                        </li>
                      </ul>
                    </li>
                    <li>
                      <h4 class="menu-title">Product Pages</h4>
                      <ul>
                        <li>
                          <a href="product-variable.html">Variable Product</a>
                        </li>
                        <li>
                          <a href="product-featured.html"
                            >Featured &amp; Sale</a
                          >
                        </li>
                        <li>
                          <a href="product-accordion.html">Data In Accordion</a>
                        </li>
                        <li>
                          <a href="product-section.html">Data In Sections</a>
                        </li>
                        <li><a href="product-swatch.html">Image Swatch</a></li>
                        <li>
                          <a href="product-extended.html">Extended Info</a>
                        </li>
                        <li>
                          <a href="product-without-sidebar.html"
                            >Without Sidebar</a
                          >
                        </li>
                        <li>
                          <a href="product-video.html"
                            >360<sup>o</sup> &amp; Video<span
                              class="tip tip-new"
                              >New</span
                            ></a
                          >
                        </li>
                      </ul>
                    </li>
                    <li>
                      <h4 class="menu-title">Product Layouts</h4>
                      <ul>
                        <li>
                          <a href="product-default.html"
                            >Default<span class="tip tip-hot">Hot</span></a
                          >
                        </li>
                        <li>
                          <a href="product-vertical.html">Vertical Thumbs</a>
                        </li>
                        <li><a href="product-grid.html">Grid Images</a></li>
                        <li><a href="product-masonry.html">Masonry</a></li>
                        <li><a href="product-gallery.html">Gallery</a></li>
                        <li>
                          <a href="product-sticky-info.html">Sticky Info</a>
                        </li>
                        <li>
                          <a href="product-sticky-thumb.html">Sticky Thumbs</a>
                        </li>
                        <li>
                          <a href="product-sticky-both.html">Sticky Both</a>
                        </li>
                      </ul>
                    </li>
                  </ul>
                  <!-- End of Megamenu -->
                </li>
                <li>
                  <a href="vendor-dokan-store.html">Vendor</a>
                  <ul>
                    <li>
                      <a href="vendor-dokan-store-list.html">Store Listing</a>
                      <ul>
                        <li>
                          <a href="vendor-dokan-store-list.html"
                            >Store listing 1</a
                          >
                        </li>
                        <li>
                          <a href="vendor-wcfm-store-list.html"
                            >Store listing 2</a
                          >
                        </li>
                        <li>
                          <a href="vendor-wcmp-store-list.html"
                            >Store listing 3</a
                          >
                        </li>
                        <li>
                          <a href="vendor-wc-store-list.html"
                            >Store listing 4</a
                          >
                        </li>
                      </ul>
                    </li>
                    <li>
                      <a href="vendor-dokan-store.html">Vendor Store</a>
                      <ul>
                        <li>
                          <a href="vendor-dokan-store.html">Vendor Store 1</a>
                        </li>
                        <li>
                          <a href="vendor-wcfm-store-product-grid.html"
                            >Vendor Store 2</a
                          >
                        </li>
                        <li>
                          <a href="vendor-wcmp-store-product-grid.html"
                            >Vendor Store 3</a
                          >
                        </li>
                        <li>
                          <a href="vendor-wc-store-product-grid.html"
                            >Vendor Store 4</a
                          >
                        </li>
                      </ul>
                    </li>
                  </ul>
                </li>
                <li>
                  <a href="blog.html">Blog</a>
                  <ul>
                    <li><a href="blog.html">Classic</a></li>
                    <li><a href="blog-listing.html">Listing</a></li>
                    <li>
                      <a href="blog-grid-3cols.html">Grid</a>
                      <ul>
                        <li>
                          <a href="blog-grid-2cols.html">Grid 2 columns</a>
                        </li>
                        <li>
                          <a href="blog-grid-3cols.html">Grid 3 columns</a>
                        </li>
                        <li>
                          <a href="blog-grid-4cols.html">Grid 4 columns</a>
                        </li>
                        <li>
                          <a href="blog-grid-sidebar.html">Grid sidebar</a>
                        </li>
                      </ul>
                    </li>
                    <li>
                      <a href="blog-masonry-3cols.html">Masonry</a>
                      <ul>
                        <li>
                          <a href="blog-masonry-2cols.html"
                            >Masonry 2 columns</a
                          >
                        </li>
                        <li>
                          <a href="blog-masonry-3cols.html"
                            >Masonry 3 columns</a
                          >
                        </li>
                        <li>
                          <a href="blog-masonry-4cols.html"
                            >Masonry 4 columns</a
                          >
                        </li>
                        <li>
                          <a href="blog-masonry-sidebar.html"
                            >Masonry sidebar</a
                          >
                        </li>
                      </ul>
                    </li>
                    <li>
                      <a href="blog-mask-grid.html">Mask</a>
                      <ul>
                        <li>
                          <a href="blog-mask-grid.html">Blog mask grid</a>
                        </li>
                        <li>
                          <a href="blog-mask-masonry.html">Blog mask masonry</a>
                        </li>
                      </ul>
                    </li>
                    <li>
                      <a href="post-single.html">Single Post</a>
                    </li>
                  </ul>
                </li>
                <li>
                  <a href="about-us.html">Pages</a>
                  <ul>
                    <li><a href="about-us.html">About Us</a></li>
                    <li><a href="become-a-vendor.html">Become A Vendor</a></li>
                    <li><a href="contact-us.html">Contact Us</a></li>
                    <li><a href="faq.html">FAQs</a></li>
                    <li><a href="error-404.html">Error 404</a></li>
                    <li><a href="coming-soon.html">Coming Soon</a></li>
                    <li><a href="wishlist.html">Wishlist</a></li>
                    <li><a href="cart.html">Cart</a></li>
                    <li><a href="checkout.html">Checkout</a></li>
                    <li><a href="my-account.html">My Account</a></li>
                    <li><a href="compare.html">Compare</a></li>
                  </ul>
                </li>
                <li>
                  <a href="elements.html">Elements</a>
                  <ul>
                    <li><a href="element-accordions.html">Accordions</a></li>
                    <li>
                      <a href="element-alerts.html">Alert &amp; Notification</a>
                    </li>
                    <li><a href="element-blog-posts.html">Blog Posts</a></li>
                    <li><a href="element-buttons.html">Buttons</a></li>
                    <li><a href="element-cta.html">Call to Action</a></li>
                    <li><a href="element-icons.html">Icons</a></li>
                    <li><a href="element-icon-boxes.html">Icon Boxes</a></li>
                    <li><a href="element-instagrams.html">Instagrams</a></li>
                    <li>
                      <a href="element-categories.html">Product Category</a>
                    </li>
                    <li><a href="element-products.html">Products</a></li>
                    <li><a href="element-tabs.html">Tabs</a></li>
                    <li>
                      <a href="element-testimonials.html">Testimonials</a>
                    </li>
                    <li><a href="element-titles.html">Titles</a></li>
                    <li><a href="element-typography.html">Typography</a></li>

                    <li><a href="element-vendors.html">Vendors</a></li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
          <div class="header-right">
            <a href="#" class="d-xl-show"
              ><i class="w-icon-map-marker mr-1"></i>Track Order</a
            >
            <a href="#"><i class="w-icon-sale"></i>Daily Deals</a>
          </div>
        </div>
      </div>
    </div>
  </header>
</template>
