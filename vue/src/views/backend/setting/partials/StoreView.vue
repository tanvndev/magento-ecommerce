<template>
  <a-typography-title :level="4">Cấu hình chung</a-typography-title>

  <a-card class="mt-3" title="Thông tin cửa hàng">
    <a-row :gutter="[16, 16]">
      <a-col span="12">
        <InputComponent name="name" label="Tên cửa hàng" placeholder="Nhập tên cửa hàng" />
      </a-col>
      <a-col span="12">
        <InputComponent name="company_name" label="Tên công ty" placeholder="Nhập tên công ty" />
      </a-col>
      <a-col span="12">
        <InputComponent name="slogan" label="Slogan" placeholder="Slogan" />
      </a-col>
      <a-col span="12">
        <InputComponent name="copyright" label="Copyright" placeholder="Copyright" />
      </a-col>
      <a-col span="24">
        <EditorComponent
          name="short_description"
          label="Giới thiệu ngắn"
          placeholder="Nhập giới thiệu ngắn"
        />
      </a-col>
      <a-col span="6">
        <div class="flex flex-col items-center justify-center">
          <h2 class="-ml-[10px] text-sm">Logo</h2>
          <InputFinderComponent name="logo" />
        </div>
      </a-col>
      <a-col span="6">
        <div class="flex flex-col items-center justify-center">
          <h2 class="-ml-[10px] text-sm">QR_APP</h2>
          <InputFinderComponent name="qr_app" />
        </div>
      </a-col>
      <a-col span="6">
        <div class="flex flex-col items-center justify-center">
          <h2 class="-ml-[10px] text-sm">Appstore App</h2>
          <InputFinderComponent name="appstore_image" />
        </div>
      </a-col>
      <a-col span="6">
        <div class="flex flex-col items-center justify-center">
          <h2 class="-ml-[10px] text-sm">Playstore App</h2>
          <InputFinderComponent name="playstore_image" />
        </div>
      </a-col>
    </a-row>
  </a-card>

  <a-card class="mt-3" title="Thông tin liên hệ">
    <a-row :gutter="[16, 16]">
      <a-col span="12">
        <InputComponent name="address" label="Địa chỉ" placeholder="Địa chỉ" />
      </a-col>
      <a-col span="12">
        <InputComponent name="email" label="Địa chỉ email" placeholder="Nhập địa chỉ email" />
      </a-col>
      <a-col span="12">
        <InputComponent name="hotline" label="Hotline" placeholder="Hotline" />
      </a-col>
      <a-col span="12">
        <InputComponent name="tax_code" label="Mã số thuế" placeholder="Mã số thuế" />
      </a-col>
      <a-col span="24">
        <InputComponent name="map" label="Bản đồ" typeInput="textarea" placeholder="Bản đồ" />
      </a-col>
    </a-row>
  </a-card>

  <a-card class="mt-3" title="Cấu hình SEO">
    <a-row :gutter="[16, 16]">
      <a-col span="12">
        <InputComponent name="meta_title" label="Tiêu đề SEO" placeholder="Tiêu đề SEO" />
      </a-col>
      <a-col span="12">
        <InputComponent name="meta_keyword" label="Từ khóa SEO" placeholder="Từ khóa SEO" />
      </a-col>
      <a-col span="12">
        <InputComponent name="meta_description" label="Mô tả SEO" placeholder="Mô tả SEO" />
      </a-col>
      <a-col span="24">
        <InputComponent name="meta_url" label="Đường dẫn" placeholder="Đường dẫn" />
      </a-col>
      <a-col span="12">
        <div class="flex flex-col items-center justify-center">
          <h2 class="-ml-[10px] text-sm">Ảnh SEO</h2>
          <InputFinderComponent name="meta_image" />
        </div>
      </a-col>
      <a-col span="12">
        <div class="flex flex-col items-center justify-center">
          <h2 class="-ml-[10px] text-sm">Favicon</h2>
          <InputFinderComponent name="favicon" />
        </div>
      </a-col>
    </a-row>
  </a-card>

  <a-card class="mt-3" title="Mạng xã hội">
    <a-row :gutter="[16, 16]">
      <a-col span="12">
        <InputComponent name="facebook" label="Facebook" placeholder="Facebook" />
      </a-col>
      <a-col span="12">
        <InputComponent name="twitter" label="Twitter" placeholder="Twitter" />
      </a-col>
      <a-col span="12">
        <InputComponent name="instagram" label="Instagram" placeholder="Instagram" />
      </a-col>
      <a-col span="12">
        <InputComponent name="youtube" label="Youtube" placeholder="Youtube" />
      </a-col>
      <a-col span="12">
        <InputComponent name="tiktok" label="Tiktok" placeholder="Tiktok" />
      </a-col>
      <a-col span="12">
        <InputComponent name="pinterest" label="Pinterest" placeholder="Pinterest" />
      </a-col>
      <a-col span="12">
        <InputComponent name="linkedin" label="Linkedin" placeholder="Linkedin" />
      </a-col>
      <a-col span="12">
        <InputComponent name="telegram" label="Telegram" placeholder="Telegram" />
      </a-col>
    </a-row>
  </a-card>
</template>

<script setup>
import { InputComponent, EditorComponent, InputFinderComponent } from '@/components/backend';
</script>
