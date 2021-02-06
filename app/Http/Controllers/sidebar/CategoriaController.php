<?php

namespace App\Http\Controllers\sidebar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Categoria;
use Validator;

class CategoriaController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index()
    {

        if (request()->ajax()) {

            return datatables()->of(Categoria::latest()->get())
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

        return view('layouts.sidebar.categoria');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
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
            'nombre'        => 'required|string|max:100',
            'descripcion'   => 'required|string|max:255'
        );

        $error = Validator::make( $request->all(), $rules );

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion
        );

        Categoria::create($form_data);


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
        // Busqueda de la categoria por id
        if ( request()->ajax() ) {
            $data = Categoria::findOrFail($id);
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
        //Validaciones
        $rules = array(
            'nombre'        => 'required|string|max:100',
            'descripcion'   => 'required|string|max:255'
        );

        $error = Validator::make( $request->all(), $rules );

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion
        );

        Categoria::whereId($request->hidden_id)->update($form_data);


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
        // Eliminando la categori por id
        $data = Categoria::findOrFail($id);
        $data->delete();
    }
}
