<?php

namespace App\Http\Controllers\Auth\admins;

use App\Http\Controllers\Controller;
use App\Models\Auth\employe\Employe;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminTechniquesController extends Controller
{
    public function index():Response
    {
        $all = Employe::where('type','=','Technique')->get();
        if(count($all))
        {
            return Response([
                'message' => $all
            ]);
        }
        return Response([
            'message' => 'There are no employees available'
        ]);

    }
}
