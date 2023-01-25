<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Store;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::insert(array(
            0 =>
            array(
                'name'   => 'Alexandrite',
                'image' =>'C:\wamp64\tmp\php9A8.tmp',
                'url' =>'/images/category/1662568071.png',
                'status' => 'Permanent',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now()
            ),
            1 =>
            array(
                'name'   => 'Amethyst',
                'image' =>'C:\wamp64\tmp\php9A8.tmp',
                'url' =>'/images/category/1662568071.png',
                'status' => 'Permanent',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now()
            ),
            2 =>
            array(
                'name'   => 'Emeralt',
                'image' =>'C:\wamp64\tmp\php9A8.tmp',
                'url' =>'/images/category/1662568071.png',
                'status' => 'Permanent',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now()
            ),
            3 =>
            array(
                'name'   => 'Garnet',
                'image' =>'C:\wamp64\tmp\php9A8.tmp',
                'url' =>'/images/category/1662568071.png',
                'status' => 'Permanent',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now()
            ),
            4 =>
            array(
                'name'   => 'Rubey',
                'image' =>'C:\wamp64\tmp\php9A8.tmp',
                'url' =>'/images/category/1662568071.png',
                'status' => 'Permanent',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now()
            ),
            5 =>
            array(
                'name'   => 'Sapphire',
                'image' =>'C:\wamp64\tmp\php9A8.tmp',
                'url' =>'/images/category/1662568071.png',
                'status' => 'Permanent',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now()
            ),
        ));

        Store::create([
            'user_id'     => 1,
            'name'        => "GemsHarbor",
            'email'       => 'gemsharbor@admin.com',
            'phone'       => '000000000000',
            'country'     => 'US',
            'address'     => 'Peshawar',
            'city'        => 'Peshawar',
            'state'       => 'Pakistan',
            'website'     => 'www.google.com',
            'is_register' => 0,
            'created_at'  => Carbon::now(),
            'updated_at'  => Carbon::now()
        ]);
    }
}
