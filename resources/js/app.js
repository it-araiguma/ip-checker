import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { Quasar, Notify, Dark } from 'quasar';
import quasarLang from 'quasar/lang/ja';

// Import icon libraries
import '@quasar/extras/roboto-font/roboto-font.css'
import '@quasar/extras/material-icons/material-icons.css'

// Import Quasar css
import 'quasar/src/css/index.sass'

// デフォルトではダークモードを無効にする
Dark.set(false);

// ユーザーがダークモードを好む場合のみ有効にする（コメントアウト）
// if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
//     Dark.set(true);
// }

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
                    dark: false // 'auto' | true | false
                }
            })
            .mixin({ methods: { route } })
            .mount(el);
    }
});
