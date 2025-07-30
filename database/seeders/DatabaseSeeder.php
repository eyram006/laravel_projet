<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Http\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Database\Seeders\RoleSeeder;
use Illuminate\Support\Facades\DB;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // $user1 = User::create([
            
        //     'name' => 'lice',
        //     'email' => 'lice@example.com',
        //     'password' => Hash::make('lice'),
           
        // ]);

        // $user1->assignRole(RoleEnum::ADMIN->value);


        // $user2=User::create([
        //     'name' => 'Boba',
        //     'email' => 'boba@gmail.com',
        //     'password' => Hash::make('boba'),
          
        // ]);
        // $user2->assignRole(RoleEnum::EMPLOYE->value);
       
    //    $user3=User::create([
            
    //        'name' => 'tal',
    //         'email' => 'tal@gmail.com',
    //         'password' => Hash::make('tal'),
           
    //     ]);
    //     $user3->assignRole(RoleEnum::GESTIONNAIRE->value);

        // User::create([
            
        //    'name' => 'Didier',
        //     'email' => 'didier@gmail.com',
        //     'password' => Hash::make('didier'),
          
        // ]);



//          Role::create(["name"=> "admin",
//         "guard_name"=> "web",
// ]);

//  Role::create(["name"=> "employe",
//         "guard_name"=> "web",
// ]);

//  Role::create(["name"=> "gestionnaire",
//         "guard_name"=> "web",
// ]);
    
// $this->call([
//         RoleSeeder::class,
//     ]);
    


$this->call([
         RoleSeeder::class,
         UserSeeder::class
      ]);


 }
    
    
    }
