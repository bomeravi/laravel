<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //

    public function upload_image(Request $request)
    {
        $request->validate(['image'=> 'required|image|mimes:jpeg,jpg,png']);
        $user = $request->user();

            try {


                $imageName = rand(9, 9999) . '-' . time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('/uploads/images'), $imageName);

                $user->image = $imageName;
                $user->save();

                return ['success'=>true, 'message'=>'Profile Picture uploaded Successfully'];
            }
            catch(e){
                return ['success'=>false,'message'=>'Unable to upload image'];
            }

    }
}
