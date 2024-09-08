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
                  <li class="has-submenu">
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
                  <li class="has-submenu">
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
