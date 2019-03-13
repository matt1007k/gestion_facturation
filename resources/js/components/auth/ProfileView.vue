<template>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-md-6">
              <h4>Datos de la empresa</h4>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
              <b-button
                v-b-modal.modalProfile
                @click="perfil()"
                ref="btnShow"
                variant="primary"
              >Editar datos</b-button>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-6 text-right font-weight-bold">Nombre:</div>
                <div class="col-md-6 text-uppercase">
                  <p v-text="user.name"></p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 text-right font-weight-bold">Correo electrónico:</div>
                <div class="col-md-6">
                  <p v-text="user.email"></p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 text-right font-weight-bold">RUC:</div>
                <div class="col-md-6">
                  <p v-text="user.ruc"></p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 text-right font-weight-bold">Num. teléfono / Celular:</div>
                <div class="col-md-6">
                  <p v-text="user.telefono"></p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 text-right font-weight-bold">Dirección:</div>
                <div class="col-md-6">
                  <p v-text="user.direccion"></p>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <h5>Logo de la empresa</h5>
            </div>
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
  data() {
    return {
      user: {}
    };
  },
  methods: {
    perfil() {
      this.$children[0].user = this.user;
    }
  },
  created() {
    this.user = window.Auth;
  }
};
</script>

<style>
</style>
