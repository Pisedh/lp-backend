<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('payments', function (Blueprint $table) {
            $table->unsignedInteger('sanitation')->nullable()->change();
            $table->unsignedInteger('wifi')->nullable()->change();
        });
    }
    public function down(): void {
        Schema::table('payments', function (Blueprint $table) {
            $table->decimal('sanitation', 10, 2)->nullable()->change();
            $table->decimal('wifi', 10, 2)->nullable()->change();
        });
    }
};
