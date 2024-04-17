<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('system_companies', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('company_id');
            $table->string('company_name');
            $table->integer('corporate_id');
            $table->integer('model_company');
            $table->string('alphanumeric_id_1');
            $table->string('alphanumeric_id_2');
            $table->string('alphanumeric_id_3');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_companies');
    }
};
