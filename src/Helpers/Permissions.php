<?php
use App\Models\stMenu;
use Illuminate\Support\Facades\Auth;
use App\Models\stUserMenu;

if (!function_exists('isAllowedPermissions')) {
    function isAllowedPermissions(...$options)
    {
        $params = $options[0];
        $menu = $params['menu'];
        $action = $params['action'];
        $column = 'permissions';
        $allowed = false;

        $menuData = stMenu::where('title', $menu)->first();

        if ($menuData) {
            $userMenuData = stUserMenu::where('menu_id', $menuData->id)
                ->where('user_id', Auth::user()->id)
                ->first();

            $permissions = json_decode($userMenuData->$column, true);
            foreach ($permissions as $permission) {
                if ($permission['key'] === $action && $permission['value'] === true) {
                    $allowed = $permission['value'];
                    break;
                }
            }
        }
        return $allowed;
    }
}

