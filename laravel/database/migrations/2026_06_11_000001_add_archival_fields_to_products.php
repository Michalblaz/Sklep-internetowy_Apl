<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $needsArchivalFlag = ! Schema::hasColumn('products', 'isarchival');
        $needsArchivalDate = ! Schema::hasColumn('products', 'archivaldate');

        if (! $needsArchivalFlag && ! $needsArchivalDate) {
            return;
        }

        Schema::table('products', function (Blueprint $table) use ($needsArchivalFlag, $needsArchivalDate) {
            if ($needsArchivalFlag) {
                $table->unsignedSmallInteger('isarchival')->default(0)->index();
            }

            if ($needsArchivalDate) {
                $table->timestamp('archivaldate')->nullable()->index();
            }
        });
    }

    public function down(): void
    {
        $columns = array_values(array_filter([
            Schema::hasColumn('products', 'isarchival') ? 'isarchival' : null,
            Schema::hasColumn('products', 'archivaldate') ? 'archivaldate' : null,
        ]));

        if ($columns === []) {
            return;
        }

        Schema::table('products', function (Blueprint $table) use ($columns) {
            $table->dropColumn($columns);
        });
    }
};
