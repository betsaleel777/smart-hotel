/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');
import VueAWN from "vue-awesome-notifications"
import { ModalPlugin } from 'bootstrap-vue'
let options = { position:"top-right",
                durations:{info:14000}
              }
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default) ;
Vue.component('attribution-add-table',require('./components/Passage/AttributionAddTableComponent').default) ;
Vue.component('attribution-add-select',require('./components/Passage/AttributionAddSelectComponent').default) ;
Vue.component('progression',require('./components/Passage/AttributionIndexProgressionComponent').default) ;
Vue.component('calendrier',require('./components/Sejour/CalendrierComponent').default)
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.use(VueAWN, options)
Vue.use(ModalPlugin)

const app = new Vue({
    el: '#app',
});
