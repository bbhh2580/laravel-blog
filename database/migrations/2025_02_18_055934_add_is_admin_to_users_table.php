<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // 给 users 表新增一个 is_admin 字段，用来标识是否为管理员， 1 为管理员, 0 不是管理员;
            $table->boolean('is_admin')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // 党回滚迁移时, 需要删除 users 表的 is_admin 字段
            $table->dropColumn('is_admin');
        });
    }
};
