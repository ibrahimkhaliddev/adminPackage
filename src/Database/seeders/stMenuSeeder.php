<?php

use Illuminate\Database\Seeder;
use App\Models\stMenu; // Replace 'App\Models\Menu' with the actual namespace for your Menu model

class stMenuSeeder extends Seeder
{
    public function run()
    {
        stMenu::insert([
            [
                'id' => 1,
                'title' => 'user',
                'slug' => 'user',
                'icon' => 'user',
                'path' => 'user',
                'parent_id' => null,
                'level' => 1,
                'position' => '1',
                'operations' => '[{"title":"create","key":"create_key","value":false},{"title":"update","key":"update_key","value":true}]',
                'created_at' => '2023-10-25 13:58:25',
                'updated_at' => '2023-11-01 09:12:50',
            ],
        ]);
    }
}
