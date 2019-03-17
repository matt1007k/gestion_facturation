<template>
  <div>
    <div class="card">
      <div class="card-header">
        <h4>Generar Factura Electrónica</h4>
      </div>
      <div class="card-body">
        <form @submit.prevent="generarDoc">
          <div class="row mb-3">
            <div class="col-md-3">
              <p class="text-danger">Estos campos son obligatorios (*)</p>
              <label for="fecha">Tipo de comprobante (*)</label>
              <select
                v-model="tipo"
                id="tipo"
                class="form-control"
                :class="{'is-invalid': errors.tipo}"
                @change="tipoDocumento($event)"
              >
                <option value disabled hidden>----- Seleccionar -----</option>
                <option
                  v-for="(tipo_com, index) in tipos"
                  :key="index"
                  :value="tipo_com[0]"
                >{{tipo_com[1]}}</option>
              </select>
              <div class="invalid-feedback" v-if="errors.tipo">{{errors.tipo[0]}}</div>
            </div>
          </div>
          <h4>Comprobante</h4>
          <div class="row mb-3">
            <div class="col-md-3">
              <label for="fecha">Fecha de Emisión (*)</label>
              <date-picker
                v-model="fecha_emision"
                id="fecha"
                lang="es"
                :class="{'is-invalid': errors.fecha_emision}"
              ></date-picker>
              <div class="invalid-feedback" v-if="errors.fecha_emision">{{errors.fecha_emision[0]}}</div>
            </div>

            <div class="col-md-3">
              <label for="codigo">Serie de Emision (*)</label>
              <input
                type="text"
                class="form-control"
                :class="{'is-invalid': errors.num_serie}"
                v-model="num_serie"
                id="codigo"
                placeholder="Ingrese la serie del comprobante"
              >
              <div class="invalid-feedback" v-if="errors.num_serie">{{errors.num_serie[0]}}</div>
            </div>
            <div class="col-md-3">
              <label for="tipo">Número de Emision (*)</label>
              <input
                type="text"
                class="form-control"
                :class="{'is-invalid': errors.num_emision}"
                v-model="num_emision"
                id="num"
                placeholder="Ingrese el número del comprobante"
              >
              <div class="invalid-feedback" v-if="errors.num_emision">{{errors.num_emision[0]}}</div>
            </div>
            <div class="col-md-3">
              <label for="tipo">Tipo de Moneda</label>
              <input type="text" class="form-control" value="soles">
            </div>
          </div>
          <h4>Cliente</h4>
          <div class="row mb-3">
            <div class="col-md-3">
              <div class="form-group">
                <label for="tipo">Tipo de documento (*)</label>
                <b-form-select
                  v-model="tipo_doc"
                  id="tipo"
                  :class="{'is-invalid': errors.tipo_doc}"
                  :options="options_tipos_doc"
                />

                <div class="invalid-feedback" v-if="errors.tipo_doc">{{errors.tipo_doc[0]}}</div>
              </div>
            </div>
            <!-- <div class="col-md-3">
              <label for="num_doc">Número de documento</label>
              <input
                type="text"
                class="form-control"
                :class="{'is-invalid': errors.num_doc}"
                v-model="num_doc"
                id="num_doc"
                placeholder="Ingrese número del documento"
              >
              <div class="invalid-feedback" v-if="errors.num_doc">{{errors.num_doc[0]}}</div>
            </div>-->
            <div class="col-md-6">
              <label for="nombre">Apellidos y nombres o razon social (*)</label>
              <multiselect
                v-model="cliente"
                :options="options_clients"
                placeholder="Buscar un cliente por DNI o nombre..."
                :loading="isLoading"
                label="nombre"
                track-by="nombre"
                :options-limit="300"
                :custom-label="numWithName"
                :limit="3"
                @search-change="filterDataClient"
              >
                <span slot="noResult">Oops! El cliente no existe!!.</span>
              </multiselect>
              <div class="invalid-feedback" v-if="errors.cliente">{{errors.cliente.nombre[0]}}</div>
            </div>
            <div class="col-md-2 d-flex align-self-center">
              <b-button v-b-modal.modalAddClient variant="success">
                <i class="icon-plus icons"></i>
                Nuevo Cliente
              </b-button>
            </div>
            <div class="col-md-6">
              <label for="direccion">Direccion del cliente</label>
              <input
                type="text"
                class="form-control"
                v-model="direccion"
                id="direccion"
                placeholder="Ingrese la direccion del cliente"
              >
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-md-12 d-flex justify-content-end">
              <button
                type="button"
                class="btn btn-success"
                data-toggle="modal"
                data-target="#agregarCliente"
              >Agregar productos</button>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-md-12">
              <h5>Producto(s) a vender (*)</h5>
              <table class="table table-hover table-responsive">
                <thead>
                  <th class="text-center">#</th>
                  <th class="text-center">Codigo</th>
                  <th class="text-center">Descripcion</th>
                  <th class="text-center">Precio</th>
                  <th class="text-center">Cantidad</th>
                  <th class="text-center">Unidad</th>
                  <th class="text-center">Importe</th>
                  <th class="text-center"></th>
                </thead>
                <tbody>
                  <template v-if="cart.length > 0">
                    <tr v-for="(item, index) in cart" :key="item.id">
                      <td>{{index + 1}}</td>
                      <td>{{item.code}}</td>
                      <td class="w-50">{{item.description}}</td>
                      <td class="text-right">{{item.price}}</td>
                      <td>
                        <input
                          type="number"
                          min="1"
                          class="form-control"
                          :value="item.quantity"
                          style="width:70px"
                          @change="updateQtyProductFromCart($event, item.id)"
                        >
                      </td>

                      <td class="text-right">Kls</td>
                      <td class="text-right">{{ parseFloat(item.price * item.quantity).toFixed(2)}}</td>
                      <td>
                        <button
                          type="button"
                          class="btn btn-danger"
                          @click="removeProductoFromCart(item)"
                        >X</button>
                      </td>
                    </tr>
                  </template>
                  <template v-else>
                    <tr>
                      <td colspan="5">No tienes productos registrados....!</td>
                    </tr>
                  </template>
                </tbody>
              </table>
              <div
                class="alert alert-danger"
                v-if="errors.details || cart.lenght > 0"
              >Los productos son necesarios para un venta.</div>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-md-6"></div>
            <div class="col-md-6">
              <h5>Resumen</h5>
              <div class="row">
                <div class="col-md-12 d-flex justify-content-between">
                  <label for="subtotal">Subtotal:</label>
                  <label for="subtotal">s/. {{subTotal()}}</label>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 d-flex justify-content-between">
                  <label for="igv">IGV: (18%)</label>
                  <label for="igv">s/. {{igvSubTotal()}}</label>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 d-flex justify-content-between">
                  <label for="total" class="font-weight-bold">Total a pagar</label>
                  <label class="font-weight-bold text-primary">s/. {{Total()}}</label>
                </div>
              </div>
              <div class="row row mt-3">
                <div class="col-md-12 d-flex justify-content-between">
                  <input
                    type="button"
                    class="btn btn-danger"
                    value="Cancelar"
                    @click="resetField()"
                  >
                  <input type="submit" class="btn btn-primary" value="Generar documento">
                </div>
              </div>
            </div>
          </div>
          <modal-product
            :products="searchOnProducts"
            @agregar="addProductToCart"
            :pagination="pagination"
            :pagesNumber="pagesNumber"
            :isActivedPage="isActivedPage"
            @nameModel="searchInput"
            @ChangePage="changePage"
          ></modal-product>
          <modal-comprobante></modal-comprobante>
          <modal-add-client></modal-add-client>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import Multiselect from "vue-multiselect";
