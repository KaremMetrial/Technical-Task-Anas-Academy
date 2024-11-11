<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/products',
            [
                'name' => 'Test Product',
                'price' => 100,
                'quantity' => 10,
                'user_id' => $user->id,
            ]
        );

        $response->assertStatus(200);
        $this->assertDatabaseHas('products', ['name' => 'Test Product']);

    }
}
