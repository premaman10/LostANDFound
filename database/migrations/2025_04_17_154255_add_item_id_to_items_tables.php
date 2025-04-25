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
        Schema::table('lost_items', function (Blueprint $table) {
            $table->string('item_id')->nullable()->unique()->after('id');
        });

        Schema::table('found_items', function (Blueprint $table) {
            $table->string('item_id')->nullable()->unique()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lost_items', function (Blueprint $table) {
            $table->dropColumn('item_id');
        });

        Schema::table('found_items', function (Blueprint $table) {
            $table->dropColumn('item_id');
        });
    }
}; 