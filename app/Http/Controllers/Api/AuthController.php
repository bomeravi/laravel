<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUser;
use App\Jobs\SendOTP;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class AuthController extends Controller
{
    //

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
      // return $request->all();

        $token = $user->createToken('App')->plainTextToken;
        return ['user'=>$user,'token' =>$token];
    }

    public function register(CreateUser $request)
    {
        $requestData = $request->all();
        $requestData['password'] = Hash::make($requestData['password']);

        if (!app()->environment(['production'])) {
            $requestData['otp_code'] = 111111;
        }
        $requestData['user_type']='freemium';
        $user = User::create($requestData);
        $requestLocation = $request->only(['lat','lng']);

        $requestLocation['name'] = 'N/A';

        $user->location()->create($requestLocation);

        dispatch(new SendOTP($user));

        return $user;
    }

    public function verify_otp(Request $request){
        $requestData = $request->validate(['otp_code'=>'required|digits:6']);



        $otp_code = $requestData['otp_code'];

        $user = $request->user();

        if($user->otp_code == $otp_code) {
            $user->otp_code = null;
            $user->email_verified_at=Carbon::now();
            $user->save();
            return ['success'=>true,'message'=>'OTP verified Successfully'];
        }
        else {
            return ['success'=>false,'message'=>'Invalid Otp'];





        }
    }
}
