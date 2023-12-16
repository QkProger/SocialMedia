import './bootstrap';

import {createApp,h} from 'vue'
import {createInertiaApp} from '@inertiajs/inertia-vue3'
import Layout from './Shared/Layout.vue'
import {InertiaProgress} from '@inertiajs/progress'
import Helper from './Shared/packages/Helper.vue'
import CKEditor from '@ckeditor/ckeditor5-vue'
import route from 'ziggy'
import {Ziggy} from './ziggy'


InertiaProgress.init()
createInertiaApp({
    resolve: name => {
        const splitName = name.split('/');
        switch(splitName.length){
            case 1: return import(`./Pages/${splitName[0]}.vue`);
            case 2: return import(`./Pages/${splitName[0]}/${splitName[1]}.vue`);
            case 3: return import(`./Pages/${splitName[0]}/${splitName[1]}/${splitName[2]}.vue`);
            case 4: return import(`./Pages/${splitName[0]}/${splitName[1]}/${splitName[2]}/${splitName[3]}.vue`);
        }
    },
    setup({
        el,
        App,
        props,
        plugin
    }) {

        createApp({
                render: () => {
                    return h(App, props)
                }
            })
            .use(plugin)
            .use(CKEditor)
            .mixin({
                methods: {
                    route,
                    error(field, errorBag = 'default') {

                        if (this.$page.props.errors.hasOwnProperty(field)) {
                            return this.$page.props.errors[field];
                        }
                        if (!this.$page.props.errors.hasOwnProperty(errorBag)) {
                            return null;
                        }
                        return null;
                    },
                    clearParams(filters) {
                        const params = {};
                        if (filters.page > 1) params.page = filters.page;
                        Object.keys(filters).forEach((column) => {
                            if (filters[column] && column != 'page') {
                                params[column] = filters[column];
                            }
                        });
                        return params;
                    },
                    clone(obj) {
                        return JSON.parse(JSON.stringify(obj));
                    },
                    back() {
                        return window.history.back();
                    }
                },
                Helper
            })
            .mount(el)
    },
})
