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
            title="Hồ sơ của tôi"
            subtitle="Quản lý thông tin hồ sơ để bảo mật tài khoản"
          >
            <v-divider class="border-opacity-100"></v-divider>

            <v-row class="mt-4 px-2">
              <v-col cols="12" md="8">
                <v-row gutter="10">
                  <v-col cols="12" md="11">
                    <IncludesInputComponent
                      name="customer_name"
                      label="Họ và tên *"
                      variant="underlined"
                    />
                  </v-col>
                  <v-col cols="12" md="8">
                    <IncludesInputComponent
                      :disabled="true"
                      name="customer_name"
                      label="Địa chỉ email"
                      old-value="vu**********@gmail.com"
                      variant="underlined"
                    />
                  </v-col>
                  <v-col cols="12" md="4">
                    <v-btn
                      variant="tonal"
                      color="primary"
                      prepend-icon="mdi-pencil"
                      >Thay đổi</v-btn
                    >
                  </v-col>
                  <v-col cols="12" md="8">
                    <IncludesInputComponent
                      :disabled="true"
                      name="customer_name"
                      label="Số điện thoại"
                      variant="underlined"
                      old-value="*********90"
                    />
                  </v-col>
                  <v-col cols="12" md="4">
                    <v-btn
                      variant="tonal"
                      color="primary"
                      prepend-icon="mdi-pencil"
                      >Thay đổi</v-btn
                    >
                  </v-col>
                </v-row>
              </v-col>
              <v-col cols="12" md="4">
                <div class="text-center">
                  <div class="text-center mb-4">
                    <v-avatar
                      image="https://cdn.vuetifyjs.com/images/john-smirk.png"
                      size="120"
                    ></v-avatar>
                  </div>

                  <v-btn> Chọn ảnh </v-btn>
                  <p class="text-body-2 mt-4">
                    Dung lượng file tối đa 1 MB Định dạng:.JPEG, .PNG
                  </p>
                </div>
              </v-col>
            </v-row>
          </v-card>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup></script>
