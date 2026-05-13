<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductForm extends Component
{
    public $productId = null;
    public $isEditMode = false;

    public $name;
    public $category_id;
    public $brand_id;
    public $base_price;
    public $promo_price;
    public $is_promo = false;
    public $stock_quantity = 0;
    public $file_name_input;

    public $availableAttributes = [];
    public $attributeValues = [];

    public $categoryFolderMap = [
        1 => 'cpu', 2 => 'gpu', 3 => 'motherboard', 4 => 'ram', 5 => 'storage',
        6 => 'psu', 7 => 'case', 8 => 'mouse', 9 => 'keyboard', 10 => 'headphones',
        11 => 'speakers', 12 => 'cooler', 13 => 'network', 14 => 'monitor'
    ];

    public function mount($productId = null)
    {
        if ($productId && is_numeric($productId)) {
            $this->productId = $productId;
            $this->isEditMode = true;
            $this->loadProductData();
        }
    }

    public function loadProductData()
    {
        $product = DB::table('products')->where('id', $this->productId)->first();
        if ($product) {
            $this->name = $product->name;
            $this->category_id = $product->category_id;
            $this->brand_id = $product->brand_id;
            $this->base_price = $product->base_price;
            $this->promo_price = $product->promo_price;
            $this->is_promo = !empty($product->promo_price);
            $this->stock_quantity = $product->stock_quantity;
            $this->file_name_input = basename($product->image_url, '.jpg');

            $this->updatedCategoryId($this->category_id);

            // Pobieramy wartości tekstowe
            $this->attributeValues = DB::table('product_attributes')
                ->join('attribute_values', 'product_attributes.attribute_value_id', '=', 'attribute_values.id')
                ->where('product_id', $this->productId)
                ->pluck('attribute_values.value', 'product_attributes.attribute_category_id')
                ->mapWithKeys(fn($val, $key) => [(string)$key => (string)$val])
                ->toArray();
        }
    }

    public function updatedCategoryId($value)
    {
        $this->attributeValues = [];
        if (!$value) {
            $this->availableAttributes = [];
            return;
        }

        $this->availableAttributes = DB::table('category_attributes')
            ->join('attribute_category', 'category_attributes.attribute_id', '=', 'attribute_category.id')
            ->where('category_attributes.category_id', $value)
            ->select('attribute_category.id', 'attribute_category.name')
            ->get()
            ->map(function ($attr) {
                $attr->values = DB::table('attribute_values')
                    ->where('attribute_category_id', $attr->id)
                    ->pluck('value')
                    ->toArray();
                return $attr;
            });
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|min:3',
            'category_id' => 'required',
            'brand_id' => 'required',
            'base_price' => 'required|numeric',
        ]);

        try {
            DB::transaction(function () {
                $folder = $this->categoryFolderMap[$this->category_id] ?? 'others';
                $inputSource = $this->file_name_input ?: $this->name;
                $safeName = str_replace(' ', '_', $inputSource);
                $safeName = preg_replace('/\.jpg$/i', '', $safeName);
                $finalFileName = $safeName . '.jpg';

                $imageUrl = "products/{$folder}/{$finalFileName}";

                $data = [
                    'category_id' => (int) $this->category_id,
                    'brand_id' => (int) $this->brand_id,
                    'name' => $this->name,
                    'base_price' => (float) $this->base_price,
                    'promo_price' => $this->is_promo ? (float) $this->promo_price : null,
                    'stock_quantity' => (int) ($this->stock_quantity ?: 0),
                    'image_url' => $imageUrl,
                    'power_draw_w' => 0,
                ];

                if ($this->isEditMode) {
                    DB::table('products')->where('id', $this->productId)->update($data);
                    DB::table('product_attributes')->where('product_id', $this->productId)->delete();
                    $currentId = $this->productId;
                } else {
                    $currentId = DB::table('products')->insertGetId($data);
                }

                foreach ($this->attributeValues as $attrId => $userValue) {
                    if (!empty($userValue)) {

                        $valRecord = DB::table('attribute_values')
                            ->where('attribute_category_id', $attrId)
                            ->where('value', $userValue)
                            ->first();

                        if (!$valRecord) {
                            $valId = DB::table('attribute_values')->insertGetId([
                                'attribute_category_id' => (int)$attrId,
                                'value' => $userValue
                            ]);
                        } else {
                            $valId = $valRecord->id;
                        }

                        DB::table('product_attributes')->insert([
                            'product_id' => $currentId,
                            'attribute_category_id' => (int) $attrId,
                            'attribute_value_id' => $valId
                        ]);
                    }
                }
            });

            session()->flash('admin_status', '✅ Zapisano pomyślnie!');
            if(!$this->isEditMode) $this->reset();

        } catch (\Exception $e) {
            $this->addError('db_error', 'Błąd: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.product-form', [
            'categories' => DB::table('categories')->get(),
            'brands' => DB::table('brands')->orderBy('name')->get(),
        ]);
    }
}
