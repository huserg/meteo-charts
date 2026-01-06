const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        colors: {
            'transparent': 'transparent',
            'current': 'currentColor',
            'light-blue': '#15E8DE',
            'blue': '#0083A4',
            'dark-blue': '#0B274D',
            'dark-gray': '#171615',
            'light': '#F9FFFE',
            'black': '#111',
            'white': '#ffffff',
            'red': {
                400: '#f87171',
                500: '#ef4444',
            },
            'yellow': {
                300: '#fde047',
            },
            'green': {
                500: '#22c55e',
            },
        },
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    darkMode: 'class',

    plugins: [require('@tailwindcss/forms')],
};
