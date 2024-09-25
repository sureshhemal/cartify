import defaultTheme from 'tailwindcss/defaultTheme'
import forms from '@tailwindcss/forms'
import typography from '@tailwindcss/typography'
import aspectRatio from '@tailwindcss/aspect-ratio'
import colors from 'tailwindcss/colors.js'

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './vendor/laravel/jetstream/**/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.vue',
  ],

  theme: {
    extend: {
      fontFamily: {
        sans: ['Figtree', ...defaultTheme.fontFamily.sans],
      },
    },

    colors: {
      ...colors,

      earthy: {
        100: '#A69080',
        200: '#AC8968',
        300: '#93785B',
        400: '#865D36',
        500: '#3E362E',
      },

      cosmic: {
        100: '#D3D9D4',
        200: '#748D92',
        300: '#124E66',
        400: '#2E3944',
        500: '#212A31',
      },

      clean: {
        100: '#FEFFFF',
        200: '#DEF2F1',
        300: '#3AAFA9',
        400: '#2B7A78',
        500: '#17252A',
      },
    },
  },

  plugins: [forms, typography, aspectRatio],
}
