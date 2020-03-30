<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTrendingPayPlan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pay_plans', function (Blueprint $table) {
            $table->unsignedInteger('order')->nullable()->default(null)->after('is_visible');
            $table->boolean('trending')->default(0)->after('order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pay_plans', function (Blueprint $table) {
            $table->dropColumn(['order', 'trending']);
        });
    }
}
