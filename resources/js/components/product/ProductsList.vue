<template>
  <div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-md-6">
          <h4>Listado de productos</h4>
        </div>
        <div class="col-md-6 d-flex justify-content-end">
          <!-- <button class="btn btn-success" data-toggle="modal" data-target="#addProduct">
                        <i class="icon-plus icons"></i>
                        Nuevo producto
          </button>-->
          <b-button v-b-modal.modalPrevent variant="success" @click="codeProductAdd">
            <i class="icon-plus icons"></i>
            Nuevo producto
          </b-button>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="row mb-3">
        <div class="col-md-8">Ver: {{pagination.total}} en total</div>
        <div class="col-md justify-content-end">
          <input type="text" class="form-control" v-model="name" placeholder="Buscar producto...!">
        </div>
      </div>
      <table class="table table-hover table-responsive">
        <thead>
          <th>Codigo</th>
          <th>Nombre</th>
          <th>Descripcion</th>
          <th>Precio</th>
          <th>Estado</th>
          <th>Cantidad</th>
          <th>Acciones</th>
        </thead>
        <tbody>
          <template v-if="searchOnProducts.length > 0">
            <tr v-for="product in searchOnProducts" :key="product.id">
              <td>{{product.code}}</td>
              <td>{{product.name}}</td>
              <td>{{product.description}}</td>
              <td>{{product.price}}</td>
              <td>
                <template v-if="product.status === 'available'">
                  <span class="badge badge-success">Disponible</span>
                </template>
                <template v-else>
                  <span class="badge badge-danger">Agotado</span>
                </template>
              </td>
              <td class="text-center">{{product.quantity}}</td>
              <td>
                <b-button
                  variant="primary"
                  size="sm"
                  v-b-modal.modalEditProduct
                  @click="editarProduct(product)"
                >
                  <i class="fa fa-edit"></i>
                  <span>Editar</span>
                </b-button>
                <button
                  type="button"
                  class="btn btn-danger btn-sm"
                  @click="eliminarProduct(product.id)"
                >
                  <i class="fa fa-remove"></i>
                  <span>Eliminar</span>
                </button>
              </td>
            </tr>
          </template>
          <template v-else>
            <tr>No tienes productos registrados....!</tr>
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
                @click.prevent="changePage(pagination.current_page - 1)"
              >Anterior</a>
            </li>
            <li
              class="page-item"
              v-for="(page, index) in pagesNumber"
              :key="index"
              :class="[ page == isActivedPage ? 'active' : '' ]"
            >
              <a class="page-link" href="#" @click.prevent="changePage(page)">{{page}}</a>
            </li>
            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
              <a
                class="page-link"
                href="#"
                @click.prevent="changePage(pagination.current_page + 1)"
              >Siguiente</a>
            </li>
          </ul>
        </nav>
      </div>
      <modal-product-create :getProducts="getProducts"></modal-product-create>

      <modal-product-edit :getProducts="getProducts"></modal-product-edit>
    </div>
  </div>
</template>

<script>
import swal from "sweetalert";
import ModalProductCreate from "./ModalProductCreate.vue";
import ModalProductEdit from "./ModalProductEdit.vue";
export default {
  components: { ModalProductCreate, ModalProductEdit },
  data() {
    return {
      name: "",
      products: [],
      id: 0,
      pagination: {
        total: 0,
        current_page: 0,
        per_page: 0,
        last_page: 0,
        from: 0,
        to: 0
      },
      offset: 3
    };
  },
  methods: {
    async getProducts(page) {
      let result = await axios.get(`/getProducts?page=${page}`);
      if (result) {
        console.log(result);
        this.products = result.data.products.data;
        this.pagination = result.data.pagination;
      } else {
        console.log("error");
      }
    },
    changePage(page) {
      this.pagination.current_page = page;
      this.getProducts(page);
    },
    codeProductAdd() {
      this.$children[0].code = `P0000${this.products.length + 1}`;
    },
    editarProduct(product) {
      // pasamos datos al componente hijo [0 , 1]
      // ModalProductCreate [0]
      // ModalProductEdit [1]
      this.$children[1].id = product.id;
      this.$children[1].code = product.code;
      this.$children[1].name = product.name;
      this.$children[1].description = product.description;
      this.$children[1].price = product.price;
      this.$children[1].quantity = product.quantity;
      this.$children[1].status = product.status;
    },
    eliminarProduct(id) {
      swal({
        title: "Estas seguro de eliminar?",
        text: "Esta operacion ya no se puede revertir",
        icon: "warning",
        buttons: true,
        dangerMode: true
      }).then(willDelete => {
        if (willDelete) {
          axios
            .delete(`/api/productos/${id}`)
            .then(result => {
              swal("El registro se elimino con exito", {
                icon: "success"
              });
            })
            .catch(error => console.log(error));
          this.getProducts();
        } else {
        }
      });
    }
  },
  created() {
    this.getProducts();
  },
  computed: {
    searchOnProducts() {
      return this.products.filter(item => {
        return (
          item.name.toLowerCase().includes(this.name.toLowerCase()) ||
          item.description.toLowerCase().includes(this.name.toLowerCase())
        );
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
