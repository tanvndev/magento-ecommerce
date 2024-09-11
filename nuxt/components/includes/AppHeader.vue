<template>
  <!-- Start of Header -->
  <header class="header">
    <div class="header-top">
      <div class="container">
        <div class="header-left">
          <p class="welcome-msg">
            Chào mừng đến với Cửa hàng Wolmart hãy nhắn tin hoặc xóa nó!
          </p>
        </div>
        <div class="header-right">
          <!-- End of Dropdown Menu -->
          <span class="d-lg-show"></span>
          <NuxtLink to="contact" class="d-lg-show">Liên hệ</NuxtLink>
          <NuxtLink href="#" class="d-lg-show">Tài khoản</NuxtLink>
          <a href="#" class="d-lg-show login sign-in"
            ><i class="w-icon-account"></i>Đăng nhập</a
          >
          <span class="delimiter d-lg-show">/</span>
          <a href="#" class="ml-0 d-lg-show login register">Đăng ký</a>
        </div>
      </div>
    </div>
    <!-- End of Header Top -->

    <div class="header-main" ref="headerMain">
      <div class="header-middle">
        <div class="container">
          <div class="header-left mr-md-4">
            <a
              href="#"
              class="mobile-menu-toggle w-icon-hamburger"
              aria-label="menu-toggle"
            >
            </a>
            <NuxtLink to="/" class="logo ml-lg-0">
              <img
                src="assets/images/logo.png"
                alt="logo"
                width="144"
                height="45"
              />
            </NuxtLink>
            <form
              method="get"
              action="#"
              class="header-search hs-expanded hs-round d-none d-md-flex input-wrapper"
            >
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
                    >Gọi ngay</a
                  >
                  hoặc :
                </h4>
                <a href="tel:#" class="phone-number font-weight-bolder ls-50"
                  >0(800)123-456</a
                >
              </div>
            </div>

            <div class="dropdown cart-dropdown cart-offcanvas mr-0 mr-lg-2">
              <div class="cart-overlay"></div>
              <NuxtLink to="#" class="cart-toggle label-down link">
                <i class="w-icon-chat">
                  <span class="cart-count">2</span>
                </i>
                <span class="cart-label">Tin nhắn</span>
              </NuxtLink>
            </div>
            <div class="dropdown cart-dropdown cart-offcanvas mr-2 mr-lg-2">
              <div class="cart-overlay"></div>
              <NuxtLink to="wishlist" class="cart-toggle label-down link">
                <i class="w-icon-heart">
                  <span class="cart-count">2</span>
                </i>
                <span class="cart-label">Ưa thích</span>
              </NuxtLink>
            </div>
            <div class="dropdown cart-dropdown cart-offcanvas mr-0 mr-lg-2">
              <div class="cart-overlay"></div>
              <NuxtLink to="/cart" class="cart-toggle label-down link">
                <i class="w-icon-cart">
                  <span class="cart-count">2</span>
                </i>
                <span class="cart-label">Giỏ hàng</span>
              </NuxtLink>
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
              <nav class="main-nav">
                <ul class="menu-custom">
                  <MenuItem
                    v-for="productCatalogue in productCatalogues"
                    :key="productCatalogue.id"
                    :item="productCatalogue"
                  />
                </ul>
              </nav>
            </div>
            <div class="header-right">
              <a href="#" class="d-xl-show"
                ><i class="w-icon-map-marker mr-1"></i>Theo dõi đơn hàng</a
              >
              <a href="#"><i class="w-icon-sale"></i>Mã giảm giá </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import MenuItem from '../MenuItem.vue'

const { $axios } = useNuxtApp()
const headerMain = ref(null)
let lastScrollPosition = 0
const productCatalogues = ref([])

const handleScroll = () => {
  if (!headerMain.value) return

  const headerTop = document.querySelector('.header-top')
  const headerMainHeight = headerMain.value.offsetHeight
  const currentScrollPosition = window.pageYOffset
  const threshold = headerTop.offsetHeight + headerMainHeight

  const isFixed = currentScrollPosition > threshold
  headerMain.value.classList.toggle('is-fixed', isFixed)

  if (!isFixed) {
    headerMain.value.classList.remove(
      'is-fixed-transition-up',
      'is-fixed-transition-down'
    )
    lastScrollPosition = currentScrollPosition
    return
  }

  const isScrollingDown = currentScrollPosition > lastScrollPosition
  headerMain.value.classList.toggle('is-fixed-transition-down', isScrollingDown)
  headerMain.value.classList.toggle('is-fixed-transition-up', !isScrollingDown)

  lastScrollPosition = currentScrollPosition
}

const getProductCatalogues = async () => {
  const response = await $axios.get('/products/catalogues/list')
  productCatalogues.value = response.data.data.filter(
    (item) => item.parent_id === null
  )
}

onMounted(() => {
  getProductCatalogues()
  window.addEventListener('scroll', handleScroll)
})
onBeforeUnmount(() => window.removeEventListener('scroll', handleScroll))
</script>

<style scoped>
.menu-custom {
  display: flex;
  list-style: none;
  padding: 0;
  margin: 0;
}

.menu-custom > .menu-item {
  margin-right: 20px;
}

.menu-custom > .menu-item:last-child {
  margin-right: 0;
}

.header-top {
  position: relative;
  z-index: 1001;
}

.header-main {
  position: relative;
  z-index: 1000;
  background-color: #fff;
  transition: all 0.3s ease-in-out;
}

.header-main.is-fixed {
  position: fixed;
  left: 0;
  right: 0;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.header-main.is-fixed-transition-down {
  top: -100%;
  transition: top 0.3s ease-in-out;
}

.header-main.is-fixed-transition-up {
  top: 0;
  transition: top 0.3s ease-in-out;
}

body {
  padding-top: 0;
}
</style>
