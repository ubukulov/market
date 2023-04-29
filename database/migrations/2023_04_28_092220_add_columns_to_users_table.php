<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('full_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('bin')->nullable();
            $table->string('legal_address')->nullable();
            $table->string('bik')->nullable();
            $table->string('bank')->nullable();
            $table->string('iik')->nullable();
            $table->string('full_name_director')->nullable();
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
            $table->dropColumn([
                'full_name', 'phone', 'bin', 'legal_address', 'bik', 'bank', 'iik', 'full_name_director'
            ]);
        });
    }
}
