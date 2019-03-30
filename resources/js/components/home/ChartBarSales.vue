<template>
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <h5 class="card-header text-white bg-primary">Ventas realizadas</h5>
        <div class="card-body">
          <!-- <b-tabs content-class="mt-3">
          <b-tab title="Ventas" active>-->
          <line-chart
            prefix="S/."
            :legend="true"
            :data="ventas"
            :messages="{empty: 'No hay ventas'}"
            xtitle="Fecha de venta"
            ytitle="Total de ventas"
            :dataset="{label: 'Total por ventas realizadas'}"
          ></line-chart>
          <!-- </b-tab>
            <b-tab title="Documentos">
              <column-chart
                prefix="S/."
                :data="documents"
                :messages="{empty: 'No hay ventas'}"
                xtitle="Fecha de emisión"
                ytitle="Total por comprobante"
                :colors="['#f44242', '#419bf4']"
              ></column-chart>
            </b-tab>
          </b-tabs>-->
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card">
        <h5 class="card-header text-white bg-info">Total de Documentos</h5>
        <div class="card-body">
          <pie-chart :data="comprobantes" :donut="true" :colors="['#f44242', '#419bf4']"></pie-chart>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      comprobantes: {},
      ventas: [],
      documents: []
    };
  },
  methods: {
    getComprobantsTotal() {
      axios
        .get("/getCodes")
        .then(res => {
          this.comprobantes = {
            Facturas: res.data.totalFacturas,
            Boletas: res.data.totalBoletas
          };
        })
        .catch(err => console.log(err));
    },
    getVentas() {
      axios
        .get("/getVentas")
        .then(res => {
          console.log(res.data);
          res.data.sales.forEach(item => {
            this.ventas.unshift([item.fecha, Number(item.total)]);
          });

          res.data.documentos.forEach(item => {
            this.documents.unshift({
              name: item.name,
              data: item.data
            });
          });
        })
        .catch(err => console.log(err));
    }
  },
  created() {
    this.getComprobantsTotal();
    this.getVentas();
  }
};
</script>

