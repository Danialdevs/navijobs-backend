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
            $table->id();
            $table->foreignId('company_office_id')
                    ->constrained('company_offices')
                    ->onDelete('cascade');
            $table->foreignId('client_id')
                    ->constrained('clients')
                    ->onDelete('cascade');
            $table->foreignId('service_id')
                    ->constrained('services')
                    ->onDelete('cascade');
            $table->string('address');
            $table->text('comment')->nullable();
            $table->string('status');
            $table->text('system_comment')->nullable(); 
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
