<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class CategoryTableSeeder extends Seeder
{
    public function run(): void
    {
        $categoryTree = [
            ['slug' => 'clothing', 'name' => 'Clothing', 'parent' => null],
            ['slug' => 'electronics', 'name' => 'Electronics', 'parent' => null],
            ['slug' => 'appliances', 'name' => 'Appliances', 'parent' => null],

            ['slug' => 'men', 'name' => 'Men', 'parent' => 'clothing'],
            ['slug' => 'women', 'name' => 'Women', 'parent' => 'clothing'],
            ['slug' => 'kids', 'name' => 'Kids', 'parent' => 'clothing'],
        ];

        $slugToId = [];

        foreach ($categoryTree as $item) {
            $parentId = $item['parent'] ? ($slugToId[$item['parent']] ?? null) : null;

            $category = Category::firstOrCreate(
                ['url' => $item['slug']],
                [
                    'parent_id' => $parentId,
                    'name' => $item['name'],
                    'image' => '',
                    'size_chart' => '',
                    'discount' => 0,
                    'description' => '',
                    'meta_title' => '',
                    'meta_description' => '',
                    'meta_keywords' => '',
                    'menu_status' => true,
                    'status' => true,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );

            $slugToId[$item['slug']] = $category->id;
        }
    }
}
