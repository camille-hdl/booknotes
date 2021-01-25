const colors = require('tailwindcss/colors');

module.exports = {
  purge: [
    './templates/**/*.html.twig',
    './templates/*.html.twig',
    './templates/**/*.html',
    './templates/*.html.twig'
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    container: {
      center: true,
      padding: '2rem',
    },
    extend: {
      colors: {
        linen: {
          light: "#FFF3E9",
          DEFAULT: "#FFF1E5",
          dark: "#FFCCA0"
        }
      }
    },
  },
  variants: {
    extend: {},
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
  fontFamily: {
    sans: ['ui-sans-serif', 'Open Sans', 'Graphik', 'sans-serif'],
    serif: ['ui-serif', 'Merriweather', 'Georgia', 'serif'],
  },
};
