import * as yup from 'yup';
import { computed } from 'vue';
import store from '@/store';
const productType = computed(() => store.getters['productStore/getProductType']);

const validationSchema = yup.object({
  name: yup.string().required('Tiêu đề sản phẩm không được để trống.'),
  product_type: yup.string().required('Loại sản phẩm không được để trống.'),
  image: yup.string().required('Ảnh sản phẩm không được để trống.'),
  album: yup.string().required('Thư viện sản phẩm không được để trống.'),
  product_catalogue_id: yup
    .mixed()
    .test(
      'is-string-or-array',
      'Vui lòng chọn nhóm sản phẩm.',
      (value) => typeof value === 'string' || (Array.isArray(value) && value.length > 0)
    )
    .required('Vui lòng chọn nhóm sản phẩm.'),
  cost_price: yup
    .number()
    .positive('Giá nhập phải là một số dương lớn hơn 0.')
    .nullable()
    .test('check-cost-price', 'Giá nhập không được để trống.', function (value) {
      if (productType.value) {
        return value !== undefined && value !== null;
      }
      return true;
    }),
  price: yup
    .number()
    .positive('Giá bán phải là một số dương lớn hơn 0.')
    .nullable()
    .test('check-price', 'Giá bán không được để trống.', function (value) {
      if (productType.value) {
        return value !== undefined && value !== null;
      }
      return true;
    }),
  sale_price: yup
    .number()
    .positive('Giá ưu đãi phải là một số dương lớn hơn 0.')
    .nullable()
    .test('is-less-than-price', 'Giá ưu đãi phải nhỏ hơn giá bán.', function (value) {
      const { price } = this.parent;
      return !value || value < price;
    })
});

export default validationSchema;
