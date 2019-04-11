<template>
  <div>
    <div class="card">
      <div class="card-header">
        <h4>Generar Nota del comprobante ({{num_comprobant}})</h4>
      </div>
      <div class="card-body">
        <p class="text-danger">Estos campos son obligatorios (*)</p>
        <form @submit.prevent="generarDoc">
          <div class="row mb-3">
            <div class="col-md-3">
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
            <div class="col-md-5">
              <label for="tipo_operation">Tipo de {{tipo_nota.length > 0 ? tipo_nota : 'nota'}} (*)</label>
              <b-form-select
                v-model="tipo_operation"
                :options="options_operation"
                :state="errors.tipo_operation"
              ></b-form-select>
              <div
                class="invalid-feedback"
                v-if="errors.tipo_operation"
              >{{errors.tipo_operation[0]}}</div>
            </div>
            <div class="col-md-4">
              <label for="description">Descripción (*)</label>
              <b-form-textarea
                id="description"
                v-model="description"
                placeholder="Ingrese una descripción"
                :state="errors.description"
                rows="3"
              ></b-form-textarea>
              <div class="invalid-feedback" v-if="errors.description">{{errors.description[0]}}</div>
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
                placeholder="Ingrese la serie de la nota"
              >
              <div class="invalid-feedback" v-if="errors.num_serie">{{errors.num_serie[0]}}</div>
            </div>
            <div class="col-md-3">
              <label for="tipo">Número de nota (*)</label>
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
            <div class="col-md-6">
              <label for="nombre">Apellidos y nombres o razon social (*)</label>
              <input
                v-model="cliente"
                class="form-control"
                disabled
                placeholder="El cliente por DNI - nombre o Razon social"
              >
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
                      <td
                        class="text-right"
                      >{{ parseFloat((item.price * item.quantity) + ((item.price * item.quantity) * 0.18)).toFixed(2)}}</td>
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
          <!-- <modal-comprobante></modal-comprobante> -->
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import DatePicker from "vue2-datepicker";

import ModalProduct from "../modals/ModalProduct.vue";
// import ModalComprobante from "./modals/ModalComprobante.vue";

export default {
  props: {
    num_comprobant: {
      type: String,
      required: true
    }
  },
  components: {
    ModalProduct,
    // ModalComprobante,
    DatePicker
  },
  name: "generar-nota",
  data() {
    return {
      cliente: "",
      isLoading: false,
      tipos: [],
      tipo_nota: "",
      tipo_operation: "null",
      options_operation: [
        { value: null, text: "---- Seleccione operación ----" }
      ],
      operation_credito: [
        { value: null, text: "---- Seleccione operación ----" }
      ],
      operation_debito: [
        { value: null, text: "---- Seleccione operación ----" }
      ],
      description: "",
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
      errors: {},
      comprobante: []
    };
  },
  methods: {
    getProducts(page) {
      axios
        .get(`/getProducts?page=${page}`)
        .then(res => {
          this.products = res.data.products.data;

          //this.tipos_doc = res.data.tipos_doc;
          this.pagination = res.data.pagination;
        })
        .catch(error => console.log(error));
    },
    changePage(page) {
      this.pagination.current_page = page;
      this.getProducts(page);
    },
    getDetails() {
      axios
        .get(`/getDetailsDocument/${this.num_comprobant}`)
        .then(res => {
          this.comprobante = res.data.comprobante;
          this.cliente = `${res.data.comprobante.num_doc} - ${
            res.data.comprobante.nombre
          }`;
          this.tipos = res.data.tipos;
          res.data.detalles.forEach(product => {
            this.cart.push(product);
          });

          res.data.tipos_credito.forEach(operation => {
            this.operation_credito.push(operation);
          });

          res.data.tipos_debito.forEach(operation => {
            this.operation_debito.push(operation);
          });

          console.log(res.data);
        })
        .catch(error => {
          console.log(error);
        });
    },
    generarDoc() {
      const cliente = {
        num_doc: this.cliente.split("-")[0],
        nombre: this.cliente.split("-")[1]
      };
      const data = {
        comprobante: this.comprobante,
        tipo: this.$data.tipo,
        tipo_doc: this.tipo_nota,
        tipo_operation: this.tipo_operation,
        fecha_emision: this.fecha_emision,
        num_serie: this.num_serie,
        num_emision: this.num_emision,
        // num_doc: this.num_doc,
        cliente: cliente,
        description: this.description,
        details: this.cart,
        subtotal: this.subTotal(),
        igv: this.igvSubTotal(),
        total: this.Total(),
        user_id: window.Auth.id
      };
      axios
        .post("/notas", data)
        .then(result => {
          console.log(result);
          this.$children[4].url = result.data;
          this.$children[4].num_comprobante = `${this.num_serie}-${
            this.num_emision
          }`;
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

      this.fecha_emision = new Date();
      this.num_serie = "";
      this.num_emision = "";

      this.cart = [];
    },
    tipoDocumento(ev) {
      console.log(ev.target.value);
      let tipo = ev.target.value;
      if (tipo === "NC") {
        this.tipo_nota = "nota de crédito";
        this.num_serie = localStorage.getItem("NCSerie");
        this.num_emision = localStorage.getItem("NCEmision");
        this.options_operation = this.operation_credito;
      } else if (tipo === "ND") {
        this.tipo_nota = "nota de débito";
        this.num_serie = localStorage.getItem("NDSerie");
        this.num_emision = localStorage.getItem("NDEmision");
        this.options_operation = this.operation_debito;
      }
    }
  },
  created() {
    this.getProducts();
    // this.getClients();
    this.getDetails();
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
