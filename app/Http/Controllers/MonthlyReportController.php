<?php

namespace App\Http\Controllers;

use App\Models\MonthlyReport;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MonthlyReportController extends Controller
{
    public function index()
    {
        return view('dashboard.laporan.index', [
            'reports' => MonthlyReport::with('product')
                ->where('user_id', Auth::guard('siswa')->id())
                ->latest('report_date')
                ->get(),
        ]);
    }

    public function create()
    {
        return view('dashboard.laporan.create', [
            'products' => $this->ownProducts()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request, fileRequired: true);

        $validated['user_id'] = Auth::guard('siswa')->id();
        $validated['file_path'] = $request->file('file')->store('uploads', 'public');
        $validated['status'] = MonthlyReport::STATUS_PENDING;

        MonthlyReport::create($validated);

        return redirect()->route('dashboard.laporan.index')->with('success', 'Laporan berhasil dibuat.');
    }

    public function edit($id)
    {
        return view('dashboard.laporan.edit', [
            'report' => $this->ownReport($id),
            'products' => $this->ownProducts()->get(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $report = $this->ownReport($id);
        $validated = $this->validated($request, fileRequired: false);

        if ($request->hasFile('file')) {
            $old = $report->file_path;
            $validated['file_path'] = $request->file('file')->store('reports', 'public');

            if ($old) {
                Storage::disk('public')->delete($old);
            }
        }

        // Mengubah angka setelah disetujui harus mengembalikan laporan ke
        // antrean review; dulu status persetujuan tetap melekat.
        if ($report->status !== MonthlyReport::STATUS_PENDING) {
            $validated['status'] = MonthlyReport::STATUS_PENDING;
        }

        $report->update($validated);

        return redirect()->route('dashboard.laporan.index')
            ->with('success', 'Laporan bulanan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $report = $this->ownReport($id);

        if ($report->file_path) {
            Storage::disk('public')->delete($report->file_path);
        }

        $report->delete();

        return redirect()->route('dashboard.laporan.index')
            ->with('success', 'Laporan bulanan berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request, bool $fileRequired): array
    {
        return $request->validate([
            // `exists` saja tidak cukup: produk harus milik siswa ini, kalau
            // tidak laporan bisa dilampirkan ke produk tim lain.
            'product_id' => ['required', 'integer', $this->ownProductRule()],
            'total_sales' => ['required', 'integer', 'min:0'],
            'revenue' => ['required', 'numeric', 'min:0'],
            'spending' => ['required', 'numeric', 'min:0'],
            'report_date' => ['required', 'date'],
            'file' => [$fileRequired ? 'required' : 'nullable', 'file', 'mimes:pdf', 'max:2048'],
        ]);
    }

    private function ownProductRule(): \Illuminate\Validation\Rules\Exists
    {
        return \Illuminate\Validation\Rule::exists('product', 'id')
            ->where('id_ceo', Auth::guard('siswa')->id());
    }

    private function ownProducts()
    {
        return Product::where('id_ceo', Auth::guard('siswa')->id());
    }

    /**
     * Laporan milik siswa yang login — sebelumnya findOrFail($id) tanpa
     * pembatasan, sehingga laporan tim lain bisa dibuka, diubah dan dihapus.
     */
    private function ownReport($id): MonthlyReport
    {
        return MonthlyReport::whereKey($id)
            ->where('user_id', Auth::guard('siswa')->id())
            ->firstOrFail();
    }
}
