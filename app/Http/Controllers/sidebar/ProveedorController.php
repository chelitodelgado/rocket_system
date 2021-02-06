<?php

namespace App\Http\Controllers\sidebar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Proveedor;
use Validator;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {

            return datatables()->of(Proveedor::latest()->get())
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

        return view('layouts.sidebar.proveedor');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'nombre'      => 'required|string|max:100',
            'ruc'         => 'required|string|max:100',
            'descripcion' => 'required|string|max:255',
            'telefono'    => 'required|string|max:11',
            'giro'        => 'required|string|max:100'
        );

        $error = Validator::make( $request->all(), $rules );

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'nombre'      => $request->nombre,
            'ruc'         => $request->ruc,
            'descripcion' => $request->descripcion,
            'telefono'    => $request->telefono,
            'giro'        => $request->giro
        );

        Proveedor::create($form_data);


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
        //
        // Busqueda de la proveedor por id
        if ( request()->ajax() ) {
            $data = Proveedor::findOrFail($id);
            return response()->json(['data' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        //Validaciones
        $rules = array(
            'nombre'      => 'required|string|max:100',
            'ruc'         => 'required|string|max:100',
            'descripcion' => 'required|string|max:255',
            'telefono'    => 'required|string|max:11',
            'giro'        => 'required|string|max:100'
        );

        $error = Validator::make( $request->all(), $rules );

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'nombre'      => $request->nombre,
            'ruc'         => $request->ruc,
            'descripcion' => $request->descripcion,
            'telefono'    => $request->telefono,
            'giro'        => $request->giro
        );

        Proveedor::whereId($request->hidden_id)->update($form_data);


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
        //
        // Eliminando la categori por id
        $data = Proveedor::findOrFail($id);
        $data->delete();

    }
}
