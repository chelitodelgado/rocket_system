@extends('master.app')

@section('title', '- Productos')

@section('sidebar')
    @parent

@endsection

@section('content')

@yield('content')

    <div class="container-fluid mt-5">

        <div class="card mb-4 wow fadeIn animated" style="visibility: visible; animation-name: fadeIn;">
            <div class="card-body d-sm-flex justify-content-between">
                <h4 class="mb-2 mb-sm-0 pt-1">
                    <a href="#">Inicio</a>
                    <span>/</span>
                    <span>Productos</span>
                </h4>
            </div>
        </div>

        <p>
            <button class="btn btn-success" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                <i class="fa fa-upload" aria-hidden="true"></i>
                - Importar catalogo de productos (Excel/sgv)
            </button>
        </p>
        <div class="collapse" id="collapseExample">
        <div class="card card-body">
            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
        </div>
        </div>

        <div class="card-body bg bg-light">
            <button id="add_producto" class="btn btn-warning">Agregar un producto</button>
            <table id="table_producto" class="table table-light text-center">
                <thead class="thead-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Codígo</th>
                        <th>Precio de compra</th>
                        <th>Precio de de venta</th>
                        <th>Stock</th>
                        <th>Acción</th>
                    </tr>
                </thead>
            </table>
        </div>

    </div>

    <!-- Modal Producto-->
    <div id="productoModal" class="modal fade"tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg bg-light">
                    <h5 class="modal-title">Agregar un nuevo producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="producto_form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-md-12">
                                <label class="m-0">Nombre del producto:</label>
                                <input id="nombre" type="text" class="form-control m-1"
                                 name="nombre" placeholder="Nombre del producto" autofocus required>
                            </div>

                            <div class="col-md-12">
                                <label class="m-0">Descripción:</label>
                                <textarea name="descripcion" id="descripcion" class="form-control m-1"
                                rows="3" placeholder="Descripción" required></textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="m-0">Codigo del producto:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-barcode"></i></div>
                                    </div>
                                    <input type="text" class="form-control" name="codigo" id="codigo" placeholder="Codigo del producto" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="m-0">Precio de compra:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-dollar-sign"></i></div>
                                    </div>
                                    <input type="text" class="form-control" name="precio_unitario" id="precio_unitario" placeholder="Precio de compra" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="m-0">Precio de venta:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-dollar-sign"></i></div>
                                    </div>
                                    <input type="text" class="form-control" name="precio_venta" id="precio_venta" placeholder="Precio de venta" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="m-0">Stock:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-hashtag"></i></div>
                                    </div>
                                    <input type="text" class="form-control" name="stock" id="stock" placeholder="Stock" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label class="m-0">Categoria:</label>
                                <select name="categoria_id" id="categoria_id" class="form-control m-1">
                                    <option>Seleccione una categoria</option>
                                    @foreach ($categoria as $item)
                                    <option value="{{ $item->id }}" >{{ $item->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label class="m-0">Proveedor:</label>
                                <select name="proveedor_id" id="proveedor_id" class="form-control m-1">
                                    <option>Seleccione un proveedor</option>
                                    @foreach ($proveedor as $item)
                                    <option value="{{ $item->id }}" >{{ $item->nombre }} -- {{ $item->giro }} </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="action" id="action" />
                                <input type="hidden" name="hidden_id" id="hidden_id" />
                                <input type="submit" name="action_button"
                                    id="action_button" class="btn btn-warning" value="Agregar" />
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        $(document).ready( function() {

            // Rellenar la tabla de producto
            $("#table_producto").DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('producto.index') }}",
                "columns":[
                    { "data": "nombre" },
                    { "data": "descripcion" },
                    { "data": "codigo" },
                    { "data": "precio_unitario","render": $.fn.dataTable.render.number( ',', '.', 2, ' $ ' ) },
                    { "data": "precio_venta" ,"render": $.fn.dataTable.render.number( ',', '.', 2, ' $ ' ) },
                    { "data": "stock","render": $.fn.dataTable.render.number( ',', '.', 2, ' # ' ) },
                    { "data": "action" }
                ]
            });

            /* Abrir ventana modal */
            $('#add_producto').click(function(){
                $('#producto_form')[0].reset();
                $('.modal-title').text("Agregar un nuevo producto");
                $('#action_button').val("Agregar");
                $('#action').val("Agregar");
                $('#productoModal').modal('show');
            });

            // Agregar nuevo producto y actualizar
            $('#producto_form').on('submit', function(event){
                event.preventDefault();

                if($('#action').val() == 'Agregar'){
                    $.ajax({
                        url:"{{ route('producto.store' )}}",
                        method:"POST",
                        data:new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "json",
                        success:function(data){

                            if(data.errors){

                                for(var count = 0; count < data.errors.length; count++){
                                    Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    footer: '<p>'+data.errors[count]+'</p>'
                                    })
                                }
                            }
                            if(data.success){
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Producto agregado',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                $('#producto_form')[0].reset();
                                $('#table_producto').DataTable().ajax.reload();
                            }
                        }
                    })
                }
                if($('#action').val() == "Editar"){
                    $.ajax({
                        url:"{{ route('producto.update') }}",
                        method:"POST",
                        data:new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType:"json",
                        success:function(data){

                            if(data.errors){
                                for(var count = 0; count < data.errors.length; count++){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        footer: '<p>'+data.errors[count]+'</p>'
                                    })
                                }

                            }
                            if(data.success){
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Producto actualizado',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                $('#producto_form')[0].reset();
                                $('#productoModal').modal('hide');
                                $('#table_producto').DataTable().ajax.reload();
                            }
                        }
                    });
                }

            });

            $(document).on('click', '.edit', function(){
                var id = $(this).attr('id');
                console.log(id);
                $.ajax({
                    url:"producto/"+id+"/edit",
                    dataType:"json",
                    success:function(html){
                        $('#nombre').val(html.data.nombre);
                        $('#descripcion').val(html.data.descripcion);
                        $('#codigo').val(html.data.codigo);
                        $('#precio_unitario').val(html.data.precio_unitario);
                        $('#precio_venta').val(html.data.precio_venta);
                        $('#categoria_id').val(html.data.categoria_id);
                        $('#proveedor_id').val(html.data.proveedor_id);
                        $('#stock').val(html.data.stock);
                        $('#hidden_id').val(html.data.id);
                        $('.modal-title').text("Editar producto");
                        $('#action_button').val("Editar");
                        $('#action').val("Editar");
                        $('#productoModal').modal('show');
                    }
                })
            }); /* Fin Script */

            /* Eliminar */
            var producto_id;

            $(document).on('click', '.delete', function(){

                producto_id = $(this).attr('id');

                Swal.fire({
                    title: 'Estas seguro de eliminar este producto?',
                    showCancelButton: true,
                    confirmButtonText: `Si`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'producto/destroy/'+producto_id,
                            success:function(data){
                            $('#table_producto').DataTable().ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Producto eliminado correctamente.',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                        });
                    } else if (result.isDenied) {
                        Swal.fire('Estas seguro de no guardar', '', 'info')
                    }
                })
            });


        });

    </script>

@endsection

