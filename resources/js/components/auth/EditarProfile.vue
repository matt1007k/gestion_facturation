<template>
  <b-modal
    id="modalProfile"
    ref="modal"
    title="Cambiar imagen o datos de la empresa"
    hide-footer
    size="lg"
    class="modal-primary"
  >
    <div class="row">
      <div class="col-md-6">
        <h5>Cambiar datos de la empresa</h5>
        <form @submit.prevent="handleSubmit()">
          <b-form-group id="name" label="Nombre de empresa:" label-for="name">
            <b-form-input
              id="name"
              type="text"
              v-model="user.name"
              required
              placeholder="ejem: EMPRESA S.A"
            />
          </b-form-group>

          <b-form-group id="email" label="Correo electrónico:" label-for="email">
            <b-form-input
              id="email"
              type="email"
              v-model="user.email"
              required
              placeholder="ejem: user112@mail.com"
            />
          </b-form-group>

          <b-form-group id="ruc" label="RUC:" label-for="ruc">
            <b-form-input
              id="ruc"
              type="text"
              v-model="user.ruc"
              required
              placeholder="Ingrese el ruc de tu empresa"
            />
          </b-form-group>
          <b-form-group id="telefono" label="N. Teléfono / Celular:" label-for="telefono">
            <b-form-input
              id="telefono"
              type="text"
              v-model="user.telefono"
              required
              placeholder="Ingrese el teléfono de tu empresa"
            />
          </b-form-group>
          <b-form-group id="direccion" label="Dirección:" label-for="direccion">
            <b-form-input
              id="direccion"
              type="text"
              v-model="user.direccion"
              required
              placeholder="Ingrese el dirección de tu empresa"
            />
          </b-form-group>

          <div class="form-group d-flex justify-content-between align-items-center">
            <b-button @click="hideModal">Cancelar</b-button>
            <b-button type="submit" variant="success">Guardar</b-button>
          </div>
        </form>
      </div>
      <div class="col-md-6">
        <h5>Cambiar logo de la empresa</h5>
        <vue-dropzone
          ref="myVueDropzone"
          id="dropzone"
          :useCustomSlot="true"
          :options="dropzoneOptions"
        >
          <div class="dropzone-custom-content">
            <h3 class="dropzone-custom-title">Arrastra un logo!</h3>
            <div class="subtitle">o seleciona una imagen en tu computadora</div>
          </div>
        </vue-dropzone>
        <p
          class="text-dark"
        >NOTA: Al momento de seleccionar o arrastrar la imagen se actualizará el logo.</p>
      </div>
    </div>
  </b-modal>
</template>

<script>
import vue2Dropzone from "vue2-dropzone";
import "vue2-dropzone/dist/vue2Dropzone.min.css";
export default {
  components: {
    vueDropzone: vue2Dropzone
  },
  data() {
    return {
      user: {},
      errors: [],
      dropzoneOptions: {
        url: "/api/upload",
        maxFilesize: 0.5,
        addRemoveLinks: true
      }
    };
  },
  methods: {
    hideModal() {
      this.$root.$emit("bv::hide::modal", "modalProfile");
    },
    handleSubmit() {
      console.log("login");
    }
  }
};
</script>

<style>
</style>
