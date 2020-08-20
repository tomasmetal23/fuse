<?php
/**
 * Created by PhpStorm.
 * User: nt1
 * Date: 2019-04-23
 * Time: 10:14
 */

namespace App\Http\Controllers;


use App\Services\CatalogsService;
use Illuminate\Routing\Controller;

class CatalogsController extends Controller
{
    public function index(){
        $serviceCatalog = new CatalogsService();
        $data = $serviceCatalog->getInitCatalogs();
        return response()->json($data);
    }

}