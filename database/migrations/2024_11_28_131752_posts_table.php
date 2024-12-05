<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
{
    Schema::create('posts', function (Blueprint $table) {
        $table->id();
        $table->text('text')->nullable();
        $table->json('images')->nullable();
        $table->json('videos')->nullable();
        $table->json('documents')->nullable();
        $table->json('comments')->nullable();
        $table->integer('likes')->default(0);
        $table->boolean('liked')->default(false);
        $table->timestamps();
    });
}


    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};