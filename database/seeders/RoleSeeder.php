<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = [
            ['name' => 'admin', 'guard_name' => 'web'], 
            ['name' => 'writer', 'guard_name' => 'web'], 
        ];

        foreach ($role as $roledata) {
            Role::create($roledata);
        }

        $user = [
            ['name' => 'Admin', 'email' => 'admin@mail.com', 'password' => Hash::make('bisa')],
            ['name' => 'Writer', 'email' => 'writer@mail.com', 'password' => Hash::make('bisa')],
        ];

        foreach ($user as $userdata) {
            User::create($userdata);
        }


        $findUser = User::where('name', 'Admin')->first();

        $findUser->assignRole('admin');

        $findUser = User::where('name', 'writer')->first();

        $findUser->assignRole('writer');

    }
}
