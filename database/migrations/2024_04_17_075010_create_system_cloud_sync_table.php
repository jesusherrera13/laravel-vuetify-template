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
        Schema::create('system_cloud_sync', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cloud_domain_id')->references('id')->on('system_cloud_domains');
            $table->string('name');
            $table->string('url');
            $table->string('method');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_cloud_sync');
    }
};
