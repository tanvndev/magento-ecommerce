<template>
  <div class="flex items-center justify-between">
    <a-typography-title :level="4">Hình thức vận chuyển</a-typography-title>

    <a-button type="primary" @click="handleOpenModal('')">
      <i class="far fa-plus mr-2"></i>
      Thêm mới
    </a-button>

    <a-modal v-model:open="state.openModal" width="1000px" title="Hình thức vận chuyển">
      <form>
        <AleartError :errors="state.errors" />
        <a-row class="my-6" :gutter="[16, 16]">
          <div class="hidden">
            <InputComponent name="id" />
          </div>
          <a-col span="24">
            <InputComponent
              name="name"
              label="Tên hình thức vận chuyển"
              placeholder="Nhập tên hình thức vận chuyển"
            />
          </a-col>
          <a-col span="24">
            <InputNumberComponent
              name="base_cost"
              label="Phí thức vận chuyển gốc"
              placeholder="Nhập phí hình thức vận chuyển gốc"
            />
          </a-col>
          <a-col span="24">
            <InputComponent
              type-input="textarea"
              name="description"
              label="Mô tả hình thức vận chuyển"
              placeholder="Nhập mô tả hình thức vận chuyển"
            />
          </a-col>
          <a-col span="24">
            <label class="-mt-5 mb-2 block text-sm font-medium text-gray-900"
              >Ảnh hình thức vận chuyển</label
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
    <a-col span="24" v-for="shippingMethod in state.shippingMethods" :key="shippingMethod.id">
      <div
        class="method-item flex items-center justify-between rounded-lg border p-4"
        @click.self="handleOpenModal(shippingMethod.id)"
      >
        <div>
          <div class="flex items-center">
            <div>
              <img
                class="rounded-lg object-cover"
                width="55"
                height="55"
                :src="shippingMethod.image"
                :alt="shippingMethod.name"
              />
            </div>
            <span class="mx-2 font-bold text-gray-700">{{ shippingMethod.name }}</span>
            <a-tag :color="shippingMethod.color">{{ shippingMethod.status }}</a-tag>
            <a-tag>{{ formatCurrency(shippingMethod.base_cost) }}</a-tag>
          </div>

          <p class="mb-1 mt-2 text-gray-500">{{ shippingMethod.description }}</p>
        </div>

        <div class="mr-4 text-center">
          <label class="switch">
            <input
              type="checkbox"
              @change="handleChangePublish($event, shippingMethod.id)"
              :checked="shippingMethod.publish == 1 ? true : false"
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
import {
  AleartError,
  InputComponent,
  InputFinderComponent,
  InputNumberComponent
} from '@/components/backend';
import { BaseService } from '@/services';
import { message } from 'ant-design-vue';
import { onMounted, reactive } from 'vue';
import { useForm } from 'vee-validate';
import { useCRUD } from '@/composables';
import { formatCurrency, formatMessages } from '@/utils/format';
import * as yup from 'yup';

const { update, create, getAll, getOne, messages, data } = useCRUD();

const state = reactive({
  openModal: false,
  errors: {},
  endpoint: 'shipping-methods',
  shippingMethods: []
});

const { handleSubmit, setValues } = useForm({
  validationSchema: yup.object({
    name: yup.string().required('Tên hình thức vận chuyển không được để trống.'),
    image: yup.string().required('Ảnh hình thức vận chuyển không được để trống.'),
    base_cost: yup.string().required('Phí gốc hình thức vận chuyển không được để trống.')
  })
});

const onSubmit = handleSubmit(async (values, { resetForm }) => {
  console.log(values);

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
  if (id) {
    await getOne(state.endpoint, id);

    const { name = '', description = '', image = '', base_cost = '' } = data.value || {};

    setValues({
      id,
      name,
      description,
      image,
      base_cost
    });
  } else {
    setValues({
      id: '',
      name: '',
      description: '',
      base_cost: '',
      image: []
    });
  }

  // Open the modal
  state.openModal = true;
};

const handleChangePublish = async (event, id) => {
  const payload = {
    modelName: 'ShippingMethod',
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
  state.shippingMethods = data.value;
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
