<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('japan_prefectures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('japan_area_id')->index()->comment('地域ID')->constrained();
            $table->integer('code', 2)->unique()->comment('都道府県コード');
            $table->string('name',10)->unique()->comment('都道府県名');
            $table->string('name_kana',20)->unique()->comment('都道府県名カナ');
            $table->string('name_en',30)->unique()->comment('都道府県名英語');
            $table->datetimes();
        });
    }
};
