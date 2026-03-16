<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add parent_reply_id for nested (reply-to-reply) threads.
     */
    public function up(): void
    {
        Schema::table('ask_the_host_replies', function (Blueprint $table) {
            $table->foreignId('parent_reply_id')->nullable()->after('ask_the_host_query_id')
                ->constrained('ask_the_host_replies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        Schema::table('ask_the_host_replies', function (Blueprint $table) {
            $table->dropForeign(['parent_reply_id']);
        });
    }
};
