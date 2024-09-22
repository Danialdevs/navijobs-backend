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
        Schema::create('application_ratings', function (Blueprint $table) {
            $table->id();
            $table->string('comment')->nullable();
            $table->integer('stars')->nullable();
            $table->foreignId('application_id')
                ->constrained('applications');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_ratings');
    }
};
