import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { Quasar, Notify, Dark } from 'quasar';
import quasarLang from 'quasar/lang/ja';

// Import icon libraries
import '@quasar/extras/roboto-font/roboto-font.css'
import '@quasar/extras/material-icons/material-icons.css'

// Import Quasar css
import 'quasar/src/css/index.sass'

// Enable dark mode by default if user prefers it
if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
    Dark.set(true);
}

createInertiaApp({
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(Quasar, {
                plugins: {
                    Notify,
                    Dark
                },
                lang: quasarLang,
                config: {
                    dark: 'auto' // 'auto' | true | false
                }
            })
            .mixin({ methods: { route } })
            .mount(el);
    }
});
