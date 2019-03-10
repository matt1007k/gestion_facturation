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
        <h5>Cambiar logo de la empresa</h5>
        <form @submit.prevent="handleSubmit()"></form>
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
      </div>
    </div>
    <b-button @click="hideModal">Close Me</b-button>
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
