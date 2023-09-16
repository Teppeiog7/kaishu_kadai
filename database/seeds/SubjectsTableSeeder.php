<?php

use Illuminate\Database\Seeder;
use App\Models\Users\Subjects;

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 国語、数学、英語を追加
        // テーブルをクリアする（既存のデータを削除）
        //DB::table('Subjects')->truncate();

        // DB::table('posts')->insert([
        //     ['user_id' => '1', 'post' => '1つ目の投稿です'],
        // ]);

        // データを挿入
        DB::table('subjects')->insert([
            ['subject' => '国語', 'created_at' => now()],
            ['subject' => '数学', 'created_at' => now()],
            ['subject' => '英語', 'created_at' => now()],
        ]);

    }
}
