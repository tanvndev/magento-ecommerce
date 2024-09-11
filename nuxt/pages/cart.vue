<template>
  <!-- Start of Main -->
  <main class="main cart">
    <!-- Start of Breadcrumb -->
    <nav class="breadcrumb-nav">
      <div class="container">
        <ul class="breadcrumb shop-breadcrumb bb-no">
          <li class="active">
            <NuxtLink to="cart">Giỏ hàng</NuxtLink>
          </li>
          <li>
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
    <div class="page-content">
      <div class="container">
        <div class="row gutter-lg mb-10">
          <div class="col-lg-8 pr-lg-4 mb-6">
            <table class="shop-table cart-table">
              <thead>
                <tr>
                  <th>
                    <v-checkbox style="font-size: 18px"></v-checkbox>
                  </th>
                  <th class="product-name"><span>Sản phẩm</span></th>
                  <th></th>
                  <th class="product-price"><span>Giá cả</span></th>
                  <th class="product-quantity"><span>Số lượng</span></th>
                  <th class="product-subtotal"><span>Tạm tính</span></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="cart in carts" :key="cart.id">
                  <td>
                    <v-checkbox style="font-size: 18px"></v-checkbox>
                  </td>
                  <td class="product-thumbnail">
                    <div class="p-relative">
                      <a href="product-default.html">
                        <figure>
                          <img
                            src="assets/images/shop/13.jpg"
                            alt="product"
                            width="300"
                            height="338"
                          />
                        </figure>
                      </a>
                      <button class="btn btn-close">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </td>
                  <td class="product-name">
                    <a href="product-default.html"> Smart Watch </a>
                  </td>
                  <td class="product-price">
                    <div class="product-price">
                      <ins class="new-price">{{
                        formatCurrency(cart.sale_price || cart.price)
                      }}</ins>
                      <del class="old-price" v-if="cart.sale_price">{{
                        formatCurrency(cart.price)
                      }}</del>
                    </div>
                  </td>
                  <td class="product-quantity">
                    <div class="input-group">
                      <input
                        class="quantity form-control"
                        type="number"
                        min="1"
                        max="100000"
                      />
                      <button class="quantity-plus w-icon-plus"></button>
                      <button class="quantity-minus w-icon-minus"></button>
                    </div>
                  </td>
                  <td class="product-subtotal">
                    <span class="amount">$60.00</span>
                  </td>
                </tr>
              </tbody>
            </table>

            <div class="cart-action mb-6">
              <a
                href="#"
                class="btn btn-dark btn-rounded btn-icon-left btn-shopping mr-auto"
                ><i class="w-icon-long-arrow-left"></i>Tiếp tục mua sắm</a
              >
              <button
                type="submit"
                class="btn btn-rounded btn-default btn-clear"
                name="clear_cart"
                value="Clear Cart"
              >
                Clear Cart
              </button>
            </div>
          </div>
          <div class="col-lg-4 sticky-sidebar-wrapper">
            <div class="sticky-sidebar">
              <div class="cart-summary mb-4">
                <h3 class="cart-title text-uppercase">Tổng số giỏ hàng</h3>
                <div
                  class="cart-subtotal d-flex align-items-center justify-content-between"
                >
                  <label class="ls-25">Tạm tính</label>
                  <span>$100.00</span>
                </div>

                <hr class="divider" />

                <ul class="shipping-methods mb-2">
                  <li>
                    <label class="shipping-title text-dark font-weight-bold"
                      >Shipping</label
                    >
                  </li>
                  <li>
                    <div class="custom-radio">
                      <input
                        type="radio"
                        id="free-shipping"
                        class="custom-control-input"
                        name="shipping"
                      />
                      <label
                        for="free-shipping"
                        class="custom-control-label color-dark"
                        >Free Shipping</label
                      >
                    </div>
                  </li>
                  <li>
                    <div class="custom-radio">
                      <input
                        type="radio"
                        id="local-pickup"
                        class="custom-control-input"
                        name="shipping"
                      />
                      <label
                        for="local-pickup"
                        class="custom-control-label color-dark"
                        >Local Pickup</label
                      >
                    </div>
                  </li>
                  <li>
                    <div class="custom-radio">
                      <input
                        type="radio"
                        id="flat-rate"
                        class="custom-control-input"
                        name="shipping"
                      />
                      <label
                        for="flat-rate"
                        class="custom-control-label color-dark"
                        >Flat rate: $5.00</label
                      >
                    </div>
                  </li>
                </ul>

                <hr class="divider mb-6" />
                <div
                  class="order-total d-flex justify-content-between align-items-center"
                >
                  <label>Total</label>
                  <span class="ls-50">$100.00</span>
                </div>
                <a
                  href="#"
                  class="btn btn-block btn-dark btn-icon-right btn-rounded btn-checkout"
                >
                  Proceed to checkout<i class="w-icon-long-arrow-right"></i
                ></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End of PageContent -->
  </main>
  <!-- End of Main -->
</template>

<script setup>
import { formatCurrency } from '#imports'

const { $axios } = useNuxtApp()

const carts = ref([])

const getCarts = async () => {
  const response = await $axios.get('/carts')
  carts.value = response.data
}

onMounted(() => {
  getCarts()
})
</script>
<style scoped></style>
