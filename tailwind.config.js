import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

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
                sans: ['Space Grotesk', ...defaultTheme.fontFamily.sans],
                spacegrotesk: ['Space Grotesk', 'sans-serif'],
                inter: ['Inter', 'sans-serif'],
                manrope: ['Manrope', 'sans-serif'],

            },
            colors: {
                'background': '#131313',
                'text-secondary': '#ABABAD',

                'primary-cyan': {
                    100: '#00D1FF',
                    200: '#00BAE3',
                    300: '#00A3C6',
                    400: '#008BAA',
                    500: '#00748E',
                    600: '#005D71',
                    700: '#004655',
                    800: '#002E39',
                    900: '#00171C',
                },

                'secondary-gray-blue': {
                    100: '#607D8B',
                    200: '#455A64',
                    300: '#37474F',
                    400: '#263238',
                    500: '#212121',
                    600: '#1B1B1B',
                    700: '#141414',
                    800: '#0E0E0E',
                    900: '#070707',
                },
            },
        },
    },

    plugins: [forms, typography],
};
