<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\stMenu;
use App\Models\Country;
use App\Models\stUserMenu;
use Illuminate\Support\Facades\Auth;
use PDF;

class MenuController extends Controller
{
    function adminHome()
    {
        $menus = stMenu::orderBy('position')->get();
        $users = User::all();
        $userId = Auth::id();
        $user = User::find($userId);
        $userMenus = $user->menus()->with('children')->orderBy('position')->get();
        $hasChildMenus = $userMenus->contains(function ($menu) {
            return $menu->children->isNotEmpty();
        });
        return view('my_package/admin/home', compact('menus', 'users', 'userMenus'));
    }
    public function getUserMenus($userId)
    {
        $user = User::find($userId);
        $userMenus = $user->menus()->orderBy('position')->get();
        return response()->json($userMenus);
    }


    public function update(Request $request)
    {
        $userId = $request->input('user_id');
        $selectedMenus = $request->input('menus');
    
        foreach ($selectedMenus as $selectedMenu) {
            $menu = stMenu::find($selectedMenu);
            $userMenu = stUserMenu::updateOrCreate(
                ['user_id' => $userId, 'menu_id' => $menu->id],
                ['permissions' => $menu->operations, 'is_allowed' => "true"]
            );
        }
    
        stUserMenu::where('user_id', $userId)
            ->whereNotIn('menu_id', $selectedMenus)
            ->update(['is_allowed' => "false"]);
    
        return redirect()->back()->with('success', 'User menus updated successfully');
    }
    
    

    public function showUserMenus()
    {
        $userId = Auth::id();
        $user = User::find($userId);
        $userMenus = $user->menus()->with('children')->orderBy('position')->get();
        $hasChildMenus = $userMenus->contains(function ($menu) {
            return $menu->children->isNotEmpty();
        });
        return view('my_package/home', compact('userMenus'));
    }

    public function createMenu()
    {
        return view('my_package/admin/createMenu');
    }

    public function storeMenu(Request $request)
    {
        $formData = $request->all();
        $operationsJSON = json_encode($formData['operations']);

        if (isset($formData['title']) && isset($formData['slug']) && isset($formData['icon']) && isset($formData['path'])) {
            $menu = new stMenu([
                'title' => $formData['title'],
                'slug' => $formData['slug'],
                'icon' => $formData['icon'],
                'path' => $formData['path'],
                'level' => '1',
                'operations' => $operationsJSON,
            ]);

            $menu->save();
            $menus = stMenu::orderBy('position')->get();
            $output = view('my_package/admin/menu/get', compact('menus'))->render();

            return $output;
        } else {
            return response()->json(['error' => 'One or more required fields are missing'], 400);
        }
    }


    // function updateMenu()
    // {
    //     return 'done';
    // }

    public function updateMenuOrder(Request $request)
    {
        $menuOrder = json_decode($request->input('menuOrder'), true);
        $this->handleMenuOrder($menuOrder);

        return response()->json(['message' => 'Menu order updated successfully']);
    }

    private function handleMenuOrder($menuOrder, $parentLevel = 1, $parentId = null)
    {
        foreach ($menuOrder as $key => $item) {
            $menu = stMenu::find($item['id']);
            $menu->position = $key;
            $menu->level = $parentLevel;

            if (isset($item['children']) && count($item['children']) > 0) {
                $this->handleNestedChildren($item['children'], $menu, $parentLevel + 1, $menu->id);
            }

            if (isset($parentId)) {
                $menu->parent_id = $parentId;
            } else {
                $menu->parent_id = null;
            }

            $menu->save();
        }
    }

    private function handleNestedChildren($children, $parent, $childLevel, $parentId)
    {
        foreach ($children as $key => $child) {
            $childMenu = stMenu::find($child['id']);
            $childMenu->position = $key;
            $childMenu->level = $childLevel;
            $childMenu->parent_id = $parentId;
            $childMenu->save();

            if (isset($child['children']) && count($child['children']) > 0) {
                $this->handleNestedChildren($child['children'], $childMenu, $childLevel + 1, $childMenu->id);
            }
        }
    }


    public function getMenu($id)
    {
        $menu = stMenu::find($id);
        return response()->json($menu);
    }

    public function singleMenuUpdate(Request $request, $id)
    {
        $menu = stMenu::find($id);
        $operationsJSON = json_encode($request->operations);
        $menu->title = $request->input('title');
        $menu->slug = $request->input('slug');
        $menu->icon = $request->input('icon');
        $menu->path = $request->input('path');
        $menu->level = $request->input('level');
        $menu->operations = $operationsJSON;
        $menu->save();

        $userMenus = stUserMenu::where('menu_id', $id)->get();
        if ($userMenus->count() > 0) {
            foreach ($userMenus as $userMenu) {
                $userMenu->permissions = $operationsJSON;
                $userMenu->save();
            }
        }

        $menus = stMenu::orderBy('position')->get();
        $output = view('my_package/admin/menu/get', compact('menus'))->render();

        return $output;
    }

    function deleteMenu($id)
    {
        $menu = stMenu::find($id)->delete();
        $menus = stMenu::orderBy('position')->get();
        $output = view('my_package/admin/menu/get', compact('menus'))->render();

        return $output;
    }

