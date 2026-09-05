<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use App\Models\MonthlyReport;
use App\Models\Product;
use App\Support\LegacyPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class MentorController extends Controller
{
    public function index()
    {
        return view('mentor.page.dashboard', [
            'mentor' => Auth::guard('mentor')->user(),
        ]);
    }

    public function login()
    {
        return view('mentor.page.login');
    }

    /**
     * Laporan bulanan milik produk-produk yang dibimbing mentor ini.
     */
    public function laporanNilai()
    {
        $monthlyReports = MonthlyReport::with('product')
            ->whereIn('product_id', Product::where('id_mentor', Auth::guard('mentor')->id())->select('id'))
            ->latest('report_date')
            ->get();

        return view('mentor.page.laporan_produk', compact('monthlyReports'));
    }

    public function approveReport($id)
    {
        $this->reportForThisMentor($id)->update(['status' => MonthlyReport::STATUS_APPROVED]);

        return redirect()->back()->with('success', 'Laporan berhasil disetujui.');
    }

    public function rejectReport($id)
    {
        $this->reportForThisMentor($id)->update(['status' => MonthlyReport::STATUS_REJECTED]);

        return redirect()->back()->with('error', 'Laporan telah ditolak.');
    }

    /**
     * Login mentor. Hash md5 lama tetap diterima lalu di-upgrade ke bcrypt.
     */
    public function signin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $mentor = Mentor::where('email', $credentials['email'])->first();

        if (! $mentor || ! LegacyPassword::check(
            $credentials['password'],
            $mentor->getAuthPassword(),
            LegacyPassword::SCHEME_MENTOR
        )) {
            throw ValidationException::withMessages([
                'email' => 'Maaf, login gagal. Periksa kembali email dan password Anda.',
            ]);
        }

        if (LegacyPassword::needsRehash($mentor->getAuthPassword())) {
            $mentor->forceFill(['password' => Hash::make($credentials['password'])])->save();
        }

        Auth::guard('mentor')->login($mentor);
        $request->session()->regenerate();
        $request->session()->put('id_mentor', $mentor->id);

        return redirect('/mentor');
    }

    public function logout(Request $request)
    {
        Auth::guard('mentor')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/mentor/login');
    }

    /**
     * Ambil laporan hanya jika produknya dibimbing oleh mentor yang login.
     */
    private function reportForThisMentor($id): MonthlyReport
    {
        return MonthlyReport::whereKey($id)
            ->whereIn('product_id', Product::where('id_mentor', Auth::guard('mentor')->id())->select('id'))
            ->firstOrFail();
    }
}
