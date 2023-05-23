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
        Schema::create('img_menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_menu')
                  ->constrained('menu')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->string('link');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('img_menus');
    }
};