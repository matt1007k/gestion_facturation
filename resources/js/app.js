require("./bootstrap");

import $ from "jquery";

import "vue-multiselect/dist/vue-multiselect.min.css";

$('[data-toggle="tooltip"]').tooltip();

$('[data-toggle="popover"]').popover();
$(".popover-dismiss").popover({
    trigger: "focus"
});

window.Vue = require("vue");
import BootstrapVue from "bootstrap-vue";
import Vuelidate from "vuelidate";
import VueSnackbar from "vue-snack";

Vue.use(BootstrapVue);
Vue.use(Vuelidate);
Vue.use(VueSnackbar, {
    position: "bottom-right"
});
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component(
    "example-component",
    require("./components/ExampleComponent.vue").default
);
Vue.component(
    "generar-factura",
    require("./components/documents/GenerarFactura.vue").default
);
Vue.component(
    "documents-list",
    require("./components/documents/DocumentsList.vue").default
);
Vue.component(
    "productos",
    require("./components/product/ProductsList.vue").default
);
Vue.component(
    "clientes",
    require("./components/clients/ClientsList.vue").default
);
Vue.component(
    "profile-view",
    require("./components/auth/ProfileView.vue").default
);
const auth = document
    .querySelector("meta[name='user']")
    .getAttribute("content");
window.Auth = JSON.parse(auth);

const app = new Vue({
    el: "#vapp"
});
