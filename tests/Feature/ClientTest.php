<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\User;
use Database\Seeders\ClientSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use RefreshDatabase;

    private $BASE_URL = '/api/v1/clients';

    /**
     * Undocumented function
     *
     * @return void
     */
    public function test_create_client(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')
                        ->postJson($this->BASE_URL, [
                            'email' => fake()->unique()->safeEmail(),
                            'adresse' => fake()->address(),
                            'last_name' => fake()->lastName(),
                            'first_name' => fake()->firstName(),
                            'phone_number' => fake()->phoneNumber(),
                        ]);

        $response->assertStatus(201);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function test_list_client(): void
    {
        $user = User::factory()->create();

        $this->seed(ClientSeeder::class);

        $response = $this->actingAs($user, 'api')->getJson($this->BASE_URL);

        $response->assertStatus(200)
                ->assertJsonPath('data.data', fn (array $data) => count($data) == 3);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function test_find_a_client_by_id(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();

        $response = $this->actingAs($user, 'api')->get($this->BASE_URL . '/' . $client->id);

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('data.id', $client->id)
                    ->where('data.last_name', $client->last_name)
                    ->where('data.first_name', $client->first_name)
                    ->where('data.phone_number', $client->phone_number)
                    ->where('data.email', fn (string $email) => str($email)->is($client->email))
                    ->etc()
            );
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function test_update_a_client_by_id(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();

        $response = $this->actingAs($user, 'api')
                        ->putJson($this->BASE_URL . '/' . $client->id, [
                            'last_name' => 'Joan'
                        ]);

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('data.id', $client->id)
                    ->where('data.last_name', 'Joan')
                    ->etc()
            );
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function test_delete_a_client_by_id(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();

        $response = $this->actingAs($user, 'api')->deleteJson($this->BASE_URL . '/' . $client->id);

        $response->assertStatus(200);
        $this->assertSoftDeleted($client);

    }

}
