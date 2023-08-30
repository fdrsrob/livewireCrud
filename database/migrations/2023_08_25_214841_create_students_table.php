<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            $table->string('student_id')->unique()->nullable();

            $table->string('name')->nullable();

            $table->string('email')->nullable();

            $table->string('phone')->unique()->nullable();

            $table->unsignedBigInteger('code')->nullable();
            
            $table->timestamps();

            $table->foreign('code')->references('id')->on('careers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
