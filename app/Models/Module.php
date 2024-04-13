<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model
{
    use HasFactory;

    protected $table = "system_modules";
    protected $fillable = ["name", "key","route", "mdi_icon", "status", "created_by", "updated_by" ];

    public function menus(): HasMany {

        return $this->hasMany(ModuleMenu::class, 'module_id');
    }
}
