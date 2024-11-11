<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function upfliles()
    {
        if(!Schema::hasTable('projects')){
            Schema::create('projects', function (Blueprint $table) {
                $table->id();
                $table->string('project_name');
                $table->date('start_date')->nullable();
                $table->date('end_date')->nullable();
                $table->string('project_image')->nullable();
                $table->string('project_excel')->nullable(); // Path to the Excel file
                $table->string('project_word')->nullable(); // Path to the Word document
                $table->string('project_pdf')->nullable(); // Path to the PDF document
                $table->integer('budget')->nullable();
                $table->integer('client_id');
                $table->text('description')->nullable();
                $table->string('status');
                $table->string('estimated_hrs')->nullable();
                $table->string('password')->nullable();
                $table->text('copylinksetting')->nullable();
                $table->text('tags')->nullable();
                $table->unsignedBigInteger('created_by');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pojects');
    }
}
