<template>
  <a-row>
    <a-col span="10">
      <div
        class="coming-soom-image-container flex h-full w-full items-center justify-center bg-[#0162e84d]"
      >
        <img
          :src="`${LARAVEL_URL}/images/2024/07/registerpng_669bc58c82ee7.webp`"
          alt=""
          class="imig-fluid"
        />
      </div>
    </a-col>
    <a-col span="14">
      <div class="flex h-screen w-full flex-col items-center justify-center px-4">
        <div class="w-full max-w-sm space-y-8 text-gray-600">
          <div class="text-center">
            <img src="https://floatui.com/logo.svg" width="150" class="mx-auto" />
            <div class="mt-5 space-y-2">
              <h3 class="text-2xl font-bold text-gray-800 sm:text-3xl">Đăng nhập tài khoản</h3>
              <p class="">
                Bạn đã có tài khoản?

                <RouterLink
                  :to="{ name: 'login' }"
                  class="font-medium text-blue-600 hover:text-blue-500"
                >
                  Đăng nhập
                </RouterLink>
              </p>
            </div>
          </div>
          <form @submit.prevent="onSubmit">
            <AleartError :errors="state.errors" />
            <div class="mb-5">
              <InputComponent label="Họ và tên" name="fullname" type="text" />
            </div>
            <div class="mb-5">
              <InputComponent label="Địa chỉ email" name="email" type="text" />
            </div>
            <div>
              <InputComponent label="Mật khẩu" name="password" type="password" />
            </div>
            <a-button
              :loading="state.loading"
              type="primary"
              size="large"
              html-type="submit"
              class="mt-4 w-full"
            >
              Đăng ký ngay
            </a-button>
          </form>
        </div>
      </div>
    </a-col>
  </a-row>
</template>
<script setup>
import { InputComponent, AleartError } from '@/components/backend';
import { useForm } from 'vee-validate';
import * as yup from 'yup';
import { reactive } from 'vue';
import { RouterLink } from 'vue-router';
import router from '@/router';
import { formatMessages } from '@/utils/format';
import { AuthService } from '@/services';
import { useAntToast } from '@/utils/antToast';
import { LARAVEL_URL } from '@/static/constants';

// STATE
const laravelUrl = import.meta.env.VITE_LARAVEL_URL;
const state = reactive({
  errors: {},
  loading: false
});

const { showMessage } = useAntToast();

// VALIDATION
const { handleSubmit } = useForm({
  validationSchema: yup.object({
    fullname: yup.string().required('Họ và tên không được để trống.'),
    email: yup
      .string()
      .email('Email không đúng định dạng email.')
      .required('Email không được để trống.'),
    password: yup
      .string()
      .min(6, 'Mật khẩu phải có ít nhất 6 ký tự.')
      .required('Mật khẩu không được để trống.')
  })
});

// SUBMIT FORM HANDLE
const onSubmit = handleSubmit(async (values) => {
  state.errors = {};
  state.loading = true;

  const response = await AuthService.register(values);

  if (!response.success) {
    state.loading = false;
    return (state.errors = formatMessages(response.messages));
  }

  state.loading = false;
  showMessage('success', response.messages);
  router.push({ name: 'login' });
});
</script>
