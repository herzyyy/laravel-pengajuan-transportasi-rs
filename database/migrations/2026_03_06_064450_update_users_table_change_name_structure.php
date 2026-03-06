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
        Schema::table('users', function (Blueprint $table) {
            // Rename name to first_name
            $table->renameColumn('name', 'first_name');
            
            // Add last_name after first_name
            $table->string('last_name')->after('first_name')->nullable();
            
            // Drop email column only
            $table->dropColumn('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Rename back
            $table->renameColumn('first_name', 'name');
            
            // Drop last_name
            $table->dropColumn('last_name');
            
            // Add back email only
            $table->string('email')->unique()->nullable();
        });
    }
};
