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
              @update:modelValue="handleChangeTab"
            >
              <v-tab
                class="text-capitalize"
                v-for="item in ORDER_STATUS"
                :key="item.value"
                :value="item.value"
                >{{ item.title }}</v-tab
              >
            </v-tabs>
          </v-card>

          <div class="mt-3">
            <v-text-field
              prepend-inner-icon="mdi-magnify"
              hint="Bạn có thể tìm kiếm theo tên Shop, ID đơn hàng hoặc Tên Sản phẩm"
              variant="outlined"
              clearable
              density="comfortable"
              placeholder="Bạn có thể tìm kiếm theo tên Shop, ID đơn hàng hoặc Tên Sản phẩm"
            ></v-text-field>
          </div>

          <v-row>
            <v-col cols="12" md="12" v-for="(item, index) in 10" :key="index">
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
                      color="green"
                    >
                      Giao hàng thành công
                    </v-chip>
                  </div>
                </div>
                <v-divider class="border-opacity-100"></v-divider>

                <NuxtLink :to="`/user/order/${'ORD202409213564A1'}`">
                  <div class="d-flex w-100 py-2 product-info-wrap">
                    <div class="order-product-image">
                      <img
                        src="https://down-vn.img.susercontent.com/file/83ef1311db3b1253241e21c0cb309e27_tn"
                        alt=""
                      />
                    </div>

                    <div class="order-product-info">
                      <div class="px-2 pt-1 product-title">
                        <div class="title">
                          <NuxtLink to="#">
                            Chuột không dây DAREU LM115G Pink / Black / White -
                            Kết nối xa 10m
                          </NuxtLink>
                        </div>
                        <div class="variant">Phân loại hàng: LM115G Đen</div>
                        <div class="quantity">x1</div>
                      </div>
                      <div>
                        <div class="product-price">
                          <ins class="new-price">{{
                            formatCurrency(20000000)
                          }}</ins>
                          <del class="old-price">{{
                            formatCurrency(2000000)
                          }}</del>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="d-flex w-100 py-2 product-info-wrap">
                    <div class="order-product-image">
                      <img
                        src="https://down-vn.img.susercontent.com/file/83ef1311db3b1253241e21c0cb309e27_tn"
                        alt=""
                      />
                    </div>

                    <div class="order-product-info">
                      <div class="px-2 pt-1 product-title">
                        <div class="title">
                          <NuxtLink to="#">
                            Chuột không dây DAREU LM115G Pink / Black / White -
                            Kết nối xa 10m
                          </NuxtLink>
                        </div>
                        <div class="variant">Phân loại hàng: LM115G Đen</div>
                        <div class="quantity">x1</div>
                      </div>
                      <div>
                        <div class="product-price">
                          <ins class="new-price">{{
                            formatCurrency(20000000)
                          }}</ins>
                          <del class="old-price">{{
                            formatCurrency(2000000)
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
                      <div class="text">₫118.800</div>
                    </div>
                  </div>
                </div>
              </v-card>
            </v-col>
          </v-row>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import ORDER_STATUS from '~/static/orderStatus'
const tab = ref(ORDER_STATUS[0].value)
const handleChangeTab = () => {
  console.log(tab.value)
}
</script>

<style>

</style>
