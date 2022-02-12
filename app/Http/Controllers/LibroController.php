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

    public function eliminar($id)
    {
        $datosLibro = Libro::find($id);

        if ($datosLibro) {
            $rutaArchivo = base_path('public') . $datosLibro->image;

            if (file_exists($rutaArchivo)) {
                unlink($rutaArchivo);
            }

            $datosLibro->delete();
            $respuesta = [
                'status' => 'ok',
                'message' => 'Libro borrado',
            ];
        }

        return response()->json($respuesta);
    }

    public function actualizar(Request $req, $id)
    {
        $datosLibro = Libro::find($id);

        if ($req->hasFile('image')) {

            if ($datosLibro) {
                $rutaArchivo = base_path('public') . $datosLibro->image;

                if (file_exists($rutaArchivo)) {
                    unlink($rutaArchivo);
                }

                $datosLibro->delete();

                $respuesta = [
                    'status' => 'ok',
                    'message' => 'Libro borrado',
                ];
            }

            $nombreArchivoOriginal = $req->file('image')->getClientOriginalName();

            $nuevoNombreArchivo = Carbon::now()->timestamp . "_" . $nombreArchivoOriginal;

            $carpetaDestino = "./upload/";

            $req->file('image')->move($carpetaDestino, $nuevoNombreArchivo);

            $datosLibro->image = ltrim($carpetaDestino, '.') . $nuevoNombreArchivo;

            $datosLibro->save();

        }

        if ($req->input('titulo')) {
            $datosLibro->titulo = $req->input('titulo');
        }

        $datosLibro->save();

        return response()->json(['Datos actualizados', $respuesta]);
    }
}
