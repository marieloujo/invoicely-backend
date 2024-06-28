<?php

namespace Tests\Feature;

use App\Models\Price;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    use RefreshDatabase;

    private $BASE_URL = '/api/v1/services';

    /**
     * Undocumented function
     *
     * @return void
     */
    public function test_create_service(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')
                        ->postJson($this->BASE_URL, [
                            'designation' => fake()->domainWord(),
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
    public function test_list_service(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        Service::factory(3)->create();

        $response = $this->getJson($this->BASE_URL);
        
        $response->assertStatus(200)
                ->assertJsonPath('data.data', fn (array $data) => count($data) == 3);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function test_find_a_service_by_id(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $service = Service::factory()->create();
        $service->prices()->save(new Price(['unit_price_excl' => 100]));

        $response = $this->get(path_build($this->BASE_URL, $service->id));

        $response->assertStatus(200)
                ->assertJsonPath('data.id', $service->id)
                ->assertJsonPath('data.designation', $service->designation)
                ->assertJsonPath('data.slug', $service->slug)
                ->assertJsonPath('data.price.unit_price_excl', 100)
                ->assertJsonPath('data.price.unit_price_incl', 118);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function test_update_a_service_by_id(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $service = Service::factory()->create();
        $service->prices()->save(new Price(['unit_price_excl' => 100]));
        $designation = fake()->domainWord();

        $response = $this->actingAs($user, 'api')->putJson(
            path_build($this->BASE_URL, $service->id),
            ['designation' => $designation]
        );

        $response->assertStatus(200)
            ->assertJsonPath('data.id', $service->id)
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
    public function test_update_a_service_price_by_id(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $service = Service::factory()->create();
        $service->prices()->save(new Price(['unit_price_excl' => 100]));

        $this->assertEquals($service->price->unit_price_incl, 118);

        $response = $this->putJson(path_build($this->BASE_URL, $service->id), ['price' => 150]);

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('data.id', $service->id)
                    ->where('data.price.unit_price_excl', 150)
                    ->where('data.price.unit_price_incl', 177)
                    ->etc()
            );

        $service->price->refresh();

        $this->assertFalse($service->price->status);
        $this->assertNotNull($service->price->end_date);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function test_delete_a_service_by_id(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $service = Service::factory()->create();

        $response = $this->actingAs($user, 'api')->deleteJson(path_build($this->BASE_URL, $service->id));

        $response->assertStatus(200);
        $this->assertSoftDeleted($service);
    }

}
