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
        Schema::create('book_master', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('page_count');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('writer_id');
            $table->unsignedBigInteger('publisher_id');
            $table->date('publication_year');
            $table->integer('qty')->nullable();
            $table->unsignedBigInteger('user_created');
            $table->unsignedBigInteger('user_updated')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('category_id')->references('id')->on('category_master')->onDelete('cascade');
            $table->foreign('writer_id')->references('id')->on('writer_master')->onDelete('cascade');
            $table->foreign('publisher_id')->references('id')->on('publisher_master')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_master');
    }
};
