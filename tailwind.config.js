const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            css: {
                loaderOptions: {
                  less: {
                    lessOptions: {
                      modifyVars: {
                        'primary-color': '#f6b26b',
                        'link-color': '#f6b26b',
                        'border-radius-base': '10px',
                      },
                      javascriptEnabled: true,
                    },
                  },
                },
              },
        },
        
    },

    plugins: [require('@tailwindcss/forms')],
  
};
