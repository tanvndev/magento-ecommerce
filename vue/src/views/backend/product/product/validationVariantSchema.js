import * as yup from 'yup';
import { computed } from 'vue';
import store from '@/store';
const productType = computed(() => store.getters['productStore/getProductType']);

const validationVariantSchema = yup.object({
  name: yup.string().required('Tiêu đề sản phẩm không được để trống.'),
  product_type: yup.string().required('Loại sản phẩm không được để trống.'),
  product_catalogue_id: yup
    .mixed()
    .test(
      'is-string-or-array',
      'Vui lòng chọn nhóm sản phẩm.',
      (value) => typeof value === 'string' || Array.isArray(value)
    )
    .required('Vui lòng chọn nhóm sản phẩm.')
});

export default validationVariantSchema;
