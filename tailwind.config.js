/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./public/*.php"],
  theme: {
    extend: {
      height: {
        "40rem": "40rem",
        "50rem": "50rem",
        "60rem": "60rem",
      },
      maxWidth: {
        "4xl": "56rem",
      },
    },
  },
  plugins: [require("tailwindcss"), require("autoprefixer")],
};
