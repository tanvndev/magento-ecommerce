<template>
  <!-- Start of Main -->
  <main class="main cart">
    <!-- Start of Breadcrumb -->
    <nav class="breadcrumb-nav">
      <div class="container">
        <ul class="breadcrumb shop-breadcrumb bb-no">
          <li class="active">
            <NuxtLink to="/cart">Giỏ hàng</NuxtLink>
          </li>
          <li>
            <NuxtLink to="/checkout">Thanh toán</NuxtLink>
          </li>
          <li>
            <NuxtLink to="/orderComplete">Hoàn tất đơn hàng</NuxtLink>
          </li>
        </ul>
      </div>
    </nav>
    <!-- End of Breadcrumb -->

    <!-- Start of PageContent -->
    <div class="page-content">
      <div class="container">
        <div class="row gutter-lg mb-10">
          <div class="col-lg-12 pr-lg-12 mb-6 cart-wrapper">
            <table class="shop-table cart-table" v-if="carts.length > 0">
              <thead>
                <tr>
                  <th>
                    <v-checkbox
                      v-model="allChecked"
                      style="font-size: 18px"
                      @change="handleAllCheckboxChange()"
                    ></v-checkbox>
                  </th>
                  <th class="product-name"><span>Sản phẩm</span></th>
                  <th width="300"></th>
                  <th class="product-price"><span>Giá cả</span></th>
                  <th class="product-quantity"><span>Số lượng</span></th>
                  <th class="product-subtotal"><span>Tạm tính</span></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(cart, index) in carts" :key="cart.id">
                  <td>
                    <v-checkbox
                      v-model="checkedItems[index]"
                      :value="cart.cart_item_id"
                      @change="
                        handleCheckboxChange($event, cart.product_variant_id)
                      "
                      style="font-size: 18px"
                    ></v-checkbox>
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
                    <nuxtLink to="#"> {{ cart.name }} </nuxtLink>
                  </td>
                  <td class="text-right">
                    <div class="product-price">
                      <ins class="new-price">{{
                        formatCurrency(cart.sale_price || cart.price)
                      }}</ins>
                      <del class="old-price" v-if="cart.sale_price">{{
                        formatCurrency(cart.price)
                      }}</del>
                    </div>
                  </td>
                  <td class="product-quantity text-right">
                    <QuantityComponent :old-quantity="cart.quantity" />
                  </td>
                  <td class="product-subtotal">
                    <span class="amount">{{
                      formatCurrency(cart.sub_total)
                    }}</span>
                  </td>
                </tr>
              </tbody>
            </table>

            <div class="cart-action mb-6" v-if="carts.length > 0">
              <a
                href="#"
                class="btn btn-dark btn-rounded btn-icon-left btn-shopping mr-auto"
                ><i class="w-icon-long-arrow-left"></i>Tiếp tục mua sắm</a
              >
              <button
                @click="handleClearCart"
                type="button"
                class="btn btn-rounded btn-default btn-clear"
              >
                Xóa giỏ hàng
              </button>
            </div>

            <div v-if="!carts.length">
              <v-empty-state
                icon="mdi-magnify"
                text="Giỏ hàng đang trống vui lòng chọn quay lại mua những sản phẩm mới nhất của chúng tôi."
                title="Chưa có sản phẩm nào trong giỏ hàng."
              ></v-empty-state>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End of PageContent -->

    <div class="cart-footer" v-if="carts.length > 0">
      <div class="container">
        <div class="footer-wrap">
          <v-row no-gutters align="center">
            <v-col cols="4">
              <v-checkbox
                v-model="allChecked"
                style="font-size: 18px"
                @change="handleAllCheckboxChange()"
                label="Chọn tất cả sản phẩm"
              ></v-checkbox>
            </v-col>
            <v-col cols="8">
              <div class="d-flex flex-end items-center">
                <div class="d-flex items-center w-100">
                  <div class="w-100 d-flex justify-between items-center">
                    <span class="total-cart-count fs-16">
                      Tổng thanh toán (1 Sản phẩm):
                    </span>

                    <span
                      class="total-cart-price mr-4 total-amout-cart text-black"
                    >
                      1.737.000 ₫
                    </span>
                  </div>

                  <div class="ml-4" style="width: 500px">
                    <a
                      href="#"
                      class="btn btn-block btn-dark btn-icon-right btn-rounded btn-checkout"
                    >
                      Mua hàng<i class="w-icon-long-arrow-right"></i
                    ></a>
                  </div>
                </div>
              </div>
            </v-col>
          </v-row>
        </div>
      </div>
    </div>
  </main>
  <!-- End of Main -->
</template>

<script setup>
import { onMounted, watch } from 'vue'
import { formatCurrency } from '#imports'
import QuantityComponent from '~/components/includes/QuantityComponent.vue'

const { $axios } = useNuxtApp()

const carts = ref([])
const checkedItems = ref([])
const allChecked = ref(false)

const handleAllCheckboxChange = () => {
  if (allChecked.value) {
    carts.value.forEach((cart, index) => {
      checkedItems.value[index] = cart.cart_item_id
    })
  } else {
    checkedItems.value = []
  }
}

const handleCheckboxChange = (event, variantId) => {
  if (event.target.checked === false) {
    delete checkedItems.value[event.target.value]
  }
  updateOneSelectedCarts(variantId)
}

const getCarts = async () => {
  const response = await $axios.get('/carts')
  carts.value = response.data

  carts.value.forEach((cart, index) => {
    if (cart.is_selected) {
      checkedItems.value[index] = cart.cart_item_id
    }
  })
}

const checkSelectedAll = () => {
  if (Object.keys(checkedItems.value)?.length === carts.value.length) {
    allChecked.value = true
  } else {
    allChecked.value = false
  }
}

const updateAllSelectedCarts = async () => {
  const response = await $axios.put('/carts/handle-selected', {
    select_all: allChecked.value,
  })
  if (response.data) {
    getCarts()
  }
}

const updateOneSelectedCarts = async (variantId) => {
  const response = await $axios.put('/carts/handle-selected', {
    product_variant_id: variantId,
  })
}

const handleClearCart = async () => {
  const response = await $axios.delete('/carts')
}

onMounted(() => {
  getCarts()
})

watch(checkedItems, checkSelectedAll, { deep: true })
watch(allChecked, updateAllSelectedCarts)
</script>

<style scoped>
.shop-table.cart-table .product-price,
.shop-table.cart-table .product-subtotal {
  text-align: right;
}
.product-name a {
  /* Giới hạn số dòng tối đa */
  display: -webkit-box;
  -webkit-box-orient: vertical;
  -webkit-line-clamp: 2; /* Giới hạn số dòng */
  overflow: hidden;
  text-overflow: ellipsis; /* Hiển thị '...' khi văn bản bị cắt bớt */
  white-space: normal; /* Cho phép dòng mới */
}
.shop-table.cart-table .product-price {
  width: auto;
}
.shop-table.cart-table .product-quantity {
  width: auto;
  text-align: right;
}
.shop-table.cart-table .product-quantity .input-group {
  float: right;
}
</style>
