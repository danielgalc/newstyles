import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.jsx',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                righteous: ['Righteous', 'cursive'],
                inter: ['Inter', 'regular'],
            },
            fontSize: {
                'custom-size': '24px', // Tamaño de fuente personalizado
            },
        },
    },

    plugins: [forms],
};
