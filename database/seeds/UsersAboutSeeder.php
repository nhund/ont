<?php

use Illuminate\Database\Seeder;
use App\Models\About;

class UsersAboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $about = new About();
        $about->title = 'Ôn thi EZ';
        $about->url = 'https://onthiez.com';
        $about->address = 'Số 24, Ngách 106, Ngõ Gốc Đề, Minh Khai, Hà Nội';
        $about->phone = '036.9999.123';
        $about->email = 'nguyenhoanganh.hht@gmail.com';
        $about->about_us = '<p>Ch&agrave;o mừng c&aacute;c em đ&atilde; về với EZ-&nbsp;Nh&agrave; của sinh vi&ecirc;n</p>';
        $about->page_facebook = 'https://www.facebook.com/';        
        $about->create_date = time();
        $about->logo = '';
        $about->map = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.5436861433705!2d105.75973541496188!3d21.050936692396682!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313454dcd3f10571%3A0xeb5653bcbc18201e!2zVGnhu4dtIEPhuqdtIMSQ4buTIC0gQuG6pXQgxJDhu5luZyBT4bqjbiBI4bqjaSBY4buTbQ!5e0!3m2!1svi!2s!4v1542635187051" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>';
        $about->status = '';
        $about->twitter = '';
        $about->google = '';
        $about->instagram = '';
        $about->youtube = '';
        $about->save();
        $this->command->info("about inserted!");
    }
}
