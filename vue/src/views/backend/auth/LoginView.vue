<template>
  <a-row>
    <a-col span="10">
      <div
        class="coming-soom-image-container flex h-full w-full items-center justify-center bg-[#0162e84d]"
      >
        <img
          :src="`${LARAVEL_URL}/images/2024/07/loginpng_669bb542d3a1d.webp`"
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
                Bạn chưa có tài khoản?
                <RouterLink
                  :to="{ name: 'register' }"
                  class="font-medium text-blue-600 hover:text-blue-500"
                >
                  Đăng ký
                </RouterLink>
              </p>
            </div>
          </div>
          <form @submit.prevent="onSubmit">
            <AleartError :errors="errors" />
            <div class="mb-5">
              <InputComponent label="Địa chỉ email" name="email" type="text" />
            </div>
            <div>
              <InputComponent label="Mật khẩu" name="password" type="password" />
            </div>
            <button
              type="submit"
              class="mt-4 w-full rounded-lg bg-primary-600 px-4 py-2 font-medium text-white duration-150 hover:bg-primary-500 active:bg-primary-600"
            >
              Đăng nhập
            </button>
          </form>

          <div class="text-center">
            <RouterLink class="text-blue-600 hover:text-blue-500" :to="{ name: 'forgot' }"
              >Quên mật khẩu?</RouterLink
            >
          </div>
        </div>
      </div>
    </a-col>
  </a-row>
</template>
<script setup>
import { InputComponent, AleartError } from '@/components/backend';
import { useForm } from 'vee-validate';
import * as yup from 'yup';
import { ref } from 'vue';
import { RouterLink } from 'vue-router';
import router from '@/router';
import { useStore } from 'vuex';
import { formatMessages } from '@/utils/format';
import { LARAVEL_URL } from '@/static/constants';

const store = useStore();
const errors = ref({});


// VALIDATION
const { handleSubmit } = useForm({
  validationSchema: yup.object({
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
  errors.value = {};
  await store.dispatch('authStore/login', values);
  const authState = store.state.authStore;
  if (!authState.status.loggedIn) {
    return (errors.value = formatMessages(authState.messages));
  }

  store.dispatch('antStore/showMessage', { type: 'success', message: 'Đăng nhập thành công.' });
  router.push({ name: 'dashboard' });
});
</script>
