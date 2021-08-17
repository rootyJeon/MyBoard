<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 25);
            $table->tinyInteger('status');
            $table->integer('o_price');
            $table->integer('s_price');
            $table->string('image_name', 100)->nullable();
            $table->string('image_path')->nullable();
            $table->foreignId('brand_id')->nullable(false); // 일대다 관계를 위한 외래키
            $table->timestamp('created_at')->nullable(false);
            $table->timestamp('updated_at')->nullable(false);
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
        Schema::dropIfExists('products');
    }
}
