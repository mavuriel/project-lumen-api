<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function index()
    {
        $datosLibro = Libro::all();

        return response()->json($datosLibro);
    }
}
