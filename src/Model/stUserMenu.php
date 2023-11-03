<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stUserMenu extends Model
{
    use HasFactory;
    protected $fillable = ["user_id", "menu_id", "permissions", "is_allowed"];
}
