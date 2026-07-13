import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    50: '#eef2ff',
                    100: '#e0e7ff',
                    500: '#6366f1',
                    600: '#4F46E5',
                    700: '#4338ca',
                },
                accent: {
                    500: '#F59E0B',
                },
                success: {
                    500: '#10B981',
                },
                danger: {
                    500: '#EF4444',
                },
            },
            boxShadow: {
                soft: '0 2px 12px rgba(0, 0, 0, 0.06)',
                card: '0 4px 20px rgba(0, 0, 0, 0.08)',
            },
            borderRadius: {
                xl2: '18px',
            },
        },
    },

    plugins: [forms],
};