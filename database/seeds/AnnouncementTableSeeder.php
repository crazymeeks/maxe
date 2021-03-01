<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class AnnouncementTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('announcements')->insert([
            [
                'title' => 'Test',
                'content' => '<p>Content</p>',
                'start_date' => date('Y-m-d'),
                'end_date' => date('Y-m-d', strtotime(now()->__toString() . ' +1 day')),
                'active' => 1,
                'created_at' => now()->__toString(),
                'updated_at' => now()->__toString(),
            ]
        ]);
    }
}
