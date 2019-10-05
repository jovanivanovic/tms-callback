import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue/src/'
import App from './components/App';
import { ValidationProvider } from 'vee-validate/dist/vee-validate.full';

import jQuery from 'jquery';

jQuery.extend(true, jQuery.fn.datetimepicker.defaults, {
    icons: {
        time: 'fa fa-clock',
        date: 'fa fa-calendar',
        up: 'fa fa-arrow-up',
        down: 'fa fa-arrow-down',
        previous: 'fa fa-chevron-left',
        next: 'fa fa-chevron-right',
        today: 'fa fa-calendar-check',
        clear: 'fa fa-trash-alt',
        close: 'fa fa-times-circle'
    }
});

import router from './router';
import store from './store';

Vue.component('ValidationProvider', ValidationProvider);
Vue.use(BootstrapVue);

const app = new Vue({
    el: '#app',
    router,
    components: { App },
    template: '<App/>',
    store
});
