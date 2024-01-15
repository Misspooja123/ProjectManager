<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('admins')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $password = Hash::make('123456');
        $adminRecords = [
            ['id'=>1, 'name'=>'Admin', 'email'=>'admin@gmail.com', 'password'=>$password],

        ];
        Admin::insert($adminRecords);

    }
}
