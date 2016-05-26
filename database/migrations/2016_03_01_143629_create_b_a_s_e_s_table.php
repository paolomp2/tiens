<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBASESTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('b_a_s_e_s', function(Blueprint $table) {
            $table->increments('id');
			$table->CAMPOnAME('CAMPO1');
			$table->timestamps();
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
        Schema::drop('b_a_s_e_s');
    }
}
