@extends('master.app')

@section('title', '- Proveedores')

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
                    <span>Proveedores</span>
                </h4>
            </div>
        </div>

        <div class="card-body bg bg-light">
            <button id="add_proveedor" class="btn btn-warning">Agregar un proveedor</button>
            <table id="table_proveedor" class="table table-light text-center">
                <thead class="thead-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Clave o RFC</th>
                        <th>Descripción</th>
                        <th>Telefono</th>
                        <th>Giro</th>
                        <th>Acción</th>
                    </tr>
                </thead>
            </table>
        </div>

    </div>

    <!-- Modal Proveedor-->
    <div id="proveedorModal" class="modal fade"tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg bg-light">
                    <h5 class="modal-title">Agregar un nuevo proveedor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="proveedor_form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-md-12">
                                <label class="m-0">Nombre del proveedor</label>
                                <input id="nombre" type="text" class="form-control m-1"
                                 name="nombre" placeholder="Nombre del proveedor" autofocus required>
                            </div>

                            <div class="col-md-12">
                                <label class="m-0">Clave o RFC</label>
                                <input id="ruc" type="text" class="form-control m-1"
                                 name="ruc" placeholder="Clave o RFC" autofocus required>
                            </div>

                            <div class="col-md-12">
                                <label class="m-0">Descripción</label>
                                <textarea name="descripcion" id="descripcion" class="form-control m-1"
                                rows="3" placeholder="Descripción" required></textarea>
                            </div>

                            <div class="col-md-5">
                                <label class="m-0">Telefono</label>
                                <input id="telefono" type="text" class="form-control m-1"
                                 name="telefono" placeholder="Telefono" autofocus required>
                            </div>

                            <div class="col-md-7">
                                <label class="m-0">Empresa del proveedor</label>
                                <input id="giro" type="text" class="form-control m-1"
                                 name="giro" placeholder="Empresa del proveedor" autofocus required>
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

            // Rellenar la tabla de proveedor
            $("#table_proveedor").DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('proveedor.index') }}",
                "columns":[
                    { "data": "nombre" },
                    { "data": "ruc" },
                    { "data": "descripcion" },
                    { "data": "telefono" },
                    { "data": "giro" },
                    { "data": "action" }
                ]
            });

            /* Abrir ventana modal */
            $('#add_proveedor').click(function(){
                $('#proveedor_form')[0].reset();
                $('.modal-title').text("Agregar un nuevo proveedor");
                $('#action_button').val("Agregar");
                $('#action').val("Agregar");
                $('#proveedorModal').modal('show');
            });

            // Agregar nuevo empleado y actualizar
            $('#proveedor_form').on('submit', function(event){
                event.preventDefault();

                if($('#action').val() == 'Agregar'){
                    $.ajax({
                        url:"{{ route('proveedor.store' )}}",
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
                                    title: 'Proveedor agregado',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                $('#proveedor_form')[0].reset();
                                $('#table_proveedor').DataTable().ajax.reload();
                            }
                        }
                    })
                }
                if($('#action').val() == "Editar"){
                    $.ajax({
                        url:"{{ route('proveedor.update') }}",
                        method:"POST",
                        data:new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType:"json",
                        success:function(data){

                            if(data.errors){
                                for(var count = 0; count < data.errors.length; count++){
                                    Swal.fire(
                                        '!Opps algo fallo',
                                        'error'
                                    )
                                }

                            }
                            if(data.success){
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Actualización completada',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                $('#proveedor_form')[0].reset();
                                $('#proveedorModal').modal('hide');
                                $('#table_proveedor').DataTable().ajax.reload();
                            }
                        }
                    });
                }

            });

            $(document).on('click', '.edit', function(){
                var id = $(this).attr('id');
                console.log(id);
                $.ajax({
                    url:"proveedor/"+id+"/edit",
                    dataType:"json",
                    success:function(html){
                        $('#nombre').val(html.data.nombre);
                        $('#ruc').val(html.data.ruc);
                        $('#descripcion').val(html.data.descripcion);
                        $('#telefono').val(html.data.telefono);
                        $('#giro').val(html.data.giro);
                        $('#hidden_id').val(html.data.id);
                        $('.modal-title').text("Editar proveedor");
                        $('#action_button').val("Editar");
                        $('#action').val("Editar");
                        $('#proveedorModal').modal('show');
                    }
                })
            }); /* Fin Script */

            /* Eliminar */
            var proveedor_id;

            $(document).on('click', '.delete', function(){

                proveedor_id = $(this).attr('id');

                Swal.fire({
                    title: 'Estas seguro de eliminar este proveedor?',
                    showCancelButton: true,
                    confirmButtonText: `Si`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'proveedor/destroy/'+proveedor_id,
                            success:function(data){
                            $('#table_proveedor').DataTable().ajax.reload();
                            Swal.fire('Proveedor eliminado!', 'success');
                        }
                        });
                    } else if (result.isDenied) {
                        Swal.fire('Estas seguroi de no guardar', '', 'info')
                    }
                })
            });


        });

    </script>

@endsection
