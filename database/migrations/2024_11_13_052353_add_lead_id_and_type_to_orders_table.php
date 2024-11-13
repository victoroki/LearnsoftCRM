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
        Schema::table('orders', function (Blueprint $table) {
            // Ensure the lead_id is unsignedBigInteger
            $table->unsignedBigInteger('lead_id')->nullable()->after('client_id');
            $table->string('type')->nullable()->after('lead_id'); // "Client" or "Lead"
            
            // Add foreign key constraint for lead_id
            $table->foreign('lead_id')->references('id')->on('leads')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['lead_id']);
            $table->dropColumn('lead_id');
            $table->dropColumn('type');
        });
    }
};
