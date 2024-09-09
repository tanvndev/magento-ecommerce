<template>
  <!-- Home Banner -->
  <HomeBanner />

  <!-- Home Category -->
  <HomeCategory />

  <div class="container">
    <div v-for="widget in widgets" :key="widget.id">
      <HomeAdvertisement
        :items="widget.items"
        v-if="widget.type == 'advertisement'"
      />

      <!-- End of Category Banner Wrapper -->
      <HomeProduct
        :items="widget.items"
        :title="widget.name"
        v-if="widget.type == 'product' && widget.items.length > 0"
      />
      <!-- End of Category Banner Wrapper -->
    </div>
    <div class="brand-container-wrap">
      <h2 class="title title-underline mb-4 ls-normal">
        Danh sách thương hiệu
      </h2>
      <div class="swiper-theme brands-wrapper mb-9">
        <div
          class="row gutter-no cols-xl-6 cols-lg-5 cols-md-4 cols-sm-3 cols-2"
        >
          <div class="brand-col">
            <figure class="brand-wrapper">
              <img
                src="~/assets/images/demos/demo1/brands/1.png"
                alt="Brand"
                width="410"
                height="186"
              />
            </figure>
            <figure class="brand-wrapper">
              <img
                src="~/assets/images/demos/demo1/brands/2.png"
                alt="Brand"
                width="410"
                height="186"
              />
            </figure>
          </div>
          <div class="brand-col">
            <figure class="brand-wrapper">
              <img
                src="~/assets/images/demos/demo1/brands/3.png"
                alt="Brand"
                width="410"
                height="186"
              />
            </figure>
            <figure class="brand-wrapper">
              <img
                src="~/assets/images/demos/demo1/brands/4.png"
                alt="Brand"
                width="410"
                height="186"
              />
            </figure>
          </div>
          <div class="brand-col">
            <figure class="brand-wrapper">
              <img
                src="~/assets/images/demos/demo1/brands/5.png"
                alt="Brand"
                width="410"
                height="186"
              />
            </figure>
            <figure class="brand-wrapper">
              <img
                src="~/assets/images/demos/demo1/brands/6.png"
                alt="Brand"
                width="410"
                height="186"
              />
            </figure>
          </div>
          <div class="brand-col">
            <figure class="brand-wrapper">
              <img
                src="~/assets/images/demos/demo1/brands/7.png"
                alt="Brand"
                width="410"
                height="186"
              />
            </figure>
            <figure class="brand-wrapper">
              <img
                src="~/assets/images/demos/demo1/brands/8.png"
                alt="Brand"
                width="410"
                height="186"
              />
            </figure>
          </div>
          <div class="brand-col">
            <figure class="brand-wrapper">
              <img
                src="~/assets/images/demos/demo1/brands/9.png"
                alt="Brand"
                width="410"
                height="186"
              />
            </figure>
            <figure class="brand-wrapper">
              <img
                src="~/assets/images/demos/demo1/brands/10.png"
                alt="Brand"
                width="410"
                height="186"
              />
            </figure>
          </div>
          <div class="brand-col">
            <figure class="brand-wrapper">
              <img
                src="~/assets/images/demos/demo1/brands/11.png"
                alt="Brand"
                width="410"
                height="186"
              />
            </figure>
            <figure class="brand-wrapper">
              <img
                src="~/assets/images/demos/demo1/brands/12.png"
                alt="Brand"
                width="410"
                height="186"
              />
            </figure>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import '~/assets/css/main.min.css'

useSeoMeta({
  title: 'Trang chủ',
  ogTitle: 'Trang chủ',
  description: 'This is my amazing site, let me tell you all about it.',
  ogDescription: 'This is my amazing site, let me tell you all about it.',
  ogImage: 'https://example.com/image.png',
  twitterCard: 'summary_large_image',
})

const widgets = ref([])
const { $axios } = useNuxtApp()

const getWidgets = async () => {
  const response = await $axios.get('/getWidget')
  widgets.value = response.data
}

onMounted(() => {
  getWidgets()
})
</script>
