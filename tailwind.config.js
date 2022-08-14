const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./node_modules/flowbite/**/*.js"
    ],

    theme: {
        linearGradientColors: theme => theme('colors'),
        radialGradientColors: theme => theme('colors'),
        conicGradientColors: theme => theme('colors'),
        extend: {
            keyframes: {
                wiggle: {
                    '0%, 100%': {transform: 'rotate(-3deg)'},
                    '50%': {transform: 'rotate(3deg)'},
                },
                fadeInX: {
                    '100%': {opacity: '1', transform: 'translateX(0px)'}
                },
                fadeInY: {
                    '100%': {opacity: '1', transform: 'translateY(0px)'}
                },
            },
            animation: {
                wiggle: 'wiggle 1s ease-in-out infinite',
                fadeInX: 'fadeInX 1s ease-in-out',
                fadeInY: 'fadeInY 1s ease-in-out'
            },
            scale: {
                '-1': '-1'
            },
            fontFamily: {
                sans: ['Roboto', 'Nunito', 'Poppins', 'Quicksand', ...defaultTheme.fontFamily.sans],
                cursive: ['Splash'],
            },
            colors: {
                nustil: {
                    DEFAULT: '#56B259',
                    '50': '#D4EBD5',
                    '100': '#C6E5C7',
                    '200': '#AAD8AC',
                    '300': '#8ECC90',
                    '400': '#72BF75',
                    '500': '#56B259',
                    '600': '#418F44',
                    '700': '#306831',
                    '800': '#1E421F',
                    '900': '#0C1B0D',
                    'purple': '#47293f'
                },
            }
        },
    },
    variants: {
        extend: {
            margin: ['hover', 'group-hover'],
            padding: ['hover', 'group-hover'],
            fill: ['hover', 'focus'],
            display: ["group-hover"],
            backgroundColor: ["checked"],
            backgroundPosition: ["hover", "group-hover"],
            borderColor: ["checked"],
            inset: ["checked"],
            zIndex: ["hover", "active"],
            transform: ["hover", "group-hover"],
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('@tailwindcss/aspect-ratio'),
        require('flowbite/plugin'),
        require('tailwindcss-gradients')

    ],
};
