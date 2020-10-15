<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateSalaryCalculationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_salary_terms', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->increments('id');
            $table->dateTime('from');
            $table->dateTime('to');
            $table->text('note')->nullable();
            $table->timestamps();
        });

        Schema::create('teacher_salary_calculations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigIncrements('id');
            $table->integer('term_id')->unsigned();
            $table->bigInteger('teacher_id')->unsigned();
            $table->bigInteger('confirmed_by')->unsigned()->nullable();
            $table->dateTime('confirmed_at')->nullable();
            $table->decimal('teaching_duration', 8, 4)->default(0);
            $table->decimal('paid_amount', 19, 4)->default(0);
            $table->decimal('final_amount', 19, 4)->default(0);
            $table->decimal('amount', 19, 4)->default(0);
            $table->text('bonus')->nullable();
            $table->text('penalty')->nullable();
            $table->text('note')->nullable();
            $table->longText('meta')->nullable();
            $table->timestamps();

            $table->foreign('term_id')->references('id')->on('teacher_salary_terms')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('teacher_id')->references('user_id')->on('teachers')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('confirmed_by')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');

            $table->index('term_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teacher_salary_calculations');
        Schema::dropIfExists('teacher_salary_terms');
    }
}
