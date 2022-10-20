<?php

use App\Models\Author;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('language');
            $table->integer('number_of_pages');
            $table->integer('number_of_available_books');
            $table->decimal('selling_price');
            $table->decimal('renting_price');
            $table->string('cover_photo_url');
            $table->foreignIdFor(Category::class)->constrained()
                ->onDelete('cascade ')
                ->onUpdate('cascade ');
            $table->foreignIdFor(Author::class)->constrained()
                ->onDelete('cascade ')
                ->onUpdate('cascade ');
            $table->foreignIdFor(Publisher::class)->constrained()
                ->onDelete('cascade ')
                ->onUpdate('cascade ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
};
