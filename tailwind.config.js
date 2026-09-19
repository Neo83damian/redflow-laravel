/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './public/js/*.js',
    ],
    theme: {
        extend: {
            colors: {
                // Matches the navy + medical-red palette already defined as
                // CSS custom properties in public/css/app-legacy.css, so any
                // NEW markup built with Tailwind utility classes can stay on
                // the same brand colors (e.g. bg-redflow-red, text-redflow-navy).
                'redflow-red': '#c0392b',
                'redflow-navy': '#1a2b4c',
            },
        },
    },
    plugins: [],
};
