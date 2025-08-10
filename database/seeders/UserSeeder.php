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
        //   $user2 = User::create([
        //     'name' => 'Boba',
        //     'email' => 'boba@gmail.com',
        //     'password' => Hash::make('boba'),

        // ]);
        // $user2->assignRole(RoleEnum::ASSURE->value);

        // $user3 = User::create([

        //     'name' => 'tal',
        //     'email' => 'tal@gmail.com',
        //     'password' => Hash::make('tal'),

        // ]);
        // $user3->assignRole(RoleEnum::GESTIONNAIRE->value);

        // $user4 = User::create([

        //     'name' => 'Didier',
        //     'email' => 'didier@gmail.com',
        //     'password' => Hash::make('didier'),

        // ]);

        // $user4->assignRole(RoleEnum::CLIENT->value);
   
   
//    $user1 = User::create([
//         'name' => 'lice',
//         'email' => 'lice@example.com',
//         'password' => Hash::make('lice'),

//     ]);

//     $user1->assignRole(RoleEnum::ADMIN->value);

//     $user2 = User::create([
//         'name'=> 'laeti',
//         'email'=> 'laeti@gmail.com',
//         'password'=> Hash::make('laeti'),
// ]);
// $user2->assignRole(RoleEnum::GESTIONNAIRE->value);

$user3 = User::create([
    'name'=> 'othy',
    'email'=> 'othy@gmail.com',
    'password'=> Hash::make('othyniella'),
]);
$user3->assignRole(RoleEnum::CLIENT->value);
   
    }
}
