<?php

namespace App\Http\Controllers\Auth\admins;

use App\Http\Controllers\Controller;
use App\Models\Auth\admins\AdminAdministrative;
use App\Models\Auth\admins\AdminFinancieres;
use App\Models\Auth\admins\AdminTechniques;
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

class SuperAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('login');
    }

    public function login(Request $request): Response
    {
        $superadmin = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string|min:6|max:8',
        ]);

        if (Auth::guard('superadmin')->attempt($superadmin)) {
            $superadmin = SuperAdmin::where('username', $request->username)->first();
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
        $superadmin = Auth::guard('sanctum')->user();
        if (null == $token) {
            $superadmin->currentAccessToken()->delete();
        }
        $personaleToken = PersonalAccessToken::findToken($token);
        if ($superadmin->id === $personaleToken->tokenable_id && get_class($superadmin) === $personaleToken->tokenable_type) {
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
        $superadmin = Auth::user();
        if ($request->hasFile("image_profile")) {
            $exist = Storage::disk('public')->exists("superadmin/image/{$superadmin->image_profile}");
            if ($exist) {
                Storage::disk('public')->delete("superadmin/image/{$superadmin->image_profile}");
                $img = $request->file("image_profile");// Uploadedfile;
                $imageName = Str::random() . '.' . $img->getClientOriginalName();

                $path = Storage::disk('public')->putFileAs('superadmin/image', $img, $imageName);
                $exis = $superadmin->update([
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
                $path = Storage::disk('public')->putFileAs('superadmin/image', $img, $imageName);
                $exis = $superadmin->update([
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
    //super admin of bureau d'order
    public function index(): Response
    {
        $admin_administrative = AdminAdministrative::all();
        $admin_financieres = AdminFinancieres::all();
        $admin_techniques = AdminTechniques::all();
        $employe = Employe::all();
        $arriver = Arriver::all();
        $depart = Depart::all();
        $superadmin = Auth::user();
        return Response([
            'datas' => $superadmin,
            'AdminAdministratives' => $admin_administrative,
            'AdminFinancieres' => $admin_financieres,
            'AdminTechniques' => $admin_techniques,
            'Employe' => $employe,
            'Arriver' => $arriver,
            'Depart' => $depart,
        ]);
    }

    //start functions of Employe:
    public function addEmploye(Request $request): Response
    {
        $valide = $request->validate([
            'fullname' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|min:6|max:8',
            'CIN' => 'required|min:8|max:12',
            'type' => 'required|string',
            'interet' => 'required|string',
        ]);
        if ($valide) {
            $addemp = Employe::create([
                'fullname' => $request->fullname,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'CIN' => $request->CIN,
                'type' => $request->type,
                'interet' => $request->interet,
                'image_profile' => 'nullable',
                'image_url' => 'sometimes',
            ]);
            $addemp->save();
            return Response([
                'message' => 'Employe has been add succes'
            ]);
        }
        return Response([
            'message' => 'your data is have some error validation'
        ]);
    }

    public function editEmploye(Request $request, $id): Response
    {
        $findEmp = Employe::find($id);
        if ($findEmp) {
            $valide = $request->validate([
                'fullname' => 'required|string',
                'email' => 'required|email',
                'password' => 'required|min:6|max:8',
                'CIN' => 'required|min:8|max:12',
                'type' => 'required|string',
            ]);
            if ($valide) {
                $findEmp->update([
                    'fullname' => $request->fullname,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'CIN' => $request->CIN,
                    'type' => $request->type,
                ]);
                return Response([
                    'message' => 'this employe has been updated succes'
                ]);
            }
        }
        return Response([
            'message' => 'this employe is not exist'
        ]);
    }

    public function deleteEmploye($id): Response
    {
        $findEmp = Employe::find($id);
        if ($findEmp) {
            $findEmp->delete();
            return Response([
                'message' => 'this employe has been deleted succes'
            ]);
        }
        return Response([
            'message' => 'this employe is not exist'
        ]);
    }

    // end of functions

    //start of functions Admin Administrative:
    public function addAdministrative(Request $request): Response
    {
        //fullname	CIN	email	password
        $valide = $request->validate([
            'fullname' => 'required|string',
            'CIN' => 'required|string|min:6|max:12',
            'email' => 'required|email',
            'password' => 'required|min:8|max:8'
        ]);
        if ($valide) {
            $add = AdminAdministrative::create([
                'fullname' => $request->fullname,
                'CIN' => $request->CIN,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $add->save();
            return Response([
                'message' => 'Admin Administrative has added successfully',
            ]);
        }
        return Response([
            'message' => 'error validation requests'
        ]);
    }

    public function editAdministrative(Request $request, $id): Response
    {
        $findAdmin = AdminAdministrative::find($id);
        if ($findAdmin) {
            $valide = $request->validate([
                'fullname' => 'required',
                'CIN' => 'required|min:6|max:8',
                'email' => 'required|email',
                'password' => 'required|min:8|max:8'
            ]);
            if ($valide) {
                $findAdmin->update([
                    'fullname' => $request->fullname,
                    'CIN' => $request->CIN,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                return Response([
                    'message' => 'Admin Administrative has been updated successfully'
                ]);
            } else {
                return Response([
                    'message' => 'error validation requests'
                ]);
            }
        }
        return Response([
            'message' => 'this admin is not exist'
        ]);
    }

    public function deleteAdministrative($id): Response
    {
        $findAdmin = AdminAdministrative::find($id);
        if ($findAdmin) {
            $findAdmin->delete();
            return Response([
                'message' => 'Admin Administrative has been deleted successfully',
            ]);
        }
        return Response([
            'message' => 'this admin is not exist',
        ]);
    }
    //end of functions
    //start functions of Admin Financieres
    public function addFinancieres(Request $request): Response
    {
        //fullname	CIN	email	password
        $valide = $request->validate([
            'fullname' => 'required|string',
            'CIN' => 'required|string|min:6|max:8',
            'email' => 'required|email',
            'password' => 'required|string|min:8|max:8'
        ]);
        if ($valide) {
            $add = AdminFinancieres::create([
                'fullname' => $request->fullname,
                'CIN' => $request->CIN,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $add->save();
            return Response([
                'message' => 'Admin Financieres has added successfully',
            ]);
        }
        return Response([
            'message' => 'error validation requests'
        ]);
    }

    public function editFinancieres(Request $request, $id): Response
    {
        $findAdmin = AdminFinancieres::find($id);
        if ($findAdmin) {
            $valide = $request->validate([
                'fullname' => 'required',
                'CIN' => 'required|min:6|max:8',
                'email' => 'required|email',
                'password' => 'required|min:8|max:8'
            ]);
            if ($valide) {
                $findAdmin->update([
                    'fullname' => $request->fullname,
                    'CIN' => $request->CIN,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                return Response([
                    'message' => 'Admin Financieres has been updated successfully'
                ]);
            } else {
                return Response([
                    'message' => 'error validation requests'
                ]);
            }
        }
        return Response([
            'message' => 'this admin is not exist'
        ]);
    }

    public function deleteFinancieres($id): Response
    {
        $findAdmin = AdminFinancieres::find($id);
        if ($findAdmin) {
            $findAdmin->delete();
            return Response([
                'message' => 'Admin Financieres has been deleted successfully',
            ]);
        }
        return Response([
            'message' => 'this admin is not exist',
        ]);
    }
    //end of functions

    //start functions of admin Techniques

    public function addTechniques(Request $request): Response
    {
        //fullname	CIN	email	password
        $valide = $request->validate([
            'fullname' => 'required',
            'CIN' => 'required|min:6|max:8',
            'email' => 'required|email',
            'password' => 'required|min:8|max:8'
        ]);
        if ($valide) {
            $add = AdminTechniques::create([
                'fullname' => $request->fullname,
                'CIN' => $request->CIN,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $add->save();
            return Response([
                'message' => 'Admin Techniques has added successfully',
            ]);
        }
        return Response([
            'message' => 'error validation requests'
        ]);
    }

    public function editTechniques(Request $request, $id): Response
    {
        $findAdmin = AdminTechniques::find($id);
        if ($findAdmin) {
            $valide = $request->validate([
                'fullname' => 'required',
                'CIN' => 'required|min:6|max:8',
                'email' => 'required|email',
                'password' => 'required|min:8|max:8'
            ]);
            if ($valide) {
                $findAdmin->update([
                    'fullname' => $request->fullname,
                    'CIN' => $request->CIN,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                return Response([
                    'message' => 'Admin Techniques has been updated successfully'
                ]);
            } else {
                return Response([
                    'message' => 'error validation requests'
                ]);
            }
        }
        return Response([
            'message' => 'this admin is not exist'
        ]);
    }

    public function deleteTechniques($id): Response
    {
        $findAdmin = AdminTechniques::find($id);
        if ($findAdmin) {
            $findAdmin->delete();
            return Response([
                'message' => 'Admin Techniques has been deleted successfully',
            ]);
        }
        return Response([
            'message' => 'this admin is not exist',
        ]);
    }
}
