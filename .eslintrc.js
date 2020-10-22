module.exports = {
    root: true,
    env: {
        node: true,
        browser: true,
    },
    extends: [
        "plugin:vue/recommended",
        "eslint:recommended",
        "prettier/vue",
        "plugin:prettier/recommended",
    ],
    rules: {
        "vue/component-name-in-template-casing": ["error", "PascalCase"],
    },
    globals: {
        Atomics: "readonly",
        SharedArrayBuffer: "readonly",
    },
    parserOptions: {
        parser: "babel-eslint",
    },
};
