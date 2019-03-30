<template>
  <div class="row">
    <div class="col-sm-6 col-md-3">
      <div class="card">
        <div class="card-body">
          <div class="h1 text-muted text-right mb-4">
            <i class="icon-chart"></i>
          </div>
          <div class="text-value">{{totalProducts}}</div>
          <small class="text-muted text-uppercase font-weight-bold">Total de productos</small>
          <div class="progress progress-xs mt-3 mb-0">
            <div
              class="progress-bar bg-info"
              role="progressbar"
              style="width: 25%"
              aria-valuenow="25"
              aria-valuemin="0"
              aria-valuemax="100"
            ></div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-md-3">
      <div class="card">
        <div class="card-body">
          <div class="h1 text-muted text-right mb-4">
            <i class="icon-people"></i>
          </div>
          <div class="text-value">{{totalClients}}</div>
          <small class="text-muted text-uppercase font-weight-bold">Total de clientes</small>
          <div class="progress progress-xs mt-3 mb-0">
            <div
              class="progress-bar bg-success"
              role="progressbar"
              style="width: 80%"
              aria-valuenow="25"
              aria-valuemin="0"
              aria-valuemax="100"
            ></div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-md-3">
      <div class="card">
        <div class="card-body">
          <div class="h1 text-muted text-right mb-4">
            <i class="icon-basket-loaded"></i>
          </div>
          <div class="text-value">{{totalProductsSales}}</div>
          <small class="text-muted text-uppercase font-weight-bold">Productos vendidos</small>
          <div class="progress progress-xs mt-3 mb-0">
            <div
              class="progress-bar bg-warning"
              role="progressbar"
              style="width: 85%"
              aria-valuenow="25"
              aria-valuemin="0"
              aria-valuemax="100"
            ></div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-md-3">
      <div class="card">
        <div class="card-body">
          <div class="h1 text-muted text-right mb-4">
            <i class="icon-pie-chart"></i>
          </div>
          <div class="text-value">{{totalVentas}}</div>
          <small class="text-muted text-uppercase font-weight-bold">Total de ventas</small>
          <div class="progress progress-xs mt-3 mb-0">
            <div
              class="progress-bar"
              role="progressbar"
              style="width: 25%"
              aria-valuenow="25"
              aria-valuemin="0"
              aria-valuemax="100"
            ></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      totalProducts: 0,
      totalVentas: 0,
      totalClients: 0,
      totalProductsSales: 0
    };
  },
  methods: {
    getTotal() {
      axios.get("/getCounts").then(res => {
        this.totalProducts = res.data.totalProducts;
        this.totalVentas = res.data.totalSales;
        this.totalClients = res.data.totalClients;
        this.totalProductsSales = res.data.totalProdSales;
      });
    }
  },
  created() {
    this.getTotal();
  }
};
</script>

<style>
</style>
