/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
         "./node_modules/flowbite/**/*.js"
  ],
  darkMode: 'class', // Enable dark mode with a custom class
  theme: {
    extend: {
      gridTemplateColumns: {
        '13': 'repeat(13, minmax(0, 1fr))', // Creates 13 equal columns
      },
    },
  },
  plugins: [
    require('flowbite/plugin')
  ],
}