import DatePicker from "vue2-datepicker";

import ModalProduct from "./modals/ModalProduct.vue";
import ModalComprobante from "./modals/ModalComprobante.vue";

import ModalAddClient from "./modals/ModalAddClient.vue";
export default {
  components: {
    ModalProduct,
    ModalComprobante,
    Multiselect,
    DatePicker,
    ModalAddClient
  },
  name: "generar-factura",
  data() {
    return {
      cliente: { nombre: "", num_doc: "" },
      options_clients: [],
      isLoading: false,
      tipos: [],
      observation: "",
      tipo_doc: null,
      options_tipos_doc: [
        { value: null, text: "----- Seleccionar -----" },
        { value: "DNI", text: "DNI" },
        { value: "RUC", text: "RUC" }
      ],
      cart: [],
      products: [],
      name: "",
      pagination: {
        total: 0,
        current_page: 0,
        per_page: 0,
        last_page: 0,
        from: 0,
        to: 0
      },
      offset: 3,
      tipo: "",
      fecha_emision: new Date(),
      num_serie: "",
      num_emision: "",
      direccion: "",
      errors: {}
    };
  },
  methods: {
    getProducts(page) {
      axios
        .get(`/getProducts?page=${page}`)
        .then(res => {
          this.products = res.data.products.data;
          this.tipos = res.data.tipos;
          //this.tipos_doc = res.data.tipos_doc;
          this.pagination = res.data.pagination;
        })
        .catch(error => console.log(error));
    },
    changePage(page) {
      this.pagination.current_page = page;
      this.getProducts(page);
    },
    generarDoc() {
      const data = {
        tipo: this.$data.tipo,
        tipo_doc: this.tipo_doc,
        fecha_emision: this.fecha_emision,
        num_serie: this.num_serie,
        num_emision: this.num_emision,
        // num_doc: this.num_doc,
        cliente: this.cliente,
        direccion: this.direccion,
        details: this.cart,
        subtotal: this.subTotal(),
        igv: this.igvSubTotal(),
        total: this.Total(),
        user_id: window.Auth.id
      };
      axios
        .post("/generar", data)
        .then(result => {
          console.log(result);
          this.$children[1].url = result.data;
          this.$root.$emit("bv::show::modal", "modalComprobante");
          this.resetField();
        })
        .catch(error => (this.errors = error.response.data.errors));
    },
    addProductToCart(product) {
      const updatedCart = [...this.cart];
      const updatedItemIndex = updatedCart.findIndex(
        item => item.id === product.id
      );

      if (updatedItemIndex < 0) {
        updatedCart.push({ ...product, quantity: 1 });
      } else {
        const updatedItem = {
          ...updatedCart[updatedItemIndex]
        };
        updatedItem.quantity++;
        updatedCart[updatedItemIndex] = updatedItem;
      }
      this.cart = updatedCart;
    },
    updateQtyProductFromCart(event, productId) {
      const qtyUpdated = event.target.value;
      const updatedCart = [...this.cart];

      const updatedItemIndex = updatedCart.findIndex(
        item => item.id === productId
      );

      const updatedItem = {
        ...updatedCart[updatedItemIndex],
        quantity: qtyUpdated
      };
      updatedCart[updatedItemIndex] = updatedItem;
      this.cart = updatedCart;
    },
    searchInput(event) {
      const name = event.target.value;
      this.name = name;
    },
    removeProductoFromCart(product) {
      const updatedCart = [...this.cart];
      const updatedItemIndex = updatedCart.findIndex(
        item => item.id === product.id
      );

      const updatedItem = {
        ...updatedCart[updatedItemIndex]
      };

      //updatedItem.quantity--;
      //if (updatedItem.quantity <= 0) {
      updatedCart.splice(updatedItemIndex, 1);
      //}else {
      //    updatedCart[updatedItemIndex] = updatedItem;
      //}
      this.cart = updatedCart;
    },

    subTotal() {
      const subTotal = this.cart
        .map(function(item) {
          return item.price * item.quantity;
        })
        .reduce(function(a, b) {
          return a + b;
        }, 0);
      return parseFloat(subTotal).toFixed(2);
    },
    igvSubTotal() {
      return parseFloat(this.subTotal() * 0.18).toFixed(2);
    },
    Total() {
      let total = Number(this.subTotal()) + Number(this.igvSubTotal());
      return parseFloat(total).toFixed(2);
    },
    resetField() {
      this.tipo = "";
      this.tipo_doc = null;
      this.fecha_emision = new Date();
      this.num_serie = "";
      this.num_emision = "";
      this.cliente = { nombre: "", num_doc: "" };
      this.direccion = "";
      this.cart = [];
    },
    tipoDocumento(ev) {
      console.log(ev.target.value);
      let tipo = ev.target.value;
      if (tipo === "FA") {
        this.tipo_doc = "RUC";
        this.num_serie = "F001";
        this.num_emision = "0000001";
      } else if (tipo === "BO") {
        this.tipo_doc = "DNI";
        this.num_serie = "B001";
        this.num_emision = "0000001";
      }
    },
    getClients() {
      this.isLoading = true;
      axios
        .get(`/getClientes/${this.tipo_doc}`)
        .then(response => {
          this.options_clients = response.data.clients;
          this.isLoading = false;
        })
        .catch(err => {
          console.log(err);
        });
    },
    numWithName({ nombre, num_doc }) {
      if (!nombre && !num_doc) {
        return "Que cliente desea buscar...!!";
      }
      return `${num_doc} — ${nombre}`;
    },
    filterDataClient(ev) {
      if (!this.tipo) {
        let config = {
          text: "Tienes que elegir un comprobante",
          button: "ok"
        };

        this.$snack.danger(config);
        return;
      }
      this.isLoading = true;

      axios
        .get(`/getClientes/${this.tipo_doc}?query=${ev}`)
        .then(response => {
          this.options_clients = response.data.clients;
          this.direccion = this.cliente.direccion;
          this.isLoading = false;
        })
        .catch(err => {
          console.log(err);
        });
    }
  },
  created() {
    this.getProducts();
    // this.getClients();
  },
  computed: {
    searchOnProducts() {
      return this.products.filter(item => {
        return item.name.toLowerCase().includes(this.name.toLowerCase());
      });
    },
    isActivedPage() {
      return this.pagination.current_page;
    },
    pagesNumber() {
      if (!this.pagination.to) {
        return [];
      }

      let from = this.pagination.current_page - this.offset;

      if (from < 1) {
        from = 1;
      }

      let to = from + this.offset * 2;

      if (to >= this.pagination.last_page) {
        to = this.pagination.last_page;
      }

      let pagesArray = [];
      while (from <= to) {
        pagesArray.push(from);
        from++;
      }

      return pagesArray;
    }
  }
};
</script>
