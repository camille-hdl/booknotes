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
  plugins: [],
  fontFamily: {
    sans: ['ui-sans-serif', 'Open Sans', 'Graphik', 'sans-serif'],
    serif: ['ui-serif', 'Merriweather', 'Georgia', 'serif'],
  },
};
