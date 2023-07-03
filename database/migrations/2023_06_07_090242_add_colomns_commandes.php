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
        Schema::table('commandes', function (Blueprint $table) {
            $table->string('city');
            $table->string('neighborhood');
            $table->string('building');
            $table->string('apartment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->dropColumn('city');
            $table->dropColumn('neighborhood');
            $table->dropColumn('building');
            $table->dropColumn('apartment');
        });
    }
};
