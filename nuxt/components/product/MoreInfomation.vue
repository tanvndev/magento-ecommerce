<template>
  <div class="tab tab-nav-boxed tab-nav-underline product-tabs">
    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item" v-for="tab in tabs" :key="tab.name">
        <a
          href="#"
          class="nav-link"
          :class="{ active: tab.name === activeTab }"
          @click.prevent="selectTab(tab.name)"
        >
          {{ tab.label }}
        </a>
      </li>
    </ul>
    <div class="tab-content">
      <div
        id="product-tab-description"
        class="tab-pane"
        :class="{ active: activeTab == 'description' }"
        v-show="activeTab == 'description'"
      >
        <div v-html="product.description || 'Đang cập nhập mô tả...'"></div>
      </div>
      <div
        id="product-tab-specifications"
        class="tab-pane"
        :class="{ active: activeTab == 'specifications' }"
        v-show="activeTab == 'specifications'"
      >
        <div
          class="specifications-list"
          v-if="product?.attribute_not_enabled?.length > 0"
        >
          <div
            class="specification"
            v-for="(attribute, index) in product?.attribute_not_enabled"
            :key="index"
            :class="{ odd: index % 2 !== 0, even: index % 2 === 0 }"
          >
            <strong>{{ attribute.attribute_name }}:</strong>

            <span
              v-for="(value, index) in attribute.attribute_value_ids"
              :key="value.id"
            >
              {{ value.name }}
              <span v-if="index < attribute.attribute_value_ids.length - 1"
                >,
              </span>
            </span>
          </div>
        </div>
      </div>
      <div
        id="product-tab-reviews"
        class="tab-pane"
        :class="{ active: activeTab == 'reviews' }"
        v-show="activeTab == 'reviews'"
      >
        <div class="row mb-3">
          <div class="col-xl-12 col-lg-5">
            <div class="ratings-wrapper d-flex justify-between">
              <div class="avg-rating-container mr-10">
                <h4 class="avg-mark font-weight-bolder ls-50">3.3</h4>
                <div class="avg-rating">
                  <p class="text-dark mb-1">Đánh giá trung bình</p>
                  <div class="ratings-container">
                    <div class="ratings-full">
                      <span class="ratings" style="width: 60%"></span>
                      <span class="tooltiptext tooltip-top"></span>
                    </div>
                    <a href="#" class="rating-reviews">(3 Đánh giá)</a>
                  </div>
                </div>
              </div>

              <div class="ratings-list w-100">
                <div class="ratings-container">
                  <div class="ratings-full">
                    <span class="ratings" style="width: 100%"></span>
                    <span class="tooltiptext tooltip-top">5</span>
                  </div>
                  <div class="progress-bar progress-bar-sm">
                    <span></span>
                  </div>
                  <div class="progress-value">
                    <mark>70%</mark>
                  </div>
                </div>
                <div class="ratings-container">
                  <div class="ratings-full">
                    <span class="ratings" style="width: 80%"></span>
                    <span class="tooltiptext tooltip-top">4</span>
                  </div>
                  <div class="progress-bar progress-bar-sm">
                    <span></span>
                  </div>
                  <div class="progress-value">
                    <mark>30%</mark>
                  </div>
                </div>
                <div class="ratings-container">
                  <div class="ratings-full">
                    <span class="ratings" style="width: 60%"></span>
                    <span class="tooltiptext tooltip-top">3</span>
                  </div>
                  <div class="progress-bar progress-bar-sm">
                    <span></span>
                  </div>
                  <div class="progress-value">
                    <mark>40%</mark>
                  </div>
                </div>
                <div class="ratings-container">
                  <div class="ratings-full">
                    <span class="ratings" style="width: 40%"></span>
                    <span class="tooltiptext tooltip-top">2</span>
                  </div>
                  <div class="progress-bar progress-bar-sm">
                    <span></span>
                  </div>
                  <div class="progress-value">
                    <mark>0%</mark>
                  </div>
                </div>
                <div class="ratings-container">
                  <div class="ratings-full">
                    <span class="ratings" style="width: 20%"></span>
                    <span class="tooltiptext tooltip-top">1</span>
                  </div>
                  <div class="progress-bar progress-bar-sm">
                    <span></span>
                  </div>
                  <div class="progress-value">
                    <mark>0%</mark>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div
          class="tab tab-nav-boxed tab-nav-outline tab-nav-center"
          v-if="reviews?.length > 0"
        >
          <div class="tab-content">
            <div class="tab-pane active" id="show-all">
              <ul class="comments list-style-none">
                <li class="comment" v-for="review in reviews" :key="n">
                  <div class="comment-body">
                    <figure class="comment-avatar">
                      <img
                        :src="review.image"
                        :alt="review.fullname"
                        width="90"
                        height="90"
                      />
                    </figure>
                    <div class="comment-content">
                      <h4 class="comment-author">
                        <span>{{ review.fullname }}</span>
                        <span class="comment-date ms-3">{{
                          review.created_at
                        }}</span>
                      </h4>
                      <div class="ratings-container comment-rating">
                        <div class="ratings-full">
                          <span
                            class="ratings"
                            :style="`width: ${review.percent_rating}%`"
                          ></span>
                          <span class="tooltiptext tooltip-top">{{
                            review.rating
                          }}</span>
                        </div>
                      </div>
                      <p>
                        {{ review.comment }}
                      </p>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  product: {
    type: [Object, Array],
    default: () => [],
  },
})

const { $axios } = useNuxtApp()
const reviews = ref([])
const tabs = reactive([
  { name: 'description', label: 'Mô tả' },
  { name: 'specifications', label: 'Thông số kĩ thuật' },
  { name: 'reviews', label: 'Đánh giá' },
])

const activeTab = ref('reviews')

const selectTab = (tabName) => {
  activeTab.value = tabName
}

const getAllReviews = async () => {
  const response = await $axios.get(`/product-reviews/${props.product.id}`)

  reviews.value = response.data
}

watch(
  () => props.product,
  () => {
    getAllReviews()
  }
)
</script>

<style scoped>
.specifications-list {
  font-family: Arial, sans-serif;
  line-height: 1.6;
}

.specification {
  padding: 8px 16px;
}

.specification.odd {
  background-color: #ffffff;
}

.specification.even {
  background-color: #f5f6f7;
}

.specification strong {
  color: #333;
  min-width: 160px;
  display: inline-block;
}
</style>
