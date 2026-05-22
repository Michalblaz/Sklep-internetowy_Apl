<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class KoszykController extends Controller
{
    public function index()
    {
        $cartItems = $this->getCartContents();
        $totalPrice = collect($cartItems)->sum(fn($item) => $item['price'] * $item['quantity']);

        return view('koszyk', [
            'cartItems' => $cartItems,
            'totalPrice' => $totalPrice
        ]);
    }

    // Dodawanie do koszyka
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'integer|min:1'
        ]);
        $recommended = \App\Models\Product::getPersonalizedRecommendations(4);
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        if (auth()->check()) {
            // Zalogowany - zapis do bazy
            $this->addToDatabase($productId, $quantity);
        } else {
            // Gość - zapis do sesji
            $this->addToSession($productId, $quantity);
            }

        if (auth()->check()) {
            \Illuminate\Support\Facades\DB::table('product_browsing_history')->insert([
                'product_id' => $productId,
                'user_id'    => auth()->id(),
                'viewed_at'  => now(),
            ]);
        }
       
        return response()->json([
        'success' => true,
        'message' => 'Produkt dodany do koszyka!',
        'recommended' => $recommended
    ]);
    }

    // Usuwanie produktu z koszyka
    public function remove(Request $request)
    {
        $productId = $request->input('product_id');

        if (auth()->check()) {
            DB::table('cart_items')
                ->where('user_id', auth()->id())
                ->where('product_id', $productId)
                ->delete();
        } else {
            $cart = session('cart', []);
            unset($cart[$productId]);
            session(['cart' => $cart]);
        }

        return back()->with('success', 'Produkt usunięty z koszyka.');
    }

    // --- METODY POMOCNICZE --- //

    private function getCartContents()
    {
        if (auth()->check()) {
            // Pobieramy dane z bazy
            $items = DB::table('cart_items')
                ->join('products', 'cart_items.product_id', '=', 'products.id')
                ->where('cart_items.user_id', auth()->id())
                ->select(
                    'products.id',
                    'products.name',
                    'products.base_price',
                    'products.promo_price',
                    'products.image_url',
                    'products.stock_quantity as stock',
                    'cart_items.quantity'
                )
                ->get();

            // Zmiana na tablicę
            $cartArray = [];
            foreach ($items as $item) {
                $basePrice = (float) $item->base_price;
                $promoPrice = $item->promo_price ? (float) $item->promo_price : null;
                $effectivePrice = ($promoPrice && $promoPrice < $basePrice) ? $promoPrice : $basePrice;
                $cartArray[] = [
                    'id'        => (int) $item->id,
                    'name'      => $item->name,
                    'base_price'  => $basePrice,
                    'promo_price' => $promoPrice,
                    'price'       => $effectivePrice,
                    'image_url' => $item->image_url,
                    'stock'     => (int) $item->stock,
                    'quantity'  => (int) $item->quantity,
                ];
            }

            return $cartArray;
        }

        $cart = session('cart', []);
        if (!empty($cart)) {
            $productIds = array_keys($cart);
            $products = \DB::table('products')
                ->whereIn('id', $productIds)
                ->select('id', 'name', 'base_price', 'promo_price', 'image_url', 'stock_quantity as stock')
                ->get()
                ->keyBy('id');

            foreach ($cart as $productId => &$item) {
                if (isset($products[$productId])) {
                    $p = $products[$productId];
                    $basePrice = (float) $p->base_price;
                    $promoPrice = $p->promo_price ? (float) $p->promo_price : null;
                    $effectivePrice = ($promoPrice && $promoPrice < $basePrice) ? $promoPrice : $basePrice;

                    $item['id']          = (int) $p->id;
                    $item['name']        = $p->name;
                    $item['base_price']  = $basePrice;
                    $item['promo_price'] = $promoPrice;
                    $item['price']       = $effectivePrice;
                    $item['stock']       = (int) $p->stock;
                    $item['image_url']   = $p->image_url;
                }
            }
            session(['cart' => $cart]);
        }
        return $cart;
    }

    private function addToDatabase($productId, $quantity)
    {
        $existingItem = DB::table('cart_items')
            ->where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->first();

        if ($existingItem) {
            DB::table('cart_items')
                ->where('id', $existingItem->id)
                ->increment('quantity', $quantity);
        } else {
            DB::table('cart_items')->insert([
                'user_id' => auth()->id(),
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }
    }

    private function addToSession($productId, $quantity)
    {
        $cart = session('cart', []);
        $product = Product::find($productId);

        if (!$product) return;

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $basePrice = (float) $product->base_price;
            $promoPrice = $product->promo_price ? (float) $product->promo_price : null;
            $effectivePrice = ($promoPrice && $promoPrice < $basePrice) ? $promoPrice : $basePrice;

            $cart[$productId] = [
                'id'          => (int) $product->id,
                'name'        => $product->name,
                'base_price'  => $basePrice,
                'promo_price' => $promoPrice,
                'price'       => $effectivePrice,
                'image_url'   => $product->image_url,
                'stock' => (int) $product->stock_quantity,
                'quantity'    => $quantity,
            ];
        }
        session(['cart' => $cart]);
    }

    public function update(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = (int) $request->input('quantity');

        // Sprawdzamy dostępność w magazynie
        $product = DB::table('products')->where('id', $productId)->first();
        if (!$product) {
            return response()->json(['error' => 'Produkt nie istnieje'], 404);
        }

        // Ograniczamy ilość do maksymalnego stanu magazynowego
        if ($quantity > $product->stock_quantity) {
            $quantity = $product->stock_quantity;
        }
        if ($quantity < 1) {
            $quantity = 1;
        }

        if (auth()->check()) {
            DB::table('cart_items')
                ->where('user_id', auth()->id())
                ->where('product_id', $productId)
                ->update(['quantity' => $quantity]);
        } else {
            $cart = session('cart', []);
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] = $quantity;
                session(['cart' => $cart]);
            }
        }

        return response()->json(['success' => true]);
    }

    // Czyścimy koszyk
    public function clear()
    {
        if (auth()->check()) {
            \DB::table('cart_items')->where('user_id', auth()->id())->delete();
        } else {
            session()->forget('cart');
        }

        return redirect()->route('cart.index')->with('success', 'Koszyk został opróżniony.');
    }

    public function toggleInsurance(Request $request)
    {
        $productId = $request->input('product_id');
        // Pobieramy tablicę ubezpieczonych produktów z sesji
        $insuredProducts = session('insured_products', []);

        if (in_array($productId, $insuredProducts)) {
            // Jeśli produkt już był ubezpieczony, usuwamy go z listy
            $insuredProducts = array_diff($insuredProducts, [$productId]);
        } else {
            // Jeśli nie był, dodajemy jego ID do listy
            $insuredProducts[] = $productId;
        }

        // Zapisujemy zaktualizowaną listę z powrotem do sesji
        session(['insured_products' => $insuredProducts]);

        return response()->json(['success' => true]);
    }

    public function transakcje()
    {
        $shippingMethods = \DB::table('shipping_methods')->orderBy('id')->get();
        $addresses = collect();

        if (auth()->check()) {
            $addresses = DB::table('addresses')
                ->where('user_id', auth()->id())
                ->orderByDesc('is_default')
                ->orderBy('id')
                ->get();
        }
        $cartItems = $this->getCartContents();
        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Twój koszyk jest pusty!');
        }

        $totalPrice = collect($cartItems)->sum(fn($item) => $item['price'] * $item['quantity']);

        $insuredProducts = session('insured_products', []);
        $insurance = 0;
        foreach ($cartItems as $item) {
            if (in_array($item['id'], $insuredProducts)) {
                $insurance += ($item['price'] * 0.10) * $item['quantity'];
            }
        }

        $deliveryCost = (float) ($shippingMethods->first()->price ?? 0);
        $finalTotal = $totalPrice + $insurance + $deliveryCost;

        return view('Transakcje', [
            'shippingMethods' => $shippingMethods,
            'addresses' => $addresses,
            'cartItems' => $cartItems,
            'totalPrice' => $totalPrice,
            'insurance' => $insurance,
            'deliveryCost' => $deliveryCost,
            'finalTotal' => $finalTotal
        ]);
    }
    public function storeTransaction(Request $request)
    {
        $cartItems = $this->getCartContents();
        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Twój koszyk jest pusty!');
        }

        $request->validate([
            'recipient_first_name' => ['required', 'string', 'max:100'],
            'recipient_last_name' => ['required', 'string', 'max:100'],
            'recipient_phone' => ['required', 'string', 'max:20'],
            'shipping_method_id' => ['required', 'integer', 'exists:shipping_methods,id'],
            'payment_method' => ['required', 'string', 'in:blik,card,cod'],
            'terms_accepted' => ['accepted'],
            'address_mode' => ['nullable', 'string', 'in:existing,new,guest'],
            'selected_address_id' => ['nullable', 'integer'],
            'new_street' => ['nullable', 'string', 'max:255'],
            'new_postal_code' => ['nullable', 'string', 'max:20'],
            'new_city' => ['nullable', 'string', 'max:100'],
            'guest_street' => ['nullable', 'string', 'max:255'],
            'guest_postal_code' => ['nullable', 'string', 'max:20'],
            'guest_city' => ['nullable', 'string', 'max:100'],
            'pickup_point_info' => ['nullable', 'string', 'max:255'],
            'courier_provider' => ['nullable', 'string', 'max:100'],
            'blik_code' => ['required_if:payment_method,blik', 'nullable', 'digits:6'],
            'card_holder' => ['required_if:payment_method,card', 'nullable', 'string', 'max:255'],
            'card_number' => ['required_if:payment_method,card', 'nullable', 'string', 'max:30'],
            'card_expiry' => ['required_if:payment_method,card', 'nullable', 'string', 'max:7'],
            'card_cvv' => ['required_if:payment_method,card', 'nullable', 'digits_between:3,4'],
        ], [
            'terms_accepted.accepted' => 'Musisz zaakceptować warunki zakupu.',
            'blik_code.required_if' => 'Podaj 6-cyfrowy kod BLIK.',
            'blik_code.digits' => 'Kod BLIK musi mieć 6 cyfr.',
            'card_holder.required_if' => 'Podaj imię i nazwisko z karty.',
            'card_number.required_if' => 'Podaj numer karty.',
            'card_expiry.required_if' => 'Podaj datę ważności karty.',
            'card_cvv.required_if' => 'Podaj kod CVV.',
        ]);

        $shippingMethod = DB::table('shipping_methods')->where('id', $request->input('shipping_method_id'))->first();
        if (!$shippingMethod) {
            return back()->withErrors(['shipping_method_id' => 'Wybrano nieprawidłowy sposób dostawy.'])->withInput();
        }

        $requiresAddress = $this->shippingRequiresAddress($shippingMethod->name);
        $address = $requiresAddress
            ? $this->resolveCheckoutAddress($request)
            : ['street' => null, 'postal_code' => null, 'city' => null];

        if ($requiresAddress && $address === null) {
            return back()
                ->withErrors(['address' => 'Uzupełnij adres dostawy.'])
                ->withInput();
        }

        $deliveryCost = (float) $shippingMethod->price;
        $selectedPoint = $this->resolvePickupPoint($request, $shippingMethod->name);
        if (!$requiresAddress && !filled($selectedPoint)) {
            return back()
                ->withErrors(['pickup_point_info' => 'Wybierz punkt odbioru.'])
                ->withInput();
        }

        $orderId = DB::transaction(function () use ($request, $cartItems, $shippingMethod, $deliveryCost, $address, $selectedPoint) {
            $orderId = DB::table('orders')->insertGetId([
                'user_id' => auth()->check() ? auth()->id() : null,
                'shipping_first_name' => $request->input('recipient_first_name'),
                'shipping_last_name' => $request->input('recipient_last_name'),
                'shipping_phone' => $request->input('recipient_phone'),
                'shipping_street' => $address['street'],
                'shipping_city' => $address['city'],
                'shipping_postal_code' => $address['postal_code'],
                'shipping_method_id' => $shippingMethod->id,
                'payment_method' => $request->input('payment_method'),
                'pickup_point_info' => $selectedPoint,
                'shipping_cost' => $deliveryCost,
                'tracking_status' => 'Nowe',
                'created_at' => now(),
            ]);

            foreach ($cartItems as $item) {
                DB::table('order_items')->insert([
                    'order_id' => $orderId,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                ]);
            }

            return $orderId;
        });

        if (auth()->check()) {
            DB::table('cart_items')->where('user_id', auth()->id())->delete();
        } else {
            session()->forget('cart');
        }
        session()->forget('insured_products');

        return redirect()
            ->route('home')
            ->with('order_success', 'Dziękujemy za zakup! Zamówienie #'.$orderId.' zostało złożone.');
    }

    private function resolveCheckoutAddress(Request $request): ?array
    {
        if (!auth()->check()) {
            $address = [
                'street' => trim((string) $request->input('guest_street')),
                'postal_code' => trim((string) $request->input('guest_postal_code')),
                'city' => trim((string) $request->input('guest_city')),
            ];

            return $this->hasCompleteAddress($address) ? $address : null;
        }

        if ($request->input('address_mode') === 'existing') {
            $address = DB::table('addresses')
                ->where('id', $request->input('selected_address_id'))
                ->where('user_id', auth()->id())
                ->first();

            if (!$address) {
                return null;
            }

            $resolvedAddress = [
                'street' => (string) $address->street,
                'postal_code' => (string) $address->postal_code,
                'city' => (string) $address->city,
            ];

            return $this->hasCompleteAddress($resolvedAddress) ? $resolvedAddress : null;
        }

        $newAddress = [
            'street' => trim((string) $request->input('new_street')),
            'postal_code' => trim((string) $request->input('new_postal_code')),
            'city' => trim((string) $request->input('new_city')),
        ];

        if (!$this->hasCompleteAddress($newAddress)) {
            return null;
        }

        $hasDefaultAddress = DB::table('addresses')
            ->where('user_id', auth()->id())
            ->where('is_default', true)
            ->exists();

        DB::table('addresses')->insert([
            'user_id' => auth()->id(),
            'street' => $newAddress['street'],
            'postal_code' => $newAddress['postal_code'],
            'city' => $newAddress['city'],
            'is_default' => !$hasDefaultAddress,
        ]);

        return $newAddress;
    }

    private function hasCompleteAddress(array $address): bool
    {
        return filled($address['street'] ?? null)
            && filled($address['postal_code'] ?? null)
            && filled($address['city'] ?? null);
    }

    private function resolvePickupPoint(Request $request, string $shippingMethodName): ?string
    {
        $method = mb_strtolower($shippingMethodName);
        if (str_contains($method, 'kurier')) {
            return 'Kurier: ' . ($request->input('courier_provider') ?: 'Standard');
        }

        if (str_contains($method, 'osobist') || str_contains($method, 'siedzib')) {
            return 'Siedziba firmy - al. Tadeusza Rejtana 16C, Rzeszów';
        }

        $pickupPoint = trim((string) $request->input('pickup_point_info'));

        return $pickupPoint !== '' ? $pickupPoint : null;
    }

    private function shippingRequiresAddress(string $shippingMethodName): bool
    {
        return str_contains(mb_strtolower($shippingMethodName), 'kurier');
    }
}
