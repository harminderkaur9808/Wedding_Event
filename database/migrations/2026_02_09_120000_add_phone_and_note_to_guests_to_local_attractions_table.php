<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds `phone` and `note_to_guests` to local_attractions.
     */
    public function up(): void
    {
        Schema::table('local_attractions', function (Blueprint $table) {
            if (!Schema::hasColumn('local_attractions', 'phone')) {
                $table->string('phone', 100)->nullable()->after('website');
            }
            if (!Schema::hasColumn('local_attractions', 'note_to_guests')) {
                $table->text('note_to_guests')->nullable()->after('phone');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('local_attractions', function (Blueprint $table) {
            if (Schema::hasColumn('local_attractions', 'phone')) {
                $table->dropColumn('phone');
            }
            if (Schema::hasColumn('local_attractions', 'note_to_guests')) {
                $table->dropColumn('note_to_guests');
            }
        });
    }
};