    function menuShow()
    {
        $userId = Auth::id();
        $user = User::find($userId);
        $userMenus = $user->menus()->with('children')->orderBy('position')->get();
        $hasChildMenus = $userMenus->contains(function ($menu) {
            return $menu->children->isNotEmpty();
        });
        $menus = stMenu::orderBy('position')->get();
        return view('my_package/admin/menu/show', compact('menus', 'userMenus'));
    }

    function menuManage()
    {
        $menus = stMenu::orderBy('position')->get();
        $users = User::all();
        $userId = Auth::id();
        $user = User::find($userId);
        $userMenus = $user->menus()->with('children')->orderBy('position')->get();
        $hasChildMenus = $userMenus->contains(function ($menu) {
            return $menu->children->isNotEmpty();
        });
        return view('my_package/admin/menu/manage', compact('menus', 'users', 'userMenus'));
    }

    public function setupCountry(Request $request)
    {
        $url = $request->getRequestUri();
        $path = parse_url($url, PHP_URL_PATH);
        $trimmedPath = trim($path, '/');

        $menu = stMenu::where('path', 'like', '%' . $trimmedPath . '%')->first();

        if ($menu) {
            $userMenu = stUserMenu::where('menu_id', $menu->id)->where('user_id', Auth::id())->first();

            if ($userMenu) {
                $permissions = json_decode($userMenu->permissions, true);
            } else {
                $permissions = [];
            }
        } else {
            $permissions = [];
        }
        $countries = Country::all();
        $userId = Auth::id();
        $user = User::find($userId);
        $userMenus = $user->menus()->with('children')->orderBy('position')->get();
        $hasChildMenus = $userMenus->contains(function ($menu) {
            return $menu->children->isNotEmpty();
        });

        return view('my_package/setup.country', compact('countries', 'userMenus', 'permissions'));
    }


    function roleSetup()
    {
        $userId = Auth::id();
        $user = User::find($userId);
        $userMenus = $user->menus()->with('children')->orderBy('position')->get();
        $hasChildMenus = $userMenus->contains(function ($menu) {
            return $menu->children->isNotEmpty();
        });
        $menus = stMenu::orderBy('position')->get();
        $users = User::all();
        return view('my_package/admin.role.setup', compact('userMenus', 'menus', 'users'));
    }

    function roleUpdate(Request $request)
    {
        $userId = $request->input('user');
        $user = User::findOrFail($userId);
        $menus = stUserMenu::where('user_id', $userId)->get();
        $requestData = $request->input();

        if ($menus->isNotEmpty()) {
            foreach ($menus as $menu) {
                $id = $menu->menu_id;
                $permissions = json_decode($menu->permissions, true);
                if ($permissions) {
                    foreach ($permissions as &$permission) {
                        $key = $permission['key'];
                        $data = isset($requestData[$key]) ? $requestData[$key] : [];

                        $permission['value'] = in_array($id, $data);
                    }
                    $menu->permissions = json_encode($permissions);
                    $menu->save();
                }
            }
        } else {
            $stMenus = stMenu::all();

            foreach ($stMenus as $menu) {
                $id = $menu->menu_id;
                $permissions = json_decode($menu->operations, true);

                foreach ($permissions as &$permission) {
                    $key = $permission['key'];
                    $data = isset($requestData[$key]) ? $requestData[$key] : [];

                    $permission['value'] = in_array($id, $data);
                }

                $stMenu = new stUserMenu([
                    'user_id' => $userId,
                    'menu_id' => $menu->id,
                    'permissions' => json_encode($permissions),
                    'is_allowed' => 'false'
                ]);

                $stMenu->save();
            }
        }
        return redirect()->back();
    }

    function getSingleUserMenuPermssion($id)
    {
        $menu = stUserMenu::where('user_id', $id)->get();
        return response()->json($menu);
    }
    function setupCountryform()
    {
        $userId = Auth::id();
        $user = User::find($userId);
        $userMenus = $user->menus()->with('children')->orderBy('position')->get();
        $hasChildMenus = $userMenus->contains(function ($menu) {
            return $menu->children->isNotEmpty();
        });
        return view('my_package/setup.countryCreate', compact('userMenus'));
    }
    function setupCountryCreate(Request $request)
    {
        $country = new Country([
            'name' => $request->countryName,
            'country_code' => $request->countryCode,
        ]);
        $country->save();
        return redirect()->route('setupCountry');
    }
    function setupCountryUpdateform($country_id)
    {
        $userId = Auth::id();
        $user = User::find($userId);
        $userMenus = $user->menus()->with('children')->orderBy('position')->get();
        $hasChildMenus = $userMenus->contains(function ($menu) {
            return $menu->children->isNotEmpty();
        });
        $country = Country::find($country_id);
        return view('my_package/setup.countryUpdate', compact('userMenus', 'country'));
    }
    function setupCountryUpdate(Request $request)
    {

        $country = Country::find($request->country_id);

        if ($country) {
            $country->update([
                'name' => $request->countryName,
                'country_code' => $request->countryCode,
            ]);

            return redirect()->route('setupCountry');
        }

    }

    function setupCountryDelete($id)
    {
        Country::find($id)->delete();
        return redirect()->route('setupCountry');
    }

    function setupCountryDownload()
    {
        $countries = Country::all();
        $pdf = PDF::loadView('my_package/setup.countries_pdf', compact('countries'));
        return $pdf->download('countries.pdf');
    }
}