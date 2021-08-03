<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('usable');
            $table->foreignId('product_id'); // 일대다 관계를 위한 왜래키
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
        Schema::dropIfExists('boards');
        // Schema::table('boards', function (Blueprint $table) {
        //     $table->dropSoftDeletes();
        // });
    }
}
