<?php

namespace Database\Seeders;

use App\Models\AboutPage;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Category;
use App\Models\CompanyProfile;
use App\Models\SpecialtieBanner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        CompanyProfile::create([
            'name'     => 'Uk Restaurent',
            'title'    => 'Uk Restaurent',
            'phone'    => '019########',
            'email'    => 'Uk_Restaurent@gmail.com',
            'last_update_ip' => request()->ip(),
        ]);

        User::create([
            'code'     => 'U00001',
            'name'     => 'Admin',
            'username' => 'admin',
            'email'    => 'admin@gmail.com',
            'password' => Hash::make(1),
            'phone'    => '019########',
            'role'     => 'Superadmin',
            'last_update_ip' => request()->ip(),
        ]);

        Category::insert([
            [
                'name'           => 'Ac',
                'slug'           => 'ac',
                'status'         => 'a',
                'added_by'       => 1,
                'created_at'     => Carbon::now(),
                'last_update_ip' => request()->ip(),
            ],
            [
                'name'           => 'Non Ac',
                'slug'           => 'non-ac',
                'status'         => 'a',
                'added_by'       => 1,
                'created_at'     => Carbon::now(),
                'last_update_ip' => request()->ip(),
            ]
        ]);

        AboutPage::create([
            'title' => 'Welcome To Uk Restaurent',
            'short_description' => 'test description here',
            'description' => '<p>test description here</p>',
            'status' => 'a',
            'updated_by' => 1,
            'created_at' => Carbon::now(),
            'last_update_ip' => request()->ip(),
        ]);

        SpecialtieBanner::create();
    }
}
