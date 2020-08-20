<?php 

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Region;

class RegionsController extends Controller {

    /**
     * obtiene todas las regiones de jalisco activas
     */
    public function index(){
        $regiones = Region::active()->orderBy('name')->get();
        return response()->json($regiones);
    }
}