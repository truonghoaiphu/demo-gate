<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Schema\Blueprint;

class CreatePayslipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payslips', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigIncrements('id');
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->string('name')->nullable();
            $table->dateTime('start_at')->nullable();
            $table->dateTime('end_at')->nullable();
            $table->timestamps();

            $table->bigInteger('old_id')->unsigned()->nullable();

            $table->foreign('created_by')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');

            $table->index('created_at');
            $table->index('old_id');
        });

        Schema::create('payslip_details', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigIncrements('id');
            $table->bigInteger('payslip_id')->unsigned();
            $table->bigInteger('teacher_id')->unsigned();
            $table->string('currency')->nullable();
            $table->double('total')->default(0);
            $table->double('money')->default(0);
            $table->double('pending')->default(0);
            $table->double('bonus')->default(0);
            $table->double('penalty')->default(0);
            $table->double('course_bonus')->default(0);
            $table->double('referral_fee')->default(0);
            $table->double('other_bonus')->default(0);
            $table->text('bonus_reason')->nullable();
            $table->tinyInteger('email_sent')->default(0);
            $table->tinyInteger('teacher_email_sent')->default(0);
            $table->timestamps();

            $table->bigInteger('old_id')->unsigned()->nullable();

            $table->foreign('payslip_id')->references('id')->on('payslips')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('teacher_id')->references('user_id')->on('teachers')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->index('payslip_id');
            $table->index('teacher_id');
            $table->index('old_id');
        });

        Schema::create('payslip_details_courses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->rowFormat = 'DYNAMIC';

            $table->bigInteger('detail_id')->unsigned();
            $table->bigInteger('course_id')->unsigned();
            $table->double('money')->default(0);
            $table->string('currency')->nullable();

            $table->foreign('detail_id')->references('id')->on('payslip_details')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('course_id')->references('id')->on('courses')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->primary(['detail_id', 'course_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payslip_details_courses');
        Schema::dropIfExists('payslip_details');
        Schema::dropIfExists('payslips');
    }
}
