<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Investor;
use App\Models\Mentor;
use App\Models\MonthlyReport;
use App\Models\Product;
use App\Models\Siswa;
use App\Support\ServiceHealth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;

/**
 * `/api/health` is unauthenticated and cheap — it exists so a load balancer or
 * a deploy step can tell "container answers HTTP" from "container is up but
 * the app inside it is broken", without needing a secret.
 *
 * `/api/monitor/*` needs the token and carries the detail: per-service status
 * and business metrics. Still no learner or business data leaves this
 * endpoint beyond counts — a monitor sees "88 produk", never a name.
 */
class MonitorController extends Controller
{
    public function __construct(private ServiceHealth $health) {}

    public function health(): JsonResponse
    {
        $healthy = $this->health->allHealthy();

        return response()->json([
            'status' => $healthy ? 'ok' : 'degraded',
            'app' => config('app.name'),
            'time' => now()->toIso8601String(),
        ], $healthy ? 200 : 503);
    }

    public function services(): JsonResponse
    {
        $checks = $this->health->checks();
        $healthy = ! collect($checks)->contains(fn ($c) => ($c['status'] ?? 'down') !== 'ok');

        return response()->json([
            'status' => $healthy ? 'ok' : 'degraded',
            'services' => $checks,
        ]);
    }

    public function metrics(): JsonResponse
    {
        return response()->json([
            'status' => 'ok',
            'app' => [
                'name' => config('app.name'),
                'env' => config('app.env'),
                'revision' => ServiceHealth::deployedRevision(),
                'laravel' => App::version(),
                'php' => PHP_VERSION,
            ],
            'accounts' => [
                'siswa' => Siswa::count(),
                'mentor' => Mentor::count(),
                'investor' => Investor::count(),
            ],
            'business' => [
                'produk' => Product::count(),
                'laporan_pending' => MonthlyReport::where('status', MonthlyReport::STATUS_PENDING)->count(),
                'laporan_disetujui' => MonthlyReport::where('status', MonthlyReport::STATUS_APPROVED)->count(),
                'laporan_ditolak' => MonthlyReport::where('status', MonthlyReport::STATUS_REJECTED)->count(),
            ],
        ]);
    }
}
