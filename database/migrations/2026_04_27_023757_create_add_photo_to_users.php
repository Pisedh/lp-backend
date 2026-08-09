<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            // Store photo as base64 string (TEXT to handle large base64)
            $table->text('photo')->nullable()->after('tools');
        });
    }
    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
         $table->dropColumn('photo');
        });
    }
};
