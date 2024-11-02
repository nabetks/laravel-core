<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('japan_areas', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique()->comment('地域コード');
            $table->string('name', 20)->unique()->comment('地域名');
            $table->string('name_kana', 40)->comment('地域名カナ');
            $table->string('name_en', 40)->comment('地域名英語');
            $table->integer('order', 2)->comment('表示順');
            $table->datetimes();
        });
    }
};
