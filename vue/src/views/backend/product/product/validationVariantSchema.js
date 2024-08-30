import * as yup from 'yup';

const validationVariantSchema = yup.object({
  'variable[name]': yup.string().required('Tên phiên bản không được để trống.'),
  'variable[sku]': yup.string().required('SKU không được để trống.'),
  'variable[weight]': yup
    .number()
    .transform((value, originalValue) => (originalValue === '' ? null : value))
    .required('Cân nặng không được để trống.')
    .positive('Cân nặng phải là số dương.'),
  'variable[length]': yup
    .number()
    .transform((value, originalValue) => (originalValue === '' ? null : value))
    .required('Chiều dài không được để trống.')
    .positive('Chiều dài phải là số dương.'),
  'variable[width]': yup
    .number()
    .transform((value, originalValue) => (originalValue === '' ? null : value))
    .required('Chiều rộng không được để trống.')
    .positive('Chiều rộng phải là số dương.'),
  'variable[height]': yup
    .number()
    .transform((value, originalValue) => (originalValue === '' ? null : value))
    .required('Chiều cao không được để trống.')
    .positive('Chiều cao phải là số dương.'),
  'variable[stock]': yup
    .number()
    .transform((value, originalValue) => (originalValue === '' ? null : value))
    .required('Số lượng không được để trống.')
    .integer('Số lượng phải là số nguyên.')
    .min(0, 'Số lượng không thể âm.'),
  'variable[cost_price]': yup
    .number()
    .positive('Giá nhập phải là một số dương lớn hơn 0.')
    .nullable()
    .test('check-cost-price', 'Giá nhập không được để trống.', function (value) {
      return value !== undefined && value !== null;
    }),
  'variable[price]': yup
    .number()
    .positive('Giá bán phải là một số dương lớn hơn 0.')
    .required('Giá bán không được để trống.'),

  'variable[sale_price]': yup
    .number()
    .transform((value, originalValue) => (originalValue === '' ? null : value))
    .positive('Giá ưu đãi phải là một số dương lớn hơn 0.')
    .nullable()
    .test('is-less-than-price', 'Giá ưu đãi phải nhỏ hơn giá bán.', function (value) {
      const price = this.parent['variable[price]'];
      return value === null || value === undefined || value < price;
    }),
  'variable[image]': yup.string().required('Ảnh không được để trống.'),
  'variable[album]': yup.string().required('Thư viện ảnh không được để trống.')
});

export default validationVariantSchema;
