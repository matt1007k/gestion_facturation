<template>
  <div
    class="modal fade"
    id="agregarCliente"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLongTitle"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-lg modal-primary" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="agregarClienteModalLongTitle">Productos Disponibles</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <h4>Buscar:</h4>
          <div class="row d-flex align-items-center">
            <div class="col-md-8">
              <input
                type="text"
                class="form-control"
                @input="$emit('nameModel', $event)"
                @change="$emit('nameModel', $event)"
                placeholder="Buscar producto...!"
              >
            </div>
            <!-- <div class="col-md-3">
              <b-button v-b-modal.modalAddProduct @click="genCode" variant="success">
                <i class="icon-plus icons"></i>
                Nuevo Producto
              </b-button>
            </div>-->
          </div>
          <table class="table table-hover table-responsive">
            <thead>
              <th>Codigo</th>
              <th>Nombre</th>
              <th>Descripcion</th>
              <th>Precio</th>
              <th>Cantidad</th>
              <th></th>
            </thead>
            <tbody>
              <template v-if="products.length > 0">
                <tr v-for="product in products" :key="product.id">
                  <td>{{product.code}}</td>
                  <td class="w-25">{{product.name}}</td>
                  <td class="w-50">{{product.description}}</td>
                  <td>{{product.price}}</td>
                  <td>{{product.quantity}}</td>
                  <td>
                    <button
                      type="button"
                      class="btn btn-primary"
                      @click="$emit('agregar', product)"
                    >
                      <i class="icon-handbag icons"></i>
                      vender
                    </button>
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

          <div class="full-width d-flex justify-content-start">
            <nav aria-label="Page navigation">
              <ul class="pagination">
                <li class="page-item" v-if="pagination.current_page > 1">
                  <a
                    class="page-link"
                    href="#"
                    @click.prevent="$emit('ChangePage', pagination.current_page - 1)"
                  >Anterior</a>
                </li>
                <li
                  class="page-item"
                  v-for="(page, index) in pagesNumber"
                  :key="index"
                  :class="[ page == isActivedPage ? 'active' : '' ]"
                >
                  <a class="page-link" href="#" @click.prevent="$emit('ChangePage', page)">{{page}}</a>
                </li>
                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                  <a
                    class="page-link"
                    href="#"
                    @click.prevent="$emit('ChangePage', pagination.current_page + 1)"
                  >Siguiente</a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
    <modal-add-product></modal-add-product>
  </div>
</template>

<script>
import ModalAddProduct from "./ModalAddProduct";
export default {
  components: { ModalAddProduct },
  props: {
    products: Array,
    nameModel: Function,
    pagination: Object,
    ChangePage: Function,
    pagesNumber: Array,
    isActivedPage: Number,
    agregar: Function
  },
  name: "ModalProduct",
  data() {
    return {
      qty: 0,
      name: ""
    };
  },
  methods: {
    genCode() {
      this.$children[0].code = `P0000${this.products.length + 1}`;
    }
  }
};
</script>

<style>
</style>
