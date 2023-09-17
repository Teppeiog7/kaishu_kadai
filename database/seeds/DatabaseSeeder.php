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
        //2023年9月17日 下記追加
        //作成したUsersTableSeederクラスをcallメソッドに渡す。
        $this->call(UsersTableSeeder::class);
    }
}
