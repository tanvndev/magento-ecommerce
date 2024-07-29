<template>
  <main class="flex h-screen w-full flex-col items-center justify-center px-4">
    <div class="w-full max-w-sm space-y-5 text-gray-600">
      <div class="pb-8 text-center">
        <img src="https://floatui.com/logo.svg" width="150" class="mx-auto" />
        <div class="mt-5">
          <h3 class="text-2xl font-bold text-gray-800 sm:text-3xl">Lấy lại mật khẩu của bạn</h3>
        </div>
      </div>
      <form @submit.prevent="onSubmit">
        <AleartError :errors="state.errors" />
        <div class="mb-5">
          <InputComponent label="Địa chỉ email" name="email" type="text" />
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
      <p class="text-center">
        Bạn muốn đăng nhập tài khoản?
        <RouterLink :to="{ name: 'login' }" class="font-medium text-blue-600 hover:text-blue-500"
          >Đăng nhập</RouterLink
        >
      </p>
    </div>
  </main>
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

const { showMessage } = useAntToast();

// STATE
const state = reactive({
  loading: false,
  errors: {}
});

// VALIDATION
const { handleSubmit } = useForm({
  validationSchema: yup.object({
    email: yup
      .string()
      .email('Email không đúng định dạng email.')
      .required('Email không được để trống.')
  })
});

// SUBMIT FORM HANDLE
const onSubmit = handleSubmit(async (values) => {
  state.errors = {};
  state.loading = true;

  const response = await AuthService.forgot(values);

  if (!response.success) {
    state.loading = false;
    return (state.errors = formatMessages(response.messages));
  }

  state.loading = false;
  showMessage('success', response.messages);
  router.push({ name: 'login' });
});
</script>
