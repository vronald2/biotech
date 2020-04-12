/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import CKEditor from 'ckeditor4-vue';
import BootstrapVue from 'bootstrap-vue'
import {BootstrapVueIcons} from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import 'bootstrap-vue/dist/bootstrap-vue-icons.min.css'
import {store} from "./store/store";
import validation from './plugins/validation';
import { ToastPlugin } from 'bootstrap-vue'


validation(store);

Vue.use(BootstrapVue)
Vue.use(BootstrapVueIcons)
Vue.use( CKEditor );
Vue.use(require('vue-moment'));
Vue.use(ToastPlugin)

const app = new Vue({
    el: '#app',
    store
});
