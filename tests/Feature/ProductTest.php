<?php

namespace Tests\Feature;

use App\Models\Price;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    private $BASE_URL = '/api/v1/products';

    /**
     * Undocumented function
     *
     * @return void
     */
    public function test_create_product(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')
                        ->postJson($this->BASE_URL, [
                            'designation' => fake()->domainWord(),
                            'lower_limit' => 1,
                            'stock' => 10,
                            'price' => 100
                        ]);

        $response->assertStatus(201)
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('data.price.unit_price_excl', 100)
                    ->where('data.price.unit_price_incl', 118)
                    ->etc()
            );
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function test_list_product(): void
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
    public function test_find_a_product_by_id(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $product = Product::factory()->create();
        $product->prices()->save(new Price(['unit_price_excl' => 100]));

        $response = $this->get(path_build($this->BASE_URL, $product->id));

        $response->assertStatus(200)
                ->assertJsonPath('data.id', $product->id)
                ->assertJsonPath('data.designation', $product->designation)
                ->assertJsonPath('data.slug', $product->slug)
                ->assertJsonPath('data.price.unit_price_excl', 100)
                ->assertJsonPath('data.price.unit_price_incl', 118);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function test_update_a_product_by_id(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $product = Product::factory()->create();
        $product->prices()->save(new Price(['unit_price_excl' => 100]));
        $designation = fake()->domainWord();

        $response = $this->actingAs($user, 'api')->putJson(
            path_build($this->BASE_URL, $product->id),
            ['designation' => $designation]
        );

        $response->assertStatus(200)
            ->assertJsonPath('data.id', $product->id)
            ->assertJsonPath('data.designation', $designation)
            ->assertJsonPath('data.slug', sluglify($designation))
            ->assertJsonPath('data.price.unit_price_excl', 100)
            ->assertJsonPath('data.price.unit_price_incl', 118);
    }


    /**
     * Undocumented function
     *
     * @return void
     */
    public function test_update_a_product_price_by_id(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $product = Product::factory()->create();
        $product->prices()->save(new Price(['unit_price_excl' => 100]));

        $this->assertEquals($product->price->unit_price_incl, 118);

        $response = $this->putJson(path_build($this->BASE_URL, $product->id), ['price' => 150]);

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('data.id', $product->id)
                    ->where('data.price.unit_price_excl', 150)
                    ->where('data.price.unit_price_incl', 177)
                    ->etc()
            );

        $product->price->refresh();

        $this->assertFalse($product->price->status);
        $this->assertNotNull($product->price->end_date);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function test_delete_a_product_by_id(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $product = Product::factory()->create();

        $response = $this->actingAs($user, 'api')->deleteJson(path_build($this->BASE_URL, $product->id));

        $response->assertStatus(200);
        $this->assertSoftDeleted($product);
    }

}
