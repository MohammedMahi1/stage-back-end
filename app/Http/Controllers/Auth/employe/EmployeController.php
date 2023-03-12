<?php

namespace App\Http\Controllers\Auth\employe;

use App\Http\Controllers\Controller;
use App\Models\Auth\employe\Employe;
use App\Models\Courrier\Arriver;
use App\Models\Courrier\Depart;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class EmployeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('login');
    }

    public function login(Request $request): Response
    {
        $employe = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:8',
        ]);

        if (Auth::guard('employe')->attempt($employe)) {
            $employe = Employe::where('email', $request->email)->first();
            if ($employe && Hash::check($request->password, $employe->password)) {
                $device = $request->userAgent();
                $token = $employe->createToken($device)->plainTextToken;
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
        $employe = Auth::guard('sanctum')->user();
        if (null == $token) {
            $employe->currentAccessToken()->delete();
        }
        $personaleToken = PersonalAccessToken::findToken($token);
        if ($employe->id === $personaleToken->tokenable_id && get_class($employe) === $personaleToken->tokenable_type) {
            $personaleToken->delete();
        }
        return Response([
            'message' => 'logout successful',
        ]);
    }


    // Returning the datas
    public function index()
    {
        $arriver = Arriver::all();
        $depart = Depart::all();
        $datas = Auth::user();
        return response()->json([
            'datas' => $datas,
            'Arriver' => $arriver,
            'Depart' => $depart,
        ]);
    }

    public function addArriver(Request $request): Response
    {
        $request->validate([
            'destinataire' => 'required|string',
            'expediteur' => 'required|string',
            'objectif' => 'required|string',
            'interet' => 'required|string',
        ]);
        $arriver = Arriver::create([
            'destinataire' => $request->destinataire,
            'expediteur' => $request->expediteur,
            'objectif' => $request->objectif,
            'interet' => $request->interet,
            'date_de_fichier' => $request->date_de_fichier,
            'employere' => $request->employere,
        ]);
        $arriver->save();
        return Response([
            'message' => "l'arriver a ete ajouter"
        ]);
    }
}
