<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Http\Enums\RoleEnum;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;    

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         User::create([
            "name"=> "laeti",
            'email' => 'laeti@gmail.com',
            'password' => Hash::make('laeti'),
        ])->assignRole(RoleEnum::ADMIN->value);

        User::create([
             "name"=> "othy",
            'email' => 'othy@gmail.com',
            'password' => Hash::make('othy'),
        ])->assignRole(RoleEnum::EMPLOYE->value);

        User::create([
            "name"=> "yasmine",
            'email' => 'yasmine@gmail.com',
            'password' => Hash::make('yasmine'),
        ])->assignRole(RoleEnum::GESTIONNAIRE->value);
    }
}
