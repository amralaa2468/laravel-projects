<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('book_id');

            $table->text('review');
            $table->unsignedTinyInteger('rating');

            $table->timestamps();

            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            //cascade means when a book gets deleted all the reviews are deleted too

            //instead of creating book_id and then references we can write
            //$table->foreignId('book_id)->constrained()->cascadeOnDelete();
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
