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

        $passwordHash = '$2y$12$pMYi.0BbkodP8g.JGJaiBOfwauCl5lUXaUN07rLHWdGWyBjHOqnPK';

        $users = [
            [
                'id' => 9001,
                'email' => 'reklamacja.demo@example.com',
                'password_hash' => $passwordHash,
                'first_name' => 'Oskar',
                'last_name' => 'Kwiatkowski',
                'phone' => '501900001',
                'is_Admin' => false,
            ],
            [
                'id' => 9002,
                'email' => 'zwrot.demo@example.com',
                'password_hash' => $passwordHash,
                'first_name' => 'Julia',
                'last_name' => 'Maj',
                'phone' => '501900002',
                'is_Admin' => false,
            ],
            [
                'id' => 9003,
                'email' => 'serwis.demo@example.com',
                'password_hash' => $passwordHash,
                'first_name' => 'Tomasz',
                'last_name' => 'Lis',
                'phone' => '501900003',
                'is_Admin' => false,
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->updateOrInsert(['id' => $user['id']], $user);
        }

        $orders = [
            [
                'id' => 9001,
                'user_id' => 9001,
                'shipping_method_id' => null,
                'tracking_status' => 'Dostarczone',
                'shipping_cost' => 14.99,
                'created_at' => now()->subDays(9),
                'shipping_first_name' => 'Oskar',
                'shipping_last_name' => 'Kwiatkowski',
                'shipping_street' => 'ul. Testowa 12',
                'shipping_city' => 'Rzeszów',
                'shipping_postal_code' => '35-001',
                'shipping_phone' => '501900001',
            ],
            [
                'id' => 9002,
                'user_id' => 9002,
                'shipping_method_id' => null,
                'tracking_status' => 'Dostarczone',
                'shipping_cost' => 12.99,
                'created_at' => now()->subDays(5),
                'shipping_first_name' => 'Julia',
                'shipping_last_name' => 'Maj',
                'shipping_street' => 'ul. Zwrotna 7',
                'shipping_city' => 'Kraków',
                'shipping_postal_code' => '30-001',
                'shipping_phone' => '501900002',
            ],
            [
                'id' => 9003,
                'user_id' => 9003,
                'shipping_method_id' => null,
                'tracking_status' => 'W realizacji',
                'shipping_cost' => 0,
                'created_at' => now()->subDays(2),
                'shipping_first_name' => 'Tomasz',
                'shipping_last_name' => 'Lis',
                'shipping_street' => 'ul. Serwisowa 4',
                'shipping_city' => 'Warszawa',
                'shipping_postal_code' => '00-001',
                'shipping_phone' => '501900003',
            ],
            [
                'id' => 9004,
                'user_id' => 9001,
                'shipping_method_id' => null,
                'tracking_status' => 'Dostarczone',
                'shipping_cost' => 14.99,
                'created_at' => now()->subDays(14),
                'shipping_first_name' => 'Oskar',
                'shipping_last_name' => 'Kwiatkowski',
                'shipping_street' => 'ul. Testowa 12',
                'shipping_city' => 'Rzeszów',
                'shipping_postal_code' => '35-001',
                'shipping_phone' => '501900001',
            ],
        ];

        foreach ($orders as $order) {
            DB::table('orders')->updateOrInsert(['id' => $order['id']], $order);
        }

        if (Schema::hasTable('order_items') && Schema::hasTable('products')) {
            $orderItems = [
                ['id' => 9001, 'order_id' => 9001, 'product_id' => 23, 'quantity' => 1, 'unit_price' => 1599.00],
                ['id' => 9002, 'order_id' => 9002, 'product_id' => 24, 'quantity' => 1, 'unit_price' => 899.00],
                ['id' => 9003, 'order_id' => 9003, 'product_id' => 26, 'quantity' => 1, 'unit_price' => 650.00],
                ['id' => 9004, 'order_id' => 9004, 'product_id' => 25, 'quantity' => 2, 'unit_price' => 569.00],
            ];

            foreach ($orderItems as $item) {
                if (DB::table('products')->where('id', $item['product_id'])->exists()) {
                    DB::table('order_items')->updateOrInsert(['id' => $item['id']], $item);
                }
            }
        }

        $complaints = [
            [
                'id' => 9001,
                'order_id' => 9001,
                'reason' => 'Reklamacja',
                'description' => 'Pamięć RAM po zamontowaniu powoduje niestabilną pracę komputera. Klient prosi o sprawdzenie produktu.',
                'status' => 'oczekujące',
            ],
            [
                'id' => 9002,
                'order_id' => 9002,
                'reason' => 'Zwrot',
                'description' => 'Dysk został zamówiony omyłkowo. Klient chce zwrócić produkt w ustawowym terminie.',
                'status' => 'zaakceptowane',
            ],
            [
                'id' => 9003,
                'order_id' => 9003,
                'reason' => 'Reklamacja',
                'description' => 'Procesor dotarł z naruszonym opakowaniem. Klient zgłasza prośbę o weryfikację przed montażem.',
                'status' => 'odrzucone',
            ],
            [
                'id' => 9004,
                'order_id' => 9004,
                'reason' => 'Zwrot',
                'description' => 'Klient wybrał złą pojemność dysku i chce wymienić zamówienie na inny model.',
                'status' => 'oczekujące',
            ],
        ];

        foreach ($complaints as $complaint) {
            DB::table('complaints')->updateOrInsert(['id' => $complaint['id']], $complaint);
        }

        $this->syncSequences();
    }

    public function down(): void
    {
        if (Schema::hasTable('complaints')) {
            DB::table('complaints')->whereIn('id', [9001, 9002, 9003, 9004])->delete();
        }

        if (Schema::hasTable('order_items')) {
            DB::table('order_items')->whereIn('id', [9001, 9002, 9003, 9004])->delete();
        }

        if (Schema::hasTable('orders')) {
            DB::table('orders')->whereIn('id', [9001, 9002, 9003, 9004])->delete();
        }

        if (Schema::hasTable('users')) {
            DB::table('users')->whereIn('id', [9001, 9002, 9003])->delete();
        }
    }

    private function syncSequences(): void
    {
        foreach (['users', 'orders', 'order_items', 'complaints'] as $table) {
            if (!Schema::hasTable($table)) {
                continue;
            }

            DB::statement("
                SELECT setval(
                    pg_get_serial_sequence('public.{$table}', 'id'),
                    GREATEST((SELECT COALESCE(MAX(id), 1) FROM public.{$table}), 1)
                )
            ");
        }
    }
};
