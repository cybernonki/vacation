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
        Schema::create('project_project', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('orderer_id')->nullable()->index('project_project_orderer_id_id_c47b8d30');
            $table->string('name', 200);
            $table->integer('sort')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_project');
    }
};
