/* eslint-env node */
module.exports = {
  root: true,
  extends: ["plugin:vue/vue3-essential", "eslint:recommended"],
  parserOptions: {
    ecmaVersion: "latest",
  },
  rules: {
    "no-unused-vars": [1, { args: "none" }],
  },
};
