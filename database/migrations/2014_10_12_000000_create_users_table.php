<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('stud_no')->nullable();
            $table->string('last_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('mid_name')->nullable();
            $table->string('suffix')->nullable();
            $table->string('program')->nullable();
            $table->string('dobirth')->nullable();
            $table->string('brgy')->nullable();
            $table->string('town')->nullable();
            $table->string('province')->nullable();
            $table->string('parent_first')->nullable();
            $table->string('parent_last')->nullable();
            $table->string('parent_mid')->nullable();
            $table->string('user_type')->default(0);
            $table->string('email')->nullable()->unique();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
