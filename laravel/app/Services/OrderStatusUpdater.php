<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class OrderStatusUpdater
{
    public function update(): array
    {
        $delivered = DB::table('orders')
            ->where('created_at', '<=', now()->subHours(24))
            ->whereRaw("LOWER(COALESCE(tracking_status, '')) NOT IN (?, ?, ?, ?)", [
                'dostarczone',
                'anulowane',
                'cancelled',
                'canceled',
            ])
            ->whereRaw("LOWER(COALESCE(tracking_status, '')) NOT LIKE ?", ['%reklamac%'])
            ->whereRaw("LOWER(COALESCE(tracking_status, '')) NOT LIKE ?", ['%zwrot%'])
            ->update([
                'tracking_status' => 'dostarczone',
            ]);

        $inProgress = DB::table('orders')
            ->where('created_at', '<=', now()->subHour())
            ->where('created_at', '>', now()->subHours(24))
            ->whereRaw("LOWER(COALESCE(tracking_status, '')) IN (?, ?, ?)", [
                '',
                'nowe',
                'new',
            ])
            ->update([
                'tracking_status' => 'w trakcie',
            ]);

        return [
            'in_progress' => $inProgress,
            'delivered' => $delivered,
        ];
    }
}
