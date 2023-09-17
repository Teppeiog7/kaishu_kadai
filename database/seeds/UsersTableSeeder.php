<?php

use Illuminate\Database\Seeder;
use App\Models\Users\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       //2023年9月17日 下記追加
       DB::table('users')->insert([
            [
              'over_name' => 'Atlas',
              'under_name' => '一郎',
              'over_name_kana' => 'アトラス',
              'under_name_kana' => 'イチロウ',
              'mail_address' => 'Atlas001@atlas.jp',
              'sex' => '1',
              'birth_day' => '1990-01-01',
              'role' => '4',//4は生徒
              'password' => bcrypt('12345678')
            ]
        ]);
    }
}
