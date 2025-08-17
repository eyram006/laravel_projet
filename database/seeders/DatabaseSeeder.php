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
use function Pest\Laravel\call;
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


      

         $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            ClientSeeder::class,
            AssureSeeder::class,
            GestionnaireSeeder::class,
            DemandeSeeder::class,

        ]); 

        // DB::table('assures')->delete();
        // DB::statement("DELETE FROM sqlite_sequence WHERE name = 'assures'");
    }


}
