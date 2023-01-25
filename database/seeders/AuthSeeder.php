<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class AuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $data = array(
        //     'name' => "OBS Accounting",
        //     'email' => 'admin@admin.com',
        //     'password' => bcrypt('password'),
        // );
        // User::create($data);

        \App\Models\User::insert(array (
            0 =>
            array (
                'id'                => 1,
                'name'              => "GEMS HARBOR",
                'username'          => "gemsharbor",
                'email'             => 'gemsharbor@admin.com',
                'email_verified_at' => now(),
                'password'          => bcrypt('gemsharbor'),
                'p_text'            => 'gemsharbor',
                // 'contact'     => '031475701224',
                // 'address'     => 'Prang Hassan Khel Charsadda',
                // 'image'       => '',
                // 'url'         => '',
                'type'           => 'Admin',
                'status'         => 'Active',
                'remember_token' => Str::random(10),
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now()
            )
        ));
    }
}
