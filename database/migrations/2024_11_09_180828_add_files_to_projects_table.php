<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFilesToProjectsTable extends Migration
{
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('project_image')->nullable();
            $table->string('project_excel')->nullable(); // Path to the Excel file
            $table->string('project_word')->nullable(); // Path to the Word document
            $table->string('project_pdf')->nullable(); // Path to the PDF document
        });
    }

    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['project_image', 'project_excel', 'project_word', 'project_pdf']);
        });
    }
}
