<?php

namespace App\Http\Controllers\Auth\admins;

use App\Http\Controllers\Controller;
use App\Models\Auth\admins\AdminAdministrative;
use App\Models\Auth\admins\SuperAdmin;
use App\Models\Auth\employe\Employe;
use App\Models\Courrier\Arriver;
use App\Models\Courrier\Depart;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;

class AdminAdministrativeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('login');
    }

    public function login(Request $request): Response
    {
        $administrative = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:6|max:8',
        ]);

        if (Auth::guard('administrative')->attempt($administrative)) {
            $administrative = AdminAdministrative::where('email', $request->email)->first();
            if ($administrative && Hash::check($request->password, $administrative->password)) {
                $device = $request->userAgent();
                $token = $administrative->createToken($device)->plainTextToken;
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
        $administrative = Auth::guard('sanctum')->user();
        if (null == $token) {
            $administrative->currentAccessToken()->delete();
        }
        $personaleToken = PersonalAccessToken::findToken($token);
        if ($administrative->id === $personaleToken->tokenable_id && get_class($administrative) === $personaleToken->tokenable_type) {
            $personaleToken->delete();
        }
        return Response([
            'message' => 'logout successful',
        ]);
    }
    public function addImageProfile(Request $request): Response
    {
        $request->validate([
            'image_profile' => 'nullable',
            'image_url' => 'sometimes',
        ]);
        $administrative = Auth::user();
        if ($request->hasFile("image_profile")) {
            $exist = Storage::disk('public')->exists("administrative/image/{$administrative->image_profile}");
            if ($exist) {
                Storage::disk('public')->delete("administrative/image/{$administrative->image_profile}");
                $img = $request->file("image_profile");// Uploadedfile;
                $imageName = Str::random() . '.' . $img->getClientOriginalName();

                $path = Storage::disk('public')->putFileAs('administrative/image', $img, $imageName);
                $exis = $administrative->update([
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
                $path = Storage::disk('public')->putFileAs('administrative/image', $img, $imageName);
                $exis = $administrative->update([
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

    public function index(): Response
    {
        $datas = Auth::user();
        $employe = Employe::where('type','Administrative')->get();
        $arriver = Arriver::where('type','Administrative')->get();
        $depart = Depart::where('type_de_class','administrative')->get();
        return Response([
            'datas'=>$datas,
            'employe' => $employe,
            'arriver' => $arriver,
            'depart' => $depart,
        ]);

    }
}
