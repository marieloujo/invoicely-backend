<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class SupplyTest extends TestCase
{

    private $BASE_URL = '/api/v1/suplies';

    /**
     * Undocumented function
     *
     * @return void
     */
    public function test_create_supply(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $product = Product::factory()->create();
        $stock = $product->stock;

        $response = $this->actingAs($user, 'api')
                        ->postJson($this->BASE_URL, [
                            'products' => [
                                'id' => $product->id,
                                'quantity' => 10,
                            ]
                        ]);

        $response->assertStatus(201);

        $product->refresh();

        $this->assertEquals($product->stock - 10, $stock);
        $this->assertEquals($product->transactions()->count(), 1);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function test_list_supply(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        Product::factory(3)->create();

        $response = $this->getJson($this->BASE_URL);
        
        $response->assertStatus(200)
                ->assertJsonPath('data.data', fn (array $data) => count($data) == 3);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function test_find_a_supply_by_id(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $supply = Product::factory()->create();
        $supply->prices()->save(new Price(['unit_price_excl' => 100]));

        $response = $this->get(path_build($this->BASE_URL, $supply->id));

        $response->assertStatus(200)
                ->assertJsonPath('data.id', $supply->id)
                ->assertJsonPath('data.designation', $supply->designation)
                ->assertJsonPath('data.slug', $supply->slug)
                ->assertJsonPath('data.price.unit_price_excl', 100)
                ->assertJsonPath('data.price.unit_price_incl', 118);
    }

}
