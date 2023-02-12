<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Statement;
use App\Models\User;
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

        //      php artisan db:seed

        Statement::factory(500)->create();

        $user = new User;
        $user->name = 'name';
        $user->email = 'admin@mail.ru';
        $user->password = Hash::make('12345678');
        $user->save();
        User::factory(20)->create();
    }
}
