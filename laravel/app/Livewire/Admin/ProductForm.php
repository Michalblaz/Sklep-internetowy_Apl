<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class ProductForm extends Component
{
    use WithFileUploads;

    public $productId = null;
    public $isEditMode = false;
    public $name;
    public $category_id;
    public $brand_id;
    public $new_category_name;
    public $new_brand_name;
    public $base_price;
    public $promo_price;
    public $is_promo = false;
    public $stock_quantity = 0;
    public $power_draw_w;
    public $file_name_input;
    public $product_image;
    public $availableAttributes = [];
    public $attributeValues = [];

    public $categoryFolderMap = [
        1 => 'cpu', 2 => 'gpu', 3 => 'motherboard', 4 => 'ram', 5 => 'storage',
        6 => 'psu', 7 => 'case', 8 => 'mouse', 9 => 'keyboard', 10 => 'headphones',
        11 => 'speakers', 12 => 'cooler', 13 => 'network', 14 => 'monitor',
    ];

    public function mount($productId = null): void
    {
        $this->ensureAdmin();

        if ($productId !== null) {
            abort_unless(filter_var($productId, FILTER_VALIDATE_INT) !== false, 404);

            $this->productId = (int) $productId;
            $this->isEditMode = true;
            $this->loadProductData();
        }
    }

    public function loadProductData(): void
    {
        $this->ensureAdmin();

        $product = DB::table('products')->where('id', $this->productId)->first();
        abort_unless($product, 404);

        $this->name = $product->name;
        $this->category_id = $product->category_id;
        $this->brand_id = $product->brand_id;
        $this->base_price = $product->base_price;
        $this->promo_price = $product->promo_price;
        $this->is_promo = ! empty($product->promo_price);
        $this->stock_quantity = $product->stock_quantity;
        $this->power_draw_w = $product->power_draw_w;
        $this->file_name_input = pathinfo($product->image_url, PATHINFO_FILENAME);

        $this->updatedCategoryId($this->category_id);

        $this->attributeValues = DB::table('product_attributes')
            ->join('attribute_values', 'product_attributes.attribute_value_id', '=', 'attribute_values.id')
            ->where('product_id', $this->productId)
            ->pluck('attribute_values.value', 'product_attributes.attribute_category_id')
            ->mapWithKeys(fn ($value, $key) => [(string) $key => (string) $value])
            ->toArray();
    }

    public function updatedCategoryId($value): void
    {
        $this->ensureAdmin();

        if ($value) {
            $this->new_category_name = null;
        }

        $this->attributeValues = [];

        if (! $value) {
            $this->availableAttributes = [];
            return;
        }

        abort_unless(
            filter_var($value, FILTER_VALIDATE_INT) !== false
            && DB::table('categories')->where('id', $value)->exists(),
            422
        );

        $this->availableAttributes = \App\Models\Attribute::query()
            ->join('category_attributes', 'attribute_category.id', '=', 'category_attributes.attribute_id')
            ->where('category_attributes.category_id', $value)
            ->select('attribute_category.*')
            ->get()
            ->map(fn ($attribute) => [
                'id' => $attribute->id,
                'name' => $attribute->name,
                'display_name' => $attribute->display_name,
                'values' => DB::table('attribute_values')
                    ->where('attribute_category_id', $attribute->id)
                    ->pluck('value')
                    ->toArray(),
            ])
            ->sortBy('display_name')
            ->values()
            ->toArray();
    }

    public function updatedBrandId($value): void
    {
        $this->ensureAdmin();

        if ($value) {
            $this->new_brand_name = null;
        }
    }

    public function updatedNewCategoryName($value): void
    {
        $this->ensureAdmin();

        if (filled($value)) {
            $this->category_id = null;
            $this->availableAttributes = [];
            $this->attributeValues = [];
        }
    }

    public function updatedNewBrandName($value): void
    {
        $this->ensureAdmin();

        if (filled($value)) {
            $this->brand_id = null;
        }
    }

    public function save(): void
    {
        $this->ensureAdmin();

        $this->validate([
            'productId' => ['nullable', 'integer', 'exists:products,id'],
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'category_id' => ['nullable', 'required_without:new_category_name', 'integer', 'exists:categories,id'],
            'new_category_name' => ['nullable', 'required_without:category_id', 'string', 'min:2', 'max:100'],
            'brand_id' => ['nullable', 'required_without:new_brand_name', 'integer', 'exists:brands,id'],
            'new_brand_name' => ['nullable', 'required_without:brand_id', 'string', 'min:2', 'max:100'],
            'base_price' => ['required', 'numeric', 'min:0', 'max:99999999'],
            'is_promo' => ['boolean'],
            'promo_price' => ['nullable', 'required_if:is_promo,true', 'numeric', 'min:0', 'lt:base_price'],
            'stock_quantity' => ['nullable', 'integer', 'min:0', 'max:999999999'],
            'power_draw_w' => ['nullable', 'integer', 'min:0', 'max:100000'],
            'file_name_input' => ['nullable', 'string', 'max:200'],
            'product_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'attributeValues' => ['array', 'max:100'],
            'attributeValues.*' => ['nullable', 'string', 'max:255'],
        ]);

        try {
            DB::transaction(function () {
                $categoryId = $this->resolveCategoryId();
                $brandId = $this->resolveBrandId();
                $safeName = $this->safeImageName($this->file_name_input ?: $this->name);
                $folder = $this->categoryFolder($categoryId);
                $extension = $this->imageExtension();
                $imageUrl = 'products/' . $folder . '/' . $safeName . '.' . $extension;

                if ($this->product_image instanceof TemporaryUploadedFile) {
                    $this->storeProductImage($this->product_image, $folder, $safeName . '.' . $extension);
                }

                $data = [
                    'category_id' => $categoryId,
                    'brand_id' => $brandId,
                    'name' => trim($this->name),
                    'base_price' => (float) $this->base_price,
                    'promo_price' => $this->is_promo ? (float) $this->promo_price : null,
                    'stock_quantity' => (int) ($this->stock_quantity ?: 0),
                    'image_url' => $imageUrl,
                    'power_draw_w' => $this->power_draw_w !== null ? (int) $this->power_draw_w : null,
                ];

                if ($this->isEditMode) {
                    DB::table('products')->where('id', $this->productId)->update($data);
                    DB::table('product_attributes')->where('product_id', $this->productId)->delete();
                    $currentId = (int) $this->productId;
                } else {
                    $currentId = DB::table('products')->insertGetId($data);
                }

                $allowedAttributeIds = DB::table('category_attributes')
                    ->where('category_id', $categoryId)
                    ->pluck('attribute_id')
                    ->map(fn ($id) => (int) $id)
                    ->all();

                foreach ($this->attributeValues as $attributeId => $userValue) {
                    if (! in_array((int) $attributeId, $allowedAttributeIds, true)) {
                        throw ValidationException::withMessages([
                            'attributeValues' => 'Przesłano atrybut spoza wybranej kategorii.',
                        ]);
                    }

                    $userValue = is_string($userValue) ? trim($userValue) : '';

                    if ($userValue === '') {
                        continue;
                    }

                    $valueRecord = DB::table('attribute_values')
                        ->where('attribute_category_id', $attributeId)
                        ->where('value', $userValue)
                        ->first();

                    $valueId = $valueRecord?->id ?? DB::table('attribute_values')->insertGetId([
                        'attribute_category_id' => (int) $attributeId,
                        'value' => $userValue,
                    ]);

                    DB::table('product_attributes')->insert([
                        'product_id' => $currentId,
                        'attribute_category_id' => (int) $attributeId,
                        'attribute_value_id' => $valueId,
                    ]);
                }
            });

            session()->flash('admin_status', 'Zapisano produkt.');

            if (! $this->isEditMode) {
                $this->reset();
            } else {
                $this->new_category_name = null;
                $this->new_brand_name = null;
                $this->product_image = null;
                $this->loadProductData();
            }
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (\Throwable $exception) {
            report($exception);
            $this->addError('db_error', 'Nie udało się zapisać produktu. Spróbuj ponownie.');
        }
    }

    public function render()
    {
        $this->ensureAdmin();

        return view('livewire.admin.product-form', [
            'categories' => DB::table('categories')->get(),
            'brands' => DB::table('brands')->orderBy('name')->get(),
        ]);
    }

    private function ensureAdmin(): void
    {
        abort_unless((bool) auth()->user()?->is_Admin, 403);
    }

    private function safeImageName(string $source): string
    {
        $safeName = preg_replace('/\.jpg$/i', '', Str::ascii($source));
        $safeName = preg_replace('/[^A-Za-z0-9._()-]+/', '_', $safeName);
        $safeName = substr(trim($safeName, '._-'), 0, 180);

        if ($safeName === '') {
            throw ValidationException::withMessages([
                'file_name_input' => 'Nazwa pliku nie zawiera dozwolonych znaków.',
            ]);
        }

        return $safeName;
    }

    private function resolveCategoryId(): int
    {
        if (filled($this->new_category_name)) {
            $name = $this->normalizedName($this->new_category_name, 'new_category_name');

            return (int) (DB::table('categories')
                ->whereRaw('lower(name) = ?', [Str::lower($name)])
                ->value('id') ?? DB::table('categories')->insertGetId([
                    'name' => $name,
                    'parrent_id' => null,
                ]));
        }

        return (int) $this->category_id;
    }

    private function resolveBrandId(): int
    {
        if (filled($this->new_brand_name)) {
            $name = $this->normalizedName($this->new_brand_name, 'new_brand_name');

            return (int) (DB::table('brands')
                ->whereRaw('lower(name) = ?', [Str::lower($name)])
                ->value('id') ?? DB::table('brands')->insertGetId([
                    'name' => $name,
                ]));
        }

        return (int) $this->brand_id;
    }

    private function normalizedName(string $name, string $field): string
    {
        $name = preg_replace('/\s+/', ' ', trim($name));

        if ($name === '') {
            throw ValidationException::withMessages([
                $field => 'Nazwa nie moze byc pusta.',
            ]);
        }

        return $name;
    }

    private function imageExtension(): string
    {
        if ($this->product_image instanceof TemporaryUploadedFile) {
            $extension = Str::lower($this->product_image->getClientOriginalExtension());

            return $extension === 'jpeg' ? 'jpg' : $extension;
        }

        if ($this->isEditMode && $this->productId) {
            $currentImage = DB::table('products')->where('id', $this->productId)->value('image_url');
            $extension = Str::lower(pathinfo((string) $currentImage, PATHINFO_EXTENSION));

            if (in_array($extension, ['jpg', 'jpeg', 'png', 'webp'], true)) {
                return $extension === 'jpeg' ? 'jpg' : $extension;
            }
        }

        return 'jpg';
    }

    private function storeProductImage(TemporaryUploadedFile $image, string $folder, string $fileName): void
    {
        $targetDirectory = public_path('images/products/' . $folder);

        File::ensureDirectoryExists($targetDirectory);
        $storedPath = $image->storeAs('images/products/' . $folder, $fileName, [
            'disk' => 'public_root',
        ]);

        if ($storedPath === false) {
            throw ValidationException::withMessages([
                'product_image' => 'Nie udalo sie zapisac zdjecia produktu.',
            ]);
        }
    }

    private function categoryFolder(int $categoryId): string
    {
        return match ($categoryId) {
            1 => 'cpu',
            2 => 'gpu',
            3 => 'motherboard',
            4 => 'ram',
            5 => 'storage',
            6 => 'psu',
            7 => 'case',
            8 => 'mouse',
            9 => 'keyboard',
            10 => 'headphones',
            11 => 'speakers',
            12 => 'cooler',
            13 => 'network',
            14 => 'monitor',
            default => 'others',
        };
    }
}
