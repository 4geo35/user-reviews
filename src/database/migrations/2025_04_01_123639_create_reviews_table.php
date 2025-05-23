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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("review_id")->nullable();
            $table->ipAddress()->nullable();
            $table->string('name')->nullable();
            $table->text('comment');
            $table->unsignedBigInteger('user_id');
            $table->dateTime("published_at")->nullable();
            $table->dateTime("registered_at")->nullable();

            $table->unsignedBigInteger("reviewable_id")->nullable();
            $table->string("reviewable_type")->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
