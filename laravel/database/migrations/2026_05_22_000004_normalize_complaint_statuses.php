<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('complaints')) {
            return;
        }

        DB::statement("ALTER TABLE public.complaints ALTER COLUMN status SET DEFAULT 'oczekujące'");

        DB::table('complaints')
            ->whereIn('status', ['new', 'in_progress', 'waiting_customer', 'oczekujace', 'w trakcie'])
            ->orWhereNull('status')
            ->update(['status' => 'oczekujące']);

        DB::table('complaints')
            ->whereIn('status', ['accepted', 'zaakceptowana', 'zaakceptowany'])
            ->update(['status' => 'zaakceptowane']);

        DB::table('complaints')
            ->whereIn('status', ['rejected', 'odrzucona', 'odrzucony'])
            ->update(['status' => 'odrzucone']);
    }

    public function down(): void
    {
        if (!Schema::hasTable('complaints')) {
            return;
        }

        DB::table('complaints')
            ->where('status', 'oczekujące')
            ->update(['status' => 'waiting_customer']);

        DB::table('complaints')
            ->where('status', 'zaakceptowane')
            ->update(['status' => 'accepted']);

        DB::table('complaints')
            ->where('status', 'odrzucone')
            ->update(['status' => 'rejected']);
    }
};
