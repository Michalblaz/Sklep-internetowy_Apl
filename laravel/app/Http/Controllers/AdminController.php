<?php

namespace App\Http\Controllers;

use App\Models\Ban;
use App\Models\Complain;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $categoryLabels = [
            1 => 'Procesory',
            2 => 'Karty Graficzne',
            3 => 'Płyty Główne',
            4 => 'RAM',
            5 => 'Dyski',
            6 => 'Zasilacze',
            7 => 'Obudowa',
            8 => 'Myszka',
            9 => 'Klawiatura',
            10 => 'Słuchawki',
            11 => 'Głośniki',
            12 => 'Chłodzenie Procesora',
            13 => 'Karty sieciowe',
            14 => 'Monitor',
        ];

        $customerQuery = User::query()
            ->where(function ($query) {
                $query->where('is_Admin', false)
                    ->orWhereNull('is_Admin');
            });

        $latestBanRows = Ban::query()
            ->select(
                'id_users',
                'end_time',
                'reason',
                DB::raw('ROW_NUMBER() OVER (PARTITION BY id_users ORDER BY id DESC) as rn')
            );

        $latestBans = DB::query()
            ->fromSub($latestBanRows, 'latest_bans')
            ->where('rn', 1);

        $customersCount = (clone $customerQuery)->count();

        $bannedAccounts = DB::query()
            ->fromSub($latestBans, 'latest_bans')
            ->where(function ($query) {
                $query->whereNull('end_time')
                    ->orWhereRaw("LOWER(end_time::text) IN ('infinity', 'infinite')");
            })
            ->count();

        $suspendedAccounts = DB::query()
            ->fromSub($latestBans, 'latest_bans')
            ->whereNotNull('end_time')
            ->whereRaw("LOWER(end_time::text) NOT IN ('infinity', 'infinite')")
            ->where('end_time', '>', now())
            ->count();

        $activeAccounts = max($customersCount - $bannedAccounts - $suspendedAccounts, 0);

        $activeOrders = Order::query()
            ->where(function ($query) {
                $query->whereNull('tracking_status')
                    ->orWhereRaw("
                        LOWER(tracking_status) NOT IN (
                            'delivered',
                            'completed',
                            'cancelled',
                            'canceled',
                            'dostarczone',
                            'zrealizowane',
                            'anulowane',
                            'zakonczone',
                            'zakończone',
                            'odebrane'
                        )
                    ");
            })
            ->count();

       $productsCount = Product::sum('stock_quantity');

        $categoryChartDataRaw = DB::table('products')
    ->select(
        'products.category_id',
        DB::raw('SUM(products.stock_quantity) as product_count')
    )
    ->whereNotNull('products.category_id')
    ->groupBy('products.category_id')
    ->get()
    ->keyBy('category_id');

$categoryChartData = collect($categoryLabels)->map(function ($label, $id) use ($categoryChartDataRaw) {
    return [
        'id' => $id,
        'label' => $label,
        'value' => (int) ($categoryChartDataRaw[$id]->product_count ?? 0),
    ];
})->sortByDesc('value')->values();

        $modelChartDataByCategory = DB::table('products')
            ->select(
                'products.category_id',
                'products.id',
                'products.name',
                'products.stock_quantity'
            )
            ->whereNotNull('products.category_id')
            ->orderBy('products.category_id')
            ->orderByDesc('products.stock_quantity')
            ->orderBy('products.name')
            ->get()
            ->groupBy('category_id')
            ->map(function ($items) {
                return $items->map(fn ($item) => [
                    'id'    => $item->id,
                    'label' => $item->name,
                    'value' => (int) $item->stock_quantity,
                ])->values();
            });

        $complaints = Complain::query()
            ->leftJoin('orders', 'complaints.order_id', '=', 'orders.id')
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->select(
                'complaints.id',
                'complaints.reason',
                'complaints.description',
                'complaints.status',
                'complaints.order_id',
                'users.first_name',
                'users.last_name',
                'users.email'
            )
            ->orderByDesc('complaints.id')
            ->paginate(5, ['*'], 'complaintsPage')
            ->through(function ($complaint) {
                $complaint->customer_name = trim(($complaint->first_name ?? '') . ' ' . ($complaint->last_name ?? ''));
                $complaint->customer_name = $complaint->customer_name !== '' ? $complaint->customer_name : 'Nieznany użytkownik';

                return $complaint;
            })
            ->withQueryString()
            ->fragment('reklamacje');

        $users = User::query()
            ->where(function ($query) {
                $query->where('users.is_Admin', false)
                    ->orWhereNull('users.is_Admin');
            })
            ->leftJoinSub($latestBans, 'latest_bans', function ($join) {
                $join->on('users.id', '=', 'latest_bans.id_users');
            })
            ->select(
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.email',
                'latest_bans.id_users as ban_user_id',
                'latest_bans.end_time as ban_end_time'
            )
            ->orderBy('users.first_name')
            ->orderBy('users.last_name')
            ->paginate(8, ['*'], 'usersPage')
            ->through(function ($user) {
                $user->full_name = trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''));
                $user->full_name = $user->full_name !== '' ? $user->full_name : 'Brak imienia';
                $user->account_status = $this->resolveAccountStatus($user->ban_end_time, $user->ban_user_id !== null);

                return $user;
            })
            ->withQueryString()
            ->fragment('uzytkownicy');

        return view('Admin', [
            'storeStats' => [
                'customers' => $customersCount,
                'views' => 0,
                'views_note' => 'Pole przygotowane pod przyszłe dane o wyświetleniach.',
            ],
            'accountStats' => [
                'active' => $activeAccounts,
                'suspended' => $suspendedAccounts,
                'banned' => $bannedAccounts,
            ],
            'shopStats' => [
                'active_orders' => $activeOrders,
                'products' => $productsCount,
            ],
            'categoryChartData' => $categoryChartData,
            'modelChartDataByCategory' => $modelChartDataByCategory,
            'complaints' => $complaints,
            'users' => $users,
        ]);
    }

    public function suspend(User $user)
    {
        if ($this->isAdminUser($user)) {
            return back()->with('admin_error', 'Nie można zawiesić konta administratora.');
        }

        if (Auth::check() && Auth::id() === $user->id) {
            return back()->with('admin_error', 'Nie możesz zawiesić własnego konta.');
        }

        $latestBan = $this->latestBanForUser($user->id);

        if ($this->resolveAccountStatus($latestBan?->end_time, $latestBan !== null) === 'zbanowany') {
            return back()->with('admin_error', 'To konto jest już zbanowane.');
        }

        Ban::create([
            'id_users' => $user->id,
            'end_time' => now()->addDays(7),
            'reason' => 'Zawieszenie nadane z panelu administratora',
        ]);

        return back()->with('admin_status', "Konto {$user->email} zostało zawieszone na 7 dni.");
    }

    public function ban(User $user)
    {
        if ($this->isAdminUser($user)) {
            return back()->with('admin_error', 'Nie można zbanować konta administratora.');
        }

        if (Auth::check() && Auth::id() === $user->id) {
            return back()->with('admin_error', 'Nie możesz zbanować własnego konta.');
        }

        $latestBan = $this->latestBanForUser($user->id);

        if ($this->resolveAccountStatus($latestBan?->end_time, $latestBan !== null) === 'zbanowany') {
            return back()->with('admin_error', 'To konto jest już zbanowane.');
        }

        DB::table('bans')->insert([
            'id_users' => $user->id,
            'end_time' => DB::raw("'infinity'"),
            'reason' => 'Ban stały nadany z panelu administratora',
        ]);

        return back()->with('admin_status', "Konto {$user->email} zostało zbanowane.");
    }

    private function latestBanForUser(int $userId): ?Ban
    {
        return Ban::query()
            ->where('id_users', $userId)
            ->orderByDesc('id')
            ->first();
    }

    private function isAdminUser(User $user): bool
    {
        return (bool) $user->is_Admin;
    }

    private function resolveAccountStatus(mixed $endTime, bool $hasBanRecord = false): string
    {
        if (! $hasBanRecord) {
            return 'aktywny';
        }

        if ($this->isInfiniteEndTime($endTime)) {
            return 'zbanowany';
        }

        if ($endTime instanceof CarbonInterface) {
            return $endTime->isFuture() ? 'zawieszony' : 'aktywny';
        }

        if (is_string($endTime) && trim($endTime) !== '') {
            try {
                return now()->lt(\Carbon\Carbon::parse($endTime)) ? 'zawieszony' : 'aktywny';
            } catch (\Throwable $exception) {
                return 'aktywny';
            }
        }

        return 'aktywny';
    }

    private function isInfiniteEndTime(mixed $endTime): bool
    {
        return $endTime === null
            || (is_string($endTime)
                && in_array(strtolower(trim($endTime)), ['infinity', 'infinite'], true));
    }
}
