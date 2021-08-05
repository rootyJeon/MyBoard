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
            $table->string('title', 100)->default('')->comment('에코 브랜드명');
            $table->string('updated_user', 100)->nullable()->comment('수정관리자');

            // boolean
            $table->boolean('is_use')->default(true)->comment('사용 여부');

            // dateTime
            $table->dateTime('display_start_at')->comment('노출 시작일');
            $table->dateTime('display_end_at')->comment('노출 시작일');

            // text
            $table->text('url')->comment('링크 URL');

            // unsignedInteger
            $table->unsignedInteger('order_seq')->default(0)->comment('정렬 순서값');

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
