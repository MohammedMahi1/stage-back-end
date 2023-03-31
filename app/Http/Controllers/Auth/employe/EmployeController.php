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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        // auth => arriver => auth(interet)
        $datas = Auth::user();
        $interet_user = Auth::user()->interet;
        $arriver = Arriver::where('interet', $interet_user)->get();
        $depart = Depart::where('interet', $interet_user)->get();
        return response()->json([
            'datas' => $datas,
            'Arriver' => $arriver,
            'Depart' => $depart,
        ]);
    }



    public function addImageProfile(Request $request): Response
    {
        $request->validate([
            'image_profile' => 'nullable',
            'image_url' => 'sometimes',
        ]);
    $employe = Auth::user();
        if ($request->hasFile("image_profile")) {
                $exist = Storage::disk('public')->exists("employe/image/{$employe->image_profile}");
                if ($exist) {
                    Storage::disk('public')->delete("employe/image/{$employe->image_profile}");
                    $img = $request->file("image_profile");// Uploadedfile;
                    $imageName = Str::random() . '.' . $img->getClientOriginalName();

                    $path = Storage::disk('public')->putFileAs('employe/image', $img, $imageName);
                    $exis = $employe->update([
                        'image_profile' => $imageName,
                        'image_url' => asset("storage/" . $path)
                    ]);
                    if ($exis) {
                        return Response([
                            'message' => 'image add successfully'
                        ]);
                    }
                }
                else{
                    $img = $request->file("image_profile");// Uploadedfile;
                    $imageName = Str::random() . '.' . $img->getClientOriginalName();
                    $path = Storage::disk('public')->putFileAs('employe/image', $img, $imageName);
                    $exis = $employe->update([
                        'image_profile' => $imageName,
                        'image_url' => asset("storage/" . $path)
                    ]);
                    if ($exis) {
                        return Response([
                            'message' => 'image add successfully'
                        ]);
                    }
                }

        }
        return Response([
            'message'=>'not good'
        ]);
    }
    public function addArriver(Request $request)
    {
        $request->validate([
            'destinataire' => 'required|string',
            'expediteur' => 'required|string',
            'objectif' => 'required|string',
        ]);
        $type = Auth::user()->type;
        $arriver = Arriver::create([
            'destinataire' => $request->destinataire,
            'expediteur' => $request->expediteur,
            'objectif' => $request->objectif,
            'interet' => $request->interet,
            'type' => $type,
            'date_de_fichier' => $request->date_de_fichier,
            'employere' => $request->employere,
        ]);
        $arriver->save();
        return Response([
            'message' => "l'arriver a ete ajouter"
        ]);
    }
    public function addDepart(Request $request): Response
    {
        //
        $request->validate([
            'expediteur' => 'required|string',
            'objectif' => 'required|string',
            'type_de_courier'=>'required|string',
            'date_de_commission'=>'required|string',
            'date_specifiee'=>'required|string',
        ]);
        $arriver = Depart::create([
            'date_de_fichier' => $request->date_de_fichier,
            'objectif' => $request->objectif,
            'expediteur' => $request->expediteur,
            'interet' => $request->interet,
            'employere' => $request->employere,
            'type_de_class' => $request->type_de_class,
            'type_de_courier' => $request->type_de_courier,
            'date_de_commission' => $request->date_de_commission,
            'date_specifiee' => $request->date_specifiee,
        ]);
        $arriver->save();
        return Response([
            'message' => "le depart a ete ajouter"
        ]);
    }
}
