import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                serif: ['Cormorant Garamond', 'serif'],
            },
            colors: {
                vault: {
                    black: '#050505',
                    obsidian: '#101010',
                    stone: '#181818',
                    border: '#2a2620',
                },
                gold: {
                    soft: '#e8cf8a',
                    DEFAULT: '#CFAE45',
                    dark: '#8a712c',
                },
                ink: {
                    primary: '#f4f0e6',
                    secondary: '#9a978d',
                },
            },
            boxShadow: {
                gold: '0 0 30px rgba(207,174,69,0.25)',
                card: '0 10px 30px rgba(0,0,0,0.5)',
            },
        },
    },

    plugins: [forms],
};