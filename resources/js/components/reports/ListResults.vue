<template>
  <div>
    <template v-if="documents.length > 0">
      <div class="row mb-3">
        <div class="col-md-12">
          <button class="btn btn-danger" @click="exportPDF()">
            <i class="fa fa-file-pdf-o"></i> Exportar PDF
          </button>
          <button class="btn btn-success" @click="exportExcel()">
            <i class="fa fa-file-excel-o"></i> Exportar Excel
          </button>
        </div>
      </div>
    </template>

    <div class="row">
      <table class="table table-responsive table-hover">
        <thead class="thead-dark">
          <tr>
            <th>#</th>
            <th>Tipo comprobante</th>
            <th>Número</th>
            <th>Fecha emisión</th>
            <th style="width: auto">Cliente</th>
            <th>Num. Doc.</th>
            <th>Estado</th>
            <th>Moneda</th>
            <th>T. Gravado</th>
            <th>T. IGV</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          <template v-if="documents.length > 0">
            <tr v-for="(document, index) of documents" :key="document.id">
              <td>{{index + 1}}</td>
              <template v-if="document.tipo === 'FA'">
                <td>Factura</td>
              </template>
              <template v-if="document.tipo === 'BO'">
                <td>Boleta</td>
              </template>
              <template v-if="document.tipo === 'NC'">
                <td>Nota de Crédito</td>
              </template>
              <template v-if="document.tipo === 'ND'">
                <td>Nota de Débito</td>
              </template>
              <td>{{document.num_comprobante}}</td>
              <td>{{document.fecha_emision}}</td>
              <td>{{document.nombre}}</td>
              <td>{{document.tipo_doc}} - {{document.num_doc}}</td>
              <template v-if="document.estado === 'accepted'">
                <td>Aceptado</td>
              </template>
              <template v-if="document.estado === 'registered'">
                <td>Registrado</td>
              </template>
              <template v-if="document.estado === 'canceled'">
                <td>Anulado</td>
              </template>
              <td>PEN</td>
              <td>{{document.subtotal}}</td>
              <td>{{document.igv}}</td>
              <td>{{document.total}}</td>
            </tr>
          </template>
          <template v-else>
            <tr>
              <td colspan="11">No hay resultados</td>
            </tr>
          </template>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import moment from "moment";
export default {
  props: ["documents", "fechaInicio", "fechaFinal", "tipo"],
  data() {
    return {};
  },
  methods: {
    exportPDF() {
      if (!this.documents) {
        return;
      }
      const formFechaI = moment(this.fechaInicio).format("YYYY-MM-DD");
      const formFechaF = moment(this.fechaFinal).format("YYYY-MM-DD");
      axios
        .get(`/reportes/pdf/${formFechaI}/${formFechaF}/${this.tipo}`)
        .then(res => {
          return (location.href = `/reportes/pdf/${formFechaI}/${formFechaF}/${
            this.tipo
          }`);
        })
        .catch(error => {
          console.log(error);
        });
    },
    exportExcel() {
      if (!this.documents) {
        return;
      }

      const data = {
        documents: this.documents
      };
      axios
        .post("/reportes/exportar-excel", data)
        .then(res => {
          console.log(res);
        })
        .catch(error => {
          console.log(error);
        });
    }
  }
};
</script>

<style>
</style>
