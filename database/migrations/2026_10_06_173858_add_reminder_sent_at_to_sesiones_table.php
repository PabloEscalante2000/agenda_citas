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
        Schema::table('sesions', function (Blueprint $table) {
            $table->dateTime("reminder_sent_at")->nullable()->after("end_time");
            $table->index(["start_time", "reminder_sent_at"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sesions', function (Blueprint $table) {
            $table->dropIndex(["start_time", "reminder_sent_at"]);
            $table->dropColumn("reminder_sent_at");
        });
    }
};
