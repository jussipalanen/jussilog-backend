<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductsPaginationTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_list_uses_default_pagination(): void
    {
        Product::factory()->count(25)->create();

        $response = $this->getJson('/api/products');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'links',
            'current_page',
            'per_page',
            'total',
        ]);
        $response->assertJsonPath('per_page', 10);
        $this->assertCount(10, $response->json('data'));
    }

    public function test_products_list_caps_per_page_at_maximum(): void
    {
        Product::factory()->count(150)->create();

        $response = $this->getJson('/api/products?per_page=200');

        $response->assertStatus(200);
        $response->assertJsonPath('per_page', 100);
        $this->assertCount(100, $response->json('data'));
    }

    public function test_products_list_supports_search_by_title_or_description(): void
    {
        Product::factory()->create([
            'title' => 'Desk Lamp',
            'description' => 'Warm light for late nights.',
        ]);
        Product::factory()->create([
            'title' => 'Side Table',
            'description' => 'Desk-friendly surface.',
        ]);
        Product::factory()->create([
            'title' => 'Couch',
            'description' => 'Comfortable seating.',
        ]);

        $response = $this->getJson('/api/products?search=Desk');

        $response->assertStatus(200);
        $this->assertCount(2, $response->json('data'));
        $response->assertJsonFragment(['title' => 'Desk Lamp']);
        $response->assertJsonFragment(['title' => 'Side Table']);
    }
}
