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
    extend: {},
  },
  plugins: [
    require('flowbite/plugin')
  ],
}