import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                primary: "#1E40AF",   // Blue
                secondary: "#FACC15", // Yellow
                light: "#FFFFFF",     // White
                muted: "#F3F4F6",     // Light gray background
            },
        },
    },
    plugins: [
        forms,
    ],
};
