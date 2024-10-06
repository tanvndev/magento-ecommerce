<script setup></script>
<template>
  <div class="page-content mt-10">
    <div class="container">
      <ul class="nav-filters filter-underline blog-filters mb-4">
        <li>
          <a href="#" class="nav-filter active">
            All Posts
            <span>6</span>
          </a>
        </li>
        <li>
          <a href="#" class="nav-filter">
            Clothes
            <span>1</span>
          </a>
        </li>
      </ul>

      <div class="row grid cols-lg-3 cols-md-2 mb-2">
        <div class="grid-item" v-for="item in 9" :key="item">
          <article class="post post-mask overlay-zoom br-sm">
            <figure class="post-media">
              <a href="post-single.html">
                <img
                  src="assets/images/blog/2cols/1.jpg"
                  width="600"
                  height="420"
                  alt="blog"
                />
              </a>
            </figure>
            <div class="post-details">
              <div class="post-details-visible">
                <div class="post-cats">
                  <a href="#">Fashion</a>
                </div>
                <h4 class="post-title text-white">
                  <a href="#">New found the men dress for summer</a>
                </h4>
              </div>
              <div class="post-meta">
                by <a href="#" class="post-author">John Doe</a> -
                <a href="#" class="post-date">03.05.2021</a>
                <a href="#" class="post-comment">0 Comments</a>
              </div>
            </div>
          </article>
        </div>
      </div>
      <ul class="pagination justify-content-center mb-10 pb-2 pt-2 mt-8">
        <li class="prev disabled">
          <a href="#" aria-label="Previous" tabindex="-1" aria-disabled="true">
            <i class="w-icon-long-arrow-left"></i>Prev
          </a>
        </li>
        <li class="page-item active">
          <a class="page-link" href="#">1</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="#">2</a>
        </li>
        <li class="next">
          <a href="#" aria-label="Next">
            Next<i class="w-icon-long-arrow-right"></i>
          </a>
        </li>
      </ul>
    </div>
  </div>
</template>
