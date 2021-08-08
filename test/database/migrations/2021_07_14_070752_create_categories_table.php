<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('usable');
            $table->foreignId('product_id')->nullable(); // 일대다 관계를 위한 외래키
            $table->timestamps();
            $table->SoftDeletes(); // 소프트 딜리트 처리
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
        // Schema::table('categories', function (Blueprint $table) {
        //     $table->dropSoftDeletes();
        // });
    }
}
