<?php

namespace App\Http\Controllers;

use App\Models\MeasurementUnit;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class MeasurementUnitController extends Controller
{
    public function storage(Request $request, MeasurementUnit $measurementUnit)
    {
        $measurementUnit->fill($request->all());
        $measurementUnit->save();
        return response()->json($measurementUnit);
    }
}
