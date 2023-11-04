<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\stMenu;

class stMenuSeeder extends Seeder
{
    public function run()
    {
        stMenu::truncate();

        $stMenus = [
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
            ],
            [
                'id' => 4,
                'title' => 'User role',
                'slug' => 'User role',
                'icon' => 'User role',
                'path' => '/role-setup',
                'parent_id' => 1,
                'level' => 2,
                'position' => '0',
                'operations' => '[{"title":"create","key":"create_key","value":"true"},{"title":"update","key":"update_key","value":"true"},{"title":"pdf","key":"pdf_key","value":"true"},{"title":"download","key":"download_key","value":"true"},{"title":"excel","key":"excel_key","value":"true"}]',
            ],
            [
                'id' => 6,
                'title' => 'Menu manage',
                'slug' => 'menu-manage',
                'icon' => 'Menu manage',
                'path' => '/menus',
                'parent_id' => 1,
                'level' => 2,
                'position' => '1',
                'operations' => '[{"title":"create","key":"create_key","value":"true"},{"title":"update","key":"update_key","value":"true"}]',
            ],
            [
                'id' => 7,
                'title' => 'Menu',
                'slug' => 'menu-show',
                'icon' => 'menu-show',
                'path' => '/menu-show',
                'parent_id' => 1,
                'level' => 2,
                'position' => '2',
                'operations' => '[{"title":"create","key":"create_key","value":"true"}]',
            ]
        ];
        

        foreach ($stMenus as $menu) {
            stMenu::create($menu);
        }
    }
}
