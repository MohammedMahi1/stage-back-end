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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class DirectorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('login','createacc');
    }

    public function login(Request $request): Response
    {
        $director = $request->validate([
            'username' => 'required|string|min:8',
            'password' => 'required|string|min:6|max:8',
        ]);

        if (Auth::guard('director')->attempt($director)) {
            $director = Director::where('username', $request->username)->first();
            if ($director && Hash::check($request->password, $director->password)) {
                $device = $request->userAgent();
                $token = $director->createToken($device)->plainTextToken;
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
        $director = Auth::guard('sanctum')->user();
        if (null == $token) {
            $director->currentAccessToken()->delete();
        }
        $personaleToken = PersonalAccessToken::findToken($token);
        if ($director->id === $personaleToken->tokenable_id && get_class($director) === $personaleToken->tokenable_type) {
            $personaleToken->delete();
        }
        return Response([
            'message' => 'logout successful',
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
        $created = Director::create([
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
