<?php

namespace App\Http\Controllers;

use App\Services\OrderStatusUpdater;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Pagination\LengthAwarePaginator;

class ProfileController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        app(OrderStatusUpdater::class)->update();

        $this->refreshTimedOrderStatuses($user->id);

        $address = $this->loadAddress($user->id);
        $shipmentHistory = $this->loadShipments($user->id);
        $shipments = $shipmentHistory
            ->reject(fn (array $shipment) => $shipment['is_delivered'])
            ->values();
        $complaintReplies = $this->loadComplaintReplies($user->id);

        $rawProducts = $this->loadObservedProducts($user->id);
        $items = $rawProducts instanceof Collection ? $rawProducts : Collection::make($rawProducts);

        $currentPage = LengthAwarePaginator::resolveCurrentPage('observed_page');
        $perPage = 5;
        $currentItems = $items->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $observedProducts = new LengthAwarePaginator(
            $currentItems,
            $items->count(),
            $perPage,
            $currentPage,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'pageName' => 'observed_page',
            ]
        );

    
        $groupedWishlists = $this->loadObservedProducts($user->id);
    
        $orders = \App\Models\Order::where('user_id', $user->id)
        ->with('shippingMethod')
        ->latest()
        ->get();

        return view('profil', [
            'userData' => [
                'first_name' => $user->first_name ?? '',
                'last_name' => $user->last_name ?? '',
                'email' => $user->email ?? '',
                'phone' => $user->phone ?? '',
                'address_street' => $address->street ?? '',
                'address_postal_code' => $address->postal_code ?? '',
                'address_city' => $address->city ?? '',
            ],
            'shipments' => $shipments,
            'shipmentHistory' => $shipmentHistory,
            'complaintReplies' => $complaintReplies,
            'observedProducts' => $observedProducts,
            'orders' => $orders,
            'groupedWishlists' => $groupedWishlists,
        ]);
    }


    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'address_street' => ['nullable', 'string', 'max:255'],
            'address_postal_code' => ['nullable', 'string', 'max:20'],
            'address_city' => ['nullable', 'string', 'max:100'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ], [
            'first_name.required' => 'Imię jest wymagane.',
            'last_name.required' => 'Nazwisko jest wymagane.',
            'email.required' => 'Adres e-mail jest wymagany.',
            'email.email' => 'Podaj poprawny adres e-mail.',
            'email.unique' => 'Ten adres e-mail jest już zajęty.',
            'password.min' => 'Hasło musi mieć co najmniej 6 znaków.',
            'password.confirmed' => 'Hasło i powtórzone hasło muszą być takie same.',
        ]);

        DB::table('users')
            ->where('id', $user->id)
            ->update([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?: null,
                'password_hash' => filled($validated['password'] ?? null)
                    ? Hash::make($validated['password'])
                    : $user->password_hash,
            ]);

        $this->upsertAddress($user->id, [
            'street' => $validated['address_street'] ?: null,
            'postal_code' => $validated['address_postal_code'] ?: null,
            'city' => $validated['address_city'] ?: null,
        ]);

        return redirect()
            ->route('profil')
            ->with('success', 'Dane użytkownika zostały zaktualizowane.');
    }

    public function storeComplaint(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'order_id' => ['required', 'integer'],
            'reason' => ['required', Rule::in(['Reklamacja', 'Zwrot'])],
            'description' => ['nullable', 'string'],
        ], [
            'order_id.required' => 'Nie wybrano przesyłki do reklamacji.',
            'reason.required' => 'Wybierz rodzaj zgłoszenia.',
        ]);

        $order = DB::table('orders')
            ->where('id', $validated['order_id'])
            ->where('user_id', $user->id)
            ->first(['id']);

        if (!$order) {
            return back()
                ->withErrors(['order_id' => 'Nie wybrano przesyłki do reklamacji.'])
                ->withInput();
        }

        $pendingStatus = $validated['reason'] === 'Zwrot'
            ? 'złożenie zwrotu'
            : 'złożenie reklamacji';

        DB::transaction(function () use ($order, $validated, $pendingStatus) {
            DB::table('complaints')->insert([
                'order_id' => $order->id,
                'reason' => $validated['reason'],
                'description' => $validated['description'] ?? '',
                'status' => 'złożone',
            ]);

            DB::table('orders')
                ->where('id', $order->id)
                ->update(['tracking_status' => $pendingStatus]);
        });
        DB::table('complaints')->insert([
            'order_id' => $order->id,
            'reason' => $validated['reason'],
            'description' => $validated['description'] ?? '',
            'status' => 'oczekujące',
        ]);

        return redirect()
            ->route('profil')
            ->with('success', 'Zgłoszenie zostało zapisane.');
    }

    public function replyComplaint(Request $request, int $complaintId): RedirectResponse
    {
        $user = $request->user();

        if (!Schema::hasColumn('complaints', 'customer_reply')) {
            return redirect()
                ->route('profil')
                ->with('error', 'Brakuje kolumn odpowiedzi w tabeli complaints. Uruchom migracje.');
        }

        $validated = $request->validate([
            'customer_reply' => ['required', 'string', 'max:5000'],
        ], [
            'customer_reply.required' => 'Wpisz treść odpowiedzi.',
        ]);

        $complaint = DB::table('complaints as c')
            ->join('orders as o', 'o.id', '=', 'c.order_id')
            ->where('c.id', $complaintId)
            ->where('o.user_id', $user->id)
            ->first(['c.id']);

        if (!$complaint) {
            return redirect()
                ->route('profil')
                ->with('error', 'Nie znaleziono zgłoszenia do odpowiedzi.');
        }

        DB::table('complaints')
            ->where('id', $complaint->id)
            ->update([
                'customer_reply' => $validated['customer_reply'],
                'customer_replied_at' => now(),
                'status' => 'oczekujące',
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('profil')
            ->with('success', 'Twoja odpowiedź została wysłana do obsługi sklepu.');
    }

    public function moveObservedToCart(Request $request, int $wishlistId, int $productId): RedirectResponse
    {
        $userId = $request->user()->id;

        // Bezpieczeństwo: czy ta wishlista należy do tego usera?
        $ownsWishlist = DB::table('wishlists')->where('id', $wishlistId)->where('user_id', $userId)->exists();
        if (!$ownsWishlist) {
            return redirect()->route('profil')->with('error', 'Odmowa dostępu.');
        }

        $existingCartItem = DB::table('cart_items')->where('user_id', $userId)->where('product_id', $productId)->first(['id']);

        if ($existingCartItem) {
            DB::table('cart_items')->where('id', $existingCartItem->id)->increment('quantity', 1);
        } else {
            DB::table('cart_items')->insert(['user_id' => $userId, 'product_id' => $productId, 'quantity' => 1]);
        }

        DB::table('wishlist_items')->where('wishlist_id', $wishlistId)->where('product_id', $productId)->delete();

        return redirect()->route('profil')->with('success', 'Produkt został dodany do koszyka i usunięty z listy.');
    }

    public function removeObserved(Request $request, int $wishlistId, int $productId): RedirectResponse
    {
        $userId = $request->user()->id;
        $ownsWishlist = DB::table('wishlists')->where('id', $wishlistId)->where('user_id', $userId)->exists();

        if ($ownsWishlist) {
            DB::table('wishlist_items')->where('wishlist_id', $wishlistId)->where('product_id', $productId)->delete();
        }

        return redirect()->route('profil')->with('success', 'Produkt został usunięty z listy.');
    }

    private function loadAddress(int $userId): ?object
    {
        return DB::table('addresses')
            ->where('user_id', $userId)
            ->orderByDesc('is_default')
            ->orderBy('id')
            ->first();
    }

    private function upsertAddress(int $userId, array $addressData): void
    {
        $hasAnyAddressValue = collect($addressData)->contains(fn ($value) => filled($value));
        $existingAddress = $this->loadAddress($userId);

        if (!$hasAnyAddressValue && !$existingAddress) {
            return;
        }

        if ($existingAddress) {
            DB::table('addresses')
                ->where('id', $existingAddress->id)
                ->update([
                    'street' => $addressData['street'],
                    'postal_code' => $addressData['postal_code'],
                    'city' => $addressData['city'],
                ]);

            return;
        }

        DB::table('addresses')->insert([
            'user_id' => $userId,
            'street' => $addressData['street'],
            'postal_code' => $addressData['postal_code'],
            'city' => $addressData['city'],
            'is_default' => true,
        ]);
    }

    private function loadShipments(int $userId): Collection
    {
        $orderColumns = [
            'o.id',
            'o.tracking_status',
            'o.shipping_cost',
            'o.created_at',
            'o.shipping_street',
            'o.shipping_city',
            'o.shipping_postal_code',
            'o.shipping_first_name',
            'o.shipping_last_name',
            'o.shipping_phone',
        ];

        foreach (['payment_method', 'pickup_point_info'] as $optionalColumn) {
            $orderColumns[] = Schema::hasColumn('orders', $optionalColumn)
                ? "o.{$optionalColumn}"
                : DB::raw("NULL as {$optionalColumn}");
        }

        $orderColumns[] = 'sm.name as shipping_method_name';

        $orders = DB::table('orders as o')
            ->leftJoin('shipping_methods as sm', 'sm.id', '=', 'o.shipping_method_id')
            ->where('o.user_id', $userId)
            ->orderByDesc('o.created_at')
            ->get($orderColumns);

        if ($orders->isEmpty()) {
            return collect();
        }

        $orderIds = $orders->pluck('id');
        $displayIdsByOrder = $orders
            ->sortBy([
                ['created_at', 'asc'],
                ['id', 'asc'],
            ])
            ->values()
            ->mapWithKeys(fn ($order, int $index) => [(int) $order->id => $index + 1]);

        $itemsByOrder = DB::table('order_items as oi')
            ->join('products as p', 'p.id', '=', 'oi.product_id')
            ->whereIn('oi.order_id', $orderIds)
            ->orderBy('oi.id')
            ->get([
                'oi.order_id',
                'oi.product_id',
                'oi.quantity',
                'oi.unit_price',
                'p.name',
                'p.image_url',
            ])
            ->groupBy('order_id');

        $complaintsByOrder = DB::table('complaints')
            ->whereIn('order_id', $orderIds)
            ->orderByDesc('id')
            ->get(['order_id', 'reason', 'status'])
            ->groupBy('order_id');

        return $orders->map(function ($order) use ($itemsByOrder, $complaintsByOrder, $displayIdsByOrder) {
            $items = $itemsByOrder->get($order->id, collect());
            $firstItem = $items->first();
            $itemsTotal = $items->sum(fn ($item) => (float) $item->unit_price * (int) $item->quantity);
            $total = $itemsTotal + (float) ($order->shipping_cost ?? 0);
            $status = trim((string) ($order->tracking_status ?? ''));
            $complaint = $complaintsByOrder->get($order->id)?->first();

            return [
                'id' => (int) $order->id,
                'display_id' => (int) ($displayIdsByOrder[(int) $order->id] ?? $order->id),
                'status' => $status !== '' ? $status : 'W realizacji',
                'is_delivered' => $this->isDeliveredStatus($status),
                'shipping_method' => $order->shipping_method_name ?: 'Brak danych',
                'created_at' => $order->created_at ? \Carbon\Carbon::parse($order->created_at)->format('d.m.Y') : null,
                'total' => number_format($total, 2, '.', ' '),
                'items_count' => $items->sum('quantity'),
                'image_path' => $this->resolveImagePath($firstItem->image_url ?? null),
                'first_product_name' => $firstItem->name ?? 'Zamówienie',
                'address' => trim(implode(', ', array_filter([
                    $order->shipping_street,
                    trim(implode(' ', array_filter([$order->shipping_postal_code, $order->shipping_city]))),
                ]))),
                'recipient' => trim(implode(' ', array_filter([$order->shipping_first_name, $order->shipping_last_name]))),
                'phone' => $order->shipping_phone,
                'payment_method' => match ($order->payment_method) {
                    'blik' => 'BLIK',
                    'card' => 'Karta płatnicza',
                    'cod' => 'Gotówka przy odbiorze',
                    default => $order->payment_method ?: 'Brak danych',
                },
                'pickup_point' => $order->pickup_point_info,
                'complaint_label' => $complaint ? ($complaint->reason . ' - ' . ($complaint->status ?? 'oczekujące')) : null,
            ];
        });
    }

    private function loadComplaintReplies(int $userId): Collection
    {
        if (!Schema::hasTable('complaints')) {
            return collect();
        }

        $hasResponseColumns = Schema::hasColumn('complaints', 'admin_response');

        return DB::table('complaints as c')
            ->join('orders as o', 'o.id', '=', 'c.order_id')
            ->where('o.user_id', $userId)
            ->orderByDesc('c.id')
            ->get([
                'c.id',
                'c.order_id',
                'c.reason',
                'c.description',
                'c.status',
                'o.created_at as order_created_at',
                $hasResponseColumns ? 'c.admin_response' : DB::raw('NULL as admin_response'),
                $hasResponseColumns ? 'c.customer_reply' : DB::raw('NULL as customer_reply'),
                $hasResponseColumns ? 'c.responded_at' : DB::raw('NULL as responded_at'),
                $hasResponseColumns ? 'c.customer_replied_at' : DB::raw('NULL as customer_replied_at'),
            ])
            ->map(function ($complaint) {
                return [
                    'id' => (int) $complaint->id,
                    'order_id' => (int) $complaint->order_id,
                    'reason' => $complaint->reason ?: 'Zgłoszenie',
                    'description' => $complaint->description ?: 'Brak opisu zgłoszenia.',
                    'status' => $complaint->status ?: 'oczekujące',
                    'status_label' => $this->complaintStatusLabel($complaint->status),
                    'order_created_at' => $complaint->order_created_at
                        ? \Carbon\Carbon::parse($complaint->order_created_at)->format('d.m.Y')
                        : 'Brak daty',
                    'admin_response' => $complaint->admin_response,
                    'customer_reply' => $complaint->customer_reply,
                    'responded_at' => $complaint->responded_at
                        ? \Carbon\Carbon::parse($complaint->responded_at)->format('d.m.Y H:i')
                        : null,
                    'customer_replied_at' => $complaint->customer_replied_at
                        ? \Carbon\Carbon::parse($complaint->customer_replied_at)->format('d.m.Y H:i')
                        : null,
                    'can_reply' => $complaint->status === 'oczekujące' && filled($complaint->admin_response),
                ];
            });
    }

    private function loadComplaintReplies(int $userId): Collection
    {
        // Pobieramy wszystkie przedmioty na wishlistach przypisanych do użytkownika
        $items = DB::table('wishlist_items as wi')
            ->join('wishlists as w', 'w.id', '=', 'wi.wishlist_id')
            ->join('products as p', 'p.id', '=', 'wi.product_id')
            ->leftJoin('brands as b', 'b.id', '=', 'p.brand_id')
            ->where('w.user_id', $userId)
            ->orderBy('w.name') // Sortowanie alfabetyczne po nazwie listy
            ->orderByDesc('p.id')
            ->get([
                'w.id as wishlist_id',
                'w.name as wishlist_name',
                'p.id as product_id',
                'p.name as product_name',
                'p.base_price',
                'p.promo_price',
                'p.image_url',
                'p.stock_quantity',
                'b.name as brand_name',
            ])
            ->map(function ($item) {
                $basePrice = (float) $item->base_price;
                $promoPrice = $item->promo_price !== null ? (float) $item->promo_price : null;
                $hasPromotion = $promoPrice !== null && $promoPrice < $basePrice;

                return [
                    'wishlist_id' => (int) $item->wishlist_id,
                    'wishlist_name' => $item->wishlist_name,
                    'id' => (int) $item->product_id,
                    'name' => $item->product_name,
                    'brand_name' => $item->brand_name,
                    'current_price' => number_format($hasPromotion ? $promoPrice : $basePrice, 2, '.', ' '),
                    'original_price' => $hasPromotion ? number_format($basePrice, 2, '.', ' ') : null,
                    'image_path' => $this->resolveImagePath($item->image_url),
                    'stock_quantity' => (int) ($item->stock_quantity ?? 0),
                ];
            });

        // Grupowanie wyników po id i nazwie listy
        return $items->groupBy(function($item) {
            return $item['wishlist_id'] . '|' . $item['wishlist_name'];
        });
    }
    private function findObservedWishlistId(int $userId): ?int
    {
        $wishlist = DB::table('wishlists')
            ->where('user_id', $userId)
            ->whereRaw('LOWER(name) = ?', ['obserwowane'])
            ->first(['id']);

        return $wishlist ? (int) $wishlist->id : null;
    }

    private function isDeliveredStatus(?string $status): bool
    {
        $normalized = mb_strtolower(trim((string) $status));

        if ($normalized === '') {
            return false;
        }

        return in_array($normalized, [
            'delivered',
            'completed',
            'cancelled',
            'canceled',
            'dostarczone',
            'zrealizowane',
            'anulowane',
            'zakonczone',
            'zakończone',
            'odebrane',
        ], true);
    }

    private function complaintStatusLabel(?string $status): string
    {
        return match ($status) {
            'zaakceptowane' => 'Zaakceptowane',
            'odrzucone' => 'Odrzucone',
            default => 'Oczekujące',
        };
    }

    private function refreshTimedOrderStatuses(?int $userId = null): void
    {
        if (!Schema::hasTable('orders')) {
            return;
        }

        $orders = DB::table('orders')
            ->when($userId !== null, fn ($query) => $query->where('user_id', $userId))
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

    private function resolveImagePath(?string $imageUrl): ?string
    {
        if (!filled($imageUrl)) {
            return null;
        }

        return asset('images/' . ltrim((string) $imageUrl, '/'));
    }
}
