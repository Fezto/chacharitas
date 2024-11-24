import defaultTheme from 'tailwindcss/defaultTheme';
import preset from './vendor/filament/support/tailwind.config.preset';
/** @type {import('tailwindcss').Config} */
export default {
    presets: [preset],
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                "patrick-hand": ['Patrick Hand', 'sans-serif'],
            },
            colors: {
                lila: '#a079b6', // Agregando color personalizado
                lilac: '#b5a5c0'
            },
        },
    },
    plugins: [require('daisyui')],
    daisyui: {
        themes: [
            {
                babyshop: {
                    "primary": "#f1cad0",
                    "secondary": "#B0E0E6",
                    "accent": "#e9deef",
                    "neutral": "#FAFAFA",
                    "base-100": "#FFFFFF",
                    "info": "#B0E0E6",
                    "success": "#C1E1C1",
                    "warning": "#FFE4B5",
                    "error": "#FFB6B6",
                },
            },
        ],
    }
};
