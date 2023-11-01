<?php

namespace App\Http\Middleware;

use App\Models\stUserMenu;
use App\Models\stMenu;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermissions
{

    public function handle($request, Closure $next, ...$permission)
    {

        $permission = implode('|', $permission);
        $permission = preg_split('/(\s)*\|(\s)*/', $permission);

        $menuSlug = explode(":", str_replace(['{', '}', '"'], '', $permission[0]))[1];
        $action = explode(":", str_replace(['{', '}', '"'], '', $permission[1]))[1];
        $menu = stMenu::where('title', 'country')->first();

        $menuPermission = stUserMenu::where('menu_id', $menu->id)
            ->where('user_id', Auth::user()->id)
            ->value('permissions');

        $permissions = json_decode($menuPermission, true);
        foreach ($permissions as $permission) {
            if (isset($permission['title']) && $permission['title'] == $action) {
                if (isset($permission['value']) && $permission['value'] === true) {
                    return $next($request);
                } else {
                    return redirect()->route('setupCountry');
                }
            }
        }
    }
}
