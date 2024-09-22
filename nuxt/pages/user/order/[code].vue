<template>
  <div class="page-content order-purchase-wrapper pt-2 mt-6">
    <div class="container">
      <div class="tab tab-vertical row gutter">
        <div class="col-lg-3">
          <UserSidebar />
        </div>
        <div class="col-lg-9">
          <v-card class="pa-2">
            <div class="d-flex justify-between items-center">
              <v-btn
                variant="text"
                @click="$router.back()"
                prepend-icon="mdi-chevron-left"
              >
                Trở lại
              </v-btn>

              <div class="text-header">
                <span class="text-uppercase mr-2"
                  >MÃ ĐƠN HÀNG. 240818KJ4JQPN1</span
                >
                <span class="text-uppercase mr-2 text-primary"
                  >Đơn hàng đã hoàn thành</span
                >
              </div>
            </div>
          </v-card>
          <v-card class="pa-2 py-5 mt-3 shadow">
            <v-timeline
              truncate-line="both"
              line-thickness="4"
              line-color="green-lighten-2"
              direction="horizontal"
              side="end"
            >
              <v-timeline-item
                fill-dot
                icon="mdi-truck"
                size="x-large"
                dot-color="green"
                v-for="(item, index) in 5"
              >
                Content
              </v-timeline-item>
            </v-timeline>
          </v-card>

          <v-card class="pa-4 mt-3 shadow">
            <div class="order-details-wrapper">
              <h4 class="title text-uppercase mb-2 ls-25">Địa chỉ nhận hàng</h4>
              <div class="mt-3">
                <span class="fs-16 mb-1"> Vũ Ngọc Tân </span>
                <div style="color: #0000008a">
                  <div>(+84) 332225690</div>
                  <span>
                    cụm dan cu 4, Kim Nỗ, Xã Kim Nỗ, Huyện Đông Anh, Hà Nội
                  </span>
                </div>
              </div>
            </div>
          </v-card>

          <v-row class="mt-1">
            <v-col cols="12" md="12">
              <v-card hover class="mx-auto pa-3 item-order shadow">
                <h4 class="title text-uppercase mb-2 ls-25">Sản phẩm (2)</h4>
                <div>
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
                </div>
              </v-card>
            </v-col>
          </v-row>

          <v-card class="pa-4 mt-3 mb-10 shadow">
            <div class="order-details-wrapper">
              <h4 class="title text-uppercase mb-2 ls-25">Chi tiết hóa đơn</h4>
              <table class="order-table">
                <thead></thead>
                <tbody></tbody>
                <tfoot>
                  <tr>
                    <th>Tạm tính:</th>
                    <td>{{ formatCurrency(200000000) }}</td>
                  </tr>
                  <tr>
                    <th>Phí vận chuyển:</th>
                    <td>{{ formatCurrency(200000000) }}</td>
                  </tr>
                  <tr>
                    <th>Mã giảm giá:</th>
                    <td>- {{ formatCurrency(200000000) }}</td>
                  </tr>
                  <tr>
                    <th>Phương thức thanh toán:</th>
                    <td>COD</td>
                  </tr>
                  <tr class="total border-b-none">
                    <th class="fs-20 fw-bold text-primary pt-4">Thành tiền:</th>
                    <td class="fs-20 fw-bold text-primary pt-4">
                      {{ formatCurrency(200000000) }}
                    </td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </v-card>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup></script>
<style scoped>
.fw-bold {
  font-weight: bold !important;
}
.border-b-none {
  border-bottom: none;
}
.title {
  font-weight: normal;
  font-size: 16px;
}
th {
  font-weight: normal;
}
.text-header span::after {
  content: '|';
  opacity: 0.3;
  padding-left: 10px;
}
.text-header span:last-child:after {
  display: none;
}
.shadow {
  box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
}
</style>
