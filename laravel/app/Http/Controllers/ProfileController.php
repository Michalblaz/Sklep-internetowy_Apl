<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $address = $this->loadAddress($user->id);
        $shipments = $this->loadShipments($user->id);
        $observedProducts = $this->loadObservedProducts($user->id);

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
            'observedProducts' => $observedProducts,
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

        DB::table('complaints')->insert([
            'order_id' => $order->id,
            'reason' => $validated['reason'],
            'description' => $validated['description'] ?? '',
            'status' => 'new',
        ]);

        return redirect()
            ->route('profil')
            ->with('success', 'Zgłoszenie zostało zapisane.');
    }

    public function moveObservedToCart(Request $request, int $productId): RedirectResponse
    {
        $userId = $request->user()->id;
        $wishlistId = $this->findObservedWishlistId($userId);

        if ($wishlistId === null) {
            return redirect()
                ->route('profil')
                ->with('error', 'Nie znaleziono listy obserwowanych produktów.');
        }

        $existsOnWishlist = DB::table('wishlist_items')
            ->where('wishlist_id', $wishlistId)
            ->where('product_id', $productId)
            ->exists();

        if (!$existsOnWishlist) {
            return redirect()
                ->route('profil')
                ->with('error', 'Wybrany produkt nie znajduje się już na liście obserwowanych.');
        }

        $existingCartItem = DB::table('cart_items')
            ->where('user_id', $userId)
            ->where('product_id', $productId)
            ->first(['id']);

        if ($existingCartItem) {
            DB::table('cart_items')
                ->where('id', $existingCartItem->id)
                ->increment('quantity', 1);
        } else {
            DB::table('cart_items')->insert([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => 1,
            ]);
        }

        DB::table('wishlist_items')
            ->where('wishlist_id', $wishlistId)
            ->where('product_id', $productId)
            ->delete();

        return redirect()
            ->route('profil')
            ->with('success', 'Produkt został dodany do koszyka i usunięty z obserwowanych.');
    }

    public function removeObserved(Request $request, int $productId): RedirectResponse
    {
        $wishlistId = $this->findObservedWishlistId($request->user()->id);

        if ($wishlistId !== null) {
            DB::table('wishlist_items')
                ->where('wishlist_id', $wishlistId)
                ->where('product_id', $productId)
                ->delete();
        }

        return redirect()
            ->route('profil')
            ->with('success', 'Produkt został usunięty z obserwowanych.');
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
        $orders = DB::table('orders as o')
            ->leftJoin('shipping_methods as sm', 'sm.id', '=', 'o.shipping_method_id')
            ->where('o.user_id', $userId)
            ->orderByDesc('o.created_at')
            ->get([
                'o.id',
                'o.tracking_status',
                'o.shipping_cost',
                'o.created_at',
                'o.shipping_street',
                'o.shipping_city',
                'o.shipping_postal_code',
                'sm.name as shipping_method_name',
            ]);

        if ($orders->isEmpty()) {
            return collect();
        }

        $orderIds = $orders->pluck('id');

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

        return $orders->map(function ($order) use ($itemsByOrder, $complaintsByOrder) {
            $items = $itemsByOrder->get($order->id, collect());
            $firstItem = $items->first();
            $itemsTotal = $items->sum(fn ($item) => (float) $item->unit_price * (int) $item->quantity);
            $total = $itemsTotal + (float) ($order->shipping_cost ?? 0);
            $status = trim((string) ($order->tracking_status ?? ''));
            $complaint = $complaintsByOrder->get($order->id)?->first();

            return [
                'id' => (int) $order->id,
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
                'complaint_label' => $complaint ? ($complaint->reason . ' - ' . ($complaint->status ?? 'new')) : null,
            ];
        });
    }

    private function loadObservedProducts(int $userId): Collection
    {
        $wishlistId = $this->findObservedWishlistId($userId);

        if ($wishlistId === null) {
            return collect();
        }

        return DB::table('wishlist_items as wi')
            ->join('products as p', 'p.id', '=', 'wi.product_id')
            ->leftJoin('brands as b', 'b.id', '=', 'p.brand_id')
            ->where('wi.wishlist_id', $wishlistId)
            ->orderByDesc('p.id')
            ->get([
                'p.id',
                'p.name',
                'p.base_price',
                'p.promo_price',
                'p.image_url',
                'p.stock_quantity',
                'b.name as brand_name',
            ])
            ->map(function ($product) {
                $basePrice = (float) $product->base_price;
                $promoPrice = $product->promo_price !== null ? (float) $product->promo_price : null;
                $hasPromotion = $promoPrice !== null && $promoPrice < $basePrice;

                return [
                    'id' => (int) $product->id,
                    'name' => $product->name,
                    'brand_name' => $product->brand_name,
                    'current_price' => number_format($hasPromotion ? $promoPrice : $basePrice, 2, '.', ' '),
                    'original_price' => $hasPromotion ? number_format($basePrice, 2, '.', ' ') : null,
                    'image_path' => $this->resolveImagePath($product->image_url),
                    'stock_quantity' => (int) ($product->stock_quantity ?? 0),
                ];
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

    private function resolveImagePath(?string $imageUrl): ?string
    {
        if (!filled($imageUrl)) {
            return null;
        }

        return asset('images/' . ltrim((string) $imageUrl, '/'));
    }
}
