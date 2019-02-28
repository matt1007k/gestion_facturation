<template>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-12">
                    <h4>Listado de comprobantes</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-3">                
                <div class="col-md-8">
                    Ver: {{pagination.total}} en total
                </div>
                <div class="col-md justify-content-end">                          
                    <input type="text" class="form-control" v-model="name" placeholder="Buscar cliente...!"/>
                </div>
            </div>
            <table class="table table-hover table-responsive">
                <thead>
                    <th>#</th>
                    <th>Fecha Emision</th>
                    <th>Cliente</th>                            
                    <th>Número</th>
                    <th>Tipo</th>
                    <th>Igv</th>
                    <th>Total</th>
                    <th>Descargar</th>
                </thead>
                <tbody>
                    <template v-if="searchOnSales.length > 0">
                        <tr v-for="(sale, index) in searchOnSales" 
                        :key="sale.id">
                            <td>{{index + 1}}</td>
                            <td>{{sale.fecha_emision}}</td>
                            <td>{{sale.nombre}}, {{sale.tipo_doc}} {{sale.num_doc}}</td>                               
                            <td>{{sale.num_comprobante}}</td>
                            <td>                                 
                                <template v-if="sale.tipo === 'FA'">FACTURA ELECTRÓNICA</template>
                                <template v-else-if="sale.tipo === 'BO'">BOLETA DE VENTA ELECTRÓNICA</template>
                            </td>
                            <td>{{sale.igv}}</td>
                            <td>{{sale.total}}</td>
                            <td>
                                <b-button variant="primary" size="sm" 
                                    @click="downloadSale(sale.num_comprobante)">
                                    <span>PDF</span> 
                                </b-button>
                            </td>
                        </tr>                        
                    </template>
                    <template v-else>
                        <tr>No tienes saleos registrados....!</tr>
                    </template>
                </tbody>
            </table>

            <div class="full-width d-flex justify-content-start">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item" v-if="pagination.current_page > 1">
                            <a class="page-link" href="#" 
                                @click.prevent="changePage(pagination.current_page - 1)">Anterior
                            </a>
                        </li>
                        <li class="page-item" v-for="(page, index) in pagesNumber" :key="index"
                            :class="[ page == isActivedPage ? 'active' : '' ]">
                            <a class="page-link" href="#"
                                @click.prevent="changePage(page)" >
                                {{page}}
                            </a>
                        </li>
                        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                            <a class="page-link" href="#" 
                                @click.prevent="changePage(pagination.current_page + 1)" >
                                Siguiente
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            

        </div>
    </div>
</template>

<script>
import swal from 'sweetalert';

export default {
    components: {},
    data() {
        return {
            name: '',
            sales: [],
            id: 0,
            pagination: {
                'total': 0,
                'current_page': 0,
                'per_page': 0,
                'last_page': 0,
                'from': 0,
                'to': 0
            },
            offset: 3
        }
    },
    methods: {
        async getSales(page){
            let result = await axios.get(`/api/getSales?page=${page}`);
            if (result) {
                console.log(result);
                this.sales = result.data.sales.data;
                this.pagination = result.data.pagination;
            } else {
                console.log('error');
            }
        },
        changePage(page){
            this.pagination.current_page = page;
            this.getSales(page);
        },
        downloadSale(num_comprobante){
            return location.href = `/descargar/${num_comprobante}`;
        }
        // eliminarSale(id){
        //     swal({
        //         title: "Estas seguro de eliminar?",
        //         text: "Esta operacion ya no se puede revertir",
        //         icon: "warning",
        //         buttons: true,
        //         dangerMode: true,
        //     })
        //     .then((willDelete) => {
        //         if (willDelete) {
                    
        //             axios.delete(`/saleos/${id}`)
        //             .then(result => {
        //                 swal("El registro se elimino con exito", {
        //                 icon: "success",
        //                 });
        //             }).catch(error => console.log(error))
        //             this.getSales();
        //         } else {
                    
        //         }
        //     });
        // },
        // editarSale(sale){
        //     this.$children[1].id =  sale.id;
            
        // }
        
    },
    created(){
        this.getSales();
    }, 
    computed: {
        searchOnSales(){
            return this.sales.filter((item) => {
                return item.nombre.toLowerCase().includes(this.name.toLowerCase())
            });
        },
        isActivedPage(){
            return this.pagination.current_page;
        },
        pagesNumber(){
            if(!this.pagination.to){
                return [];
            }

            let from = this.pagination.current_page - this.offset;

            if (from < 1) {
                from = 1;
            }            

            let to = from + (this.offset * 2);

            if (to >= this.pagination.last_page) {
                to = this.pagination.last_page;
            }
            
            let pagesArray = [];
            while(from <= to){
                pagesArray.push(from);
                from++;
            }

            return pagesArray;
        }       
        
    }
}
</script>
