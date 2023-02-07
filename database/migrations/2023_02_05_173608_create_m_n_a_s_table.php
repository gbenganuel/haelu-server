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
        Schema::create('m_n_a_s', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable()->comment('references id on users table');
            $table->integer('food_intake_decline')->nullable();
            $table->integer('weight_loss')->nullable();
            $table->integer('mobility')->nullable();
            $table->integer('psych_stress_or_acute_disease')->nullable();
            $table->integer('neurological_problems')->nullable();
            $table->integer('bmi')->nullable()->comment('unit is measured as kg/m2');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_n_a_s');
    }
};
