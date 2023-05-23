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
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->unsignedBigInteger('numberPhone');
            $table->string('main_image');
            $table->time('timeOpen');
            $table->time('timeClose');
            $table->string('small_Presentation');
            $table->boolean('coins')->default(0);
            $table->string('country');
            $table->string('city');
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('active')->default(0);
            $table->string('code')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};
