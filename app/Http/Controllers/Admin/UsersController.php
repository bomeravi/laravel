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
        $gender = $requestData['columns'][3]['search']['value'];
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
        $lat = 0;
        $lng = 0;

            $model = User::select('users.id','users.name', 'users.email','users.user_type','users.age','users.created_at','users.gender',
                \DB::raw('(SQRT(POWER(( '. $lat.'-user_locations.lat),2)+POWER(( '. $lng.'-user_locations.lng),2)) ) AS distance')
            )
                ->join('user_locations', 'users.id', '=', 'user_locations.user_id')
                ->where('users.user_role', '!=', 'admin')
                ->where('users.age' ,'>=', $min_age)
                ->where('users.age','<=', $max_age);

            $model->having('distance','<=', $distance);



            return DataTables::eloquent($model)
                ->filterColumn('gender',function($query, $keyword) {
                    $query->where('gender', $keyword);
                })
                ->filterColumn('age',function($query, $keyword) {

                })
                ->filterColumn('distance',function($query, $keyword) {

                })


                ->editColumn('created_at' , function(User $user) {
                    return $user->created_at;
                })

                ->toJson();
    }
}
