<template>
  <!-- Modal Component -->
  <b-modal
    id="modalClientCreate"
    ref="modal"
    title="Registrar Cliente"
    hide-footer
    size="lg"
    class="modal-primary"
  >
    <form @submit.stop.prevent="handleSubmit">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="nombre">Nombre</label>
            <input
              class="form-control"
              id="nombre"
              type="text"
              v-model.trim="$v.nombre.$model"
              :class="{ 'is-invalid': $v.nombre.$error }"
              placeholder="Ingrese un nombre"
            >
            <div class="invalid-feedback" v-if="!$v.nombre.required">Este campo es obligatorio</div>
            <div
              class="invalid-feedback"
              v-if="!$v.nombre.minLength"
            >El nombre tiene que tener {{$v.nombre.$params.minLength.min}} como minimo.</div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="tipo_doc">Tipo de documento</label>
            <b-form-select
              v-model.trim="$v.tipo_doc.$model"
              :options="options"
              :class="{ 'is-invalid': $v.tipo_doc.$error }"
            />
            <div class="invalid-feedback" v-if="!$v.tipo_doc.required">Este campo es obligatorio</div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="num_doc">Numero de Doc.</label>
            <input
              class="form-control"
              id="num_doc"
              type="text"
              v-model.trim="$v.num_doc.$model"
              :class="{ 'is-invalid': $v.num_doc.$error }"
              placeholder="Ingrese el num. de documento"
            >
            <div class="invalid-feedback" v-if="!$v.num_doc.required">Este campo es obligatorio</div>
            <div
              class="invalid-feedback"
              v-if="!$v.num_doc.minLength"
            >El numero de documento no es valido.</div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="direccion">Direccion</label>
            <textarea
              class="form-control"
              id="direccion"
              cols="30"
              rows="2"
              v-model.trim="direccion"
              placeholder="Ingrese una direccion"
            ></textarea>
          </div>
        </div>
      </div>
      <div class="d-flex justify-content-end">
        <b-button class="mt-3 mr-3" variant="secondary" @click="hideModal">Cancelar</b-button>
        <b-button class="mt-3" variant="outline-success" type="submit">Guardar</b-button>
      </div>
    </form>
  </b-modal>
</template>

<script>
import { required, minLength, number } from "vuelidate/lib/validators";
export default {
  props: {
    getClients: Function
  },
  data() {
    return {
      nombre: "",
      tipo_doc: null,
      options: [
        { value: null, text: "-----Seleccionar-------" },
        { value: "DNI", text: "DNI" },
        { value: "RUC", text: "RUC" }
      ],
      num_doc: "",
      direccion: ""
    };
  },
  methods: {
    hideModal() {
      this.$root.$emit("bv::hide::modal", "modalClientCreate");
      this.nombre = null;
      this.tipo_doc = null;
      this.num_doc = null;
      this.direccion = null;
    },
    async handleSubmit() {
      console.log("submit!");
      this.$v.$touch();
      if (this.$v.$invalid) {
        console.log("invalid");
      } else {
        let data = {
          nombre: this.nombre,
          tipo_doc: this.tipo_doc,
          num_doc: this.num_doc,
          direccion: this.direccion
        };

        let result = await axios.post("/api/clientes", data);
        if (result) {
          let config = {
            text: result.data.message,
            button: "ok"
          };
          this.$nextTick(() => {
            // // // Wrapped in $nextTick to ensure DOM is rendered before closing
            this.$refs.modal.hide();
          });
          this.$emit("getClients", this.getClients());
          this.$snack.success(config);
        } else {
          console.log(result);
        }
      }
    }
  },
  validations: {
    nombre: {
      required,
      minLength: minLength(4)
    },
    tipo_doc: {
      required
    },
    num_doc: {
      required,
      minLength: minLength(8)
    }
  }
};
</script>

<style>
</style>
