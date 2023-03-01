<?php

namespace App\Http\Controllers\Directory;

use App\Http\Controllers\Controller;
use App\Models\Auth\admins\AdminAdministrative;
use App\Models\Auth\admins\AdminFinancieres;
use App\Models\Auth\admins\AdminTechniques;
use App\Models\Auth\admins\SuperAdmin;
use App\Models\Auth\employe\Employe;
use App\Models\Directory\Director;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class PresidentController extends Controller
{
    public function index() : Response
    {
        $director = Director::all();
        $super_admin = SuperAdmin::all();
        $admin_administrative = AdminAdministrative::all();
        $admin_financieres = AdminFinancieres::all();
        $admin_techniques = AdminTechniques::all();
        $employe = Employe::all();
        return Response([
            'Director' => $director,
            'SuperAdmin' => $super_admin,
            'AdminAdministratives' => $admin_administrative,
            'AdminFinancieres' => $admin_financieres,
            'AdminTechniques' => $admin_techniques,
            'Employe'=>$employe,
        ]);
    }

    function addDirector(Request $request):Response
    {
        $valide = $request->validate([
            'fullname' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|min:6|max:8',
        ]);
        if ($valide)
        {
            $username = Str::random(6);
            $addemp = Director::create([
                'fullname' => $request->fullname,
                'username' => strtoupper($username),
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $addemp->save();
            return Response([
                'message' => 'Director has been add succes'
            ]);
        }
        return Response([
            'message' => 'your data is have some error validation'
        ]);
    }
}
