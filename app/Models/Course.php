<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\UserCourse;
use App\Models\CourseRating;
use App\Models\Rating;
use App\Models\CommentCourse;
use App\Models\Lesson;
use Illuminate\Support\Facades\DB;

class Course extends Model
{
    const STATUS_ON = 1;
    const STATUS_OFF = 2;


    const TYPE_FREE_TIME = 1;
    const TYPE_FREE_NOT_TIME = 2;
    const TYPE_PUBLIC = 3;
    const TYPE_APPROVAL = 4;
    const TYPE_PRIVATE = 5;

    const STICKY = 1;
    const NOT_STICKY = 0;

    const LESSON = 'lesson';
    const EXAM = 'exam';
    const LEVEL2 = 'level2';

    protected $table = 'course';
    protected $primaryKey = 'id';

    const STATUS = [
        self::TYPE_FREE_TIME => '<span style="color: #FF8515;font-weight: bold;">Miễn phí có thời hạn</span>',
        self::TYPE_FREE_NOT_TIME => '<span style="color: #3c3bb3; font-weight: bold;">Miễn phí không thời hạn</span>',
        self::TYPE_PUBLIC  => '<span style="color: #5cb85c; font-weight: bold;">Công khai</span>',
        self::TYPE_APPROVAL => '<span style="color: #000; font-weight: bold;">Cần xét duyệt</span>',
        self::TYPE_PRIVATE => '<span style="color: #c9302c; font-weight: bold;">Riêng tư</span>'
    ];

