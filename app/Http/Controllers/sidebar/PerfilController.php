<?php

namespace App\Http\Controllers\sidebar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;
use App\Empresa;
use App\RoleUser;
use Validator;

class PerfilController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {

        $empresa = Empresa::latest()->get();
        $role = Role::latest()->get();
        $users =  RoleUser::query('role_user')
            ->join('users', 'role_user.user_id', '=', 'users.id')
            ->join('roles',  'role_user.role_id',  '=', 'roles.id')
            ->select('role_user.*',
                     'users.name',
                     'roles.id',
                     'roles.description'
                    )
            ->get();

        if (request()->ajax()) {
            return datatables()->of($users)
                ->addColumn('action', function ($data) {
                    $button = '<a style="cursor:pointer"
                    name="edit" id="' . $data->id . '"
                    class="edit btn btn-sm btn-warning"><i class="fa fa-edit"></i></a> ';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a style="cursor:pointer"
                    name="delete" id="' . $data->id . '"
                    class="delete btn btn-sm btn-danger"><i class="fa fa-trash"></i></a> ';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('layouts.sidebar.empresa', [
            'empresa' => $empresa,
            'role'    => $role
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create( Request $request)
    {
        //Validaciones
        $rules = array(
            'nombre'        => 'required|string|max:100',
            'ramo'          => 'required|string|max:255',
            'descripcion'   => 'required|string|max:255',
            'email_empresa' => 'required|string|email|max:255'
        );

        $error = Validator::make( $request->all(), $rules );

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }



        $form_data = array(
            'nombre'      => $request->nombre,
            'ramo'        => $request->ramo,
            'descripcion' => $request->descripcion,
            'email'       => $request->email_empresa,
            'user_id'     => 1
        );

        Empresa::create($form_data);


        return response()->json(['success' => 'OK']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        //Validaciones
        $rules = array(
            'name'     => 'required|string|max:100',
            'email'    => 'required|string|email|max:255',
            'rfc'      => 'required|string|max:100',
            'password' => 'required|string|max:255'
        );

        $error = Validator::make( $request->all(), $rules );

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'name'      => $request->name,
            'email'     => $request->email,
            'rfc'       => $request->rfc,
            'password'  => Hash::make($request->password)
        );

        User::create($form_data)->roles()->attach(Role::where('name', $request->role)->first() );


        return response()->json(['success' => 'OK']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Retornar el id del usuaurio a editar
        if ( request()->ajax() ) {
            $data = User::findOrFail($id);
            return response()->json(
                [
                    'data' => $data
                ]
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
        // Actualizar usuarios
        //Validaciones

        /*TODO: Terminar el proceso de editar el usuario ya que no me permite editar el campo de rol.
                Decoficar la contraseña para terminar el modulo de usuarios.
        */

        $rules = array(
            'name'     => 'required|string|max:100',
            'email'    => 'required|string|email|max:255',
            'rfc'      => 'required|string|max:100'
        );

        $error = Validator::make( $request->all(), $rules );

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'name'      => $request->name,
            'email'     => $request->email,
            'rfc'       => $request->rfc
        );
        // User::create($form_data)->roles()->attach(Role::where('name', $request->role)->first() );
        User::whereId($request->hidden_id)->update($form_data);


        return response()->json(['success' => 'OK']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Eliminar el usuario seleccionado
        $data = User::findOrFail($id);
        $data->delete();
    }
}
