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
            if (!Schema::hasColumn('complaints', 'updated_at')) {
                $table->timestamp('updated_at')->nullable();
            }
        });

        DB::table('complaints')->where('id', 9001)->update([
            'status' => 'oczekujące',
            'updated_at' => now(),
        ]);

        DB::table('complaints')->where('id', 9002)->update([
            'status' => 'zaakceptowane',
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        if (!Schema::hasTable('complaints')) {
            return;
        }

        $columns = array_values(array_filter(
            ['updated_at'],
            fn (string $column) => Schema::hasColumn('complaints', $column)
        ));

        if ($columns !== []) {
            Schema::table('complaints', fn (Blueprint $table) => $table->dropColumn($columns));
        }
    }
};
