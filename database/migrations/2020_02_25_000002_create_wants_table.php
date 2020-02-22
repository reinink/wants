<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWantsTable extends Migration
{
    public function up()
    {
        Schema::create('wants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('category_id')->index()->foreign('category_id')->references('id')->on('categories');
            $table->string('title', 100);
            $table->string('slug', 100);
            $table->string('status', 10);
            $table->timestamps();
        });
    }
}