    protected $fillable = [
        'name', 'status', 'avatar', 'user_id', 'begin_time', 'end_time', 'price', 'study_time', 'type', 'discount', 'category_id', 'is_free', 'description', 'sapo', 'avatar_path', 'created_at', 'updated_at', 'sticky', 'rating_1', 'rating_2', 'rating_3', 'rating_4', 'rating_5'
    ];
    public $timestamps = false;

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id')->withDefault(['name' => '']);
    }

    public function category()
    {
        return $this->hasOne('App\Models\Category', 'id', 'category_id')->withDefault(['name' => '']);
    }

    public function getAvatarThumbAttribute()
    {
        if (!empty($this->avatar) && !empty($this->avatar_path)) {
            return asset('public' . $this->avatar_path . '/480_320/' . $this->avatar);
        }
        return asset('public/images/course/course.jpg');;

    }

    public function getPriceNewAttribute()
    {
        if ($this->is_free == 1) {
            return 0;
        }
        if ($this->price > $this->discount) {
            return $this->price - $this->discount;
        } else {
            return 0;
        }

    }

    public function getDiscountPercentAttribute()
    {
        if ($this->is_free == 1) {
            return 0;
        } else {
            $price = $this->price ? $this->price : 1;
            return ($this->discount / $price) * 100;
        }
    }

    public static function Filter($data)
    {
        $limit  = isset($data['limit']) ? $data['limit'] : 20;
        $course = Course::select('*');
        if (isset($data['name']) && !empty($data['name'])) {
            $course = $course->where('name', 'like', '%' . $data['name'] . '%');
        }
        if (isset($data['status']) && !empty($data['status'])) {
            $course = $course->where('status', $data['status']);
        }
        if (isset($data['status_not']) && !empty($data['status_not'])) {
            $course = $course->where('status', '!=', $data['status_not']);
        }
        if (isset($data['is_free']) && !empty($data['is_free'])) {
            $course = $course->where('is_free', $data['is_free']);
        }
        if (isset($data['rating']) && !empty($data['rating'])) {
            if ($data['rating'] > 0 && $data['rating'] < 6) {
                if ($data['rating'] == 1) {
                    $course = $course->where('rating_1', '>', 0);
                }
                if ($data['rating'] == 2) {
                    $course = $course->where('rating_2', '>', 0);
                }
                if ($data['rating'] == 3) {
                    $course = $course->where('rating_3', '>', 0);
                }
                if ($data['rating'] == 4) {
                    $course = $course->where('rating_4', '>', 0);
                }
                if ($data['rating'] == 5) {
                    $course = $course->where('rating_5', '>', 0);
                }
            }

        }

        if (isset($data['created_at']) && !empty($data['created_at'])) {
            $time   = explode('-', $data['created_at']);
            $course = $course->where('created_at', '>', strtotime($time[0] . '00:00:01'))
                ->where('created_at', '<', strtotime($time[1] . '23:59:59'));
        }
        if (isset($data['user_id'])) {
            $course = $course->where('user_id', $data['user_id']);
        }
        if (isset($data['price'])) {
            if ($data['price'] == 'free') {
                $course = $course->where('is_free', 1);
            } else {
                $part = explode('-', $data['price']);
                if ($part[1] == 'max') {
                    $course = $course->where('price', '>', $part[0]);
                } else {
                    $course = $course->whereBetween('price', $part);
                }
            }
        }
        if (isset($data['course_id_in'])) {
            $course = $course->whereIn('id', $data['course_id_in']);
        }
        if (isset($data['category_id'])) {
            $course = $course->whereIn('category_id', $data['category_id']);
            //dd(explode(',',$data['category_id']));
        }
        if (isset($data['sortBy'])) {
            if ($data['sortBy'] == 'price-ascending') {
                $course = $course->orderByRaw('`price` - `discount` ASC');
            }
            if ($data['sortBy'] == 'price-descending') {
                $course = $course->orderByRaw('`price` - `discount` DESC');
            }
            if ($data['sortBy'] == 'created-ascending') {
                $course = $course->orderBy('created_at', 'ASC');
            }
            if ($data['sortBy'] == 'created-descending') {
                $course = $course->orderBy('created_at', 'DESC');
            }
        }

        $course = $course->paginate($limit);
        return $course;
    }

    public static function boot()
    {
        parent::boot();


        self::creating(function ($model) {

        });
        self::created(function ($model) {
            if (isset($model->attributes['id'])) {
                // $course_rating = CourseRating::where('course_id',$model->attributes['id'])->first();
                // if(!$course_rating)
                // {                    
                //     $course_rating = new CourseRating();
                //     $course_rating->course_id = $model->attributes['id'];
                //     $course_rating->rating_1 = 0;
                //     $course_rating->rating_2 = 0;
                //     $course_rating->rating_3 = 0;
                //     $course_rating->rating_4 = 0;
                //     $course_rating->rating_5 = 0;
                //     $course_rating->create_date = time();                                    
                //     $course_rating->save();
                // }
            }
        });

        self::updating(function ($model) {

        });

        self::updated(function ($model) {
            if ($model->isDirty('status')) {
                if (isset($model->original['status']) && $model->original['status'] == self::TYPE_APPROVAL) {
                    // neu dang o trang thai can xet duyet ma chuyen sang cac trang thai khac thi huy het don cho
                    if ($model->attributes['status'] != $model->original['status']) {
                        UserCourse::where('course_id', $model->attributes['id'])->where('status', UserCourse::STATUS_APPROVAL)->delete();
                    }
                }
                if (isset($model->original['status']) && $model->original['status'] == self::TYPE_FREE_NOT_TIME) {
                    //Miễn phí không thời hạn: Tham gia học không giới hạn số ngày. 
                    //Nếu đang học mà mà khóa chuyển thành tính phí thì khóa học hết hạn luôn, người học bắt buộc phải mua.
                    if ($model->attributes['status'] == self::TYPE_PUBLIC) {
                        UserCourse::where('course_id', $model->attributes['id'])->update(['and_date' => 1]);
                    }
                }
            }
        });

        self::deleting(function ($model) {
            // ... code here
        });

        self::deleted(function ($model) {
            if (isset($model->attributes['id'])) {
                //CourseRating::where('course_id',$model->attributes['id'])->delete();
                Rating::where('course_id', $model->attributes['id'])->delete();
                UserCourse::where('course_id', $model->attributes['id'])->delete();
            }
        });
    }


    public static function getCourses()
    {
        return Course::where('status', '!=', Course::TYPE_PRIVATE)
            ->where('sticky', Course::STICKY)
            ->take(8)->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comment()
    {
        return $this->hasMany(CommentCourse::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lesson()
    {
        return $this->hasMany(Lesson::class);
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userCourse()
    {
        return $this->hasMany(UserCourse::class);
    }

    public static function reportRatingCourse($id)
    {
        $ratings = Rating::select('rating_value', DB::raw('count(*) as total'))
            ->where('course_id', $id)->groupBy('rating_value')->get();

        $ratingValue  = array(
            '1' => 0,
            '2' => 0,
            '3' => 0,
            '4' => 0,
            '5' => 0,
        );
        $rating_avg   = 0;
        $rating_value = 0;
        $user_rating  = 0;
        foreach ($ratings as $rating) {
            $rating_value += (int)$rating->total * (int)$rating->rating_value;
            $user_rating  += $rating->total;

            $ratingValue[$rating->rating_value] = array(
                'users' => $rating->total,
                'total' => (int)$rating->total
            );
        }
        if ($rating_value > 0) {
            $rating_avg = $rating_value / $user_rating;
        }
        $var['user_rating']  = $user_rating;
        $var['rating_avg']   = number_format((float)$rating_avg, 1, '.', '');
        $var['rating_value'] = $ratingValue;

        return $var;
    }
}
