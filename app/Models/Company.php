<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = "system_companies";
    protected $fillable = ["company_id", "company_name","corporate_id", "model_company", "alphanumeric_id_1", "alphanumeric_id_2", "alphanumeric_id_3", "created_by", "updated_by" ];
}
