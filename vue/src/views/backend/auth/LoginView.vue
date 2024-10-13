<template>
  <a-row>
    <a-col span="10">
      <div
        class="coming-soom-image-container flex h-full w-full items-center justify-center bg-[#0162e84d]"
      >
        <img :src="'/src/assets/images/loginpng.webp'" alt="" class="imig-fluid" />
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
              <InputComponent
                label="Địa chỉ email"
                name="email"
                type="text"
                placeholder="Nhập địa chỉ email của bạn"
              />
            </div>
            <div>
              <InputComponent
                label="Mật khẩu"
                name="password"
                type="password"
                placeholder="*************"
              />
            </div>
<<<<<<< HEAD
=======
            <div class="mt-2 flex items-center justify-between">
              <div>
                <RouterLink
                  class="text-[13px] text-blue-600 hover:text-blue-500"
                  :to="{ name: 'forgot' }"
                  >Quên mật khẩu?</RouterLink
                >
              </div>

              <div>
                <RouterLink
                  class="text-[13px] text-blue-600 hover:text-blue-500"
                  :to="{ name: 'login.otp' }"
                  >Đăng nhập với SMS</RouterLink
                >
              </div>
            </div>

            <!-- Thêm reCAPTCHA ở đây -->
            <RecaptchaComponent />

>>>>>>> 28ac521f371fe1d69daf3422cd40b3245b2bcee1
            <button
              type="submit"
              class="mt-4 w-full rounded-lg bg-primary-600 px-4 py-2 font-medium text-white duration-150 hover:bg-primary-500 active:bg-primary-600"
            >
              Đăng nhập
            </button>
          </form>

          <div className="relative">
            <span className="block w-full h-px bg-gray-300"></span>
            <p
              className="inline-block w-fit text-sm bg-white px-2 absolute -top-2 inset-x-0 mx-auto uppercase"
            >
              Hoặc
            </p>
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
import { message } from 'ant-design-vue';
import { NUXT_URL } from '@/static/constants';

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
<<<<<<< HEAD
  await store.dispatch('authStore/login', values);
=======

  // eslint-disable-next-line no-undef
  const recaptchaResponse = grecaptcha.getResponse();

  if (!recaptchaResponse) {
    
    return message.error('Vui lòng xác nhận bạn không phải là robot.');
  }

  const formData = {
    ...values,
    'g-recaptcha-response': recaptchaResponse
  };

  await store.dispatch('authStore/login', formData);
>>>>>>> 28ac521f371fe1d69daf3422cd40b3245b2bcee1
  const authState = store.state.authStore;
  if (!authState.status.loggedIn) {
    return (errors.value = formatMessages(authState.messages));
  }

  message.success('Đăng nhập thành công.');
  if (authState.user?.user_catalogue === 'admin') {
    return router.push({ name: 'dashboard' });
  }
  window.location.href = NUXT_URL;
});
</script>
