<template>
  <!-- Modal Component -->
  <b-modal
    id="modalPrevent"
    ref="modal"
    title="Registrar Producto"
    hide-footer
    size="lg"
    class="modal-primary"
  >
    <form @submit.stop.prevent="handleSubmit">
      <div class="row">
        <div class="col-md-5">
          <div class="form-group">
            <label for="code">Código</label>
            <input
              class="form-control"
              id="code"
              type="text"
              v-model.trim="$v.code.$model"
              :class="{ 'is-invalid': $v.code.$error }"
              placeholder="Ingrese un nombre"
            >
            <div class="invalid-feedback" v-if="!$v.code.required">Este campo es obligatorio</div>
            <div
              class="invalid-feedback"
              v-if="!$v.code.minLength"
            >El código tiene que tener {{$v.code.$params.minLength.min}} como minimo.</div>
          </div>
        </div>
        <div class="col-md">
          <div class="form-group">
            <label for="name">Nombre</label>
            <input
              class="form-control"
              id="name"
              type="text"
              v-model.trim="$v.name.$model"
              :class="{ 'is-invalid': $v.name.$error }"
              placeholder="Ingrese un nombre"
            >
            <div class="invalid-feedback" v-if="!$v.name.required">Este campo es obligatorio</div>
            <div
              class="invalid-feedback"
              v-if="!$v.name.minLength"
            >El nombre tiene que tener {{$v.name.$params.minLength.min}} como minimo.</div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="price">Precio</label>
            <input
              class="form-control"
              id="price"
              min="0"
              value="1"
              step="0.01"
              type="number"
              v-model.trim="$v.price.$model"
              :class="{ 'is-invalid': $v.price.$error }"
            >
            <div class="invalid-feedback" v-if="!$v.price.required">Este campo es obligatorio</div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="quantity">Cantidad</label>
            <input
              class="form-control"
              id="quantity"
              min="0"
              value="1"
              type="number"
              v-model.trim="$v.quantity.$model"
              :class="{ 'is-invalid': $v.quantity.$error }"
            >
            <div class="invalid-feedback" v-if="!$v.quantity.required">Este campo es obligatorio</div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-8">
          <div class="form-group">
            <label for="description">Descripción</label>
            <textarea
              class="form-control"
              id="description"
              cols="30"
              rows="3"
              v-model.trim="$v.description.$model"
              :class="{ 'is-invalid': $v.description.$error }"
              placeholder="Ingrese una descripcion"
            ></textarea>
            <div class="invalid-feedback" v-if="!$v.description.required">Este campo es obligatorio</div>
            <div
              class="invalid-feedback"
              v-if="!$v.code.minLength"
            >Este campo tiene que tener {{$v.code.$params.minLength.min}} como minimo.</div>
          </div>
        </div>
        <div class="col-md">
          <b-form-group label="Estado">
            <b-form-radio-group v-model="status" :options="options" name="status"/>
          </b-form-group>
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
    getProducts: Function
  },
  data() {
    return {
      code: "",
      name: "",
      description: "",
      price: "",
      quantity: "",
      status: "available",
      options: [
        { text: "Disponible", value: "available" },
        { text: "Agotado", value: "unavailable" }
      ]
    };
  },
  methods: {
    hideModal() {
      this.$root.$emit("bv::hide::modal", "modalPrevent");
      this.cleanField();
    },
    async handleSubmit() {
      console.log("submit!");
      this.$v.$touch();
      if (this.$v.$invalid) {
        console.log("invalid");
      } else {
        let data = {
          code: this.code,
          name: this.name,
          description: this.description,
          price: this.price,
          quantity: this.quantity,
          status: this.status,
          user_id: window.Auth.id
        };

        let result = await axios.post("/api/productos", data);
        if (result) {
          let config = {
            text: result.data.message,
            button: "ok"
          };
          this.$nextTick(() => {
            // // // Wrapped in $nextTick to ensure DOM is rendered before closing
            this.$refs.modal.hide();
            this.cleanField();
          });
          this.$emit("getProducts", this.getProducts());
          this.$snack.success(config);
        } else {
          console.log(result);
        }
      }
    },
    cleanField(){
      this.$v.$reset();
      this.name = "";
      this.description = "";
      this.price = 0.0;
      this.quantity = 0;
      this.status = "available";
    }
  },
  validations: {
    code: {
      required,
      minLength: minLength(4)
    },
    name: {
      required,
      minLength: minLength(4)
    },
    price: {
      required
    },
    quantity: {
      required
    },
    description: {
      required,
      minLength: minLength(4)
    }
  }
};
</script>

<style>
</style>
