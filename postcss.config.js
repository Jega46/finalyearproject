module.exports = {
    plugins: {
        tailwindcss: {},
        autoprefixer: {},
    },
    css: {
        loaderOptions: {
          less: {
            lessOptions: {
              modifyVars: {
                'primary-color': '#333',
                'link-color': '#333',
                'border-radius-base': '10px',
              },
              javascriptEnabled: true,
            },
          },
        },
      },
};
