<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt');
            $table->text('content');
            $table->string('image')->nullable();
            $table->timestamp('published_at')->nullable()->comment('Дата и время публикации в UTC');
            $table->timestamps();
            
            // Индексы для оптимизации
            $table->index('published_at');
            $table->index('slug');
        });
    }

    public function down()
    {
        Schema::dropIfExists('news');
    }
};