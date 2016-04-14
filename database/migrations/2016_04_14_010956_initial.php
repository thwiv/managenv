<?php


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Initial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if(!Schema::hasTable('environments')){
            Schema::create('environments', function (Blueprint $table) {
                $table->increments('id')->unsigned();
                $table->string('name', 100);
                $table->integer('parent_id', false, true)->nullable();


            });
        }

        Schema::table('environments', function(Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('environments');
        });
        if(!Schema::hasTable('variables')) {
            Schema::create('variables', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('environment_id', false, true);
                $table->string('name', 100);
                $table->text('value');
            });
        }
        Schema::table('variables', function(Blueprint $table) {
            $table->foreign('environment_id')->references('id')->on('environments');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
