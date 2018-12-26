<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActivationToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //migration的意思是修改数据库的表信息, 通过文件来修改, 能避免多人协同开发的时候, 修改完表格式, 其他人员不知道到底
            //表被改成啥了, 直接migrate即可
            //使用方法: php artisan migrate
            $table->string('activation_token')->nullable();
            $table->boolean('activated')->default(false);
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
            //
            $table->dropColumn('activation_token');
            $table->dropColumn('activated');
        });
    }
}
