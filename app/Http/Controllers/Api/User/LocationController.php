<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\UserLocation as Location;
class LocationController extends Controller
{
    //
    public function locations(Request $request){
        $min_age = $request->get('min_age');
        $max_age = $request->get('max_age');
        $distance = $request->get('distance');
        $user = $request->user();
        return $user->nearby($min_age, $max_age, $distance)->paginate(10);
    }

    public function update_location(Request $request){

        $user = $request->user();
        $requestData = $request->validate([
            'lat' =>'numeric|required|between:-90.0,90.0',
            'lng' =>'numeric|required|between:-90.0,90.0',
            'name' => 'string'
        ]);
        $lat = $requestData['lat'];
        $lng = $requestData['lng'];

        $name = $requestData['name'];
        if(empty($name)){
            $name = 'N/A';
        }

        $user->location()->update(['lat'=> $lat, 'lng'=>$lng,'name'=>$name]);
        return $user->location;
    }
}
