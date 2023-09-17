<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //作成したUsersTableSeederクラスをcallメソッドに渡す。
        $this->call(UsersTableSeeder::class);
        //作成したSubjectsTableSeederクラスをcallメソッドに渡す。
        $this->call(SubjectsTableSeeder::class);
    }
}
