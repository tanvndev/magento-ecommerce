<template>
  <div class="page-content pt-2 mt-6">
    <div class="container">
      <div class="tab tab-vertical row gutter">
        <div class="col-lg-3">
          <UserSidebar />
        </div>
        <div class="col-lg-9">
          <v-card
            class="mx-auto pa-2"
            title="Địa chỉ của tôi"
            subtitle="Quản lý thông tin địa chỉ của bạn"
          >
            <v-divider class="border-opacity-100"></v-divider>

            <div class="px-2">
              <div class="d-flex justify-end">
                <v-btn variant="tonal" color="success" prepend-icon="mdi-plus"
                  >Thêm địa chỉ mới</v-btn
                >
              </div>
              <v-row class="mt-4">
                <v-col cols="12" md="12">
                  <div class="customer-user py-3" v-for="i in 3" :key="i">
                    <div class="row gutter-sm">
                      <div class="col-xs-9">
                        <div class="v2-checkout-address-inner">
                          <div>
                            <div class="v2-address-title-container">
                              <span class="v2-address-title">Vũ Ngọc Tân</span>
                              <span class="v2-mobile">0332225690</span>
                            </div>
                          </div>
                          <div class="v2-address-info-item">
                            <span
                              class="v2-address-tag-label mr-2"
                              style="
                                background-image: linear-gradient(
                                  -143deg,
                                  rgb(255, 123, 83) 0%,
                                  rgb(255, 75, 40) 100%
                                );
                              "
                              >NHÀ RIÊNG</span
                            >
                            <span class="v2-address-info-address">
                              Thôn cầu thăng long Cổng cụm 4 ngõ thứ 2, Xã Kim
                              Nỗ, Huyện Đông Anh, Hà Nội
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="col-xs-3">
                        <div class="d-flex justify-end mr-1">
                          <a href="#" class="mr-2"> Cập nhập</a>
                          <a href="#"> Xóa</a>
                        </div>
                        <div class="mt-2 d-flex justify-end">
                          <v-btn density="compact">Mặc định</v-btn>
                        </div>
                      </div>
                    </div>
                  </div>
                </v-col>
              </v-row>
            </div>
          </v-card>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup></script>
