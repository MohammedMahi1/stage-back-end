<?php

namespace App\Http\Controllers\Directory;

use App\Http\Controllers\Controller;
use App\Models\Auth\admins\AdminAdministrative;
use App\Models\Auth\admins\AdminFinancieres;
use App\Models\Auth\admins\AdminTechniques;
use App\Models\Auth\admins\SuperAdmin;
use App\Models\Auth\employe\Employe;
use App\Models\Courrier\Arriver;
use App\Models\Courrier\Depart;
use App\Models\Directory\Director;
use App\Models\Directory\President;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class PresidentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('login','createacc');
    }
    public function login(Request $request): Response
    {
        $superadmin = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string|min:6|max:8',
        ]);

        if (Auth::guard('president')->attempt($superadmin)) {
            $superadmin = President::where('username', $request->username)->first();
            if ($superadmin && Hash::check($request->password, $superadmin->password)) {
                $device = $request->userAgent();
                $token = $superadmin->createToken($device)->plainTextToken;
                return Response([
                    'token' => $token
                ]);
            } else {
                return Response([
                    'message' => 'Your data is incorect'
                ]);
            }
        }
        return Response([
            'message' => 'Your data is incorect'
        ]);

    }
    public function logout($token = null): Response
    {
        $president = Auth::guard('sanctum')->user();
        if (null == $token) {
            $president->currentAccessToken()->delete();
        }
        $personaleToken = PersonalAccessToken::findToken($token);
        if ($president->id === $personaleToken->tokenable_id && get_class($president) === $personaleToken->tokenable_type) {
            $personaleToken->delete();
        }
        return Response([
            'message' => 'logout successful',
        ]);
    }

    public function index() : Response
    {
        $datas = Auth::user();
        $director = Director::all();
        $arriver = Arriver::all();
        $depart = Depart::all();
        $super_admin = SuperAdmin::all();
        $admin_administrative = AdminAdministrative::all();
        $admin_financieres = AdminFinancieres::all();
        $admin_techniques = AdminTechniques::all();
        $employe = Employe::all();
        return Response([
            'datas'=>$datas,
            'Arriver'=>$arriver,
            'Depart'=>$depart,
            'Director' => $director,
            'SuperAdmin' => $super_admin,
            'AdminAdministratives' => $admin_administrative,
            'AdminFinancieres' => $admin_financieres,
            'AdminTechniques' => $admin_techniques,
            'Employe'=>$employe,
        ]);
    }

    public function createacc(Request $request):Response
    {
        $request->validate([
           'fullname'=>'required|string',
           'email'=>'required|string',
           'username'=>'required|string|min:8',
           'password'=>'required|string|min:6'
        ]);
        $created = President::create([
           'fullname' => $request->fullname,
           'email' => $request->email,
           'username' => $request->username,
            'password' => Hash::make($request->password)
        ]);
        $created->save();
        return Response([
           'message' =>'Success'
        ]);
    }
}
