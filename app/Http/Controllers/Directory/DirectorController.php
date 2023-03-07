<?php

namespace App\Http\Controllers\Directory;

use App\Http\Controllers\Controller;
use App\Models\Auth\admins\AdminAdministrative;
use App\Models\Auth\admins\AdminFinancieres;
use App\Models\Auth\admins\AdminTechniques;
use App\Models\Auth\admins\SuperAdmin;
use App\Models\Auth\employe\Employe;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class DirectorController extends Controller
{
    public function index():Response
    {
        $super_admin = SuperAdmin::all();
        $admin_administrative = AdminAdministrative::all();
        $admin_financieres = AdminFinancieres::all();
        $admin_techniques = AdminTechniques::all();
        $employe = Employe::all();
        return Response([
            'SuperAdmin' => $super_admin,
            'AdminAdministratives' => $admin_administrative,
            'AdminFinancieres' => $admin_financieres,
            'AdminTechniques' => $admin_techniques,
            'Employe'=>$employe,
        ]);
    }

    function addSuperAdmin(Request $request):Response
    {
        $valide = $request->validate([
            'fullname' => 'required|string',
            'CIN' => 'required|min:8|max:12',
            'username' => 'required|string|min:8|max:12',
            'email' => 'required|email',
            'password' => 'required|min:6|max:8',
        ]);
        if ($valide) {
            $addsuperadmin = SuperAdmin::create([
                'fullname' => $request->fullname,
                'CIN' => $request->CIN,
                'username'=>$request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $addsuperadmin->save();
            return Response([
                'message' => 'Super admin has been add succes'
            ]);
        }
        return Response([
            'message' => 'your data is have some error validation'
        ]);
    }
}
