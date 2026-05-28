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
       Schema::create('menus', function (Blueprint $table) {

        $table->id();

        $table->string('name');

        $table->string('category');

        $table->string('origin')->nullable();

        $table->string('price');

        $table->text('description');

        $table->longText('full_description');

        $table->string('image')->nullable();

        $table->string('temperature')->default('both');

        $table->boolean('is_popular')->default(false);

        $table->boolean('is_new')->default(false);

        $table->timestamps();

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
