<?php

use Illuminate\Database\Seeder;
use App\Models\Course;

class UpdateCourseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courses = Course::where('status',2)->update(['status'=>Course::TYPE_PRIVATE]);
        $courses = Course::where('status',1)->update(['status'=>Course::TYPE_PUBLIC]);
        $this->command->info("inserted!");
    }
}
