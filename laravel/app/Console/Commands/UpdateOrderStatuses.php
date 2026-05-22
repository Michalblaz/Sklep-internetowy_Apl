<?php

namespace App\Console\Commands;

use App\Services\OrderStatusUpdater;
use Illuminate\Console\Command;

class UpdateOrderStatuses extends Command
{
    protected $signature = 'orders:update-statuses';

    protected $description = 'Updates order statuses after 1 hour and 24 hours.';

    public function handle(OrderStatusUpdater $updater): int
    {
        $result = $updater->update();

        $this->info("Updated {$result['in_progress']} orders to \"w trakcie\".");
        $this->info("Updated {$result['delivered']} orders to \"dostarczone\".");

        return self::SUCCESS;
    }
}
