<?php 

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Municipio;

class MunicipiosController extends Controller {

    /**
     * obtiene todos los municipios activos de jalisco
     */
    public function index(){
        $municipios = Municipio::active()->orderBy('name')->get();
        return response()->json($municipios);
    }
}