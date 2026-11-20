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
        Schema::table('guest_entries', function (Blueprint $table) {
            $table->string('met_with', 120)->nullable()->after('organization');
            $table->string('purpose', 180)->change();
            $table->text('message')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guest_entries', function (Blueprint $table) {
            $table->dropColumn('met_with');
            $table->string('purpose', 32)->change();
            $table->text('message')->nullable(false)->change();
        });
    }
};
