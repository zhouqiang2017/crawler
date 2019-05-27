<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSomeColumnToUsersTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name', 50)->nullable()->change();
            $table->string('email', 128)->nullable()->change();
            $table->string('password', 255)->nullable()->change();
            $table->string('open_id', 128)->nullable()->after('remember_token')->comment('open_id');
            $table->string('union_id', 128)->nullable()->after('open_id')->comment('union_id');
            $table->string('nick_name', 32)->nullable()->after('union_id')->comment('微信昵称');
            $table->string('mobile', 11)->nullable()->after('nick_name')->comment('微信授权手机号');
            $table->string('session_key', 128)->nullable()->after('mobile')->comment('微信session_key');
            $table->string('avatar', 255)->nullable()->after('session_key')->comment('微信头像');
            $table->unsignedTinyInteger('gender')->default(0)->after('avatar')->comment('性别      1：男  2 女 0：未知 ');
            $table->string('country', 50)->nullable()->after('gender')->comment('国籍');
            $table->string('province', 50)->nullable()->after('country')->comment('省份');
            $table->string('city', 50)->nullable()->after('province')->comment('城市');
            $table->string('language', 50)->nullable()->after('city')->comment('语言');
            $table->unsignedTinyInteger('status')->default(1)->after('language')->comment('状态   1：有效，2：无效');
            $table->string('remark', 255)->nullable()->after('status')->comment('备注');
            $table->unsignedTinyInteger('type')->default(0)->after('remark')->comment('来源渠道   0：网站 1：小程序 2：公众号');
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
            $table->string('name', 255)->nullable(false)->change();
            $table->string('email', 255)->nullable(false)->change();
            $table->string('password', 255)->nullable(false)->change();
            $table->dropColumn('open_id');
            $table->dropColumn('union_id');
            $table->dropColumn('nick_name');
            $table->dropColumn('mobile');
            $table->dropColumn('session_key');
            $table->dropColumn('avatar');
            $table->dropColumn('gender');
            $table->dropColumn('country');
            $table->dropColumn('province');
            $table->dropColumn('city');
            $table->dropColumn('language');
            $table->dropColumn('status');
            $table->dropColumn('remark');
            $table->dropColumn('type');
        });
    }
}
