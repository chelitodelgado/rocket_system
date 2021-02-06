@extends('master.app')

@section('title', '- Mi empresa')

@section('sidebar')
    @parent

@endsection

@section('content')

        @yield('content')

        <!-- Jumbotron -->
        <div class="jumbotron text-center">

            <!-- Card image -->
            <div class="view overlay my-4 waves-light" mdbWavesEffect>
                <img src="{{ asset('logotipo.png') }}" class="img-fluid mx-auto" alt="">
            </div>

            @empty($empresa)
            <h5 class="indigo-text h5 mb-4">
                <button id="btn_empresa" type="button" class="btn btn-blue-grey">Agregar informacion de mi empresa</button>
            </h5>
            @endempty

            @foreach ($empresa as $item)
            <div class="card">
                <div class="header">
                <h2 class="card-title h2 pb-2"><strong>Información de mi empresa</strong></h2>
                </div>
                <div class="card-body">
                <!--Nombre de la empresa-->
                    <h4 class="card-title">{{ $item->nombre }}</h4>
                    <!--Ramo de la empresa-->
                    <h4 class="card-title">{{ $item->ramo }}</h4>
                    <!--Email corporativo-->
                    <h4 class="card-title">{{ $item->email }}</h4>
                </div>
                @endforeach
            </div>

        </div>

        <div class="card testimonial-card">

            <!--Bacground color-->
            <div class="card-up indigo lighten-1">
            </div>

            <div class="card-footer bg bg-primary">

                <button id="add_user" type="button" color="info" class="btn btn-info"
                data-toggle="modal" data-target="#exampleModal">Nuevo usuario</button>

                <table id="table_users" class="table table-light text-center">
                    <thead class="thead-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Rol</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                </table>
            </div>

        </div>

        <!-- Modal Usuario-->
        <div id="userModal" class="modal fade"tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg bg-light">
                        <h5 class="modal-title">Agregar nuevo usuario</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <span id="form_result"></span>
                        <form method="POST" id="user_form" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="m-0">Nombre completo:</label>
                                    <input id="name" type="text" class="form-control m-1"
                                     name="name" placeholder="Nombre completo" autofocus required>
                                </div>

                                <div class="col-md-6">
                                    <label class="m-0">RFC/CURP:</label>
                                    <input id="rfc" type="text" class="form-control m-1"
                                     name="rfc" placeholder="RFC/CURP" required>
                                </div>


                                <div class="col-md-6">
                                    <label class="m-0">Correo electronico:</label>
                                    <input id="email" type="email" class="form-control m-1"
                                     name="email" placeholder="Email" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="m-0">Contraseña:</label>
                                    <input id="password" type="password" class="form-control m-1"
                                     name="password" placeholder="Contraseña">
                                </div>

                                <div class="col-md-6">
                                    <label class="m-0">Tipo de usuario:</label>
                                    <select name="role" id="role" class="form-control m-1">
                                        @foreach ($role as $item)
                                        <option value="{{$item->name}}">{{$item->description}}</option>
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
        <!-- Modal Empresa-->
        <div id="empresaModal" class="modal fade"tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg bg-light">
                        <h5 class="modal-title">Agregar información sobre mi empresa</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" id="empresa_form" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="m-0">Nombre:</label>
                                    <input id="nombre" type="text" class="form-control m-1"
                                     name="nombre" placeholder="Nombre" autofocus required>
                                </div>

                                <div class="col-md-6">
                                    <label class="m-0">Ramo:</label>
                                    <input id="ramo" type="text" class="form-control m-1"
                                     name="ramo" placeholder="Ramo de la empresa" required>
                                </div>


                                <div class="col-md-6">
                                    <label class="m-0">Descripción:</label>
                                    <textarea name="descripcion" id="descripcion" placeholder="Descripción" class="form-control m-1" cols="3" required></textarea>
                                </div>

                                <div class="col-md-6">
                                    <label class="m-0">Correo electronico:</label>
                                    <input id="email_empresa" type="email" class="form-control m-1"
                                     name="email_empresa" placeholder="Email">
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="hidden" name="action_empresa" id="action_empresa" />
                                    <input type="hidden" name="hidden_id_empresa" id="hidden_id_empresa" />
                                    <input type="submit" name="action_button"
                                        id="action_button_empresa" class="btn btn-warning" value="Agregar" />
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

        <!-- Script -->
        <script type="text/javascript">

            $(document).ready( function() {

                // Agregar empresa
                $('#btn_empresa').click( function() {
                    $('#empresa_form')[0].reset();
                    $('.modal-title').text("Agregar información sobre mi empresa");
                    $('#action_button').val("Agregar");
                    $('#action').val("Agregar");
                    $('#empresaModal').modal('show');
                });

                // Agregar nuevo empleado y actualizar
                $('#empresa_form').on('submit', function(event){
                    event.preventDefault();

                    if($('#action').val() == 'Agregar'){
                        $.ajax({
                            url:"{{ route('empresa.create' )}}",
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
                                        title: 'Datos de la empresa actualizados',
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                    $('#btn_empresa').hide();
                                    $('#user_form')[0].reset();
                                    $('#table_users').DataTable().ajax.reload();
                                }
                            }
                        })
                    }
                    if($('#action').val() == "Editar"){
                        $.ajax({
                            url:"{{ route('empresa.update') }}",
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
                                    Swal.fire(
                                            'Actualización completa',
                                            'success'
                                        )
                                    $('#user_form')[0].reset();
                                    $('#table_users').DataTable().ajax.reload();
                                }
                            }
                        });
                    }

                });

                /* Abrir ventana modal */
                $('#add_user').click(function(){
                    $('#user_form')[0].reset();
                    $('.modal-title').text("Agregar un nuevo usuario");
                    $('#action_button').val("Agregar");
                    $('#action').val("Agregar");
                    $('#userModal').modal('show');
                });

                // Rellenar el datatable
                $("#table_users").DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "{{ route('empresa.index') }}",
                    "columns":[
                        { "data": "name" },
                        { "data": "description" },
                        { "data": "action" }
                    ]
                });

                // Agregar nuevo empleado y actualizar
                $('#user_form').on('submit', function(event){
                    event.preventDefault();

                    if($('#action').val() == 'Agregar'){
                        $.ajax({
                            url:"{{ route('empresa.store' )}}",
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
                                        title: 'Oops... comprube la información.',
                                        footer: '<p>'+data.errors[count]+'</p>'
                                        })
                                    }
                                }
                                if(data.success){
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Usuario agregado correctamente.',
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                    $('#user_form')[0].reset();
                                    $('#table_users').DataTable().ajax.reload();
                                }
                            }
                        })
                    }
                    if($('#action').val() == "Editar"){
                        $.ajax({
                            url:"{{ route('empresa.update') }}",
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
                                        title: 'Usuario actualizado correctamente.',
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                    $('#user_form')[0].reset();
                                    $('#table_users').DataTable().ajax.reload();
                                }
                            }
                        });
                    }

                });

                $(document).on('click', '.edit', function(){
                    var id = $(this).attr('id');
                    $('#form_result').html('');
                    $.ajax({
                        url:"empresa/"+id+"/edit",
                        dataType:"json",
                        success:function(html){
                            console.log(html.data);
                            $('#name').val(html.data.name);
                            $('#rfc').val(html.data.rfc);
                            $('#email').val(html.data.email);
                            $('#password').val(html.data.password);
                            $('#hidden_id').val(html.data.id);
                            $('.modal-title').text("Editar usuario");
                            $('#action_button').val("Editar");
                            $('#action').val("Editar");
                            $('#userModal').modal('show');
                        }
                    })
                }); /* Fin Script */

                /* Eliminar */
                var user_id;

                $(document).on('click', '.delete', function(){

                    user_id = $(this).attr('id');

                    Swal.fire({
                        title: 'Estas seguro de eliminar a este usuario?',
                        showCancelButton: true,
                        confirmButtonText: `Si`,
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            $.ajax({
                                url: 'empresa/destroy/'+user_id,
                                success:function(data){
                                    console.log(data);
                                $('#table_users').DataTable().ajax.reload();
                                Swal.fire('Usuario eliminado!', '', 'success');
                            }
                            });
                        } else if (result.isDenied) {
                            Swal.fire('Changes are not saved', '', 'info')
                        }
                    })
                });

            });

        </script>

@endsection
