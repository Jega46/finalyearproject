import "ant-design-vue/dist/antd.css";
import "../css/style.css";

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import Antd from 'ant-design-vue';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app = createApp(
            {
                render: () => h(App, props),
                provide: {
                    validateMessages: {
                        required: '${label} is required!',
                        types: {
                            email: '${label} is not a valid email!',
                            number: '${label} is not a valid number!',
                        },
                        number: {
                            range: '${label} must be between ${min} and ${max}',
                        },
                    }
                }
            })
            .use(plugin)
            .use(Antd)
            .use(ZiggyVue, Ziggy)
            .mount(el);
        return app;
    },
    progress: {
        color: '#4B5563',
    },
});


