<template>
  <div class="row">
    <div class="col-md-12">
      <form @submit.prevent="onSubmit()">
        <b-form-group
          id="sfs_url"
          description="El url para generar los archivos"
          label="Ingrese el url"
        >
          <b-form-input id="sfs_url" v-model="sfs_url"></b-form-input>
        </b-form-group>
        <b-button type="submit" variant="outline-success">Guardar</b-button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      id: "",
      sfs_url: ""
    };
  },
  methods: {
    getSetting() {
      axios
        .get("/configuraciones")
        .then(res => {
          this.sfs_url = res.data.setting.sfs_url;
          this.id = res.data.setting.id;
        })
        .catch(err => console.log(err));
    },
    onSubmit() {
      const data = {
        sfs_url: this.sfs_url
      };
      axios
        .put(`/api/configuraciones/${this.id}`, data)
        .then(res => {
          let config = {
            text: res.data.message,
            button: "ok"
          };
          this.$snack.success(config);
        })
        .catch(err => console.log(err));
    }
  },
  created() {
    this.getSetting();
  }
};
</script>
