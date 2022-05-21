<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('profile_pic')->nullable();
            $table->string('social_name');
            $table->string('social_place')->nullable();
            $table->string('commercial_name');
            $table->string('num_rc')->nullable();//
            $table->string('nif')->nullable();//
            $table->string('nis')->nullable();//
            $table->string('num_ar')->nullable();//
            $table->string('activity_code');
            $table->softDeletes();
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
        Schema::dropIfExists('user_profiles');
    }
}
