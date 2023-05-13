<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'gender',
        'user_type',
        'user_role',
        'age',
        'otp_code'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'otp_code'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['profile_url'];


    public function getProfileUrlAttribute(){
        return url('/uploads/images') . "/". $this->image;
    }
    public function getImageAttribute()
{
        if(empty($this->image)){
            return 'default.png';
        }
        return $this->image;
}

    public function location()
    {
        return $this->hasOne(UserLocation::class)->withDefault(['name'=>'N/A','lat'=> 0, 'lang'=>0]);
    }


    public function scopeNearby($query,$min_age,$max_age,$distance)
    {
        $lat = $this->location->lat;
        $lng = $this->location->lng;
        $user_id = $this->id;
        $user_type = $this->user_type;
         $query->select('users.name', 'users.email','users.user_type','users.age',
            \DB::raw('(SQRT(POWER(( '. $lat.'-user_locations.lat),2)+POWER(( '. $lng.'-user_locations.lng),2)) ) AS distance')
        )
            ->join('user_locations', 'users.id', '=', 'user_locations.user_id')
            ->where('users.id', '!=', $user_id)->where('users.user_role', '!=','admin');
         if(!(empty($min_age)||empty($max_age)))
        $query->where('users.age', '>=',$min_age)->where('users.age','<=', $max_age);
            if($user_type == 'freemium'){
                $query->where('users.user_type', 'freemium');
            }
            if(!empty($distance)){
                $query->having('distance', '<=', $distance);
            }

            return $query->orderBy('distance', 'asc');
    }
}
