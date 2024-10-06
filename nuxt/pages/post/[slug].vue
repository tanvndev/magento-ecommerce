<script setup>
const date = ref(new Date())
</script>
<template>
  <div class="page-content mb-8 mt-5">
    <div class="container">
      <div class="row gutter-lg">
        <div class="main-content post-single-content">
          <div class="post post-grid post-single">
            <figure class="post-media br-sm">
              <img
                src="assets/images/blog/single/1.jpg"
                alt="Blog"
                width="930"
                height="500"
              />
            </figure>
            <div class="post-details">
              <div class="post-meta">
                by <a href="#" class="post-author">John Doe</a> -
                <a href="#" class="post-date">03.01.2021</a>
                <a href="#" class="post-comment"
                  ><i class="w-icon-comments"></i><span>0</span>Comments</a
                >
              </div>
              <h2 class="post-title">
                <a href="#"
                  >Fashion tells about who you are from external point</a
                >
              </h2>
              <div class="post-content">
                <p>
                  Sed pretium, ligula sollicitudin laoreet viverra, tortor
                  libero sodales leo, eget blandit nunc tortor eu nibh.
                  Suspendisse potenti. Sed egstas, ant at vulputate volutpat,
                  uctus metus libero eu augue, vitae luctus metus libero eu
                  augue.
                </p>
                <p>
                  Morbi purus libero, faucibus adi piscing, com modo quis,
                  gravida iest. Sed lectus. Praesent elementum hendrerit tortor.
                  Sed semper lorem at felis. Vestibulum volutpat, lacus a
                  ultrices sagittis, mi neque euismod dui, eu pulvinar nunc
                  sapien ornare nisl. pede arcu, dapibus eu, fermen tum et,
                  dapibus sed, urna.
                  <a href="#">Morbi interdum mollis sapien.</a>
                  Sed ac risus. Pha sellus lacinia, magna a laoreet, lect us
                  arcu pulvinar risus, vitae fac ilisis libero dolor a purus.
                </p>
              </div>
            </div>
          </div>
          <!-- End Post -->
          <blockquote class="text-center mb-8">
            <i class="fas fa-quote-left"></i>
            <p class="font-weight-bold text-dark mt-1 mb-2">
              War and Marketing Have Many Similarities
            </p>
            <cite class="font-weight-normal text-dark">JELLY CRISTIANA</cite>
          </blockquote>
          <!-- End Blockquote -->
          <p class="mb-10">
            Morbi interdum mollis sapien. Sed ac risus. Pha sellus lacinia,
            magna a laoreet, lect us arcu pulvinar risus, vitae fac ilisis libeo
            dolor. Sed vel lacus. Mauris nibh felis, adipiscing varius,
            adipiscing in, lacinia vel, tellus. Suspendisse ac urna.
          </p>
          <h4 class="title title-md font-weight-bold">
            Defaulting to Mindfulness: The Third Person Effect
          </h4>
          <p class="mb-2">
            Phasellus hendrerit. Pellentesque aliquet nibh nec urna. In nisi
            neque, aliquet vel, da pibus id, mattis vel, nisi. Sed pretium,
            ligula soll itudin laoreet viverra. Sed lectus. Praesent elementum
            hendrerit tortor. Sed semper lorem at felis. Vestibulum volutpat,
            lacus a ultric sagittis, mi neque euismod duin.
          </p>
          <ul class="list-style-none list-type-check">
            <li>
              Nunc nec porttitor turpis. In eu risus enim neque, aliquet ve In
              vitae mollis elit.
            </li>
            <li>Vivamus finibus vel mauris eu risus enut vehicula.</li>
            <li>
              Nullam a magna porttitor, dictum risus nec, fauci eu risus enbus
              sapien.
            </li>
            <li>
              Ultrices eros in eu risus encursus turpis massa tincidunt ante.
            </li>
          </ul>
          <p>
            Nibh ipsum consequat nisl vel. Non arcu risus quis varius quam
            quisque id diam vel. Eu turpis egestas pharetra.
          </p>

          <div class="social-links-wrapper mb-7">
            <div class="social-links">
              <div
                class="social-icons social-no-color border-thin"
                style="border-color: transparent !important"
              >
                <a
                  href="https://www.facebook.com/"
                  class="social-icon social-facebook w-icon-facebook"
                  data-platform="facebook"
                  @click.prevent="handleSocialIconClick"
                ></a>
                <a
                  href="https://twitter.com/"
                  class="social-icon social-twitter w-icon-twitter"
                  data-platform="twitter"
                  @click.prevent="handleSocialIconClick"
                ></a>
                <a
                  href="https://www.pinterest.com/"
                  class="social-icon social-pinterest fab fa-pinterest-p"
                  data-platform="pinterest"
                  @click.prevent="handleSocialIconClick"
                ></a>
                <a
                  href="https://www.whatsapp.com/"
                  class="social-icon social-whatsapp fab fa-whatsapp"
                  data-platform="whatsapp"
                  @click.prevent="handleSocialIconClick"
                ></a>
                <a
                  href="https://www.linkedin.com/"
                  class="social-icon social-youtube fab fa-linkedin-in"
                  data-platform="linkedin"
                  @click.prevent="handleSocialIconClick"
                ></a>
              </div>
            </div>
          </div>
          <!-- End Social Links -->
          <div class="post-author-detail" style="border-radius: 4px">
            <figure class="author-media mr-4">
              <img
                src="assets/images/blog/single/1.png"
                alt="Author"
                width="105"
                height="105"
              />
            </figure>
            <div class="author-details">
              <div class="author-name-wrapper flex-wrap mb-2">
                <h4 class="author-name font-weight-bold mb-2 pr-4 mr-auto">
                  John Doe
                  <span class="font-weight-normal text-default">(AUTHOR)</span>
                </h4>
              </div>
              <p class="mb-0">
                Vestibulum volutpat, lacus a ultrices sagittis, mi neque
                euismoder eu pulvinar nunc sapien ornare nisl. Ped earcudaap
                ibuseu, fermentum et, dapibus sed, urna. Morbi interdum mollis
                sapien.
              </p>
            </div>
          </div>
          <!-- End Post Author Detail -->
          <div class="post-navigation">
            <div class="nav nav-prev">
              <a href="#" class="align-items-start text-left">
                <span>
                  <i class="w-icon-long-arrow-left"></i>
                  bài viết trước
                </span>
                <span class="nav-content mb-0 text-normal"
                  >Vivamus vestibulum ntulla nec ante</span
                >
              </a>
            </div>
            <div class="nav nav-next">
              <a href="#" class="align-items-end text-right">
                <span>
                  bài viết tiếp theo
                  <i class="w-icon-long-arrow-right"></i>
                </span>
                <span class="nav-content mb-0 text-normal"
                  >Fusce lacinia arcuet nulla</span
                >
              </a>
            </div>
          </div>

          <h4 class="title title-lg font-weight-bold pt-1 mt-10">3 Comments</h4>
          <ul class="comments list-style-none pl-0">
            <li class="comment">
              <div class="comment-body">
                <figure class="comment-avatar">
                  <img
                    src="assets/images/blog/single/1.png"
                    alt="Avatar"
                    width="90"
                    height="90"
                  />
                </figure>
                <div class="comment-content">
                  <h4 class="comment-author font-weight-bold">
                    <a href="#">John Doe</a>
                    <span class="comment-date">Aug 23, 2021 at 10:46 am</span>
                  </h4>
                  <p>
                    Vestibulum volutpat, lacus a ultrices sagittis, mi neque
                    euismod dui, eu pulvinar nunc sapien ornare nisl.arcu fer
                    ment umet, dapibus sed, urna.
                  </p>
                  <a
                    href="#"
                    class="btn btn-dark btn-link btn-underline btn-icon-right btn-reply"
                    >Reply<i class="w-icon-long-arrow-right"></i
                  ></a>
                </div>
              </div>
            </li>
            <li class="comment">
              <div class="comment-body">
                <figure class="comment-avatar">
                  <img
                    src="assets/images/blog/single/2.png"
                    alt="Avatar"
                    width="90"
                    height="90"
                  />
                </figure>
                <div class="comment-content">
                  <h4 class="comment-author font-weight-bold">
                    <a href="#">Semi Colon</a>
                    <span class="comment-date">Aug 24, 2021 at 13:25 am</span>
                  </h4>
                  <p>
                    Sed pretium, ligula sollicitudin laoreet viverra, tortor
                    libero sodales.
                  </p>
                  <a
                    href="#"
                    class="btn btn-dark btn-link btn-underline btn-icon-right btn-reply"
                    >Reply<i class="w-icon-long-arrow-right"></i
                  ></a>
                </div>
              </div>
            </li>
            <li class="comment">
              <div class="comment-body">
                <figure class="comment-avatar">
                  <img
                    src="assets/images/blog/single/1.png"
                    alt="Avatar"
                    width="90"
                    height="90"
                  />
                </figure>
                <div class="comment-content">
                  <h4 class="comment-author font-weight-bold">
                    <a href="#">John Doe</a>
                    <span class="comment-date">Aug 23, 2021 at 10:46 am</span>
                  </h4>
                  <p>
                    Vestibulum volutpat, lacus a ultrices sagittis, mi neque
                    euismod dui, eu pulvinar nunc sapien ornare nisl.arcu fer
                    ment umet, dapibus sed, urna.
                  </p>
                  <a
                    href="#"
                    class="btn btn-dark btn-link btn-underline btn-icon-right btn-reply"
                    >Reply<i class="w-icon-long-arrow-right"></i
                  ></a>
                </div>
              </div>
            </li>
          </ul>
          <!-- End Comments -->
          <form class="reply-section pb-4">
            <h4 class="title title-md font-weight-bold pt-1 mt-10 mb-0">
              Leave a Reply
            </h4>
            <p>
              Your email address will not be published. Required fields are
              marked
            </p>
            <div class="row">
              <div class="col-sm-6 mb-4">
                <input
                  type="text"
                  class="form-control"
                  placeholder="Enter Your Name"
                  id="name"
                />
              </div>
              <div class="col-sm-6 mb-4">
                <input
                  type="text"
                  class="form-control"
                  placeholder="Enter Your Email"
                  id="email_1"
                />
              </div>
            </div>
            <textarea
              cols="30"
              rows="6"
              placeholder="Write a Comment"
              class="form-control mb-4"
              id="comment"
            ></textarea>
            <button class="btn btn-dark btn-rounded btn-icon-right btn-comment">
              Post Comment<i class="w-icon-long-arrow-right"></i>
            </button>
          </form>
        </div>
        <!-- End of Main Content -->
        <aside
          class="sidebar right-sidebar blog-sidebar sidebar-fixed sticky-sidebar-wrapper"
        >
          <div class="sidebar-overlay">
            <a href="#" class="sidebar-close">
              <i class="close-icon"></i>
            </a>
          </div>
          <a href="#" class="sidebar-toggle">
            <i class="fas fa-chevron-left"></i>
          </a>
          <div class="sidebar-content">
            <div class="sticky-sidebar">
              <div class="widget widget-categories">
                <h3 class="widget-title bb-no mb-0">Nhóm bài viết</h3>
                <ul class="widget-body filter-items search-ul">
                  <li><a href="blog.html">Clothes</a></li>
                  <li><a href="blog.html">Entertainment</a></li>
                  <li><a href="blog.html">Fashion</a></li>
                  <li><a href="blog.html">Lifestyle</a></li>
                  <li><a href="blog.html">Others</a></li>
                  <li><a href="blog.html">Shoes</a></li>
                  <li><a href="blog.html">Technology</a></li>
                </ul>
              </div>

              <div class="widget widget-custom-block">
                <h3 class="widget-title bb-no">Custom Block</h3>
                <div class="widget-body">
                  <p class="text-default mb-0">
                    Fringilla urna porttitor rhoncus dolor purus. Luctus
                    veneneratis lectus magna fring. Suspendisse potenti. Sed
                    egestas, ante et vulputate volutpat, uctus metus libero.
                  </p>
                </div>
              </div>

              <div class="widget widget-calendar">
                <h3 class="widget-title bb-no">Lịch</h3>
                <div class="widget-body">
                  <div class="calendar-container">
                    <v-container>
                      <v-row justify="space-around">
                        <v-date-picker
                          :model-value="date"
                          show-adjacent-months
                          show-week
                          elevation="4"
                        ></v-date-picker>
                      </v-row>
                    </v-container>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </aside>
      </div>
    </div>
  </div>
</template>
