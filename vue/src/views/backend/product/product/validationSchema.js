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

const validationVariantSchema = yup.object({
  variable_name: yup.string().required('Tên phiên bản không được để trống.'),
  variable_sku: yup.string().required('SKU không được để trống.'),
  variable_weight: yup
    .number()
    .transform((value, originalValue) => (originalValue === '' ? null : value))
    .required('Cân nặng không được để trống.')
    .positive('Cân nặng phải là số dương.'),
  variable_length: yup
    .number()
    .transform((value, originalValue) => (originalValue === '' ? null : value))
    .required('Chiều dài không được để trống.')
    .positive('Chiều dài phải là số dương.'),
  variable_width: yup
    .number()
    .transform((value, originalValue) => (originalValue === '' ? null : value))
    .required('Chiều rộng không được để trống.')
    .positive('Chiều rộng phải là số dương.'),
  variable_height: yup
    .number()
    .transform((value, originalValue) => (originalValue === '' ? null : value))
    .required('Chiều cao không được để trống.')
    .positive('Chiều cao phải là số dương.'),
  variable_stock: yup
    .number()
    .transform((value, originalValue) => (originalValue === '' ? null : value))
    .required('Số lượng không được để trống.')
    .integer('Số lượng phải là số nguyên.')
    .min(0, 'Số lượng không thể âm.'),
  variable_cost_price: yup
    .number()
    .positive('Giá nhập phải là một số dương lớn hơn 0.')
    .nullable()
    .test('check-cost-price', 'Giá nhập không được để trống.', function (value) {
      return value !== undefined && value !== null;
    }),
  variable_price: yup
    .number()
    .positive('Giá bán phải là một số dương lớn hơn 0.')
    .required('Giá bán không được để trống.'),

  variable_sale_price: yup
    .number()
    .transform((value, originalValue) => (originalValue === '' ? null : value))
    .positive('Giá ưu đãi phải là một số dương lớn hơn 0.')
    .nullable()
    .test('is-less-than-price', 'Giá ưu đãi phải nhỏ hơn giá bán.', function (value) {
      const price = this.parent['variable_price'];
      return value === null || value === undefined || value < price;
    }),
  variable_image: yup.string().required('Ảnh không được để trống.'),
  variable_album: yup.string().required('Thư viện ảnh không được để trống.')
});

export { validationSchema, validationVariantSchema };
