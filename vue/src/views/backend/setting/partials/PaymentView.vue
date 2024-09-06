<template>
  <div class="flex items-center justify-between">
    <a-typography-title :level="4">Phương thức thanh toán</a-typography-title>

    <a-button type="primary" @click="handleOpenModal('')">
      <i class="far fa-plus mr-2"></i>
      Thêm mới
    </a-button>

    <a-modal v-model:open="state.openModal" width="1000px" title="Phương thức thanh toán">
      <form>
        <AleartError :errors="state.errors" />
        <a-row class="my-6" :gutter="[16, 16]">
          <div class="hidden">
            <InputComponent name="id" />
          </div>
          <a-col span="24">
            <InputComponent
              name="name"
              label="Tên phương thức thanh toán"
              placeholder="Nhập tên phương thức thanh toán"
            />
          </a-col>
          <a-col span="24">
            <InputComponent
              type-input="textarea"
              name="description"
              label="Mô tả phương thức thanh toán"
              placeholder="Nhập mô tả phương thức thanh toán"
            />
          </a-col>
          <a-col span="24">
            <label class="-mt-5 mb-2 block text-sm font-medium text-gray-900"
              >Ảnh phương thức thanh toán</label
            >
            <InputFinderComponent name="image" />
          </a-col>
        </a-row>
      </form>
      <template #footer>
        <a-button @click="onSubmit" type="primary">
          <span>Lưu lại</span>
        </a-button>

        <a-button @click="state.openModal = false">
          <span>Hủy bỏ</span>
        </a-button>
      </template>
    </a-modal>
  </div>

  <a-row :gutter="[16, 16]" class="mt-5">
    <a-col span="24" v-for="paymentMethod in state.paymentMethods" :key="paymentMethod.id">
      <div
        class="method-item flex items-center justify-between rounded-lg border p-4"
        @click.self="handleOpenModal(paymentMethod.id)"
      >
        <div>
          <div class="flex items-center">
            <div>
              <img
                class="rounded-lg object-cover"
                width="55"
                height="55"
                :src="paymentMethod.image"
                :alt="paymentMethod.name"
              />
            </div>
            <span class="mx-2 font-bold text-gray-700">{{ paymentMethod.name }}</span>
            <a-tag :color="paymentMethod.color">{{ paymentMethod.status }}</a-tag>
          </div>
          <p class="mb-1 mt-2 text-gray-500">{{ paymentMethod.description }}</p>
        </div>

        <div class="mr-4 text-center">
          <label class="switch">
            <input
              type="checkbox"
              @change="handleChangePublish($event, paymentMethod.id)"
              :checked="paymentMethod.publish == 1 ? true : false"
            />
            <span class="slider"></span>
          </label>
        </div>
      </div>
    </a-col>
    <a-col v-if="state.shippingMethods?.length == 0" span="24">
      <a-empty
        image="https://gw.alipayobjects.com/mdn/miniapp_social/afts/img/A*pevERLJC9v0AAAAAAAAAAABjAQAAAQ/original"
        :image-style="{
          height: '60px',
          display: 'inline-block',
          'text-align': 'center'
        }"
      >
        <template #description>
          <span> Chưa có dữ liệu. </span>
        </template>
      </a-empty>
    </a-col>
  </a-row>
</template>
<script setup>
import { AleartError, InputComponent, InputFinderComponent } from '@/components/backend';
import { BaseService } from '@/services';
import { message } from 'ant-design-vue';
import { onMounted, reactive } from 'vue';
import { useForm } from 'vee-validate';
import { useCRUD } from '@/composables';
import { formatMessages } from '@/utils/format';
import * as yup from 'yup';

const { update, create, getAll, getOne, messages, data } = useCRUD();

const state = reactive({
  openModal: false,
  errors: {},
  endpoint: 'payment-methods',
  paymentMethods: []
});

const { handleSubmit, setValues } = useForm({
  validationSchema: yup.object({
    name: yup.string().required('Tên phương thức thanh toán không được để trống.'),
    image: yup.string().required('Ảnh phương thức thanh toán không được để trống.')
  })
});

const onSubmit = handleSubmit(async (values, { resetForm }) => {
  const response = values.id
    ? await update(state.endpoint, values.id, values)
    : await create(state.endpoint, values);

  if (!response) {
    return (state.errors = formatMessages(messages.value));
  }

  message.success(messages.value);

  state.openModal = false;
  state.errors = {};

  resetForm();
  getAllPaymentMethods();
});

const handleOpenModal = async (id = null) => {
  console.log(id);

  if (id) {
    await getOne(state.endpoint, id);

    const { name = '', description = '', image = '' } = data.value || {};

    setValues({
      id,
      name,
      description,
      image
    });
  } else {
    setValues({
      id: '',
      name: '',
      description: '',
      image: []
    });
  }

  // Open the modal
  state.openModal = true;
};

const handleChangePublish = async (event, id) => {
  const payload = {
    modelName: 'PaymentMethod',
    modelId: id,
    field: 'publish',
    value: event.target.checked ? 1 : 2
  };

  const response = await BaseService.changeStatus(payload);
  const type = response.success ? 'success' : 'error';
  message[type](response.messages ?? 'Có lỗi vui lòng thử lại.');
  getAllPaymentMethods();
};

const getAllPaymentMethods = async () => {
  await getAll(state.endpoint);
  state.paymentMethods = data.value;
};

onMounted(getAllPaymentMethods);
</script>
<style scoped>
.method-item {
  transition: all 0.2s ease-in-out;
  cursor: pointer;
}
.method-item:hover {
  background: #f6f7f8;
  border-color: transparent;
  box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;
}
</style>
