<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 22/08/2019
 * Time: 14:25
 */

namespace App\Components\Course;

use App\Models\Course;
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
    public function  __construct(Request $request){
        $this->request = $request;
    }

    /**
     * get the special courses of school
     */
    public function getSpecialCoursesOfSchool($shool_id, $limit = 3)
    {
        return Course::where('sticky', Course::STICKY)
            ->where('category_id', $shool_id)
            ->orderBy('id', 'DESC')
            ->limit($limit)
            ->get();
    }

    /**
     * get the courses of school by status
     */
    public function getCoursesOfSchoolByStatus($shool_id, array $status, $limit = 10)
    {
        return Course::where('category_id', $shool_id)
            ->whereIn('status', $status)
            ->orderBy('id', 'DESC')
            ->limit($limit)
            ->get();
    }

    /**
     * get the courses of school at home page 
     */
    public function getCourseOfSchoolForHomePage($shool_id)
    {

        $freeCourse = $this->getCoursesOfSchoolByStatus($shool_id, [Course::TYPE_FREE_TIME], 1);

        $specialCourses = $this->getSpecialCoursesOfSchool($shool_id);

        $ortherCourse = $this->getCoursesOfSchoolByStatus($shool_id, [Course::TYPE_PUBLIC, Course::TYPE_FREE_NOT_TIME, Course::TYPE_FREE_NOT_TIME]);

        return $freeCourse->merge($specialCourses)->merge($ortherCourse);

    }

    /**
     * get the sources of all schools at Home Page
     */
    public function getSourcesForHomePage(){
        // $query = Course::where(function($q){
        //     $q->where('status', Course::TYPE_FREE_TIME)
        //     ->orWhere('sticky', Course::STICKY);
        // });

        $query =  Course::where('status','!=',Course::TYPE_PRIVATE)
        ->where('sticky',Course::STICKY);

        return $this->paginate($query);
    }

    /**
     * searching sources by sourcename and school_id
     */
    public function search()
    {
        $query = Course::query();

        return $this->applySchoolIdFilter($query)
            ->applySourceNameFilter($query)
            ->paginate($query);
    }

    /**
     * filter Source by source name
     */
    protected function applySourceNameFilter(&$query)
    {
        $sourseName = $this->request->get('source_name');

        if($sourseName){
            $this->qs[] = 'name';
            $query->where('name', 'LIKE', "%{$sourseName}%");
        }
        return $this;
    }

    /**
     * filter Source by school id
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
}