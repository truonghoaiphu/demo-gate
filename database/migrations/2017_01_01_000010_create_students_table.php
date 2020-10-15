<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigInteger('user_id')->unsigned()->primary();
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('approved_by')->unsigned()->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->longText('meta')->nullable();
            $table->tinyInteger('source')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->bigInteger('old_id')->unsigned()->nullable();

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('created_by')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('approved_by')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');

            $table->index('status');
            $table->index('created_at');
            $table->index('deleted_at');

            $table->index('old_id');
        });

        Schema::create('student_aggregations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigInteger('user_id')->unsigned()->primary();
            $table->integer('count_classrooms')->default(0);
            $table->integer('count_class_times')->default(0);
            $table->decimal('count_learning_hours', 8, 2)->default(0);
            $table->integer('count_outcome')->default(0);
            $table->integer('count_teachers')->default(0);
            $table->integer('count_male_teachers')->default(0);
            $table->integer('count_female_teachers')->default(0);

            $table->foreign('user_id')->references('user_id')->on('students')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_aggregations');
        Schema::dropIfExists('students');
    }
}
