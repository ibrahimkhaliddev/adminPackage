<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\stUserMenu;

class stUserMenuSeeder extends Seeder
{
    public function run()
    {
        stUserMenu::truncate();

        $stUserMenu = [
            [
                'id' => 1,
                'user_id' => '1',
                'menu_id' => '1',
                'permissions' => '[{"title":"create","key":"create_key","value":false}]',
                'is_allowed' => 'true'
            ],
            [
                'id' => 2,
                'user_id' => '1',
                'menu_id' => '2',
                'permissions' => '[{"title":"create","key":"create_key","value":false}]',
                'is_allowed' => 'true'
            ],
            [
                'id' => 3,
                'user_id' => '1',
                'menu_id' => '3',
                'permissions' => '[{"title":"create","key":"create_key","value":false}]',
                'is_allowed' => 'true'
            ],
            [
                'id' => 4,
                'user_id' => '1',
                'menu_id' => '4',
                'permissions' => '[{"title":"create","key":"create_key","value":false}]',
                'is_allowed' => 'true'
            ],
        ];

        foreach ($stUserMenu as $menu) {
            stUserMenu::create($menu);
        }
    }
}
