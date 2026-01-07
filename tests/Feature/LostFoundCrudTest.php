<?php

namespace Tests\Feature;

use App\Models\LostFoundItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LostFoundCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_lost_found_create_update_and_delete_flow()
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $this->actingAs($user);

        // create lost-found item
        $resp = $this->post('/lost-found', [
            'item_name' => 'Kunci Test',
            'type' => 'lost',
            'description' => 'Kunci hilang di test',
            'location' => 'Gerbang A',
        ]);

        $resp->assertStatus(302);

        $this->assertDatabaseHas('lost_found_items', [
            'item_name' => 'Kunci Test',
            'user_id' => $user->id,
        ]);

        $item = LostFoundItem::where('item_name', 'Kunci Test')->first();
        $this->assertNotNull($item);

        // update (mark resolved) via PUT
        $put = $this->put(route('lost-found.update', $item));
        $put->assertStatus(302);

        $this->assertDatabaseHas('lost_found_items', [
            'id' => $item->id,
            'status' => 'resolved',
        ]);

        // delete
        $del = $this->delete(route('lost-found.destroy', $item));
        $del->assertStatus(302);

        $this->assertDatabaseMissing('lost_found_items', [
            'id' => $item->id,
        ]);
    }
}
