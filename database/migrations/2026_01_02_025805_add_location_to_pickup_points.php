<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pickup_points', function (Blueprint $table) {
            $table->json('location')->nullable();
        });
        
    }

    public function down(): void
    {
        Schema::table('pickup_points', function (Blueprint $table) {
            $table->dropColumn('location');
        });
    }
};