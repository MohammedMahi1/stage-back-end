<?php

namespace App\Http\Controllers\Auth\admins;

use App\Http\Controllers\Controller;
use App\Models\Auth\admins\AdminAdministrative;
use App\Models\Auth\admins\AdminFinancieres;
use App\Models\Auth\employe\Employe;
use App\Models\Courrier\Arriver;
use App\Models\Courrier\Depart;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AdminFinancieresController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('login');
    }
    public function login(Request $request): Response
    {
        $finenciere = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:6|max:8',
        ]);

        if (Auth::guard('finenciere')->attempt($finenciere)) {
            $finenciere = AdminFinancieres::where('email', $request->email)->first();
            if ($finenciere && Hash::check($request->password, $finenciere->password)) {
                $device = $request->userAgent();
                $token = $finenciere->createToken($device)->plainTextToken;
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
        $finenciere = Auth::guard('sanctum')->user();
        if (null == $token) {
            $finenciere->currentAccessToken()->delete();
        }
        $personaleToken = PersonalAccessToken::findToken($token);
        if ($finenciere->id === $personaleToken->tokenable_id && get_class($finenciere) === $personaleToken->tokenable_type) {
            $personaleToken->delete();
        }
        return Response([
            'message' => 'logout successful',
        ]);
    }
    public function index(): Response
    {
        $datas = Auth::user();
        $employe = Employe::where('type', 'Finenciere')->get();
        $arriver = Arriver::where('type', 'Finenciere')->get();
        $depart = Depart::where('type_de_class', 'finenciere')->get();
        return Response([
            'datas' => $datas,
            'employe' => $employe,
            'arriver' => $arriver,
            'depart' => $depart,
        ]);

    }
}
