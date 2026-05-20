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
        'message' => 'Produkt dodany do koszyka!'
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

        return view('Transakcje');
    }
}
