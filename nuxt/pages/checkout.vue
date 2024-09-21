<template>
  <!-- Start of Main -->
  <main class="main checkout">
    <!-- Start of Breadcrumb -->
    <nav class="breadcrumb-nav">
      <div class="container">
        <ul class="breadcrumb shop-breadcrumb bb-no">
          <li class="passed">
            <NuxtLink to="cart">Giỏ hàng</NuxtLink>
          </li>
          <li class="active">
            <NuxtLink to="checkout">Thanh toán</NuxtLink>
          </li>
          <li>
            <NuxtLink to="orderComplete">Hoàn tất đơn hàng</NuxtLink>
          </li>
        </ul>
      </div>
    </nav>
    <!-- End of Breadcrumb -->

    <!-- Start of PageContent -->
    <div class="page-content checkout-content-wrapper">
      <div class="container">
        <div class="coupon-toggle">
          Bạn có mã giảm giá?
          <a
            @click.prevent="showApplyVoucher = !showApplyVoucher"
            href="#"
            class="show-coupon font-weight-bold text-uppercase text-dark"
            >Nhập mã code</a
          >
        </div>
        <div class="coupon-content mb-4" v-show="showApplyVoucher">
          <p>
            Nếu bạn có mã giảm giá, vui lòng áp dụng bên dưới. Bạn có thể xem mã
            giảm giá
            <NuxtLink
              to="/voucher"
              target="_blank"
              title="Xem mã giảm giá tại đây"
              >tại đây</NuxtLink
            >
          </p>
          <div class="input-wrapper-inline">
            <input
              type="text"
              name="Mã giảm giá"
              class="form-control form-control-md mr-1 mb-2"
              placeholder="Mã giảm giá"
            />
            <button
              type="button"
              class="btn button btn-rounded btn-coupon mb-2"
            >
              Áp Dụng Mã
            </button>
          </div>
        </div>
        <form class="form checkout-form" action="#" method="post">
          <div class="row mb-9">
            <div class="col-lg-7 pr-lg-4 mb-4 main-content" ref="mainContent">
              <!-- Checkout address -->
              <CheckoutAddress />

              <!-- Shipping method -->
              <CheckoutShippingMethod />

              <!-- Checkout product -->
              <CheckoutProduct />

              <div class="form-group mt-3">
                <div class="col-md-12">
                  <v-textarea
                    hint="Lời nhắn về đơn hàng của bạn, ví dụ ghi chú đặc biệt về việc giao hàng"
                    clearable
                    row-height="20"
                    rows="2"
                    auto-grow
                    variant="outlined"
                    density="comfortable"
                    label="Lời nhắn"
                  ></v-textarea>
                </div>
              </div>
            </div>
            <div class="col-lg-5 mb-4">
              <div
                class="order-summary-wrapper sticky-sidebar"
                ref="secondaryContent"
                :style="sidebarStyle"
              >
                <CheckoutSidebar />
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!-- End of PageContent -->
  </main>
  <!-- End of Main -->
</template>
<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'

const showApplyVoucher = ref(false)
const sidebarStyle = ref({})
const mainContent = ref(null)
const secondaryContent = ref(null)
const stickyOffset = 20

const handleScroll = () => {
  const scrollY = window.scrollY
  const mainRect = mainContent.value?.getBoundingClientRect()
  const secondaryRect = secondaryContent.value?.getBoundingClientRect()

  if (mainRect < secondaryRect + 100) {
    return
  }

  const colRect = document
    .querySelector('.main-content')
    ?.getBoundingClientRect()

  if (scrollY > stickyOffset && colRect) {
    if (scrollY < colRect.bottom + window.scrollY) {
      const newBottom = Math.max(
        window.innerHeight - mainRect.bottom - stickyOffset,
        0
      )
      sidebarStyle.value = {
        position: 'fixed',
        bottom: `${newBottom + 20}px`,
        width: '505px',
        borderBottom: '1px solid rgb(238, 238, 238)',
      }
    } else {
      sidebarStyle.value = {}
    }
  } else {
    sidebarStyle.value = {}
  }
}

onMounted(async () => {
  window.addEventListener('scroll', handleScroll)
})

onBeforeUnmount(() => {
  window.removeEventListener('scroll', handleScroll)
})
</script>

<style scoped></style>
