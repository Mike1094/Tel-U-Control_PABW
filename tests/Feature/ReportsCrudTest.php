<?php

namespace Tests\Feature;

use App\Models\Report;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportsCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_report_create_and_delete_flow()
    {
        // create a verified user
        $user = User::factory()->create(['email_verified_at' => now()]);

        $this->actingAs($user);

        // create report
        $response = $this->post('/reports', [
            'title' => 'Test Laporan',
            'description' => 'Deskripsi test',
            'location' => 'Lokasi Test',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('reports', [
            'title' => 'Test Laporan',
            'user_id' => $user->id,
        ]);

        $report = Report::where('title', 'Test Laporan')->first();
        $this->assertNotNull($report);

        // delete report
        $del = $this->delete(route('reports.destroy', $report));
        $del->assertStatus(302);

        $this->assertDatabaseMissing('reports', [
            'id' => $report->id,
        ]);
    }
}
