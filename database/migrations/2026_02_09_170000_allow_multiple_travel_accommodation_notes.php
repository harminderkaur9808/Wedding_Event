<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Allow multiple notes per type: drop unique on type, add sort_order.
     */
    public function up(): void
    {
        Schema::table('travel_accommodation_notes', function (Blueprint $table) {
            $table->dropUnique(['type']);
        });
        Schema::table('travel_accommodation_notes', function (Blueprint $table) {
            $table->unsignedTinyInteger('sort_order')->default(0)->after('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('travel_accommodation_notes', function (Blueprint $table) {
            $table->dropColumn('sort_order');
        });
        Schema::table('travel_accommodation_notes', function (Blueprint $table) {
            $table->unique('type');
        });
    }
};
