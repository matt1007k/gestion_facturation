<template>
    <div>
        <div class="card">
            <div class="card-header">Generar Factura Electrónica</div>
            <div class="card-body">
                <form @submit.prevent="generarDoc">                      
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="fecha">Tipo de comprobante</label>
                            <select v-model="tipo" id="tipo" class="form-control">
                                <option
                                v-for="(tipo, index) in tipos"
                                :key="index"
                                >{{tipo}}</option>                               
                            </select>
                        </div>
                    </div>  
                    <h4>Comprobante</h4>                  
                    <div class="row mb-3">                           
                        <div class="col-md-3">
                            <label for="fecha">Fecha de Emision</label>
                            <input type="date" v-model="fecha_emision" id="fecha" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="codigo">Serie de Emision</label>
                            <input type="text" class="form-control" v-model="num_serie" id="codigo" placeholder="Ingrese la serie del comprobante">
                        </div>
                        <div class="col-md-3">
                            <label for="tipo">Numero de Emision</label>
                            <input type="text" class="form-control" v-model="num_emision" id="num" placeholder="Ingrese el numero del comprobante">
                        </div>
                        <div class="col-md-3">
                            <label for="tipo">Tipo de Moneda</label>
                            <input type="text" class="form-control" value="soles">
                        </div>
                    </div>
                    <h4>Cliente</h4>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tipo">Tipo de documento</label>
                                <select v-model="tipo_doc" id="tipo" class="form-control">
                                <option v-for="tipo in tipos_doc"
                                        :key="tipo">{{tipo}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="num_doc">Numero de documento</label>
                            <input type="text" class="form-control" v-model="num_doc" id="num_doc" placeholder="Ingrese numero del documento">
                        </div>
                        <div class="col-md-6">
                            <label for="nombre">Apellidos y nombres o razon social</label>
                            <input type="text" class="form-control" v-model="nombre" id="nombre" placeholder="Ingrese los datos o razon del cliente">
                        </div>
                        <div class="col-md-6">
                            <label for="direccion">Direccion del cliente</label>
                            <input type="text" class="form-control" v-model="direccion" id="direccion" placeholder="Ingrese la direccion del cliente">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 d-flex justify-content-end">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#agregarCliente">
                            Agregar productos
                            </button>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <table class="table table-hover table-responsive">
                                <thead>
                                    <th class="text-center">Codigo</th>                                   
                                    <th class="text-center">Descripcion</th>
                                    <th class="text-center">Precio</th>
                                    <th class="text-center">Cantidad</th>
                                    <th class="text-center">Sub. total</th>
                                    <th class="text-center">IGV</th>
                                    <th class="text-center">Importe</th>
                                    <th class="text-center"></th> 
                                </thead>
                                <tbody>
                                    <template v-if="cart.length > 0">
                                        <tr v-for="item in cart" 
                                            :key="item.id">
                                            <td>{{item.code}}</td>                                       
                                            <td class="w-50">{{item.description}}</td>
                                            <td class="text-right">{{item.price}}</td>
                                            <td>
                                                <input type="number" min="1" class="form-control" 
                                                :value="item.quantity" style="width:70px" 
                                                @change="updateQtyProductFromCart($event, item.id)"/>
                                            </td>
                                            <td class="text-right">
                                                {{ item.price * item.quantity}}
                                            </td>
                                            <td class="text-right">
                                                {{parseFloat((item.price * item.quantity) * 0.18).toFixed(2) }}
                                            </td>
                                            <td class="text-right">
                                                {{(item.price * item.quantity) + ((item.price * item.quantity) * 0.18)}}
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger" 
                                                    @click="removeProductoFromCart(item)">
                                                    X
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                    <template v-else>
                                        <tr>
                                            <td colspan="5">No tienes productos registrados....!</td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6">
                            <h5>Resumen</h5>
                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-between">
                                    <label for="subtotal">Subtotal: </label>
                                    <label for="subtotal">s/. {{subTotal()}}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-between">
                                    <label for="igv">IGV: (18%) </label>
                                    <label for="igv">s/. {{igvSubTotal()}}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-between">
                                    <label for="total" class="font-weight-bold">Total a pagar</label>
                                    <label class="font-weight-bold text-primary">s/. {{Total()}}</label>
                                </div>
                            </div>
                            <div class="row row mt-3">
                                <div class="col-md-12 d-flex justify-content-between">
                                    <input type="button" class="btn btn-danger" value="Cancelar"> 
                                    <input type="submit" class="btn btn-primary" value="Generar documento">                           
                                </div>
                            </div>
                        </div>
                    </div>
                    <modal-product 
                        :products="searchOnProducts" @agregar="addProductToCart"
                        :pagination="pagination"  
                        :pagesNumber="pagesNumber"
                        :isActivedPage="isActivedPage"
                        @nameModel="searchInput"
                        @ChangePage="changePage"
                        ></modal-product>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import ModalProduct from './ModalProduct.vue'
export default {
    components: {ModalProduct},
    name: "generar-factura",
    data(){
        return {            
            tipos: [],
            observation: '',
            tipos_doc: [],   
            cart: [],
            subtotal: 0,
            products: [],
            name: '',
            pagination: {
                'total': 0,
                'current_page': 0,
                'per_page': 0,
                'last_page': 0,
                'from': 0,
                'to': 0
            },
            offset: 3,  
            tipo: '', 
            tipo_doc: '',         
            fecha_emision: '',
            num_serie: '',
            num_emision: '',
            num_doc: '',
            nombre: '',
            direccion: ''    
        }
    },
    methods: {
        getProducts(page){
            axios.get(`/api/getProducts?page=${page}`)
                .then(res => {
                    this.products = res.data.products.data;
                    this.tipos = res.data.tipos;
                    this.tipos_doc = res.data.tipos_doc;
                    this.pagination = res.data.pagination;
                })
                .catch(error => console.log(error))
        },
        changePage(page){
            this.pagination.current_page = page;
            this.getProducts(page);
        },
        async generarDoc(){
            const data = {
                tipo: this.tipo, 
                tipo_doc: this.tipo_doc,         
                fecha_emision: this.fecha_emision,
                num_serie: this.num_serie,
                num_emision: this.num_emision,
                num_doc: this.num_doc,
                nombre: this.nombre,
                direccion: this.direccion,
                details: this.cart,
                subtotal:  this.subTotal(),
                igv: this.igvSubTotal(),
                total: this.Total()
            }
            let result = axios.post('/generar', data);
            if(result){
                console.log(result);
                
            }else{
                console.log(result);
            }

        },
        addProductToCart(product){
            const updatedCart = [...this.cart];
            const updatedItemIndex = updatedCart.findIndex(
                item => item.id === product.id
            );
          
            if (updatedItemIndex < 0) {
                updatedCart.push({...product, quantity: 1});
            }else {
                const updatedItem = {
                    ...updatedCart[updatedItemIndex]
                };
                updatedItem.quantity++;
                updatedCart[updatedItemIndex] = updatedItem;
            }
            this.cart  = updatedCart;            
        },
        updateQtyProductFromCart(event, productId){
            const qtyUpdated = event.target.value;
            const updatedCart = [...this.cart];

            const updatedItemIndex = updatedCart.findIndex(
                item => item.id === productId
            );

            const updatedItem = {
                ...updatedCart[updatedItemIndex],
                quantity: qtyUpdated
            };
            updatedCart[updatedItemIndex] = updatedItem;
            this.cart  = updatedCart;
        },
        searchInput(event){
            const name = event.target.value;
            this.name = name;
        },
        removeProductoFromCart(product){
            const updatedCart = [...this.cart];
            const updatedItemIndex = updatedCart.findIndex(
                item => item.id === product.id
            );

            const updatedItem = {
                ...updatedCart[updatedItemIndex]
            };

            //updatedItem.quantity--;
            //if (updatedItem.quantity <= 0) {
            updatedCart.splice(updatedItemIndex, 1);
            //}else {
            //    updatedCart[updatedItemIndex] = updatedItem;
            //}
            this.cart  = updatedCart;
        },
        
        subTotal(){
            const subTotal = this.cart.map(function(item) { 
                return (item.price * item.quantity) + ((item.price * item.quantity) * 0.18);
            }).reduce(function(a, b) {
                return a + b
            }, 0)
            return parseFloat(subTotal).toFixed(2);
        },
        igvSubTotal(){
            return parseFloat(this.subTotal() * 0.18).toFixed(2);
        },
        Total(){
            return parseFloat(this.subTotal() + (this.subTotal() * 0.18)).toFixed(2);
        }
    
    },
    created() {
        this.getProducts();
    },
    computed: {
        searchOnProducts(){
            return this.products.filter((item) => {
                return item.name.toLowerCase().includes(this.name.toLowerCase())
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
