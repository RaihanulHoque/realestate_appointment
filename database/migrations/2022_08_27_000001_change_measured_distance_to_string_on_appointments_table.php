<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('measured_distance');
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->string('measured_distance', 20)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('measured_distance');
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->decimal('measured_distance', 8, 2)->nullable();
        });
    }
};
