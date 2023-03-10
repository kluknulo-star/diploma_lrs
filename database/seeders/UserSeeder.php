<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//      php artisan db:seed --class=UserSeeder
        $user = new User;
        $user->name = 'name';
        $user->email = 'admin@mail.ru';
        $user->password = Hash::make('12345678');
        $user->save();
        User::factory(20)->create();
    }
}
