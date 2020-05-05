<?php

namespace App;
 
use App\Models\Course;
use App\Models\UserCourse;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Wallet;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    const USER_STUDENT = 1;
    const USER_TEACHER = 2;
    const USER_ADMIN = 6;
    const SUPPORT_TEACHER = 5;

    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;

    const STATUS_ACTIVE = 1;
    const STATUS_BLOCK = 2;
    const STATUS_DEACTIVE = 3;

    const LOGIN_FB = 1;
    const LOGIN_GG = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','full_name','email', 'password','phone','gender','birthday','status','avatar','level','user_group','create_at','update_at','note','school_id','social_id','social_type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public $timestamps = false;

    public function school()
    {
        return $this->hasOne('App\Models\School', 'id', 'school_id')->withDefault(['name'=>'']);
    }   
    public function wallet()
    {
        return $this->hasOne('App\Models\Wallet', 'user_id', 'id')->withDefault(['xu'=>0]);
    } 

    public function getPositionAttribute()
    {
        $position = 'Học sinh';
        if($this->level == self::USER_TEACHER)
        {
            $position = 'Giáo viên';
        }
        if($this->level == self::USER_ADMIN)
        {
            $position = 'Admin';
        }
        return $position;
    } 
    public function getNameFullAttribute()
    {
        if(empty($this->full_name))
        {
            return $this->email;    
        }
        return $this->full_name;  
        
    }  
    public function getAvatarFullAttribute()
    {
        if(empty($this->avatar))
        {
            return asset(config('app.url').'public/images/avatar-default.png');
        }
        return asset(config('app.url').$this->avatar);
        
    }   

    public static function boot()
    {
        parent::boot();


        self::creating(function($model){

        });
        self::created(function($model){
            if (isset($model->attributes['id']))
            { 
                $waleet = Wallet::where('user_id',$model->attributes['id'])->first();
                if(!$waleet)
                {                    
                    $waleet = new Wallet();
                    $waleet->user_id = $model->attributes['id'];
                    $waleet->xu = 0;
                    $waleet->status = Wallet::STATUS_ON;
                    $waleet->created_at = time();                                    
                    $waleet->save();

                }
            }
        });

        self::updating(function($model){

        });

        self::updated(function($model){

        });

        self::deleting(function($model){
            // ... code here
        });

        self::deleted(function($model){
            $wallet = Wallet::where('user_id',$model->attributes['id'])->first();
            if($wallet)
            {
                $wallet->delete();
            }
            // xoa khoa hoc cua user
            // xoa cac khoa hoc do user tao
            // xoa lich su quesson
            // xoa lic su lesson
            // xoa comment
        });
    }
    public static function searchUser($param)
    {
        $limit = isset($param['limit']) ? $param['limit']:  20;
        $users = User::select('users.*');
        if(isset($param['full_name']) && !empty($param['full_name']))
        {
            $users = $users->where('full_name','like','%' .$param['full_name']. '%');
        }

        if(isset($param['phone']) && !empty($param['phone']))
        {
            $users = $users->where('phone',$param['phone']);
        }
        if(isset($param['email']) && !empty($param['email']))
        {
            $users = $users->where('email','like','%' .$param['email']. '%');
        }
        if(isset($param['create_at']) && !empty($param['create_at']))
        {
            $time = explode('-',$param['create_at']);
            $users = $users->where('create_at','>',strtotime($time[0].'00:00:01'))
            ->where('create_at','<',strtotime($time[1].'23:59:59'));
        }
        $users = $users->orderBy('id','DESC')->paginate($limit);
        return $users;
    }

    public function courses(){
       return $this->belongsToMany(Course::class, UserCourse::class,  'user_id', 'course_id');
    }
}
