import '../css/app.css';
import './bootstrap';
import './Icons/icons';
import 'vue3-perfect-scrollbar/style.css';
import "vue3-colorpicker/style.css";

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import AntdvTheme from "@/Theme/antdv-theme.js";
import { PerfectScrollbarPlugin } from 'vue3-perfect-scrollbar';
import Vue3ColorPicker from "vue3-colorpicker";
import VueApexCharts from "vue3-apexcharts";

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(PerfectScrollbarPlugin)
            .use(Vue3ColorPicker)
            .use(VueApexCharts)
            .component('font-awesome-icon', FontAwesomeIcon)
            .mount(el);
    },
    progress: {
        color: AntdvTheme.token.colorPrimary
    },
});
