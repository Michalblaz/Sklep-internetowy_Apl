<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class StoreSeeder extends Seeder
{
   public function run(): void
{
    $sqlPath = database_path('seeders/sql/store_data.sql');

    if (!File::exists($sqlPath)) {
        $this->command->error("Plik nie istnieje: {$sqlPath}");
        return;
    }

    $sql = File::get($sqlPath);

    // Wyłączenie sprawdzania więzów
    DB::statement("SET session_replication_role = 'replica';");

    try {
        $this->command->info('Rozpoczynam wgrywanie danych...');
        
        // Rozbijamy zapytania, jeśli są rozdzielone średnikami (opcjonalnie)
        // Ale przy dużych zrzutach lepiej użyć unprepared:
        DB::unprepared($sql);
        
        $this->command->info('Dane wgrane pomyślnie!');
    } catch (\Exception $e) {
        $this->command->error("Błąd podczas wgrywania danych: " . $e->getMessage());
    } finally {
        // Zawsze przywracamy tryb origin, nawet po błędzie
        DB::statement("SET session_replication_role = 'origin';");
    }
}
}
