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
                'background-black': '#0E0E0E',
                'background-item': '#ADAAAA',
                'background-section': "#1A1919",

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

                'error-red': {
                    100: '#FF716C',
                    200: '#FF4A44',
                    300: '#FF231B',
                    400: '#F20800',
                    500: '#CA0700',
                    600: '#A10500',
                    700: '#790400',
                    800: '#510300',
                    900: '#280100',
                },

                'success-green': {
                    100: '#6CFF72',
                    200: '#44FF4B',
                    300: '#1BFF25',
                    400: '#00F20A',
                    500: '#00CA08',
                    600: '#00A107',
                    700: '#007905',
                    800: '#005103',
                    900: '#002802',
                },

            },
        },
    },

    plugins: [forms, typography],
};
