<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('users') || !Schema::hasTable('orders') || !Schema::hasTable('complaints')) {
            return;
        }

        $user = DB::table('users')
            ->where('first_name', 'Jakub')
            ->where('last_name', 'Chmiel')
            ->first(['id']);

        if (!$user) {
            return;
        }

        DB::table('orders')->updateOrInsert(
            ['id' => 9010],
            [
                'user_id' => $user->id,
                'shipping_method_id' => null,
                'tracking_status' => 'Dostarczone',
                'shipping_cost' => 14.99,
                'created_at' => now()->subDays(3),
                'shipping_first_name' => 'Jakub',
                'shipping_last_name' => 'Chmiel',
                'shipping_street' => 'ul. Testowa 10',
                'shipping_city' => 'Rzeszów',
                'shipping_postal_code' => '35-001',
                'shipping_phone' => '531485472',
            ]
        );

        if (Schema::hasTable('order_items') && Schema::hasTable('products') && DB::table('products')->where('id', 26)->exists()) {
            DB::table('order_items')->updateOrInsert(
                ['id' => 9010],
                [
                    'order_id' => 9010,
                    'product_id' => 26,
                    'quantity' => 1,
                    'unit_price' => 650.00,
                ]
            );
        }

        DB::table('complaints')->updateOrInsert(
            ['id' => 9010],
            [
                'order_id' => 9010,
                'reason' => 'Reklamacja',
                'description' => 'Testowa reklamacja dla konta Jakub Chmiel. Produkt po dostawie wymaga sprawdzenia przez serwis.',
                'status' => 'oczekujące',
                'updated_at' => now(),
            ]
        );

        foreach (['orders', 'order_items', 'complaints'] as $table) {
            if (Schema::hasTable($table)) {
                DB::statement("
                    SELECT setval(
                        pg_get_serial_sequence('public.{$table}', 'id'),
                        GREATEST((SELECT COALESCE(MAX(id), 1) FROM public.{$table}), 1)
                    )
                ");
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('complaints')) {
            DB::table('complaints')->where('id', 9010)->delete();
        }

        if (Schema::hasTable('order_items')) {
            DB::table('order_items')->where('id', 9010)->delete();
        }

        if (Schema::hasTable('orders')) {
            DB::table('orders')->where('id', 9010)->delete();
        }
    }
};
