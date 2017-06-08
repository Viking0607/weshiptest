<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Иван',
            'surname' => 'Петров',
            'email' => 'viking060790@yandex.ru',
            'password' => bcrypt('secret'),
        ]);

        DB::table('users')->insert([
            'name' => 'Петр',
            'surname' => 'Иванов',
            'email' => 'viking0607@mail.ru',
            'password' => bcrypt('secret'),
        ]);
    }
}
