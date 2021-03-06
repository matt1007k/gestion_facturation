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
import Axios from "axios";

import VueChartkick from "vue-chartkick";
import Chart from "chart.js";

Vue.use(BootstrapVue);
Vue.use(Vuelidate);
Vue.use(VueSnackbar, {
    position: "bottom-right"
});

Vue.use(VueChartkick, { adapter: Chart });
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

Vue.component(
    "form-setting",
    require("./components/auth/FormSetting.vue").default
);

Vue.component(
    "generar-nota",
    require("./components/documents/notes/GenerarNota.vue").default
);

Vue.component(
    "generar-reporte",
    require("./components/reports/GenerarReporte.vue").default
);

Vue.component("dashboard", require("./components/home/Dashboard.vue").default);

const auth =
    document.querySelector("meta[name='user']").getAttribute("content") || {};
window.Auth = JSON.parse(auth);

const app = new Vue({
    el: "#vapp",
    created() {
        Axios.get("/getCodes")
            .then(result => {
                let facEmision = `0000000${result.data.totalFacturas + 1}`;
                let bolEmision = `0000000${result.data.totalBoletas + 1}`;

                let NotaCreditoEmision = `0000000${result.data
                    .totalNotaCredito + 1}`;
                let NotaDebitoEmision = `0000000${result.data.totalNotaDebito +
                    1}`;

                localStorage.setItem("facSerie", "F001");
                localStorage.setItem("facEmision", facEmision);
                localStorage.setItem("bolSerie", "B001");
                localStorage.setItem("bolEmision", bolEmision);

                localStorage.setItem("NCSerie", "BC1B");
                localStorage.setItem("NCEmision", NotaCreditoEmision);
                localStorage.setItem("NDSerie", "FD1A");
                localStorage.setItem("NDEmision", NotaDebitoEmision);
            })
            .catch(err => console.log(err));

        // Axios.get('/txtcab/F001-0000001').then(result => {
        //     console.log(result.data);
        // })
        // .catch(err => console.log(err));
    }
});
