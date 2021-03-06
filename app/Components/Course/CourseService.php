<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 22/08/2019
 * Time: 14:25
 */

namespace App\Components\Course;

use App\Models\Course;
use App\Models\UserCourse;
use Illuminate\Http\Request;
use App\Support\WithPaginationLimit;
class CourseService
{
    use WithPaginationLimit;

    protected $request;
    protected $qs = [];

    /**
     * @param \Illuminate\Http\Request $request
     */
    public function  __construct(Request $request = null){
        $this->request = $request;
    }

    /**
     * get the special courses of school
     *
     * @param $school_id
     * @param int $limit
     * @return mixed
     */
    public function getStickyCourses($school_id = null, $limit = null)
    {
        $limit = $limit ?: request('limit', 3);
        $query =  Course::query()
            ->where('status', '<>',Course::TYPE_PRIVATE)
            ->where('sticky', Course::STICKY);

        if($school_id){
            $query->where('category_id', $school_id);
        }

        return $query->orderBy('id', 'DESC')
        ->limit($limit)
        ->get();
    }

    /**
     * get the courses of school by status
     *
     * @param array $status
     * @param int $limit
     * @param $school_id
     * @return mixed
     */
    public function getCoursesOfByStatus(array $status, $school_id = null, $limit = null)
    {
        $limit = $limit ?: request('limit', 3);
        $query = Course::query()
            ->where('status', '<>',Course::TYPE_PRIVATE)
        ;

        if($school_id){
            $query->where('category_id', $school_id);
        }

        return $query->whereIn('status', $status)
            ->orderBy('sticky', 'DESC')
            ->orderBy('id', 'DESC')
            ->limit($limit)
            ->get();
    }

    /**
     * get the sources of all at Home Page
     *
     * @param null $school_id
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getSourcesForHomePage($school_id = null, $limit = null){

        $limit = $limit ?: request('limit', 4);
        $query = Course::query()
            ->where('status', '<>',Course::TYPE_PRIVATE);
        if($school_id){
            $query->where('category_id', $school_id);
        }
        return $query
        ->orderBy('sticky', 'DESC')
        ->orderBy('id', 'DESC')
        ->limit($limit)->get();
    }

    /**
     * searching all sources by sourcename and school_id
     */
    public function search()
    {
        $query = Course::query()
            ->where('status', '<>',Course::TYPE_PRIVATE);

        return $this->applySchoolIdFilter($query)
            ->applySourceNameFilter($query)
            ->paginate($query);
    }

    /**
     * searching sources by sourcename and school_id of user
     */
    public function searchByUser()
    {
        $query = Course::query()
            ->where('status', '<>',Course::TYPE_PRIVATE);

        return $this->applySchoolIdFilter($query)
            ->applySourceNameFilter($query)
            ->applyUserFilter($query)
            ->applyTimeFilter($query)
            ->paginate($query);
    }

    /**
     * filter Source by source name
     *
     * @param $query
     * @return $this
     */
    protected function applySourceNameFilter(&$query)
    {
        $courseName = $this->request->get('source_name');

        if($courseName){
            $this->qs[] = 'name';
            $query->where('name', 'LIKE', "%{$courseName}%");
        }
        return $this;
    }

    /**
     * filter Source by school id
     *
     * @param $query
     * @return $this
     */
    protected function applySchoolIdFilter(&$query)
    {
        $schoolId = $this->request->get('school_id');

        if( $schoolId){
            $this->qs[] = 'category_id';
            $query->where('category_id',  $schoolId);
        }
        return $this;
    }

     /**
     * filter Source by user id
     *
     * @param $query
     * @return $this
     */
    protected function applyUserFilter($query){
        $userId = $this->request->get('user_id') ?: $this->request->user()->id;

        if( $userId){
            $this->qs[] = 'user_id';
            $query->whereHas('userCourse',  function ($q) use ($userId){
                $q->where('user_id', $userId);
            });
        }
        return $this;
    }

    /**
     * filter Source by user id
     *
     * @param $query
     * @return $this
     */
    protected function applyTimeFilter($query){

        $sortTime = $this->request->get('sort_time');

        if ($this->request->has('sort_time')){
            if ($sortTime == 'created'){
                $query->orderBy('created_at', 'DESC');
            }
            if ($sortTime == 'expired'){
                $query->whereHas('userCourse',  function ($q){
                    $q->where('and_date', '>', time());
                    $q->orWhere('status', UserCourse::STATUS_OFF);
                });
            }
        }

        return $this;
    }

    public function getOtherCourseSchoolHome($school_id){
        $stick = $this->getStickyCourses($school_id, 3)->pluck('id')->toArray();
        $free  = $this->getCoursesOfByStatus([Course::TYPE_FREE_TIME], $school_id, 1)->pluck('id')->toArray();

        $courseIds = array_merge($stick, $free);

        if (\request('course_current_id')){
            $courseIds = array_merge($courseIds, [\request('course_current_id')]);
        }

        $limit = request('limit', 4);

        $query = Course::query();

        if($school_id){
            $query->where('category_id', $school_id);
        }
        return $query
            ->whereNotIn('id', $courseIds)
            ->orderBy('sticky', 'DESC')
            ->orderBy('id', 'DESC')
            ->paginate($limit);
    }

     /**
     * @param  \Illuminate\Database\Eloquent\Builder &$query
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    protected function paginate(&$query)
    {
        if ($this->request->has('limit')) {
            $this->qs[] = 'limit';
        }

        return $query->latest()
                ->paginate($this->getPaginationLimit($this->request))
                ->appends($this->request->only($this->qs));
    }

    public function createFolderGalaryForLesson($course_id)
    {
        //tao fordel anh
        $path = '/images/course/'.$course_id;
        $destinationPath = public_path($path);
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777);
        }
        $path = '/images/course/'.$course_id.'/lesson';
        $destinationPath = public_path($path);
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777);
        }
        $path = '/images/course/'.$course_id.'/lesson/audio';
        $destinationPath = public_path($path);
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777);
        }
    }
}