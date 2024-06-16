<?php namespace Sebastian\Forms\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateApplicationsTable extends Migration
{
    public function up()
    {
        Schema::create('sebastian_forms_applications', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->text('text')->nullable();

            $table->string('ip')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sebastian_forms_applications');
    }
}
