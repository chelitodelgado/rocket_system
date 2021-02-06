@extends('master.app')

@section('title', '- Ventas')

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
                    <span>Ventas</span>
                </h4>
            </div>
        </div>

        <div class="card-body bg bg-info">
            <button id="add_venta" class="btn btn-success">Hacer una venta</button>
            <button id="add_multiventas" class="btn btn-warning">Hacer una multi venta</button>
            <table id="table_ventas" class="table table-light text-center">
                <thead class="thead-light">
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Fecha de venta</th>
                        <th>Total</th>
                        <th>Acción (Solo el admin puede eliminar)</th>
                    </tr>
                </thead>
            </table>
        </div>

    </div>

    <!-- Modal Ventas-->
    <div id="ventasModal" class="modal fade"tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg bg-light">
                    <h5 class="modal-title">Agregar una nueva venta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="ventas_form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <label class="m-0">Producto:</label>
                                <select name="articulo_id" id="articulo_id" class="form-control">
                                    <option>Seleccion el producto</option>
                                    @foreach ($producto as $item)
                                    <option value="{{$item->id}}">{{$item->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- <div class="col-md-6">
                                <label class="m-0">Codigo del producto:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-barcode"></i></div>
                                    </div>
                                    <input type="text" class="form-control" name="codigo" id="codigo" placeholder="Codigo del producto">
                                </div>
                            </div> --}}

                            <div class="col-md-6">
                                <label class="m-0">Cantidad:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-hashtag"></i></div>
                                    </div>
                                    <input type="number" class="form-control" name="cantidad" id="cantidad" placeholder="Cantidad" required>
                                </div>
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

    <!-- Modal Ventas-->
    <div id="multiventasModal" class="modal fade"tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg bg-light">
                    <h5 class="modal-title">Agregar una nueva venta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="multiventas_form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <table id="tabla" class="table table-bordered table-hover dataTable">
                                    <thead>
                                        <tr class="bg bg-gray">
                                            <th style="width: 60%">Producto</th>
                                            <th style="width: 40%">Cantidad</th>
                                            <th style="width: 10%">
                                                <input type="button" id="add" value="Añadir" class="btn btn-sm btn-primary">
                                                <button id="add" class="del btn btn-sm btn-primary"> <i class="fa fa-plus"></i> </button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select name="articulo_id[]" id="articulo_id" class="form-control" >
                                                    <option>Producto</option>
                                                    @foreach ($producto as $item)
                                                    <option value="{{$item->id}}">{{$item->nombre}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <div class="col-md-12">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text"><i class="fas fa-hashtag"></i></div>
                                                        </div>
                                                        <input type="number" class="form-control" name='cantidad[]' id="cantidad" placeholder="Cantidad" required>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <button class="del btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
            $("#table_ventas").DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('ventas.index') }}",
                "columns":[
                    { "data": "nombre" },
                    { "data": "cantidad" },
                    { "data": "created_at"},
                    { "data": "total" ,"render": $.fn.dataTable.render.number( ',', '.', 2, ' $ ' ) },
                    { "data": "action" }
                ]
            });

            /* Abrir ventana modal */
            $('#add_venta').click(function(){
                $('#ventas_form')[0].reset();
                $('.modal-title').text("Agregar una nueva venta");
                $('#action_button').val("Agregar");
                $('#action').val("Agregar");
                $('#ventasModal').modal('show');
            });




            /* Abrir ventana modal */
            $('#add_multiventas').click(function(){
                $('#multiventas_form')[0].reset();
                $('.modal-title').text("Agregar una multi venta");
                $('#action_button').val("Agregar");
                $('#action').val("Agregar");
                $('#multiventasModal').modal('show');
            });

            /* Add column with */

            /**
            * Funcion para añadir una nueva fila en la tabla
            */
            $("#add").click(function(){
			var nuevaFila="<tr> \
				<td><select name='articulo_id[]' id='articulo_id' required class='form-control'><option>Selecciona ...</option>@foreach ($producto as $item)<option value='{{ $item->id }}''>{{ $item->nombre }}</option>@endforeach</select></td> \
				<td><input type='number' name='cantidad[]' required class='form-control'></td> \
				<td><button class='del btn btn-sm btn-danger'> <i class='fa fa-trash'></i> </button></td> \
                </tr>";
                $("#tabla tbody").append(nuevaFila);
            });

            // evento para eliminar la fila
            $("#tabla").on("click", ".del", function(){
                $(this).parents("tr").remove();
            });

            /* Fin */










            // Agregar nuevo empleado y actualizar
            $('#ventas_form').on('submit', function(event){
                event.preventDefault();

                if($('#action').val() == 'Agregar'){
                    $.ajax({
                        url:"{{ route('ventas.store' )}}",
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
                                    title: 'Venta concretada correctamente.',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                $('#ventas_form')[0].reset();
                                $('#table_ventas').DataTable().ajax.reload();
                            }

                        }
                    })
                }
                if($('#action').val() == "Editar"){
                    $.ajax({
                        url:"{{ route('ventas.update') }}",
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
                                    text: 'Comprueba la información'
                                    })
                                }

                            }
                            if(data.success){
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Venta actualizada correctamente.',
                                })
                                $('#ventas_form')[0].reset();
                                $('#ventasModal').modal('hide');
                                $('#table_ventas').DataTable().ajax.reload();
                            }
                        }
                    });
                }

            });

            $(document).on('click', '.edit', function(){
                var id = $(this).attr('id');
                console.log(id);
                $.ajax({
                    url:"ventas/"+id+"/edit",
                    dataType:"json",
                    success:function(html){
                        $('#articulo_id').val(html.data.articulo_id);
                        $('#cantidad').val(html.data.cantidad);
                        $('#hidden_id').val(html.data.id);
                        $('.modal-title').text("Editar esta venta");
                        $('#action_button').val("Editar");
                        $('#action').val("Editar");
                        $('#ventasModal').modal('show');
                    }
                })
            }); /* Fin Script */

            /* Eliminar */
            var venta_id;

            $(document).on('click', '.delete', function(){

                venta_id = $(this).attr('id');

                Swal.fire({
                    title: 'Estas seguro de eliminar esta venta?',
                    showCancelButton: true,
                    confirmButtonText: `Eliminar`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'ventas/destroy/'+venta_id,
                            success:function(data){
                                $('#table_ventas').DataTable().ajax.reload();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Venta eliminda correctamente.',
                                })
                            }
                        })
                        Swal.fire('Eliminación completada!', '', 'success')
                    }
                })

            })


        });
    </script>

@endsection

