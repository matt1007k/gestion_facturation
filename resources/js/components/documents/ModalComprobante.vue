<template>    
    <!-- Modal Component -->
    <b-modal
    id="modalComprobante"
    ref="modal"
    title="Imprimir o descargar comprobante"
    hide-footer
    size="xs"
    class="modal-primary"
    >
            <div class="full-width d-flex justify-content-center">
                <b-button  variant="danger" @click="printComprobante">
                    <span>Imprimir A4</span>     
                    <i class="icon-doc icons font-4xl"></i> 
                </b-button>              
            </div>
           
            
            <div class="d-flex justify-content-end">
                <b-button class="mt-3 mr-3" variant="secondary" @click="hideModal">Cancelar</b-button>
                <b-button class="mt-3" variant="success" 
                    @click="goListComprobantes">
                    Lista de comprobantes
                </b-button>
            </div>
        
    </b-modal>    
</template>

<script>
import { required, minLength, number } from 'vuelidate/lib/validators'
export default {
    name: "modal-comprobante",
    data(){
        return {
            url: 'http://localhost:8000/documentos',
        }
    },
    methods: {
        hideModal () {
            this.$root.$emit('bv::hide::modal','modalComprobante');
            // this.url = process.env.MIX_APP_URL
        },        
        printComprobante(){
            return location.href = this.url;
        },
        goListComprobantes(){
            return location.href = '/documentos';
        }       
    },
    
}
</script>

