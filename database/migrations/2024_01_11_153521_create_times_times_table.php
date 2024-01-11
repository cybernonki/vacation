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
        Schema::create('times_times', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->date('work_date');
            $table->double('work_time');
            $table->bigInteger('employee_id')->nullable()->index('times_times_employee_id_c59b02af_fk_vacation_employee_id');
            $table->bigInteger('project_id')->nullable()->index('times_times_project_id_7aae653d_fk_project_project_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('times_times');
    }
};
