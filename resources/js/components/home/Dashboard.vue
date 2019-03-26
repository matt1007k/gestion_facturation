<template>
  <div>
    <count-items></count-items>
    <chart-bar-sales></chart-bar-sales>
  </div>
</template>

<script>
import CountItems from "./CountItems.vue";
import ChartBarSales from "./ChartBarSales.vue";
export default {
  components: { CountItems, ChartBarSales },
  data() {
    return {};
  }
};
</script>

<style>
</style>
