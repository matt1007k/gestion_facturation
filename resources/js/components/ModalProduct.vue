<template>
    <div class="modal fade" id="agregarCliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-primary" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarClienteModalLongTitle">Productos Disponibles</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Buscar: </h4>                            
                            <input type="text" class="form-control" placeholder="Buscar producto...!"/>
                        </div>
                    </div>
                    <table class="table table-hover table-responsive">
                        <thead>
                            <th>Codigo</th>
                            <th>Nombre</th>                            
                            <th>Descripcion</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th></th>
                        </thead>
                        <tbody>
                            <template v-if="products.length > 0">
                                <tr v-for="product in products" 
                                :key="product.id">
                                    <td>{{product.code}}</td>
                                    <td class="w-25">{{product.name}}</td>                               
                                    <td class="w-75">{{product.description}}</td>
                                    <td>{{product.price}}</td>
                                    <td>{{product.quantity}}</td>
                                    <td>
                                        <button type="button" class="btn btn-success" @click="$emit('agregar', product)">Agregar</button>
                                    </td>
                                </tr>
                            </template>
                            <template v-else>
                                <tr>No tienes productos registrados....!</tr>
                            </template>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">                    
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>                    
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        products: Array,
        agregar: Function
    },
    name: "ModalProduct",
    data(){
        return {
            qty: 0
        }
    },
    methods: {
        agregarProducto(product){

            this.$emit()
            /*
            axios.post('/agregar-producto', product)
                .then(res => {
                    console.log(res);
                })
                .catch(error => {
                    console.log(error);
                })
            */
        }
    }  
}
</script>

<style>

</style>
