<?php

namespace Tests\Feature;

use App\Models\Product;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

use function PHPUnit\Framework\assertContains;
use function PHPUnit\Framework\assertNotNull;

class ProductTest extends TestCase
{
    public function testProduct()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $product = Product::first();

        $this->get("/api/products/$product->id")
            ->assertStatus(200)
            ->assertHeader('Author', 'thariq')
            ->assertJson([
                'value' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'category' => [
                        'id' => $product->category->id,
                        'name' => $product->category->name,
                    ],
                    'category_id' => $product->category_id,
                    'price' => $product->price,
                    'created_at' => $product->created_at->toJSON(),
                    'updated_at' => $product->updated_at->toJSON(),
                ]
            ]);
    }

    public function testProductCollection()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $response = $this->get("/api/products")
            ->assertStatus(200)
            ->assertHeader('Author', 'thariq');

        Log::info($response->json());
        
        // decoding json
        $names = $response->json('data.*.name');
        for ($i=1; $i <= 5 ; $i++) { 
            assertContains("product $i of Food", $names);
        }
        for ($i=1; $i <= 5 ; $i++) { 
            assertContains("product $i of Gadget", $names);
        }    
    }

    public function testProductsPaging()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $response = $this->get("/api/products-paging")
            ->assertStatus(200);

        assertNotNull($response->json('data'));
        assertNotNull($response->json('links'));
        assertNotNull($response->json('meta'));
    }

    public function testProductsAdditional()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

            $product = Product::first();

        $response = $this->get("/api/products-additional")
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                ],
                'author' => 'thariq'
            ]);

        assertNotNull($response->json('server_time'));
    }
}
