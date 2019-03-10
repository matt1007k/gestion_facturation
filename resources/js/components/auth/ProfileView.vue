<template>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <h1 v-text="auth.name"></h1>
              <h2 v-text="auth.email"></h2>
            </div>
            <div class="col-md-6">
              <h4>Logo de la empresa</h4>
            </div>
            <b-button v-b-modal.modalProfile ref="btnShow" variant="primary">Editar datos</b-button>
          </div>
          <editar-profile></editar-profile>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import EditarProfile from "./EditarProfile.vue";
export default {
  name: "formProfile",
  components: {
    EditarProfile
  },
  props: {
    auth: {
      type: Object,
      default: {}
    }
  },
  data() {
    return {};
  },
  methods: {}
};
</script>

<style>
</style>
