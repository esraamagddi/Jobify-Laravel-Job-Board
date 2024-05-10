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
        Schema::create('applications', function (Blueprint $table) {

            // 3 | email in resume - email in profile - email in application

            $table->id();
            $table->bigInteger('job_id');           // temp FK
            $table->bigInteger('candidate_id');     // temp FK
            // $table->enum('status', ['applied', 'cancelled']);
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->string('resume')->nullable();           // ok
            $table->text('contact_details')->nullable();    // phone - etc ...
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
