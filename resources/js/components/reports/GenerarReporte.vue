  <template>
  <div class="card">
    <div class="card-header bg-primary">
      <h4>Consultar documentos</h4>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <form @submit.prevent="generarReporte()">
            <div class="row d-flex align-items-center">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="fecha_inicio">Fecha de Inicio</label>
                  <div>
                    <date-picker v-model="fecha_inicio" id="fecha_inicio" lang="es"></date-picker>
                    <input type="hidden" v-model="fecha_inicio" class="form-control">
                    <div
                      class="invalid-feedback"
                      v-if="errors.fecha_inicio"
                    >{{errors.fecha_inicio[0]}}</div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="fecha_final">Fecha de Final</label>
                  <div>
                    <date-picker v-model="fecha_final" id="fecha_final" lang="es"></date-picker>
                    <input type="hidden" v-model="fecha_final" class="form-control">
                    <div
                      class="invalid-feedback"
                      v-if="errors.fecha_final"
                    >{{errors.fecha_final[0]}}</div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="fecha_inicio">Tipo de documento</label>
                  <b-select :options="options_documents" v-model="tipo"></b-select>
                </div>
              </div>
              <div class="col-md-3">
                <button class="btn btn-primary" type="submit">
                  <i class="icon-magnifier"></i> Buscar
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <template v-if="loading">Cargando...</template>
          <template v-else>
            <list-results
              :documents="results"
              :fechaInicio="fecha_inicio"
              :fechaFinal="fecha_final"
              :tipo="tipo"
            ></list-results>
          </template>
        </div>
      </div>
    </div>
    <div class="card-footer">
      <p class="no-margin">NOTA: Puede la fecha final debe de ser después de la fecha inicial.</p>
    </div>
  </div>
</template>
  
<script>
import ListResults from "./ListResults.vue";
import DatePicker from "vue2-datepicker";
export default {
  components: { DatePicker, ListResults },
  data() {
    return {
      fecha_inicio: new Date(),
      fecha_final: new Date(),
      tipo: "all",
      options_documents: [
        { value: "FA", text: "Factura" },
        { value: "BO", text: "Boleto" },
        { value: "NC", text: "Nota de Crédito" },
        { value: "ND", text: "Nota de Débito" },
        { value: "all", text: "Todos" }
      ],
      results: [],
      errors: {},
      loading: false
    };
  },
  methods: {
    generarReporte() {
      const data = {
        fecha_inicio: this.fecha_inicio,
        fecha_final: this.fecha_final,
        tipo: this.tipo
      };
      this.loading = true;
      axios
        .post("/reportes", data)
        .then(res => {
          this.loading = false;
          this.results = res.data.results;
        })
        .catch(error => {
          this.loading = true;
          this.errors = error.response.data.errors;
        });
    }
  }
};
</script>
  
 
  