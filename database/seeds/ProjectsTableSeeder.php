<?php

use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('projects')->insert([
            'created_at' => time(),
            'updated_at' => time(),
            'user_id' => 1,
            'hash' => md5(time()),
            'name' => 'test',
            'key' => 'TEST'
        ]);
    }
}
