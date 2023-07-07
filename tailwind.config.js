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
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                customDarkGreen: '#6B9080',
                customLightGreen: '#A4C3B2',
                customGrayGreen: '#CCE3DE',
                customWhite: '#F6FFF8',
                customGray: '#EAF4F4',
            },
        },
    },
    safelist: [
        {
            pattern: /bg-+/,
            variants: ['hover', 'focus', 'active'],
        },
        {
            pattern: /^text-.+$/,
            variants: ['hover', 'focus', 'active'],
        },
        {
            pattern: /^leading-.+$/,
        },
        {
            pattern: /^tracking-.+$/,
        },
        {
            pattern: /^font-.+$/,
        },
        {
            pattern: /^(m|my|mx|mt|mr|mb|ml)-.+$/,
        },
        {
            pattern: /^(p|py|px|pt|pr|pb|pl)-.+$/,
        },
    ],
    plugins: [forms, typography],
};
