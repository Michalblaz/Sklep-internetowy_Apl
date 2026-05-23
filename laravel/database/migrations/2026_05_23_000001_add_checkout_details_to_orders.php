<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $needsPaymentMethod = ! Schema::hasColumn('orders', 'payment_method');
        $needsPickupPointInfo = ! Schema::hasColumn('orders', 'pickup_point_info');

        if (! $needsPaymentMethod && ! $needsPickupPointInfo) {
            return;
        }

        Schema::table('orders', function (Blueprint $table) use ($needsPaymentMethod, $needsPickupPointInfo) {
            if ($needsPaymentMethod) {
                $table->string('payment_method', 100)->nullable();
            }

            if ($needsPickupPointInfo) {
                $table->string('pickup_point_info', 255)->nullable();
            }
        });
    }

    public function down(): void
    {
        $columns = [];

        if (Schema::hasColumn('orders', 'payment_method')) {
            $columns[] = 'payment_method';
        }

        if (Schema::hasColumn('orders', 'pickup_point_info')) {
            $columns[] = 'pickup_point_info';
        }

        if ($columns === []) {
            return;
        }

        Schema::table('orders', function (Blueprint $table) use ($columns) {
            $table->dropColumn($columns);
        });
    }
};
