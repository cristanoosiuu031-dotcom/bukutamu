<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guest_entries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('email')->nullable();
            $table->string('phone', 32)->nullable();
            $table->string('organization', 120)->nullable();
            $table->string('purpose', 32);
            $table->text('message');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guest_entries');
    }
};
