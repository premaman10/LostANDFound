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
        Schema::table('found_items', function (Blueprint $table) {
            $table->foreignId('lost_item_id')->nullable()->constrained('lost_items')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('found_items', function (Blueprint $table) {
            $table->dropForeign(['lost_item_id']);
            $table->dropColumn('lost_item_id');
        });
    }
};
