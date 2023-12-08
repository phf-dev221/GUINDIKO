<?php

namespace App\Http\Controllers\Api\articles;

use Exception;
use App\Models\Mentor;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginMentorRequest;
use App\Http\Requests\CreateMentorRequest;
use App\Http\Requests\CreateMentoreRequest;

class MentorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function registerMentor(CreateMentorRequest $request)
    {
        try{
            $user = new Mentor();
    
            $user->nom = $request->nom;
            $user->telephone = $request->telephone;
            $user->nombre_annee_experience = $request->nombre_annee_experience;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);

            if ($request->hasFile('photo_profil')) {
                $file = $request->file('photo_profil');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('profil', $filename, 'public');
                $user->photo_profil = $path;
            }
            
            $user->save();
            return response()->json([
                'status_code'=>200,
                'status_message'=>'utilisateur ajouté avec succes',
                'status_body'=>$user
            ]);
    
            }
            catch(Exception $e){
                return response()->json([$e]);
            }
    }

    public function login(LoginMentorRequest $request){
        if(Auth::guard('mentor')->attempt($request->only(['email','password']))){
            $user = Auth::guard('mentor')->user();
            $token = $user->createToken('cle_secret_pour_le_mentor',['mentor'])->plainTextToken;

            return response()->json([
                'status_code'=>200,
                'status_message'=>'utilisateur connecté',
                'status_body'=>$user,
                'token'=>$token
            ]);
        }
        if(Auth::guard('web')->attempt($request->only(['email','password']))){
            $user = Auth::guard('web')->user();
            $token = $user->createToken('cle_secret_pour_le_back')->plainTextToken;

            return response()->json([
                'status_code'=>200,
                'status_message'=>'utilisateur connecté',
                'status_body'=>$user,
                'token'=>$token
            ]);
        }
        else{
            
            return response()->json([
                'status_code'=>403,
                'status_message'=>'Identifiants non valides',

            ]);
        }
    }

    public function logout()
    {
        try {
            dd(Auth::user()->check());
            if (Auth::guard('mentor')->check()){
                Auth::guard('mentor')->logout();
    
                return response()->json([
                    'status' => 200,
                    'success' => true,
                    'status_message' => 'Déconnexion réussie'
                ]);
            } else {
                return response()->json([
                    'status' => 401,
                    'success' => false,
                    'status_message' => 'Aucun utilisateur connecté'
                ]);
            }
        
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'status_message' => 'Erreur lors de la déconnexion',
                'errors'=>$e
            ]);
        }

    }
    
    /*methodes de basse*/
    // Method pour lister les mentors dont leurs état d'archive est false
    public function non_archive(Mentor $mentor)
    {
        try {
            if ($mentor->est_archive == false) {
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'Voici la liste des mentors non archivés',
                    'mentor' => Mentor::all(),
                ]); 
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    // Method pour lister les user dont leurs état d'archive est true
    public function est_archive(Mentor $mentor)
    {
        try {
            if ($mentor->est_archive == true) {
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'Voici la liste des mentors qui sont archivés',
                    'mentor' => Mentor::all(),
                ]); 
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    //Liste des users qui ont des etats non archive et qui n'ont pas atteint leurs limite max de mentorés
    public function nombre_mentor(Mentor $mentor)
    {
        try {
            if ($mentor->est_archive == false) {
                if ($mentor->nombre_mentores < 16) {
                    return response()->json([
                        'status_code' => 200,
                        'status_message' => 'Voici la liste des mentors qui n\'ont pas atteint la limite et qui ne sont pas archivés',
                        'mentor' => Mentor::all(),
                    ]); 
                }
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    //Cette methode permet de lister les mentors qui ont atteint leurs limite de mentorés mais ils ne sont pas archivés
    public function nombre_mentor_atteint(Mentor $mentor)
    {
        try {
            if ($mentor->est_archive == false) {
                if ($mentor->nombre_mentores >= 16) {
                    return response()->json([
                        'status_code' => 200,
                        'status_message' => 'Voici la liste des mentors qui n\'ont pas atteint la limite et qui ne sont pas archivés',
                        'mentor' => Mentor::all(),
                    ]); 
                }
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }


}
