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
                'operations' => '[{"title":"create","key":"create_key","value":false}]',
            ],
            [
                'id' => 2,
                'title' => 'User role',
                'slug' => 'User role',
                'icon' => 'User role',
                'path' => '/role-setup',
                'parent_id' => 1,
                'level' => 2,
                'position' => '0',
                'operations' => '[{"title":"create","key":"create_key","value":false}]',
            ],
            [
                'id' => 3,
                'title' => 'Menu manage',
                'slug' => 'menu-manage',
                'icon' => 'Menu manage',
                'path' => '/menus',
                'parent_id' => 1,
                'level' => 2,
                'position' => '1',
                'operations' => '[{"title":"create","key":"create_key","value":false}]',
            ],
            [
                'id' => 4,
                'title' => 'Menu',
                'slug' => 'menu-show',
                'icon' => 'menu-show',
                'path' => '/menu-show',
                'parent_id' => 1,
                'level' => 2,
                'position' => '2',
                'operations' => '[{"title":"create","key":"create_key","value":false}]',
            ]
        ];
        

        foreach ($stMenus as $menu) {
            stMenu::create($menu);
        }
    }
}
