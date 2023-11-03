<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stMenu extends Model
{
    use HasFactory;

    public function children()
    {
        return $this->hasMany(stMenu::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(stMenu::class, 'parent_id');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'usermenus', 'menu_id', 'user_id');
    }

    protected $fillable = ['title', 'slug', 'icon', 'path', 'parent_id', 'level','operations'];
}
