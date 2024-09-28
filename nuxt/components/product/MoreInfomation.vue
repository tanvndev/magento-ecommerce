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
        <div class="row mb-4">
          <div class="col-xl-4 col-lg-5 mb-4">
            <div class="ratings-wrapper">
              <div class="avg-rating-container">
                <h4 class="avg-mark font-weight-bolder ls-50">3.3</h4>
                <div class="avg-rating">
                  <p class="text-dark mb-1">Average Rating</p>
                  <div class="ratings-container">
                    <div class="ratings-full">
                      <span class="ratings" style="width: 60%"></span>
                      <span class="tooltiptext tooltip-top"></span>
                    </div>
                    <a href="#" class="rating-reviews">(3 Reviews)</a>
                  </div>
                </div>
              </div>
              <div
                class="ratings-value d-flex align-items-center text-dark ls-25"
              >
                <span class="text-dark font-weight-bold">66.7%</span
                >Recommended<span class="count">(2 of 3)</span>
              </div>
              <div class="ratings-list">
                <div class="ratings-container">
                  <div class="ratings-full">
                    <span class="ratings" style="width: 100%"></span>
                    <span class="tooltiptext tooltip-top"></span>
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
                    <span class="tooltiptext tooltip-top"></span>
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
                    <span class="tooltiptext tooltip-top"></span>
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
                    <span class="tooltiptext tooltip-top"></span>
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
                    <span class="tooltiptext tooltip-top"></span>
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
          <div class="col-xl-8 col-lg-7 mb-4">
            <div class="review-form-wrapper">
              <h3 class="title tab-pane-title font-weight-bold mb-1">
                Submit Your Review
              </h3>
              <p class="mb-3">
                Your email address will not be published. Required fields are
                marked *
              </p>
              <form action="#" method="POST" class="review-form">
                <div class="rating-form">
                  <label for="rating">Your Rating Of This Product :</label>
                  <span class="rating-stars">
                    <a class="star-1" href="#">1</a>
                    <a class="star-2" href="#">2</a>
                    <a class="star-3" href="#">3</a>
                    <a class="star-4" href="#">4</a>
                    <a class="star-5" href="#">5</a>
                  </span>
                  <select
                    name="rating"
                    id="rating"
                    required
                    style="display: none"
                  >
                    <option value="">Rate…</option>
                    <option value="5">Perfect</option>
                    <option value="4">Good</option>
                    <option value="3">Average</option>
                    <option value="2">Not that bad</option>
                    <option value="1">Very poor</option>
                  </select>
                </div>
                <textarea
                  cols="30"
                  rows="6"
                  placeholder="Write Your Review Here..."
                  class="form-control"
                  id="review"
                ></textarea>
                <div class="row gutter-md">
                  <div class="col-md-6">
                    <input
                      type="text"
                      class="form-control"
                      placeholder="Your Name"
                      id="author"
                    />
                  </div>
                  <div class="col-md-6">
                    <input
                      type="text"
                      class="form-control"
                      placeholder="Your Email"
                      id="email_1"
                    />
                  </div>
                </div>
                <div class="form-group">
                  <input
                    type="checkbox"
                    class="custom-checkbox"
                    id="save-checkbox"
                  />
                  <label for="save-checkbox"
                    >Save my name, email, and website in this browser for the
                    next time I comment.</label
                  >
                </div>
                <button type="submit" class="btn btn-dark">
                  Submit Review
                </button>
              </form>
            </div>
          </div>
        </div>

        <div class="tab tab-nav-boxed tab-nav-outline tab-nav-center">
          <div class="tab-content">
            <div class="tab-pane active" id="show-all">
              <ul class="comments list-style-none">
                <li class="comment" v-for="n in 4" :key="n">
                  <div class="comment-body">
                    <figure class="comment-avatar">
                      <img
                        src="assets/images/agents/1-100x100.png"
                        alt="Commenter Avatar"
                        width="90"
                        height="90"
                      />
                    </figure>
                    <div class="comment-content">
                      <h4 class="comment-author">
                        <a href="#">John Doe</a>
                        <span class="comment-date"
                          >March 22, 2021 at 1:54 pm</span
                        >
                      </h4>
                      <div class="ratings-container comment-rating">
                        <div class="ratings-full">
                          <span class="ratings" style="width: 60%"></span>
                          <span class="tooltiptext tooltip-top"></span>
                        </div>
                      </div>
                      <p>
                        pellentesque habitant morbi tristique senectus et. In
                        dictum non consectetur a erat. Nunc ultrices eros in
                        cursus turpis massa tincidunt ante in nibh mauris cursus
                        mattis. Cras ornare arcu dui vivamus arcu felis bibendum
                        ut tristique.
                      </p>
                      <div class="comment-action">
                        <a
                          href="#"
                          class="btn btn-secondary btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize"
                        >
                          <i class="far fa-thumbs-up"></i>Helpful (1)
                        </a>
                        <a
                          href="#"
                          class="btn btn-dark btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize"
                        >
                          <i class="far fa-thumbs-down"></i>Unhelpful (0)
                        </a>
                      </div>
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

const tabs = reactive([
  { name: 'description', label: 'Mô tả' },
  { name: 'specifications', label: 'Thông số kĩ thuật' },
  { name: 'reviews', label: 'Đánh giá' },
])

const activeTab = ref('specifications')

const selectTab = (tabName) => {
  activeTab.value = tabName
}
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
