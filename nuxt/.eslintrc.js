module.exports = {
    extends: [
      'eslint:recommended',
      'plugin:vue/essential',
      'plugin:prettier/recommended' // Kích hoạt các quy tắc Prettier cho ESLint
    ],
    plugins: ['prettier'],
    rules: {
      'prettier/prettier': ['error'], // Hiển thị lỗi nếu mã nguồn không tuân theo quy tắc Prettier
    },
    // Các thiết lập khác tùy thuộc vào nhu cầu của bạn
  }
