<template>
  <div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-md-6">
          <h4>Listado de Clientes</h4>
        </div>
        <div class="col-md-6 d-flex justify-content-end">
          <b-button v-b-modal.modalClientCreate variant="success">
            <i class="icon-plus icons"></i>
            Nuevo Cliente
          </b-button>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="row mb-3">
        <div class="col-md-8">Ver: {{pagination.total}} en total</div>
        <div class="col-md justify-content-end">
          <input
            type="text"
            class="form-control"
            v-model="name"
            placeholder="Buscar un cliente...!"
          >
        </div>
      </div>
      <table class="table table-hover table-responsive">
        <thead>
          <th>#</th>
          <th>Nombre</th>
          <th>Tipo Doc.</th>
          <th>Num. Doc.</th>
          <th>Direccion</th>
          <th>Acciones</th>
        </thead>
        <tbody>
          <template v-if="searchOnClients.length > 0">
            <tr v-for="(client, index) in searchOnClients" :key="client.id">
              <td>{{index + 1}}</td>
              <td>{{client.nombre}}</td>
              <td>{{client.tipo_doc}}</td>
              <td>{{client.num_doc}}</td>
              <td>{{client.direccion}}</td>
              <td>
                <b-button
                  variant="primary"
                  size="sm"
                  v-b-modal.modalEditClient
                  @click="editarClient(client)"
                >
                  <i class="fa fa-edit"></i>
                  <span>Editar</span>
                </b-button>
                <button
                  type="button"
                  class="btn btn-danger btn-sm"
                  @click="eliminarClient(client.id)"
                >
                  <i class="fa fa-remove"></i>
                  <span>Eliminar</span>
                </button>
              </td>
            </tr>
          </template>
          <template v-else>
            <tr>No tienes clientes registrados....!</tr>
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
      <modal-client-create :getClients="getClients"></modal-client-create>

      <modal-client-edit :getClients="getClients"></modal-client-edit>
    </div>
  </div>
</template>

<script>
import swal from "sweetalert";
import ModalClientCreate from "./ModalClientCreate.vue";
import ModalClientEdit from "./ModalClientEdit.vue";
export default {
  components: { ModalClientCreate, ModalClientEdit },
  data() {
    return {
      name: "",
      clients: [],
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
    async getClients(page) {
      let result = await axios.get(`/api/getClients?page=${page}`);
      if (result) {
        console.log(result);
        this.clients = result.data.clients.data;
        this.pagination = result.data.pagination;
      } else {
        console.log("error");
      }
    },
    changePage(page) {
      this.pagination.current_page = page;
      this.getClients(page);
    },
    eliminarClient(id) {
      swal({
        title: "Estas seguro de eliminar?",
        text: "Esta operacion ya no se puede revertir",
        icon: "warning",
        buttons: true,
        dangerMode: true
      }).then(willDelete => {
        if (willDelete) {
          axios
            .delete(`/api/clientes/${id}`)
            .then(result => {
              swal("El registro se elimino con exito", {
                icon: "success"
              });
            })
            .catch(error => console.log(error));
          this.getClients();
        } else {
        }
      });
    },
    cleanFormAdd() {
      // this.$children[0].nombre = null;
    },
    editarClient(client) {
      // pasamos datos al componente hijo [0 , 1]
      // ModalClientCreate [0]
      // ModalClientEdit [1]
      this.$children[1].id = client.id;
      this.$children[1].nombre = client.nombre;
      this.$children[1].tipo_doc = client.tipo_doc;
      this.$children[1].num_doc = client.num_doc;
      this.$children[1].direccion = client.direccion;
    }
  },
  created() {
    this.getClients();
  },
  computed: {
    searchOnClients() {
      return this.clients.filter(item => {
        return (
          item.nombre.toLowerCase().includes(this.name.toLowerCase()) ||
          item.num_doc.toLowerCase().includes(this.name.toLowerCase())
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
