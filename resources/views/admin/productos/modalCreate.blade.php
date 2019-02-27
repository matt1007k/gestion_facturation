<div class="modal fade" id="addProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-primary" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLongTitle">Registrar Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('productos.store')}}" method="POST">
            <div class="modal-body">
                <div class="form-group">
                    <label for="code">Codigo</label>
                    <input class="form-control" id="code" type="text" name="code" placeholder="Ingrese un codigo" required>
                    <span class="help-block">Please enter your email</span>
                </div> 
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input class="form-control" id="name" type="text" name="name" placeholder="Ingrese un nombre" required>
                    <span class="help-block">Please enter your email</span>
                </div> 
                <div class="form-group">
                    <label for="price">Precio</label>
                    <input class="form-control" id="price" min="0" type="number" name="price" required>
                    <span class="help-block">Please enter your email</span>
                </div> 
                <div class="form-group">
                    <label for="quantity">Cantidad</label>
                    <input class="form-control" id="quantity" min="0" type="number" name="quantity" required>
                    <span class="help-block">Please enter your email</span>
                </div> 
                <div class="form-group">
                    <label for="img">Imagen</label>
                    <input class="form-control" id="img" type="file" name="img" required>
                    <span class="help-block">Please enter your email</span>
                </div>
                <div class="form-group">
                    <label for="description">Descricion</label>
                    <textarea class="form-control" name="description" id="description" cols="30" rows="5"></textarea>
                    <span class="help-block">Please enter your email</span>
                </div>
                <div class="form-group">
                    <label for="status">Estado</label>
                    <div class="row">
                        <input class="form-check-input" id="avalilable" type="radio" value="avalilable" name="status">
                        <label class="form-check-label" for="avalilable">Disponible</label>
                        <input class="form-check-input" id="avalilable" type="radio" value="avalilable" name="status">
                        <label class="form-check-label" for="avalilable">No disponible</label>
                    </div>
                    
                    <span class="help-block">Please enter your email</span>
                </div>
            </div>
            <div class="modal-footer"> 
                <button class="btn btn-primary" type="submit">Guardar</button>                   
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>                    
            </div>
            </form>
        </div>
    </div>
</div>