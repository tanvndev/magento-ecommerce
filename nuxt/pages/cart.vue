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
          <div class="col-lg-12 pr-lg-12 mb-6">
            <table class="shop-table cart-table">
              <thead>
                <tr>
                  <th>
                    <v-checkbox
                      v-model="allChecked"
                      style="font-size: 18px"
                      @change="handleAllCheckboxChange"
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
                <tr v-for="cart in carts" :key="cart.id">
                  <td>
                    <v-checkbox
                      v-model="checkedItems[cart.cart_item_id]"
                      :value="cart.cart_item_id"
                      @change="handleCheckboxChange"
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
        </div>
      </div>
    </div>
    <!-- End of PageContent -->
  </main>
  <!-- End of Main -->
</template>

<script setup>
import { onMounted } from 'vue'
import { formatCurrency } from '#imports'

const { $axios } = useNuxtApp()

const carts = ref([])
const checkedItems = ref([])
const allChecked = ref(false)

const handleAllCheckboxChange = () => {
  if (allChecked.value) {
    carts.value.forEach((cart) => {
      checkedItems.value[cart.cart_item_id] = cart.cart_item_id
    })
  } else {
    checkedItems.value = []
  }
}

const handleCheckboxChange = (event) => {
  if (event.target.checked === false) {
    delete checkedItems.value[event.target.value]
  }

  if (Object.keys(checkedItems.value)?.length === carts.value.length) {
    allChecked.value = true
  } else {
    allChecked.value = false
  }
}

const getCarts = async () => {
  const response = await $axios.get('/carts')
  carts.value = response.data
}

onMounted(() => {
  getCarts()
})

// Watch for changes in `checkedItems` to update `allChecked`
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
