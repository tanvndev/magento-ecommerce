<template>
  <div class="checkout-address">
    <div class="d-flex items-center justify-between pb-4">
      <h3 class="title billing-title text-uppercase ls-10 pt-1 m-0">
        Địa chỉ giao hàng
      </h3>
      <a href="#" class="fs-15">Chỉnh sửa</a>
    </div>
    <div class="customer-address">
      <div class="row gutter-sm">
        <div class="col-xs-6">
          <v-text-field
            v-model="firstName"
            :rules="rules"
            clearable
            color="primary"
            variant="outlined"
            density="comfortable"
            label="Họ và tên *"
          ></v-text-field>
        </div>
        <div class="col-xs-6">
          <v-text-field
            v-model="firstName"
            :rules="rules"
            clearable
            variant="outlined"
            density="comfortable"
            label="Số điện thoại *"
          ></v-text-field>
        </div>
        <div class="col-xs-12">
          <v-text-field
            v-model="firstName"
            :rules="rules"
            clearable
            variant="outlined"
            density="comfortable"
            label="Địa chỉ email *"
          ></v-text-field>
        </div>
        <div class="col-xs-12 mb-5">
          <v-btn rounded="xl" prepend-icon="mdi-map-marker">
            <template v-slot:prepend>
              <v-icon color="warning"></v-icon>
            </template>

            Chọn từ vị trí
          </v-btn>
        </div>
      </div>
      <div class="row gutter-sm">
        <div class="col-md-4">
          <v-select
            :items="[
              'California',
              'Colorado',
              'Florida',
              'Georgia',
              'Texas',
              'Wyoming',
            ]"
            variant="outlined"
            density="comfortable"
            label="Tỉnh / Thành phố *"
          ></v-select>
        </div>
        <div class="col-md-4">
          <v-select
            :items="[
              'California',
              'Colorado',
              'Florida',
              'Georgia',
              'Texas',
              'Wyoming',
            ]"
            variant="outlined"
            density="comfortable"
            label="Quận / Huyện *"
          ></v-select>
        </div>
        <div class="col-md-4">
          <v-select
            :items="[
              'California',
              'Colorado',
              'Florida',
              'Georgia',
              'Texas',
              'Wyoming',
            ]"
            variant="outlined"
            density="comfortable"
            label="Phường / Xã *"
          ></v-select>
        </div>

        <div class="col-md-12">
          <v-textarea
            row-height="15"
            rows="1"
            auto-grow
            variant="outlined"
            density="comfortable"
            label="Địa chỉ chi tiết *"
          ></v-textarea>
        </div>
      </div>
    </div>

    <div class="customer-user d-none">
      <div>
        <div class="v2-checkout-address-inner">
          <div>
            <div class="v2-address-title-container">
              <span class="v2-address-title">Vũ Ngọc Tân</span>
              <span class="v2-mobile">0332225690</span>
            </div>
          </div>
          <div class="v2-address-info-item">
            <span
              class="v2-address-tag-label"
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
              Thôn cầu thăng long Cổng cụm 4 ngõ thứ 2, Xã Kim Nỗ, Huyện Đông
              Anh, Hà Nội
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup></script>

<style scoped>
.v2-address-title-container {
  font-size: 16px;
  color: #333333;
  margin-bottom: 6px;
}
.v2-address-title {
  margin-right: 20px;
}
.customer-user {
  margin-top: -10px;
  box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
  padding: 14px;
  border-radius: 6px;
  margin-bottom: 30px;
}
.v2-address-tag-label {
  padding: 3px 14px;
  color: #fff;
  font-weight: 600;
  border-radius: 10px;
  font-size: 13px;
  margin-right: 4px;
}
.v2-address-info-address {
  font-size: 14px;
  color: #333333;
}
</style>
