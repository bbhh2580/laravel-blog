<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('followers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index()->comment('被关注的用户 ID');
            $table->integer('follower_id')->index()->comment('被关注的用户的粉丝, 也是对应用户表的 ID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('followers');
    }
};
