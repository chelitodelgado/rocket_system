<?php

namespace App\Http\Controllers\sidebar;

use App\Http\Controllers\Controller;
use App\Producto;
use App\Categoria;
use App\Proveedor;
use Illuminate\Http\Request;
use Validator;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categoria = Categoria::latest()->get();
        $proveedor = Proveedor::latest()->get();

        if (request()->ajax()) {

            return datatables()->of(Producto::latest()->get())
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

        return view('layouts.sidebar.productos', [
            'categoria' => $categoria,
            'proveedor' => $proveedor
        ]);
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

        $user = \Auth::user();
        $id = $user->id;

        //Validaciones
        $rules = array(
            'nombre'          => 'required|string|max:100',
            'descripcion'     => 'required|string|max:255',
            'codigo'          => 'required|string|max:255',
            'precio_unitario' => 'required|string|max:255',
            'precio_venta'    => 'required|string|max:255',
            'stock'           => 'required',
            'categoria_id'    => 'required',
            'proveedor_id'    => 'required'
        );

        $error = Validator::make( $request->all(), $rules );

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'nombre'          => $request->nombre,
            'descripcion'     => $request->descripcion,
            'codigo'          => $request->codigo,
            'precio_unitario' => $request->precio_unitario,
            'precio_venta'    => $request->precio_venta,
            'stock'           => $request->stock,
            'user_id'         => $id,
            'categoria_id'    => $request->categoria_id,
            'proveedor_id'    => $request->proveedor_id
        );

        Producto::create($form_data);


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
            $data = Producto::findOrFail($id);
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
        $user = \Auth::user();
        $id = $user->id;

        //Validaciones
        $rules = array(
            'nombre'          => 'required|string|max:100',
            'descripcion'     => 'required|string|max:255',
            'codigo'          => 'required|string|max:255',
            'precio_unitario' => 'required|string|max:255',
            'precio_venta'    => 'required|string|max:255',
            'stock'           => 'required',
            'categoria_id'    => 'required',
            'proveedor_id'    => 'required'
        );

        $error = Validator::make( $request->all(), $rules );

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'nombre'          => $request->nombre,
            'descripcion'     => $request->descripcion,
            'codigo'          => $request->codigo,
            'precio_unitario' => $request->precio_unitario,
            'precio_venta'    => $request->precio_venta,
            'stock'           => $request->stock,
            'user_id'         => $id,
            'categoria_id'    => $request->categoria_id,
            'proveedor_id'    => $request->proveedor_id
        );

        Producto::whereId($request->hidden_id)->update($form_data);


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
        $data = Producto::findOrFail($id);
        $data->delete();
    }
}
