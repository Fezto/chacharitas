import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                "patrick-hand": ['Patrick Hand', 'sans-serif'],
            },
        },
    },
    plugins: [require('daisyui')],
    daisyui: {
        themes: [
            {
                babyshop: {
                    "primary": "#f1cad0", // Un rosa pastel más suave
                    "secondary": "#B0E0E6", // Un azul pastel más claro
                    "accent": "#FFFACD", // Un amarillo pastel más suave
                    "neutral": "#FAFAFA", // Un gris muy claro para un fondo más suave
                    "base-100": "#FFFFFF", // Blanco puro para mantener la claridad y simplicidad
                    "info": "#B0E0E6", // Azul pastel para un tono amigable e informativo
                    "success": "#C1E1C1", // Un verde pastel más suave
                    "warning": "#FFE4B5", // Un tono durazno pastel más suave
                    "error": "#FFB6B6", // Un rojo pastel más suave
                },
            },
        ],

    }
};
