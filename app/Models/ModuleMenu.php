<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModuleMenu extends Model
{
    use HasFactory;

    protected $table = "system_modules_menus";
    protected $fillable = ["name", "key", "route", "mdi_icon", "status", "module_id"];

    public function modulo(): BelongsTo {
        return $this->belongsTo(Module::class);
    }
}
