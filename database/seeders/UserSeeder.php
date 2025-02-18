<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        User::factory()->count(50)->create();

        $user = User::find(1);
        $user->name = 'hana';
        $user->email = 'hana@gmail.com';
        $user->password = bcrypt('123456');
        $user->save();
    }
}
