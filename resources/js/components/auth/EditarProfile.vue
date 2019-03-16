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
          <div class="form-group">
            <label for="name">Nombre de empresa:</label>
            <input
              class="form-control"
              id="name"
              type="text"
              v-model.trim="user.name"
              :class="{ 'is-invalid': errors.name }"
              placeholder="ejem: EMPRESA S.A"
            >
            <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
          </div>

          <div class="form-group">
            <label for="email">Correo electrónico:</label>
            <input
              class="form-control"
              id="email"
              type="email"
              v-model.trim="user.email"
              :class="{ 'is-invalid': errors.email }"
              placeholder="ejem: user112@mail.com"
            >
            <div class="invalid-feedback" v-if="errors.email">{{errors.email[0]}}</div>
          </div>

          <div class="form-group">
            <label for="ruc">RUC:</label>
            <input
              class="form-control"
              id="ruc"
              type="text"
              v-model.trim="user.ruc"
              :class="{ 'is-invalid': errors.ruc }"
              placeholder="Ingrese el ruc de la empresa"
            >
            <div class="invalid-feedback" v-if="errors.ruc">{{errors.ruc[0]}}</div>
          </div>

          <div class="form-group">
            <label for="telefono">N. Teléfono / Celular:</label>
            <input
              class="form-control"
              id="telefono"
              type="text"
              v-model.trim="user.telefono"
              :class="{ 'is-invalid': errors.telefono }"
              placeholder="Ingrese el num. teléfono o celular"
            >
            <div class="invalid-feedback" v-if="errors.telefono">{{errors.telefono[0]}}</div>
          </div>

          <div class="form-group">
            <label for="direccion">Dirección:</label>
            <textarea
              class="form-control"
              id="direccion"
              type="text"
              v-model.trim="user.direccion"
              :class="{ 'is-invalid': errors.direccion }"
              placeholder="Ingrese el dirección de tu empresa"
              rows="3"
              cols="10"
            ></textarea>
            <div class="invalid-feedback" v-if="errors.direccion">{{errors.direccion[0]}}</div>
          </div>

          <div class="form-group d-flex justify-content-between align-items-center">
            <b-button @click="hideModal">Cancelar</b-button>
            <b-button type="submit" variant="success">Guardar</b-button>
          </div>
        </form>
      </div>
      <div class="col-md-6">
        <h5>Cambiar logo de la empresa</h5>
        <p class="text-danger">Se recomienda resoluciones 700x300</p>
        <vue-dropzone
          ref="myVueDropzone"
          id="dropzone"
          :useCustomSlot="true"
          :options="dropzoneOptions"
          @vdropzone-success="successUpload"
          @vdropzone-error="failed"
          @vdropzone-sending="sendingEvent"
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
      errors: {},
      dropzoneOptions: {
        url: `/api/upload`,
        headers: {
          "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]")
            .content
        },
        paramName: "logo",
        maxFilesize: 0.7,
        addRemoveLinks: true,
        maxFiles: 1,
        acceptedFiles: "image/*",
        parallelUploads: 1
      }
    };
  },
  methods: {
    hideModal() {
      this.$root.$emit("bv::hide::modal", "modalProfile");
    },
    handleSubmit() {
      axios
        .put(`/api/usuario/${this.user.id}`, this.user)
        .then(res => {
          console.log(res);
          let config = {
            text: res.data.message,
            button: "ok"
          };
          this.$nextTick(() => {
            // // // Wrapped in $nextTick to ensure DOM is rendered before closing
            this.$refs.modal.hide();
          });
          this.$snack.success(config);
        })
        .catch(err => {
          console.log(err);
          this.errors = err.response.data.errors;
        });
    },
    sendingEvent(file, xhr, formData) {
      formData.append("id", this.user.id);
    },
    successUpload(file, response) {
      let config = {
        text: response.message,
        button: "ok"
      };
      this.$refs.myVueDropzone.removeAllFiles();
      this.$nextTick(() => {
        // // // Wrapped in $nextTick to ensure DOM is rendered before closing
        this.$refs.modal.hide();
      });
      this.$snack.success(config);
      console.log(this.$refs.myVueDropzone);
    },
    failed(file, message, xhr) {
      let response = xhr.response;
      let parse = JSON.parse(response, (key, value) => {
        return value;
      });

      var messageSpan = document.querySelector(".dz-error-message > span");
      messageSpan.innerText = parse.errors.logo[0];
    }
  }
};
</script>

<style>
</style>
