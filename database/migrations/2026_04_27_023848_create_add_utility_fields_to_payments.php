<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('payments', function (Blueprint $table) {
            $table->decimal('water_old', 10, 2)->nullable()->after('note');
            $table->decimal('water_new', 10, 2)->nullable()->after('water_old');
            $table->decimal('water_rate', 10, 2)->default(2500)->after('water_new');
            $table->decimal('elec_old',  10, 2)->nullable()->after('water_rate');
            $table->decimal('elec_new',  10, 2)->nullable()->after('elec_old');
            $table->decimal('elec_rate', 10, 2)->default(1500)->after('elec_new');
            $table->decimal('wifi', 10, 2)->nullable()->after('elec_rate');
            $table->decimal('booking_price', 10, 2)->nullable()->after('wifi');
            $table->decimal('sanitation', 10, 2)->nullable()->after('booking_price');

        });
    }
    public function down(): void {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['water_old','water_new','water_rate','elec_old','elec_new','elec_rate','wifi','sanitation']);
        });
    }
};
