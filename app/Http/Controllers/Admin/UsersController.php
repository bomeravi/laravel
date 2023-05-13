<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;
class UsersController extends Controller
{
    //
    public function index()
    {
        return view('admin.users.index');
    }

    public function ajax_users(Request $request){

        $requestData = $request->all();
        $age_range = $requestData['columns'][4]['search']['value'];
        $distance = $requestData['columns'][5]['search']['value'];
        if(empty($distance)){
            $distance = 9999999999;
        }
        $min_age = 0;
        $max_age = 100;


        if(preg_match('/^([0-9]+)?-([0-9]+)?$/', $age_range, $datas)){
            $min_age = $datas[1];
            if(count($datas)>2)
            $max_age = $datas[2];

        }
            $model = User::select('id','name','email','gender','age','user_type','created_at')->with('location')->where('user_role', '!=', 'admin')->where('age' ,'>=', $min_age)->where('age','<=', $max_age);
            $lat = 0;
            $lng = 0;






            return DataTables::eloquent($model)
                ->addColumn('distance', function (User $user) use ($lng, $lat) {
                    //return  $user->location->lat;
                   // number_format( $myNumber, 2, '.', '' );
                   //return \DB::raw('SELECT SQRT(POWER(5,2)+POWER(5,2)) as distance' );
                   return number_format(SQRT(POW((  $lat-$user->location->lat),2)+POW((  $lng-$user->location->lng),2)) , 2, '.', '' );
                })
                ->filterColumn('gender', function($query, $keyword) {
                    $query->where('gender', $keyword);
                })
                ->filterColumn('distance', function($query, $keyword) use ($distance) {
                    $query->having('distance','>', $distance);
                })
                ->filterColumn('age',function($query, $keyword) {
                })
                ->editColumn('created_at' , function(User $user) {
                    return $user->created_at->format('Y-m-d');
                })




                //->filter(function ($query) {

                  //  function ($instance) use ($request)
                   // if (request()->has('distance')) {
                        //return request('distance');

//                        $query->having('distance', "<=",   request('distance') );
                   // }

                //},true)
                ->toJson();
                //->make(false);
    }
}
