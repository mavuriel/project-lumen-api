<?php
namespace App\Http\Controllers;

use App\Models\Libro;
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

        $datosLibro->titulo = $req->titulo;
        $datosLibro->image = $req->image;

        $datosLibro->save();

        return response()->json($req);
    }
}
