<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;

Route::middleware(['auth'])->group(function () {
    Route::get('/update-all-users-menu', [HomeController::class, 'updateUserMenu'])->name('updateUserMenu');
    Route::get('/get-user-menu/{id}', [HomeController::class, 'getSingleUser'])->name('getSingleUser');
    Route::post('/update-user-menu/{id}', [HomeController::class, 'updateUserMenu'])->name('updateUserMenu');
    Route::get('/amdin', [MenuController::class, 'adminHome'])->name('adminHome');
    Route::post('/admin/menus/update', [MenuController::class, 'update'])->name('update.menus');
    Route::get('/admin/get-user-menus/{userId}', [MenuController::class, 'getUserMenus'])->name('get.user.menus');
    Route::post('/admin/update-user-menus/{userId}', [MenuController::class, 'updateUserMenus'])->name('update.user.menus');
    Route::get('/showUserMenus', [MenuController::class, 'showUserMenus'])->name('showUserMenus');
    Route::get('/create-menu', [MenuController::class, 'createMenu'])->name('createMenu');
    Route::post('/create-menu', [MenuController::class, 'storeMenu'])->name('store.menu');
    Route::post('/menu-update', [MenuController::class, 'updateMenu'])->name('menu.update');
    Route::post('/update-menu-order', [MenuController::class, 'updateMenuOrder'])->name('update.menu.order');

    Route::get('/menu/{id}', [MenuController::class, 'getMenu'])->name('getMenu');
    Route::post('/menu-update/{id}', [MenuController::class, 'singleMenuUpdate'])->name('singleMenuUpdate');
    Route::get('/menu-deleteMenu/{id}', [MenuController::class, 'deleteMenu'])->name('deleteMenu');
    Route::get('/menu-show', [MenuController::class, 'menuShow'])->name('menuShow');
    Route::get('/menu-manage', [MenuController::class, 'menuManage'])->name('menuManage');
    Route::get('/setup/country', [MenuController::class, 'setupCountry'])->name('setupCountry');

    Route::get('/setup/country/update_key/{id}', [MenuController::class, 'setupCountryUpdateform'])->name('setupCountryUpdateform')->middleware('permission:' . json_encode(['menu' => 'country', 'action' => 'update']));
    Route::get('/setup/country/download_key', [MenuController::class, 'setupCountryDownload'])->name('setupCountryDownload')->middleware('permission:' . json_encode(['menu' => 'country', 'action' => 'download']));
    Route::get('/setup/country/delete_key/{id}', [MenuController::class, 'setupCountryDelete'])->name('setupCountryDelete')->middleware('permission:' . json_encode(['menu' => 'country', 'action' => 'delete']));
    Route::get('/setup/country/create_key', [MenuController::class, 'setupCountryform'])->name('setupCountryform')->middleware('permission:' . json_encode(['menu' => 'country', 'action' => 'create']));
    Route::post('/setup/country/create', [MenuController::class, 'setupCountryCreate'])->name('setupCountryCreate');
    Route::post('/setup/country/update', [MenuController::class, 'setupCountryUpdate'])->name('setupCountryUpdate');

    Route::get('user-role', [MenuController::class, 'roleSetup'])->name('roleSetup');
    Route::post('role-update', [MenuController::class, 'roleUpdate'])->name('roleUpdate');
    Route::get('get-user-menu-permissions/{id}', [MenuController::class, 'getSingleUserMenuPermssion'])->name('getSingleUserMenuPermssion');

});