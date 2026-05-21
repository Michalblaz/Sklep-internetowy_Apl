<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProductPageController extends Controller
{
    public function show(?int $id = null): View
    {
        $product = null;
        $specs = collect();
        $reviews = collect();
        $currentUserReview = null;
        $topSpecs = [];
        $rating = 0.0;
        $ratingColorSegments = array_fill(0, 5, 0);
        $isObserved = false;

        if ($id !== null) {
            $product = Product::query()
                ->with(['brand', 'category'])
                ->find($id);
        }

        if ($product) {
            if (auth()->check()) {
                DB::table('product_browsing_history')->insert([
                    'product_id' => $product->id,
                    'user_id' => auth()->id(),
                    'viewed_at' => now(),
                ]);
            }

            $attributeTable = (new Attribute())->getTable();
            $attributeColumn = Product::attributeCategoryPivotColumn();

            $specs = DB::table('product_attributes as pa')
                ->join($attributeTable . ' as ac', 'ac.id', '=', 'pa.' . $attributeColumn)
                ->leftJoin('attribute_values as av', 'av.id', '=', 'pa.attribute_value_id')
                ->where('pa.product_id', $product->id)
                ->orderBy('ac.name')
                ->get([
                    'ac.name as key',
                    'av.value as value',
                ])
                ->filter(fn ($spec) => filled($spec->value))
                ->map(function ($spec) {
                    $attribute = new Attribute();
                    $attribute->name = $spec->key;

                    return [
                        'label' => $attribute->display_name,
                        'value' => $attribute->formatValue($spec->value),
                    ];
                })
                ->values();

            $reviews = DB::table('reviews as r')
                ->leftJoin('users as u', 'u.id', '=', 'r.user_id')
                ->where('r.product_id', $product->id)
                ->orderByDesc('r.created_at')
                ->get([
                    'r.rating as stars',
                    'r.comment as content',
                    'u.first_name',
                    'u.last_name',
                ])
                ->map(function ($review) {
                    $author = trim(collect([$review->first_name, $review->last_name])->filter()->implode(' '));

                    return [
                        'author' => $author !== '' ? $author : 'Użytkownik',
                        'content' => $review->content ?? '',
                        'stars' => (int) $review->stars,
                    ];
                })
                ->values();

            $rating = round((float) $reviews->avg('stars'), 2);
            $ratingColorSegments = $this->buildRatingSegments($rating);

            $topSpecs = array_values(array_filter([
                ['label' => 'Marka', 'value' => $product->brand->name ?? null],
                ['label' => 'Kategoria', 'value' => $product->category->name ?? null],
                [
                    'label' => 'Stan magazynowy',
                    'value' => isset($product->stock_quantity)
                        ? ((int) $product->stock_quantity === 0 ? 'Brak produktów w magazynie' : $product->stock_quantity)
                        : null,
                ],
                [
                    'label' => 'Pobór mocy',
                    'value' => filled($product->power_draw_w) && (int) $product->power_draw_w !== 0
                        ? $product->power_draw_w . ' W'
                        : null,
                ],
            ], fn ($spec) => filled($spec['value'])));

            if (empty($topSpecs) && $specs->isNotEmpty()) {
                $topSpecs = $specs->take(4)->all();
            }

            if (auth()->check()) {
                $currentUserReview = DB::table('reviews')
                    ->where('product_id', $product->id)
                    ->where('user_id', auth()->id())
                    ->first([
                        'id',
                        'rating',
                        'comment',
                    ]);

                $wishlistId = $this->findObservedWishlistId(auth()->id());

                if ($wishlistId !== null) {
                    $isObserved = DB::table('wishlist_items')
                        ->where('wishlist_id', $wishlistId)
                        ->where('product_id', $product->id)
                        ->exists();
                }
            }
        }

        $currentPrice = $product && $product->promo_price !== null && (float) $product->promo_price < (float) $product->base_price
            ? (float) $product->promo_price
            : ($product ? (float) $product->base_price : null);

        $originalPrice = $product ? (float) $product->base_price : null;
        $hasPromotion = $product && $product->promo_price !== null && (float) $product->promo_price < (float) $product->base_price;
        $discountPercent = $hasPromotion && $originalPrice > 0
            ? (int) round((($originalPrice - $currentPrice) / $originalPrice) * 100)
            : 0;
        $imagePath = $product && filled($product->image_url)
            ? asset('images/' . ltrim($product->image_url, '/'))
            : null;

        return view('produkt', [
            'product' => $product,
            'specs' => $specs,
            'reviews' => $reviews,
            'currentUserReview' => $currentUserReview,
            'topSpecs' => $topSpecs,
            'rating' => $rating,
            'ratingColorSegments' => $ratingColorSegments,
            'currentPrice' => $currentPrice,
            'originalPrice' => $originalPrice,
            'hasPromotion' => $hasPromotion,
            'discountPercent' => $discountPercent,
            'imagePath' => $imagePath,
            'isObserved' => $isObserved,
            'description' => null,
        ]);
    }

    public function storeReview(Request $request, int $id): RedirectResponse
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['nullable', 'string'],
        ], [
            'rating.required' => 'Wybierz ocenę.',
            'rating.between' => 'Ocena musi być w zakresie od 1 do 5.',
        ]);

        $existingReview = DB::table('reviews')
            ->where('product_id', $product->id)
            ->where('user_id', $request->user()->id)
            ->first(['id']);

        if ($existingReview) {
            DB::table('reviews')
                ->where('id', $existingReview->id)
                ->update([
                    'rating' => $validated['rating'],
                    'comment' => $validated['comment'] ?? '',
                    'created_at' => now(),
                ]);
        } else {
            DB::table('reviews')->insert([
                'product_id' => $product->id,
                'user_id' => $request->user()->id,
                'rating' => $validated['rating'],
                'comment' => $validated['comment'] ?? '',
                'created_at' => now(),
            ]);
        }

        return redirect()
            ->route('products.show', $product->id)
            ->with('success', $existingReview ? 'Opinia została zaktualizowana.' : 'Opinia została dodana.');
    }

    public function toggleObserved(Request $request, int $id): JsonResponse
    {
        $product = Product::findOrFail($id);

        if (!$request->user()) {
            return response()->json([
                'success' => false,
                'message' => 'Musisz być zalogowany, żeby obserwować produkty.',
            ], 401);
        }

        $wishlistId = $this->findOrCreateObservedWishlistId($request->user()->id);

        $existingWishlistItem = DB::table('wishlist_items')
            ->where('wishlist_id', $wishlistId)
            ->where('product_id', $product->id)
            ->exists();

        if ($existingWishlistItem) {
            DB::table('wishlist_items')
                ->where('wishlist_id', $wishlistId)
                ->where('product_id', $product->id)
                ->delete();

            return response()->json([
                'success' => true,
                'isObserved' => false,
                'message' => 'Produkt został usunięty z obserwowanych.',
            ]);
        }

        DB::table('wishlist_items')->insert([
            'wishlist_id' => $wishlistId,
            'product_id' => $product->id,
        ]);

        return response()->json([
            'success' => true,
            'isObserved' => true,
            'message' => 'Produkt został dodany do obserwowanych.',
        ]);
    }

    private function buildRatingSegments(float $rating): array
    {
        $segments = [];

        for ($segment = 0; $segment < 5; $segment++) {
            $segmentFill = max(0, min(1, $rating - $segment));
            $segments[] = $segmentFill >= 1
                ? 1
                : ($segmentFill <= 0 ? 0 : round(floor($segmentFill * 10) / 10, 1));
        }

        return $segments;
    }

    private function findObservedWishlistId(int $userId): ?int
    {
        $wishlist = DB::table('wishlists')
            ->where('user_id', $userId)
            ->whereRaw('LOWER(name) = ?', ['obserwowane'])
            ->first(['id']);

        return $wishlist ? (int) $wishlist->id : null;
    }

    private function findOrCreateObservedWishlistId(int $userId): int
    {
        $wishlistId = $this->findObservedWishlistId($userId);

        if ($wishlistId !== null) {
            return $wishlistId;
        }

        return (int) DB::table('wishlists')->insertGetId([
            'user_id' => $userId,
            'name' => 'Obserwowane',
        ]);
    }
}
