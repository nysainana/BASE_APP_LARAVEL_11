import defaultTheme from 'tailwindcss/defaultTheme';
import AntdvTheme from './resources/js/Theme/antdv-theme.js';
import { createRequire } from 'module';
const require = createRequire(import.meta.url);
const plugin = require('tailwindcss/plugin');

const mainComponentsPlugin = plugin(({ addComponents, theme }) => {
  addComponents({
    '.main-shadow': {
      boxShadow: theme('boxShadow.sm'),
      '--tw-shadow-color': theme('colors.gray.200'),
    },
    '.main-rounded': {
      borderRadius: `${AntdvTheme.token.borderRadius}px`,
      overflow: 'hidden',
    },
    '.main-border': {
      borderColor: theme('colors.gray.200'),
      '&:hover': {
        borderColor: theme('colors.gray.200'),
      },
    },
    '.main-hover': {
      '&:hover': {
        backgroundColor: theme('colors.gray.100'),
      },
    },
  });
});

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.vue',
  ],

  theme: {
    extend: {
      fontFamily: {
        sans: ['Figtree', ...defaultTheme.fontFamily.sans],
      },
      screens: {
        sm: '576px',
        md: '768px',
        lg: '992px',
        xl: '1200px',
        '2xl': '1600px',
      },
      colors: {
        primary: AntdvTheme.token.colorPrimary,
        'text-primary': AntdvTheme.token.colorText,
      },
    },
  },

  plugins: [mainComponentsPlugin],
  darkMode: 'class',
};
