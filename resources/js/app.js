/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import VueAWN from 'vue-awesome-notifications'
import { ModalPlugin } from 'bootstrap-vue'
import Vue from 'vue'
require('./bootstrap')
window.Vue = require('vue')
const options = {
  position: 'top-right',
  durations: { info: 14000 }
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

Vue.component('attribution-add-table', require('./components/Passage/AttributionAddTableComponent.vue').default)
Vue.component('attribution-add-select', require('./components/Passage/AttributionAddSelectComponent.vue').default)
Vue.component('progression', require('./components/Passage/AttributionIndexProgressionComponent.vue').default)
Vue.component('calendrier', require('./components/Sejour/CalendrierComponent.vue').default)
Vue.component('input-product', require('./components/Restauration/InputProductComponent.vue').default)
Vue.component('synthese-product', require('./components/Restauration/SyntheseProductComponent.vue').default)
Vue.component('input-choice', require('./components/General/InputChoiceComponent.vue').default)
Vue.component('synthese-choice', require('./components/General/SyntheseChoiceComponent.vue').default)
Vue.component('modal-button-appro', require('./components/Appro/ModalButtonComponent.vue').default)
Vue.component('form-multicritere', require('./components/Inventaire/FormMulticritereComponent.vue').default)
Vue.component('form-multicritere-point', require('./components/Point/FormMulticriterePoint.vue').default)
Vue.component('payer-table', require('./components/Facture/PayerTable.vue').default)
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.use(VueAWN, options)
Vue.use(ModalPlugin)

const app = new Vue({
  el: '#app'
})
