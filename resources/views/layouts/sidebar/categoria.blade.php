@extends('master.app')

@section('title', '- Categorias')

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
                    <span>Categorias</span>
                </h4>
            </div>
        </div>

        <div class="card-body bg bg-light">
            <button id="add_categoria" class="btn btn-warning">Agregar una categoria</button>
            <table id="table_categoria" class="table table-light text-center">
                <thead class="thead-light">
                    <tr>
                        <th style="width: 30%">Nombre</th>
                        <th style="width: 50%">Descripción</th>
                        <th style="width: 20%">Acción</th>
                    </tr>
                </thead>
            </table>
        </div>

    </div>

    <!-- Modal Categoria-->
    <div id="categoriaModal" class="modal fade"tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg bg-light">
                    <h5 class="modal-title">Agregar una nueva categoria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="form_result"></span>
                    <form method="POST" id="categoria_form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <label class="m-0">Nombre de la categoria:</label>
                                <input id="nombre" type="text" class="form-control m-1"
                                 name="nombre" placeholder="Nombre de la categoria" autofocus required>
                            </div>

                            <div class="col-md-12">
                                <label class="m-0">Descripción de la categoria:</label>
                                <textarea name="descripcion" id="descripcion" class="form-control m-1"
                                rows="3" placeholder="Descripción" required></textarea>
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

            // Rellenar la tabla de categorias
            $("#table_categoria").DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('categoria.index') }}",
                "columns":[
                    { "data": "nombre" },
                    { "data": "descripcion" },
                    { "data": "action" }
                ]
            });

            /* Abrir ventana modal */
            $('#add_categoria').click(function(){
                $('#categoria_form')[0].reset();
                $('.modal-title').text("Agregar una nueva categoria");
                $('#action_button').val("Agregar");
                $('#action').val("Agregar");
                $('#categoriaModal').modal('show');
            });

            // Agregar nuevo empleado y actualizar
            $('#categoria_form').on('submit', function(event){
                event.preventDefault();

                if($('#action').val() == 'Agregar'){
                    $.ajax({
                        url:"{{ route('categoria.store' )}}",
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
                                    title: 'Categoria agregado correctamente.',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                $('#categoria_form')[0].reset();
                                $('#table_categoria').DataTable().ajax.reload();
                            }
                        }
                    })
                }
                if($('#action').val() == "Editar"){
                    $.ajax({
                        url:"{{ route('categoria.update') }}",
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
                                    title: 'Categoria agregada correctamente.',
                                })
                                $('#categoria_form')[0].reset();
                                $('#categoriaModal').modal('hide');
                                $('#table_categoria').DataTable().ajax.reload();
                            }
                        }
                    });
                }

            });

            $(document).on('click', '.edit', function(){
                var id = $(this).attr('id');
                console.log(id);
                $.ajax({
                    url:"categoria/"+id+"/edit",
                    dataType:"json",
                    success:function(html){
                        $('#nombre').val(html.data.nombre);
                        $('#descripcion').val(html.data.descripcion);
                        $('#hidden_id').val(html.data.id);
                        $('.modal-title').text("Editar categoria");
                        $('#action_button').val("Editar");
                        $('#action').val("Editar");
                        $('#categoriaModal').modal('show');
                    }
                })
            }); /* Fin Script */

            /* Eliminar */
            var categoria_id;

            $(document).on('click', '.delete', function(){

                categoria_id = $(this).attr('id');

                Swal.fire({
                    title: 'Estas seguro de eliminar esta categoria?',
                    showCancelButton: true,
                    confirmButtonText: `Si`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'categoria/destroy/'+categoria_id,
                            success:function(data){
                            $('#table_categoria').DataTable().ajax.reload();
                            Swal.fire('Categoria eliminado!', '', 'success');
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
