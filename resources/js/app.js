require('./bootstrap');

import $ from 'jquery'

$('[data-toggle="tooltip"]').tooltip()

$('[data-toggle="popover"]').popover()
$('.popover-dismiss').popover({
  trigger: 'focus'
})


window.Vue = require('vue');
import BootstrapVue from 'bootstrap-vue'
import Vuelidate from 'vuelidate'
import VueSnackbar from 'vue-snack' 


Vue.use(BootstrapVue)
Vue.use(Vuelidate)
Vue.use(VueSnackbar, {
  position: 'bottom-right'
})
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('generar-factura', require('./components/GenerarFactura.vue').default);
Vue.component('productos', require('./components/product/ProductsList.vue').default);
Vue.component('form-login', require('./components/auth/FormLogin.vue').default);

const app = new Vue({
    el: '#vapp'
});
