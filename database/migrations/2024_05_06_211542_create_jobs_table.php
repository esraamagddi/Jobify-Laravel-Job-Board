<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employer_id');  // temp FK
            $table->bigInteger('category_id');  // temp FK
            $table->string('title', 50);
            $table->string('description', 50);
            $table->mediumText('responsibilities');
            $table->mediumText('skills');
            $table->mediumText('qualifications');
            $table->string('salary_range', 50);
            $table->enum('work_type', ['remote', 'offline', 'hybrid']);
            $table->string('location', 60);
            $table->date('deadline');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
