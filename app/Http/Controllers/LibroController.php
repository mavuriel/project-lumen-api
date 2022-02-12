<?php
namespace App\Http\Controllers;

use App\Models\Libro;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LibroController extends Controller
{
    public function index()
    {
        $datosLibro = Libro::all();

        return response()->json($datosLibro);
    }

    public function guardar(Request $req)
    {
        $datosLibro = new Libro;

        if ($req->hasFile('image')) {
            $nombreArchivoOriginal = $req->file('image')->getClientOriginalName();

            $nuevoNombreArchivo = Carbon::now()->timestamp . "_" . $nombreArchivoOriginal;

            $carpetaDestino = "./upload/";

            $req->file('image')->move($carpetaDestino, $nuevoNombreArchivo);

            $datosLibro->titulo = $req->titulo;
            $datosLibro->image = ltrim($carpetaDestino, '.') . $nuevoNombreArchivo;

            $datosLibro->save();

        }

        return response()->json($nuevoNombreArchivo);
    }

    public function ver($id)
    {
        $datosLibro = new Libro;
        $datosEncontrados = $datosLibro->find($id);

        return response()->json($datosEncontrados);
    }
}
