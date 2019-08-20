<?php

use Illuminate\Database\Seeder;
use App\Models\School;

class SchoolUpdateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('school')->update(['status'=>School::STATUS_ON]);
        $this->command->info("inserted!");
    }
}
