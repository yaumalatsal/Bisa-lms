<?php

namespace Tests\Feature;

use App\Models\Siswa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * The contract an external status console polls this app on: /api/health with
 * no auth, /api/monitor/{services,metrics} behind a shared token. Getting any
 * of this wrong either breaks the deploy health check or, worse, leaks
 * business counts to an unauthenticated caller.
 */
class MonitorApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function health_needs_no_token(): void
    {
        $this->get('/api/health')
            ->assertOk()
            ->assertJsonPath('status', 'ok')
            ->assertJsonStructure(['status', 'app', 'time']);
    }

    /** @test */
    public function monitor_routes_refuse_everything_when_no_token_is_configured(): void
    {
        config(['monitor.token' => null]);

        $this->get('/api/monitor/services')
            ->assertStatus(503)
            ->assertJsonPath('error', 'monitoring_disabled');

        $this->get('/api/monitor/metrics')
            ->assertStatus(503)
            ->assertJsonPath('error', 'monitoring_disabled');
    }

    /** @test */
    public function monitor_routes_reject_a_missing_or_wrong_token(): void
    {
        config(['monitor.token' => 'the-real-token']);

        $this->get('/api/monitor/services')->assertStatus(401);

        $this->withHeaders(['X-Monitor-Token' => 'wrong'])
            ->get('/api/monitor/services')
            ->assertStatus(401);

        $this->withHeaders(['Authorization' => 'Bearer wrong'])
            ->get('/api/monitor/metrics')
            ->assertStatus(401);
    }

    /** @test */
    public function the_x_monitor_token_header_is_accepted(): void
    {
        config(['monitor.token' => 'the-real-token']);

        $this->withHeaders(['X-Monitor-Token' => 'the-real-token'])
            ->get('/api/monitor/services')
            ->assertOk()
            ->assertJsonStructure(['status', 'services' => ['database', 'cache', 'queue', 'storage', 'session']]);
    }

    /** @test */
    public function a_bearer_token_is_also_accepted(): void
    {
        config(['monitor.token' => 'the-real-token']);

        $this->withHeaders(['Authorization' => 'Bearer the-real-token'])
            ->get('/api/monitor/metrics')
            ->assertOk()
            ->assertJsonStructure([
                'status',
                'app' => ['name', 'env', 'revision', 'laravel', 'php'],
                'accounts' => ['siswa', 'mentor', 'investor'],
                'business' => ['produk', 'laporan_pending', 'laporan_disetujui', 'laporan_ditolak'],
            ]);
    }

    /** @test */
    public function metrics_reflect_real_counts_not_placeholders(): void
    {
        config(['monitor.token' => 'the-real-token']);

        Siswa::create([
            'nomor_induk' => '999001',
            'password' => bcrypt('x'),
            'tanggal_lahir' => '2003-01-01',
            'nama' => 'Test Siswa',
        ]);

        $this->withHeaders(['X-Monitor-Token' => 'the-real-token'])
            ->get('/api/monitor/metrics')
            ->assertOk()
            ->assertJsonPath('accounts.siswa', 1);
    }

    /** @test */
    public function no_learner_or_business_data_leaves_the_endpoint_by_name(): void
    {
        config(['monitor.token' => 'the-real-token']);

        Siswa::create([
            'nomor_induk' => '999002',
            'password' => bcrypt('x'),
            'tanggal_lahir' => '2003-01-01',
            'nama' => 'Siti Rahasia',
        ]);

        $response = $this->withHeaders(['X-Monitor-Token' => 'the-real-token'])
            ->get('/api/monitor/metrics');

        $response->assertOk();
        $this->assertStringNotContainsString('Siti Rahasia', $response->getContent());
        $this->assertStringNotContainsString('999002', $response->getContent());
    }
}
