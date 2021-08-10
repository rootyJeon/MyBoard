<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;

class CreateExampleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('tbl_example', function (Blueprint $table) {

            /*
                참고 URL : https://laravel.kr/docs/7.x/migrations#creating-columns
            
            */

            // 순서. autoincrements
            $table->increments('idx');

            // string
            $table->string('title', 100)->default('')->comment('string varchar 100');
            $table->string('title_sub', 100)->nullable()->comment('string varchar 100 nullable');

            // boolean
            $table->boolean('isuse')->default(true)->comment('boolean tinyint default 1');

            // dateTime
            $table->dateTime('start_at')->comment('datetime');
            $table->dateTime('end_at')->comment('datetime');

            // timestamps
            $table->timestamps();

            // softDelete
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_example');
    }
}
