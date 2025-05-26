/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./backend/templates/**/*.{html,twig}",
    "./backend/templates/**/*.html.twig",
    "./assets/js/**/*.js",
    "./backend/public/**/*.html",
    "./**/*.html"
  ],
  theme: {
    extend: {
      fontFamily: {
        'sans': ['Inter', 'ui-sans-serif', 'system-ui'],
      },
    },
  },
  plugins: [],
}
