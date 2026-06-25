<?php

namespace App\Http\Controllers;

use App\Models\Ban;
use App\Models\Complain;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\CarbonInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'action' => ['nullable', Rule::in(['add-product'])],
            'edit_id' => ['nullable', 'integer', 'exists:products,id'],
            'stock_view' => ['nullable', Rule::in(['low', 'archived'])],
            'low_stock_threshold' => ['nullable', 'integer', 'min:0', 'max:999'],
            'archival_date' => ['nullable', Rule::in(['all', 'today', '7', '30', '90'])],
            'stock_search' => ['nullable', 'string', 'max:100'],
            'complaint_name' => ['nullable', 'string', 'max:100'],
            'complaint_email' => ['nullable', 'string', 'max:254'],
            'complaint_status' => ['nullable', Rule::in(['oczekujące', 'zaakceptowane', 'odrzucone'])],
            'complaint_type' => ['nullable', Rule::in(['Reklamacja', 'Zwrot'])],
            'user_name' => ['nullable', 'string', 'max:100'],
            'user_email' => ['nullable', 'string', 'max:254'],
            'user_status' => ['nullable', Rule::in(['aktywny', 'zawieszony', 'zbanowany'])],
        ]);

        $this->refreshTimedOrderStatuses();

        $stockView = $filters['stock_view'] ?? 'low';
        $lowStockThreshold = (int) ($filters['low_stock_threshold'] ?? 5);
        $archivalDateFilter = $filters['archival_date'] ?? 'all';
        $stockSearch = trim($filters['stock_search'] ?? '');
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
        $storeViews = Schema::hasTable('site_page_views')
            ? DB::table('site_page_views')->where('page_path', '/')->count()
            : 0;

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

        $orderStatusStats = [
            'new' => Order::query()
                ->whereRaw("LOWER(COALESCE(tracking_status, '')) IN ('', 'nowe', 'new')")
                ->count(),
            'in_progress' => Order::query()
                ->whereRaw("LOWER(COALESCE(tracking_status, '')) IN ('w trakcie', 'w realizacji', 'processing', 'in_progress')")
                ->count(),
            'delivered' => Order::query()
                ->whereRaw("LOWER(COALESCE(tracking_status, '')) IN ('dostarczone', 'delivered', 'completed', 'zrealizowane', 'odebrane')")
                ->count(),
        ];

        $productsCount = Product::sum('stock_quantity');

        $categoryChartData = DB::table('categories')
            ->leftJoin('products', function ($join) {
                $join->on('products.category_id', '=', 'categories.id')
                    ->where('products.isarchival', 0);
            })
            ->select(
                'categories.id',
                'categories.name as label',
                DB::raw('COALESCE(SUM(products.stock_quantity), 0) as value')
            )
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('value')
            ->orderBy('categories.name')
            ->get()
            ->map(fn ($category) => [
                'id' => (int) $category->id,
                'label' => $category->label,
                'value' => (int) $category->value,
            ]);

        $modelChartDataByCategory = DB::table('products')
            ->select(
                'products.category_id',
                'products.id',
                'products.name',
                'products.stock_quantity'
            )
            ->where('products.isarchival', 0)
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

        $complaintNameFilter = trim($filters['complaint_name'] ?? '');
        $complaintEmailFilter = trim($filters['complaint_email'] ?? '');
        $complaintStatusFilter = $filters['complaint_status'] ?? null;
        $complaintTypeFilter = $filters['complaint_type'] ?? null;
        $hasComplaintResponseColumns = Schema::hasColumn('complaints', 'admin_response');

        $complaints = Complain::query()
            ->leftJoin('orders', 'complaints.order_id', '=', 'orders.id')
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->when($complaintNameFilter !== '', function ($query) use ($complaintNameFilter) {
                $query->whereRaw(
                    "LOWER(TRIM(COALESCE(users.first_name, '') || ' ' || COALESCE(users.last_name, ''))) LIKE ?",
                    [$this->likePattern($complaintNameFilter)]
                );
            })
            ->when($complaintEmailFilter !== '', function ($query) use ($complaintEmailFilter) {
                $query->whereRaw('LOWER(users.email) LIKE ?', [$this->likePattern($complaintEmailFilter)]);
            })
            ->when(in_array($complaintTypeFilter, ['Reklamacja', 'Zwrot'], true), function ($query) use ($complaintTypeFilter) {
                $query->where('complaints.reason', $complaintTypeFilter);
            })
            ->when(in_array($complaintStatusFilter, ['oczekujące', 'zaakceptowane', 'odrzucone'], true), function ($query) use ($complaintStatusFilter) {
                $query->where('complaints.status', $complaintStatusFilter);
            })
            ->select(
                'complaints.id',
                'complaints.reason',
                'complaints.description',
                'complaints.status',
                'complaints.order_id',
                'orders.created_at as order_created_at',
                $hasComplaintResponseColumns ? 'complaints.admin_response' : DB::raw('NULL as admin_response'),
                $hasComplaintResponseColumns ? 'complaints.customer_reply' : DB::raw('NULL as customer_reply'),
                $hasComplaintResponseColumns ? 'complaints.responded_at' : DB::raw('NULL as responded_at'),
                $hasComplaintResponseColumns ? 'complaints.customer_replied_at' : DB::raw('NULL as customer_replied_at'),
                'users.first_name',
                'users.last_name',
                'users.email'
            )
            ->orderByDesc('complaints.id')
            ->get()
            ->map(function ($complaint) {
                $complaint->customer_name = trim(($complaint->first_name ?? '') . ' ' . ($complaint->last_name ?? ''));
                $complaint->customer_name = $complaint->customer_name !== '' ? $complaint->customer_name : 'Nieznany użytkownik';

                $complaint->type_label = $complaint->reason === 'Zwrot' ? 'Zwrot' : 'Reklamacja';
                $complaint->status_label = $this->complaintStatusLabel($complaint->status);
                $complaint->order_created_at_label = $complaint->order_created_at
                    ? \Carbon\Carbon::parse($complaint->order_created_at)->format('d.m.Y')
                    : 'Brak daty';
               $messages = DB::table('complaint_messages')
                    ->where('complaint_id', $complaint->id)
                    ->orderBy('created_at')
                    ->get()
                    ->map(function ($message) {

                        return [
                            'sender_type' => $message->sender_type,
                            'message' => $message->message,
                            'created_at' => $message->created_at
                                ? \Carbon\Carbon::parse($message->created_at)->format('d.m.Y H:i')
                                : null,
                        ];
                    });

                $complaint->messages = $messages;

                $complaint->latest_message = $messages->last();

                return $complaint;
            });

        $complaintStats = [
            'all' => $complaints->count(),
            'complaints' => $complaints->where('type_label', 'Reklamacja')->count(),
            'returns' => $complaints->where('type_label', 'Zwrot')->count(),
        ];

        $userNameFilter = trim($filters['user_name'] ?? '');
        $userEmailFilter = trim($filters['user_email'] ?? '');
        $userStatusFilter = $filters['user_status'] ?? null;

        $users = User::query()
            ->where(function ($query) {
                $query->where('users.is_Admin', false)
                    ->orWhereNull('users.is_Admin');
            })
            ->leftJoinSub($latestBans, 'latest_bans', function ($join) {
                $join->on('users.id', '=', 'latest_bans.id_users');
            })
            ->when($userNameFilter !== '', function ($query) use ($userNameFilter) {
                $query->whereRaw(
                    "LOWER(TRIM(COALESCE(users.first_name, '') || ' ' || COALESCE(users.last_name, ''))) LIKE ?",
                    [$this->likePattern($userNameFilter)]
                );
            })
            ->when($userEmailFilter !== '', function ($query) use ($userEmailFilter) {
                $query->whereRaw('LOWER(users.email) LIKE ?', [$this->likePattern($userEmailFilter)]);
            })
            ->when(in_array($userStatusFilter, ['aktywny', 'zawieszony', 'zbanowany'], true), function ($query) use ($userStatusFilter) {
                match ($userStatusFilter) {
                    'zbanowany' => $query->whereNotNull('latest_bans.id_users')
                        ->where(function ($query) {
                            $query->whereNull('latest_bans.end_time')
                                ->orWhereRaw("LOWER(latest_bans.end_time::text) IN ('infinity', 'infinite')");
                        }),
                    'zawieszony' => $query->whereNotNull('latest_bans.id_users')
                        ->whereNotNull('latest_bans.end_time')
                        ->whereRaw("LOWER(latest_bans.end_time::text) NOT IN ('infinity', 'infinite')")
                        ->where('latest_bans.end_time', '>', now()),
                    default => $query->where(function ($query) {
                        $query->whereNull('latest_bans.id_users')
                            ->orWhere(function ($query) {
                                $query->whereNotNull('latest_bans.end_time')
                                    ->whereRaw("LOWER(latest_bans.end_time::text) NOT IN ('infinity', 'infinite')")
                                    ->where('latest_bans.end_time', '<=', now());
                            });
                    }),
                };
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
            ->get()
            ->map(function ($user) {
                $user->full_name = trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''));
                $user->full_name = $user->full_name !== '' ? $user->full_name : 'Brak imienia';
                $user->account_status = $this->resolveAccountStatus($user->ban_end_time, $user->ban_user_id !== null);

                return $user;
            });

        $stockProducts = Product::withoutGlobalScope('active')
            ->with(['brand', 'category'])
            ->when($stockSearch !== '', function ($query) use ($stockSearch) {
                $searchPattern = $this->likePattern($stockSearch);

                $query->where(function ($query) use ($searchPattern) {
                    $query->whereRaw('LOWER(products.name) LIKE ?', [$searchPattern])
                        ->orWhereHas('category', function ($categoryQuery) use ($searchPattern) {
                            $categoryQuery->whereRaw('LOWER(categories.name) LIKE ?', [$searchPattern]);
                        });
                });
            })
            ->when($stockView === 'archived', function ($query) use ($archivalDateFilter) {
                $query->where('products.isarchival', 1)
                    ->when($archivalDateFilter === 'today', fn ($query) => $query->whereDate('products.archivaldate', today()))
                    ->when(in_array($archivalDateFilter, ['7', '30', '90'], true), function ($query) use ($archivalDateFilter) {
                        $query->where('products.archivaldate', '>=', now()->subDays((int) $archivalDateFilter));
                    })
                    ->orderByDesc('products.archivaldate');
            }, function ($query) use ($lowStockThreshold) {
                $query->where('products.isarchival', 0)
                    ->where('products.stock_quantity', '<=', $lowStockThreshold)
                    ->orderBy('products.stock_quantity');
            })
            ->orderBy('products.name')
            ->get();

        $attributeCategoryTable = $this->attributeCategoryTable();
        $adminAttributes = DB::table($attributeCategoryTable)
            ->orderBy('name')
            ->get();

        $adminShippingMethods = DB::table('shipping_methods')
            ->orderBy('id')
            ->get();

        $editableUsers = User::query()
            ->select('id', 'email', 'first_name', 'last_name', 'phone', 'is_Admin')
            ->orderBy('id')
            ->get();

        $editableOrders = DB::table('orders')
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->leftJoin('shipping_methods', 'orders.shipping_method_id', '=', 'shipping_methods.id')
            ->select(
                'orders.id',
                'orders.user_id',
                'orders.shipping_method_id',
                'orders.tracking_status',
                'orders.shipping_cost',
                'orders.created_at',
                'orders.shipping_first_name',
                'orders.shipping_last_name',
                'orders.shipping_street',
                'orders.shipping_city',
                'orders.shipping_postal_code',
                'orders.shipping_phone',
                'orders.payment_method',
                'orders.pickup_point_info',
                'users.email as user_email',
                'shipping_methods.name as shipping_method_name'
            )
            ->orderByDesc('orders.id')
            ->limit(60)
            ->get();

        return view('Admin', [
            'storeStats' => [
                'customers' => $customersCount,
                'views' => $storeViews,
                'views_note' => 'Zliczane są wejścia na stronę startową bez odświeżeń.',
            ],
            'accountStats' => [
                'active' => $activeAccounts,
                'suspended' => $suspendedAccounts,
                'banned' => $bannedAccounts,
            ],
            'shopStats' => [
                'orders_new' => $orderStatusStats['new'],
                'orders_in_progress' => $orderStatusStats['in_progress'],
                'orders_delivered' => $orderStatusStats['delivered'],
                'products' => $productsCount,
            ],
            'categoryChartData' => $categoryChartData,
            'modelChartDataByCategory' => $modelChartDataByCategory,
            'complaints' => $complaints,
            'complaintStats' => $complaintStats,
            'users' => $users,
            'stockProducts' => $stockProducts,
            'lowStockProducts' => $stockProducts,
            'stockView' => $stockView,
            'lowStockThreshold' => $lowStockThreshold,
            'archivalDateFilter' => $archivalDateFilter,
            'stockSearch' => $stockSearch,
            'adminAttributes' => $adminAttributes,
            'adminShippingMethods' => $adminShippingMethods,
            'editableUsers' => $editableUsers,
            'editableOrders' => $editableOrders,
        ]);
    }

    public function storeAttributeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:100'],
        ]);

        DB::table($this->attributeCategoryTable())->insert([
            'name' => $this->normalizeAdminText($validated['name']),
        ]);

        return redirect(route('admin') . '#zarzadzanie-atrybuty')
            ->with('admin_status', 'Atrybut zostal dodany.');
    }

    public function updateAttributeCategory(Request $request, int $attribute)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:100'],
        ]);

        DB::table($this->attributeCategoryTable())
            ->where('id', $attribute)
            ->update([
                'name' => $this->normalizeAdminText($validated['name']),
            ]);

        return redirect(route('admin') . '#zarzadzanie-atrybuty')
            ->with('admin_status', 'Atrybut zostal zaktualizowany.');
    }

    public function storeShippingMethod(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'price' => ['required', 'numeric', 'min:0', 'max:999999.99'],
        ]);

        DB::table('shipping_methods')->insert([
            'name' => $this->normalizeAdminText($validated['name']),
            'price' => round((float) $validated['price'], 2),
        ]);

        return redirect(route('admin') . '#zarzadzanie-dostawy')
            ->with('admin_status', 'Metoda dostawy zostala dodana.');
    }

    public function updateShippingMethod(Request $request, int $method)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'price' => ['required', 'numeric', 'min:0', 'max:999999.99'],
        ]);

        DB::table('shipping_methods')
            ->where('id', $method)
            ->update([
                'name' => $this->normalizeAdminText($validated['name']),
                'price' => round((float) $validated['price'], 2),
            ]);

        return redirect(route('admin') . '#zarzadzanie-dostawy')
            ->with('admin_status', 'Metoda dostawy zostala zaktualizowana.');
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'first_name' => ['nullable', 'string', 'max:100'],
            'last_name' => ['nullable', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'is_Admin' => ['nullable', 'boolean'],
        ]);

        $isAdmin = (bool) ($validated['is_Admin'] ?? false);

        if (Auth::id() === $user->id && ! $isAdmin) {
            return redirect(route('admin') . '#zarzadzanie-uzytkownicy')
                ->with('admin_error', 'Nie mozesz odebrac uprawnien administratora wlasnemu kontu.');
        }

        $user->forceFill([
            'first_name' => $this->nullableAdminText($validated['first_name'] ?? null),
            'last_name' => $this->nullableAdminText($validated['last_name'] ?? null),
            'phone' => $this->nullableAdminText($validated['phone'] ?? null),
            'email' => $this->normalizeAdminText($validated['email']),
            'is_Admin' => $isAdmin,
        ])->save();

        return redirect(route('admin') . '#zarzadzanie-uzytkownicy')
            ->with('admin_status', 'Uzytkownik zostal zaktualizowany.');
    }

    public function updateOrder(Request $request, int $order)
    {
        $validated = $request->validate([
            'shipping_method_id' => ['nullable', 'integer', 'exists:shipping_methods,id'],
            'tracking_status' => ['nullable', 'string', 'max:100'],
            'shipping_cost' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            'payment_method' => ['nullable', 'string', 'max:100'],
            'pickup_point_info' => ['nullable', 'string', 'max:255'],
            'shipping_first_name' => ['nullable', 'string', 'max:255'],
            'shipping_last_name' => ['nullable', 'string', 'max:255'],
            'shipping_street' => ['nullable', 'string', 'max:255'],
            'shipping_city' => ['nullable', 'string', 'max:255'],
            'shipping_postal_code' => ['nullable', 'string', 'max:20'],
            'shipping_phone' => ['nullable', 'string', 'max:255'],
        ]);

        DB::table('orders')
            ->where('id', $order)
            ->update([
                'shipping_method_id' => $validated['shipping_method_id'] ?? null,
                'tracking_status' => $this->nullableAdminText($validated['tracking_status'] ?? null),
                'shipping_cost' => isset($validated['shipping_cost']) ? round((float) $validated['shipping_cost'], 2) : null,
                'payment_method' => $this->nullableAdminText($validated['payment_method'] ?? null),
                'pickup_point_info' => $this->nullableAdminText($validated['pickup_point_info'] ?? null),
                'shipping_first_name' => $this->nullableAdminText($validated['shipping_first_name'] ?? null),
                'shipping_last_name' => $this->nullableAdminText($validated['shipping_last_name'] ?? null),
                'shipping_street' => $this->nullableAdminText($validated['shipping_street'] ?? null),
                'shipping_city' => $this->nullableAdminText($validated['shipping_city'] ?? null),
                'shipping_postal_code' => $this->nullableAdminText($validated['shipping_postal_code'] ?? null),
                'shipping_phone' => $this->nullableAdminText($validated['shipping_phone'] ?? null),
            ]);

        return redirect(route('admin') . '#zarzadzanie-zamowienia')
            ->with('admin_status', 'Zamowienie zostalo zaktualizowane.');
    }

    public function archiveProduct(Request $request, int $product)
    {
        $this->validateStockRedirectInput($request);
        $model = Product::withoutGlobalScope('active')->findOrFail($product);

        if ($model->isarchival) {
            return $this->stockPanelRedirect($request, 'archived')
                ->with('admin_error', 'Ten produkt jest już archiwalny.');
        }

        DB::transaction(function () use ($model) {
            $model->forceFill([
                'isarchival' => 1,
                'archivaldate' => now(),
            ])->save();

            DB::table('cart_items')->where('product_id', $model->id)->delete();
            DB::table('wishlist_items')->where('product_id', $model->id)->delete();
        });

        return $this->stockPanelRedirect($request, 'low')
            ->with('admin_status', "Produkt {$model->name} został przeniesiony do archiwum.");
    }

    public function restoreProduct(Request $request, int $product)
    {
        $this->validateStockRedirectInput($request);
        $model = Product::withoutGlobalScope('active')->findOrFail($product);

        if (! $model->isarchival) {
            return $this->stockPanelRedirect($request, 'low')
                ->with('admin_error', 'Ten produkt jest już aktywny.');
        }

        $model->forceFill([
            'isarchival' => 0,
            'archivaldate' => null,
        ])->save();

        return $this->stockPanelRedirect($request, 'archived')
            ->with('admin_status', "Produkt {$model->name} został przywrócony.");
    }

    public function updateComplaint(Request $request, Complain $complaint)
    {
        $request->merge([
            'admin_response' => is_string($request->input('admin_response'))
                ? trim($request->input('admin_response'))
                : $request->input('admin_response'),
        ]);

        $validated = $request->validate([
            'action_type' => ['required', 'in:respond,accept,reject'],
            'admin_response' => ['required', 'string', 'max:5000'],
        ], [
            'admin_response.required' => 'Wpisz treść odpowiedzi.',
        ]);

        $status = match ($validated['action_type']) {
            'accept' => 'zaakceptowane',
            'reject' => 'odrzucone',
            default => 'oczekujące',
        };

        DB::transaction(function () use ($complaint, $status, $validated) {
            DB::table('complaints')
                ->where('id', $complaint->id)
                ->update([
                    'status' => $status,
                ]);

            DB::table('complaint_messages')->insert([
                'complaint_id' => $complaint->id,
                'sender_type' => 'admin',
                'message' => $validated['admin_response'],
                'created_at' => now(),
            ]);
        });

        $message = match ($status) {
            'zaakceptowane' => 'Zgłoszenie zostało zaakceptowane.',
            'odrzucone' => 'Zgłoszenie zostało odrzucone.',
            default => 'Odpowiedź została wysłana.',
        };

        return redirect(route('admin') . '#reklamacje')
            ->with('admin_status', $message);
    }

    public function suspend(User $user)
    {
        if ($this->isAdminUser($user)) {
            return $this->usersPanelRedirect()->with('admin_error', 'Nie można zawiesić konta administratora.');
        }

        if (Auth::check() && Auth::id() === $user->id) {
            return $this->usersPanelRedirect()->with('admin_error', 'Nie możesz zawiesić własnego konta.');
        }

        $latestBan = $this->latestBanForUser($user->id);

        Ban::create([
            'id_users' => $user->id,
            'end_time' => now()->addDays(7),
            'reason' => 'Zawieszenie nadane z panelu administratora',
        ]);

        $previousStatus = $this->resolveAccountStatus($latestBan?->end_time, $latestBan !== null);

        return $this->usersPanelRedirect()->with(
            'admin_status',
            $previousStatus === 'zbanowany'
                ? "Ban konta {$user->email} został zmieniony na zawieszenie na 7 dni."
                : "Konto {$user->email} zostało zawieszone na 7 dni."
        );
    }

    public function ban(User $user)
    {
        if ($this->isAdminUser($user)) {
            return $this->usersPanelRedirect()->with('admin_error', 'Nie można zbanować konta administratora.');
        }

        if (Auth::check() && Auth::id() === $user->id) {
            return $this->usersPanelRedirect()->with('admin_error', 'Nie możesz zbanować własnego konta.');
        }

        $latestBan = $this->latestBanForUser($user->id);

        if ($this->resolveAccountStatus($latestBan?->end_time, $latestBan !== null) === 'zbanowany') {
            return $this->usersPanelRedirect()->with('admin_error', 'To konto jest już zbanowane.');
        }

        DB::table('bans')->insert([
            'id_users' => $user->id,
            'end_time' => DB::raw("'infinity'"),
            'reason' => 'Ban stały nadany z panelu administratora',
        ]);

        return $this->usersPanelRedirect()->with('admin_status', "Konto {$user->email} zostało zbanowane.");
    }

    public function unban(User $user)
    {
        if ($this->isAdminUser($user)) {
            return $this->usersPanelRedirect()->with('admin_error', 'Nie można zmienić blokady konta administratora.');
        }

        $latestBan = $this->latestBanForUser($user->id);

        if ($this->resolveAccountStatus($latestBan?->end_time, $latestBan !== null) === 'aktywny') {
            return $this->usersPanelRedirect()->with('admin_error', 'To konto jest już aktywne.');
        }

        Ban::create([
            'id_users' => $user->id,
            'end_time' => now(),
            'reason' => 'Odblokowanie konta z panelu administratora',
        ]);

        return $this->usersPanelRedirect()->with('admin_status', "Konto {$user->email} zostało odblokowane.");
    }

    private function stockPanelRedirect(Request $request, string $stockView)
    {
        $query = array_filter([
            'stock_view' => $stockView,
            'low_stock_threshold' => $request->input('low_stock_threshold'),
            'archival_date' => $request->input('archival_date'),
            'stock_search' => $request->input('stock_search'),
        ], fn ($value) => $value !== null && $value !== '');

        return redirect(route('admin', $query) . '#stany-magazynowe');
    }

    private function validateStockRedirectInput(Request $request): void
    {
        $request->validate([
            'stock_view' => ['nullable', Rule::in(['low', 'archived'])],
            'low_stock_threshold' => ['nullable', 'integer', 'min:0', 'max:999'],
            'archival_date' => ['nullable', Rule::in(['all', 'today', '7', '30', '90'])],
            'stock_search' => ['nullable', 'string', 'max:100'],
        ]);
    }

    private function likePattern(string $value): string
    {
        return '%' . addcslashes(mb_strtolower($value), '\\%_') . '%';
    }

    private function attributeCategoryTable(): string
    {
        return Schema::hasTable('attribute_cathegory')
            ? 'attribute_cathegory'
            : 'attribute_category';
    }

    private function normalizeAdminText(string $value): string
    {
        return preg_replace('/\s+/', ' ', trim($value));
    }

    private function nullableAdminText(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = $this->normalizeAdminText($value);

        return $value === '' ? null : $value;
    }

    private function usersPanelRedirect()
    {
        return redirect(route('admin') . '#uzytkownicy');
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

    private function complaintStatusLabel(?string $status): string
    {
        return match ($status) {
            'zaakceptowane' => 'Zaakceptowane',
            'odrzucone' => 'Odrzucone',
            default => 'Oczekujące',
        };
    }

    private function refreshTimedOrderStatuses(): void
    {
        if (!Schema::hasTable('orders')) {
            return;
        }

        $orders = DB::table('orders')
            ->whereNotNull('created_at')
            ->get(['id', 'created_at', 'tracking_status']);

        foreach ($orders as $order) {
            $currentStatus = mb_strtolower(trim((string) $order->tracking_status));

            if (in_array($currentStatus, ['cancelled', 'canceled', 'anulowane'], true)) {
                continue;
            }

            $ageInMinutes = \Carbon\Carbon::parse($order->created_at)->diffInMinutes(now());
            $nextStatus = match (true) {
                $ageInMinutes >= 5 => 'Dostarczone',
                $ageInMinutes >= 1 => 'W trakcie',
                default => 'Nowe',
            };

            if ($order->tracking_status !== $nextStatus) {
                DB::table('orders')
                    ->where('id', $order->id)
                    ->update(['tracking_status' => $nextStatus]);
            }
        }
    }
}
