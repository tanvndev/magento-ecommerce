<template>
  <div class="page-content order-purchase-wrapper pt-2 mt-6 pb-50">
    <div class="container">
      <div class="tab tab-vertical row gutter">
        <div class="col-lg-3">
          <UserSidebar />
        </div>
        <div class="col-lg-9">
          <v-card class="mx-auto px-2">
            <v-tabs
              v-model="tab"
              align-tabs="start"
              color="primary"
              center-active
              @update:modelValue="debounceHandleChangeTab"
            >
              <v-tab
                class="text-capitalize"
                v-for="item in ORDER_STATUS_TABS"
                :key="item.value"
                :value="item.value"
                >{{ item.title }}</v-tab
              >
            </v-tabs>
          </v-card>

          <div class="mt-3">
            <v-text-field
              v-model="search"
              @input="debounceHandleSearch"
              prepend-inner-icon="mdi-magnify"
              hint="Bạn có thể tìm kiếm theo ID đơn hàng"
              variant="outlined"
              clearable
              density="comfortable"
              placeholder="Bạn có thể tìm kiếm theo ID đơn hàng"
            ></v-text-field>
          </div>

          <v-row>
            <v-col
              cols="12"
              md="12"
              v-for="(order, index) in orders"
              :key="order.id"
            >
              <v-card hover class="mx-auto pa-3 item-order">
                <div class="d-flex justify-between items-center pb-1">
                  <div>
                    <v-btn
                      variant="tonal"
                      class="text-capitalize"
                      size="small"
                      prepend-icon="mdi-chat"
                      color="blue"
                      >Chat</v-btn
                    >
                  </div>
                  <div>
                    <v-chip
                      prepend-icon="mdi-truck"
                      class="px-3 text-uppercase"
                      :color="order?.order_status_color"
                    >
                      {{ order?.order_status }}
                    </v-chip>
                  </div>
                </div>
                <v-divider class="border-opacity-100"></v-divider>

                <NuxtLink
                  @click.prevent="getOrderDetail(order.id)"
                  :to="`/user/order/${order.code}`"
                >
                  <div
                    class="d-flex w-100 py-2 product-info-wrap"
                    v-for="item in order?.order_items"
                    :key="item.id"
                  >
                    <div class="order-product-image">
                      <img
                        class="object-contain"
                        :src="item.image"
                        :alt="item.product_variant_name"
                      />
                    </div>

                    <div class="order-product-info">
                      <div class="px-2 pt-1 product-title">
                        <div class="title">
                          <NuxtLink
                            :to="`/product/${item.slug}-${item.product_id}`"
                          >
                            {{ item.product_variant_name }}
                          </NuxtLink>
                        </div>
                        <div class="variant">
                          Phân loại: {{ item.attribute_values }}
                        </div>
                        <div class="quantity">x1</div>
                      </div>
                      <div>
                        <div class="product-price">
                          <ins class="new-price">{{
                            formatCurrency(item.sale_price || item.price)
                          }}</ins>
                          <del class="old-price" v-if="item.sale_price">{{
                            formatCurrency(item.price)
                          }}</del>
                        </div>
                      </div>
                    </div>
                  </div>
                </NuxtLink>

                <v-divider class="border-opacity-100"></v-divider>

                <div class="d-flex w-100 justify-between items-center">
                  <div class="order-footer">
                    <v-row align="center" justify="end" no-gutters>
                      <v-col cols="auto" class="mr-2">
                        <v-btn
                          size="large"
                          class="text-capitalize"
                          color="primary"
                          >Đánh giá</v-btn
                        >
                      </v-col>
                      <v-col cols="auto">
                        <v-btn
                          @click="addToCart(order.id)"
                          size="large"
                          variant="text"
                          class="text-capitalize border"
                          >Mua lại</v-btn
                        >
                      </v-col>
                      <v-col cols="auto" class="ml-2">
                        <v-btn
                          size="large"
                          variant="text"
                          class="text-capitalize border"
                          >Liên hệ người bán</v-btn
                        >
                      </v-col>
                    </v-row>
                  </div>
                  <div class="order-middle">
                    <div class="total-amount">
                      <label>Thành tiền:</label>
                      <div class="text">
                        {{ formatCurrency(order.final_price) }}
                      </div>
                    </div>
                  </div>
                </div>
              </v-card>
            </v-col>

        </v-row>
        <div v-if="!orders?.length">
          <v-empty-state
            icon="mdi-magnify"
            text="Chúng tôi không thể tìm thấy đơn hàng của bạn vui lòng thử lại."
            title="Không có dữ liệu."
          ></v-empty-state>
        </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ORDER_STATUS_TABS } from '~/static/order'
import { useLoadingStore, useCartStore, useOrderStore } from '#imports'

const tab = ref(ORDER_STATUS_TABS[0].value)
const { $axios } = useNuxtApp()
const loadingStore = useLoadingStore()
const orderStore = useOrderStore()
const cartStore = useCartStore()
const orders = ref([])
const search = ref('')

const getAllOrder = async () => {
  try {
    loadingStore.setLoading(true)
    const response = await $axios.get('/getOrderUser', {
      params: {
        order_status: tab.value,
        search: search.value,
      },
    })
    orders.value = response.data?.data
  } catch (error) {
  } finally {
    loadingStore.setLoading(false)
  }
}

const debounceHandleSearch = debounce(getAllOrder, 500)

const debounceHandleChangeTab = debounce(getAllOrder, 500)

const getOrderDetail = async (orderId) => {
  const order = orders.value.find((order) => order.id === orderId)
  if (!order) {
    return
  }
  orderStore.setOrderDetail(order)
}

const addToCart = async (orderId) => {
  const order = orders.value.find((order) => order.id === orderId)
  const variantIds = order.order_items
    .map((item) => item.product_variant_id)
    .join(',')

  if (!variantIds) {
    return toast('Có lỗi vui lòng thử lại.', 'error')
  }

  const payload = {
    product_variant_id: variantIds,
  }

  const response = await $axios.post('/carts/comming-soon', payload)

  cartStore.setCartCount(response.data?.items.length)
  toast(response.messages, response.status)
}

onMounted(async () => {
  await getAllOrder()
})
</script>

<style></style>
