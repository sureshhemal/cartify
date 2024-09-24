module.exports = {
  root: true,
  env: {
    node: true,
  },
  extends: [
    'plugin:vue/recommended',
  ],
  rules: {
    semi: [2, 'never'],
    indent: ['error', 2],
    quotes: ['error', 'single'],
    'linebreak-style': ['error', 'unix'],
    'object-curly-spacing': ['error', 'always'],
    'comma-dangle': ['error', 'always-multiline'],
    'arrow-parens': ['error', 'as-needed'],
    'vue/component-name-in-template-casing': ['error', 'PascalCase'],
    'prefer-arrow-callback': ['error', { 'allowNamedFunctions': false }],
    'arrow-spacing': ['error', { 'before': true, 'after': true }],
  },
  overrides: [
    {
      files: ['**/__tests__/*.{j,t}s?(x)'],
      env: {
        mocha: true,
      },
    },
  ],
}
