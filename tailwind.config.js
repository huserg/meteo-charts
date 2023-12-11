const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        colors: {
            'light-blue': '#15E8DE',
            'blue': '#0083A4',
            'dark-blue': '#0B274D',
            'dark-gray': '#171615',
            'light': '#F9FFFE',
            'black': '#111',
        },
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    darkMode: 'class',

    plugins: [require('@tailwindcss/forms')],
};
