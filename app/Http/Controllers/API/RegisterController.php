<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\{User, Code, Profil};
use Auth;
use Validator;
use Illuminate\Http\JsonResponse;

class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required:unique',
            'name' => 'required',
            'prenom' => 'string',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'c_password' => 'required|string',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $codeExisteDejaDansLaTableCode = Code::find($request->code);
        if(!empty($codeExisteDejaDansLaTableCode)){
            $user = new User();
            $user->code = $request->code ?? "";
            $user->name = $request->name;
            $user->prenom = $request->prenom ?? "";
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->login = $request->name.'.'.$request->prenom;
            $user->save();
            
            // $profilId = $request->profil_id;
            
            
            if ($user->save()) {
                $userId = $user->id;
                $profilId = "adsdsdNULL";
                $user->profils()->attach($profilId); 
            }else{
                return $this->sendError("Vous devez selectionner un profil");
            }
    
            $success['token'] =  $user->createToken('Monbarreau')->plainTextToken;
            $success['name'] =  $user->name;
       
            return $this->sendResponse($success, 'Compte utilisateur créer avec succès !.');
        }else{
            return $this->sendError("Ce code nest pas valider, demander un code à l'administrateur.");
        }
   
       
    }
   
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request): JsonResponse
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('Monbarreau')->plainTextToken; 
            $success['name'] =  $user->name;
   
            return $this->sendResponse($success, 'Utilisateur connecté avec succès.');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }
}
