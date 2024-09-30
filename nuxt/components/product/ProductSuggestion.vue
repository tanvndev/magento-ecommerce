<template>
  <section class="vendor-product-section combo-detail">
    <div class="title-link-wrapper mb-4">
      <h4 class="title text-left">Sản phẩm gợi ý</h4>
    </div>

    <div>
      <div class="buy-access ba-col2">
        <div class="row align-items-center d-flex">
          <div class="col-lg-2">
            <div class="d-flex items-center">
              <div class="bunbled">
                <div class="img-sp">
                  <img
                    src="https://cdn.tgdd.vn/Products/Images/42/329135/s16/iphone-16-xanh-la-650x650.png"
                    alt=""
                  />
                </div>
                <h3>iPhone 16 128GB</h3>
                <strong>22.990.000₫</strong>
                <small> <del>3.690.000₫</del> </small>
              </div>

              <div class="plus">
                <i class="w-icon-plus fs-50"></i>
              </div>
            </div>
          </div>

          <div class="col-lg-7">
            <ul class="list-access">
              <li class="active">
                <div class="img-access">
                  <img
                    src="https://cdn.tgdd.vn/Products/Images/9499/315355/s16/de-sac-khong-day-magsafe-3-in-1-15w-anker-737-cube-y1811-thumb-650x650.png"
                  />
                </div>
                <h3>
                  <a href="">EarPods jack cắm USB-C</a>
                </h3>
                <strong>2.395.000₫</strong>
                <small> <del>3.690.000₫</del> </small>

                <div class="checkbox-wrapper">
                  <v-checkbox
                    v-model="comboItem"
                    value="1"
                    color="primary"
                  ></v-checkbox>
                </div>
              </li>
              <li class="active">
                <div class="img-access">
                  <img
                    src="https://cdn.tgdd.vn/Products/Images/60/329778/s16/op-lung-magsafe-iphone-16-pro-max-nhua-trong-apple-16-650x650.png"
                  />
                </div>
                <h3>
                  <a href="">
                    Ốp lưng MagSafe iPhone 16 Pro Max Nhựa Trong Apple</a
                  >
                </h3>
                <strong>1.130.000₫</strong>
                <small> <del>1.430.000₫</del> </small>

                <div class="checkbox-wrapper">
                  <v-checkbox
                    v-model="comboItem"
                    value="2"
                    color="primary"
                  ></v-checkbox>
                </div>
              </li>
              <li class="active">
                <div class="img-access">
                  <img
                    src="https://cdn.tgdd.vn/Products/Images/54/315072/s16/tai-nghe-co-day-apple-mtjy3-thumb-13-650x650.png"
                  />
                </div>
                <h3>
                  <a href="">EarPods jack cắm USB-C</a>
                </h3>
                <strong>450.000₫</strong>
                <small> <del>550.000₫</del> </small>

                <div class="checkbox-wrapper">
                  <v-checkbox
                    v-model="comboItem"
                    value="3"
                    color="primary"
                  ></v-checkbox>
                </div>
              </li>
            </ul>
          </div>

          <div class="col-lg-3">
            <div class="total-bill">
              <div>
                <strong>26.965.000₫</strong>
                <span>
                  <del>28.660.000₫</del>
                </span>
              </div>
              <a
                href="/cart/single?productId=329135&amp;gtype=muakem&amp;comboid=315355,329778,315072"
                >Mua <b>{{ comboItem?.length }}</b> sản phẩm</a
              >
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script setup>
const comboItem = ref(['3', '2', '1'])

watch(comboItem, () => {
  console.log(comboItem.value)
})
</script>
<style scoped></style>
