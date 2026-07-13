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
                display: ['Montserrat', ...defaultTheme.fontFamily.sans],
                mono: ['JetBrains Mono', ...defaultTheme.fontFamily.mono],
            },
            colors: {
                ink: {
                    DEFAULT: '#0A0A0C',
                    '000': '#050507',
                    deep: '#0A0A0C',
                    card: '#18181C',
                    elev: '#232328',
                },
                paper: {
                    DEFAULT: '#F4F4F0',
                    soft: '#C9C9C2',
                    mute: '#80807A',
                    deep: '#5A5A55',
                },
                purple: {
                    DEFAULT: '#7C3AED',
                    soft: '#A78BFA',
                    deep: '#5B21B6',
                },
            },
            maxWidth: {
                container: '1340px',
                'container-wide': '1480px',
                'container-narrow': '1080px',
            },
        },
    },

    plugins: [forms],
};
