<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Modify the status enum by dropping and recreating the enum with updated values
        DB::statement("ALTER TABLE `applications` MODIFY `status` ENUM('full-done', 'awaiting', 'canceled') DEFAULT 'awaiting'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Reverse the change by adding back 'found-worker' to the enum
        DB::statement("ALTER TABLE `applications` MODIFY `status` ENUM('found-worker', 'full-done', 'awaiting', 'canceled') DEFAULT 'awaiting'");
    }
};
