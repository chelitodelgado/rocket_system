<?php

namespace App\Http\Controllers\sidebar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Ventas;
use App\Producto;
use DateTime;
use Illuminate\Support\Facades\DB;
use Validator;

class VentasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $producto = Producto::latest()->get();

        $datatable = Producto::query('articulo')
            ->join('ventas', 'articulo.id', '=', 'ventas.articulo_id')
            ->select('articulo.nombre', 'ventas.*')
            ->get();

        if (request()->ajax()) {

            return datatables()->of($datatable)
                ->addColumn('action', function ($data) {
                    $button = '<a style="cursor:pointer"
                    name="edit" id="' . $data->id . '"
                    class="edit btn btn-sm btn-warning">Editar</a> ';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a style="cursor:pointer"
                    name="delete" id="' . $data->id . '"
                    class="delete btn btn-sm btn-danger">Eliminar</a> ';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);

        }
        // Redireccionar a vista de ventas
        return view('layouts.sidebar.venta',[
            'producto' => $producto
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
    public function store(Request $request)
    {

        $total = 0;
        $stock = 0;

        $date = new DateTime('today');

        //Validaciones
        $rules = array(
            'articulo_id' => 'required',
            'cantidad'    => 'required'
        );

        $error = Validator::make( $request->all(), $rules );

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        // Obtener la data de Producto
        $producto = Producto::findOrFail($request->articulo_id);
        $stock = $producto->stock - $request->cantidad;


        Producto::whereId($producto->id)->update(['stock' =>  $stock]);

        $total = $producto->precio_venta * $request->cantidad;


        $form_data = array(
            'articulo_id' => $request->articulo_id,
            'cantidad'    => $request->cantidad,
            'total'       => $total,
            'created_at'  => $date
        );

        Ventas::create($form_data);


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
            $data = Ventas::findOrFail($id);
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

        $total = 40;

        //Validaciones
        $rules = array(
            'articulo_id' => 'required',
            'cantidad'    => 'required'
        );

        $error = Validator::make(  $request->all(), $rules );

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'articulo_id' => $request->articulo_id,
            'cantidad'    => $request->cantidad,
            'total'       => $total
        );

        Ventas::whereId($request->hidden_id)->update($form_data);


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
        $data = Ventas::findOrFail($id);
        $data->delete();
    }
}
