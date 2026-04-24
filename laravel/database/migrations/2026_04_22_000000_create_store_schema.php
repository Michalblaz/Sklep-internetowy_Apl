<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

return new class extends Migration
{
    public function up(): void
    {
       $sqlPath = database_path('seeders/sql/store_schema.sql');

    if (!File::exists($sqlPath)) {
        throw new \Exception("Plik SQL nie istnieje: {$sqlPath}");
    }
        
       
            $sql = File::get($sqlPath);
            DB::unprepared($sql);
        
    }

    public function down(): void
    {
        DB::unprepared(<<<'SQL'
DROP TABLE IF EXISTS public.bans;
DROP TABLE IF EXISTS public.wishlist_items;
DROP TABLE IF EXISTS public.wishlists;
DROP TABLE IF EXISTS public.reviews;
DROP TABLE IF EXISTS public.product_attributes;
DROP TABLE IF EXISTS public.order_items;
DROP TABLE IF EXISTS public.complaints;
DROP TABLE IF EXISTS public.orders;
DROP TABLE IF EXISTS public.category_attributes;
DROP TABLE IF EXISTS public.cart_items;
DROP TABLE IF EXISTS public.addresses;
DROP TABLE IF EXISTS public.products;
DROP TABLE IF EXISTS public.attribute_values;
DROP TABLE IF EXISTS public.attribute_category;
DROP TABLE IF EXISTS public.shipping_methods;
DROP TABLE IF EXISTS public.brands;
DROP TABLE IF EXISTS public.categories;
DROP TABLE IF EXISTS public.users;
SQL);
    }
};
