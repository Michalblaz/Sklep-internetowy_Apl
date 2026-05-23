<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('complaints')) {
            return;
        }

        Schema::table('complaints', function (Blueprint $table) {
            if (!Schema::hasColumn('complaints', 'admin_response')) {
                $table->text('admin_response')->nullable();
            }

            if (!Schema::hasColumn('complaints', 'customer_reply')) {
                $table->text('customer_reply')->nullable();
            }

            if (!Schema::hasColumn('complaints', 'responded_at')) {
                $table->timestamp('responded_at')->nullable();
            }

            if (!Schema::hasColumn('complaints', 'customer_replied_at')) {
                $table->timestamp('customer_replied_at')->nullable();
            }

            if (!Schema::hasColumn('complaints', 'updated_at')) {
                $table->timestamp('updated_at')->nullable();
            }
        });

        DB::table('complaints')->where('id', 9001)->update([
            'status' => 'oczekujące',
            'admin_response' => 'Prosimy o przesłanie informacji, czy problem występuje również po przetestowaniu pamięci w drugim slocie płyty głównej.',
            'responded_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('complaints')->where('id', 9002)->update([
            'status' => 'zaakceptowane',
            'admin_response' => 'Zwrot został zaakceptowany. Prosimy o odesłanie produktu w oryginalnym opakowaniu.',
            'responded_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        if (!Schema::hasTable('complaints')) {
            return;
        }

        $columns = array_values(array_filter(
            ['admin_response', 'customer_reply', 'responded_at', 'customer_replied_at', 'updated_at'],
            fn (string $column) => Schema::hasColumn('complaints', $column)
        ));

        if ($columns !== []) {
            Schema::table('complaints', fn (Blueprint $table) => $table->dropColumn($columns));
        }
    }
};
