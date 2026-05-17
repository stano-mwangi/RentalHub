<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PropertyManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_property_listings()
    {
        $property = Property::factory()->create();

        $response = $this->get(route('properties.index'));

        $response->assertStatus(200);
        $response->assertSee($property->title);
    }

    public function test_guest_can_view_property_details()
    {
        $property = Property::factory()->create();

        $response = $this->get(route('properties.show', $property));

        $response->assertStatus(200);
        $response->assertSee($property->title);
        $response->assertSee('Contact the team');
    }

    public function test_non_admin_cannot_create_property()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('properties.store'), []);

        $response->assertStatus(403);
    }

    public function test_admin_can_create_property()
    {
        Storage::fake('public');
        $user = User::factory()->create(['is_admin' => true]);
        $this->actingAs($user);

        $data = [
            'title' => 'Test Property',
            'description' => 'A nice place',
            'address' => '123 Main St',
            'price' => 1234.56,
            'status' => 'vacant',
            'latitude' => 1.2345678,
            'longitude' => 2.3456789,
            'image' => UploadedFile::fake()->image('photo.jpg'),
        ];

        $response = $this->post(route('properties.store'), $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('properties', [
            'title' => 'Test Property',
            'user_id' => $user->id,
        ]);
    }

    public function test_non_admin_cannot_update_property()
    {
        $user = User::factory()->create();
        $property = Property::factory()->create();
        $this->actingAs($user);

        $response = $this->put(route('properties.update', $property), [
            'title' => 'Updated Title',
            'description' => $property->description,
            'address' => $property->address,
            'price' => $property->price,
            'status' => $property->status,
            'latitude' => $property->latitude,
            'longitude' => $property->longitude,
        ]);

        $response->assertStatus(403);
    }

    public function test_admin_can_update_property()
    {
        $user = User::factory()->create(['is_admin' => true]);
        $property = Property::factory()->create();
        $this->actingAs($user);

        $response = $this->put(route('properties.update', $property), [
            'title' => 'Updated Title',
            'description' => $property->description,
            'address' => $property->address,
            'price' => $property->price,
            'status' => $property->status,
            'latitude' => $property->latitude,
            'longitude' => $property->longitude,
        ]);

        $response->assertRedirect(route('properties.show', $property));
        $this->assertDatabaseHas('properties', [
            'id' => $property->id,
            'title' => 'Updated Title',
        ]);
    }

    public function test_non_admin_cannot_delete_property()
    {
        $user = User::factory()->create();
        $property = Property::factory()->create();
        $this->actingAs($user);

        $response = $this->delete(route('properties.destroy', $property));

        $response->assertStatus(403);
    }

    public function test_admin_can_delete_property()
    {
        $user = User::factory()->create(['is_admin' => true]);
        $property = Property::factory()->create();
        $this->actingAs($user);

        $response = $this->delete(route('properties.destroy', $property));

        $response->assertRedirect(route('properties.index'));
        $this->assertDatabaseMissing('properties', [
            'id' => $property->id,
        ]);
    }
}
