<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Support\LegacyPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class SiswaController extends Controller
{
    /**
     * Pendaftaran siswa baru.
     */
    public function register_siswa(Request $request)
    {
        $validated = $request->validate([
            'nama_siswa' => ['required', 'string', 'max:255'],
            'nis' => ['required', 'string', 'max:50', 'unique:siswa,nomor_induk'],
            'password' => ['required', 'string', 'min:8'],
            'ttl' => ['required', 'date'],
        ], [
            'nis.unique' => 'Maaf, NIS sudah terdaftar, silakan hubungi Guru Pendamping.',
        ]);

        Siswa::create([
            'nama' => $validated['nama_siswa'],
            'nomor_induk' => $validated['nis'],
            'password' => Hash::make($validated['password']),
            'tanggal_lahir' => $validated['ttl'],
        ]);

        return redirect('/login')->with('status', 'Pendaftaran berhasil, silakan melakukan login.');
    }

    public function logout(Request $request)
    {
        Auth::guard('siswa')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    /**
     * Login siswa. Menerima hash lama (md5+sha1) lalu meng-upgrade-nya ke
     * bcrypt secara transparan pada login pertama yang berhasil.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nis' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $siswa = Siswa::where('nomor_induk', $credentials['nis'])->first();

        if (! $siswa || ! LegacyPassword::check(
            $credentials['password'],
            $siswa->getAuthPassword(),
            LegacyPassword::SCHEME_SISWA
        )) {
            throw ValidationException::withMessages([
                'nis' => 'Maaf, login gagal. Periksa kembali NIS dan password Anda.',
            ]);
        }

        if (LegacyPassword::needsRehash($siswa->getAuthPassword())) {
            $siswa->forceFill(['password' => Hash::make($credentials['password'])])->save();
        }

        Auth::guard('siswa')->login($siswa);
        $request->session()->regenerate();

        return $this->afterLoginRedirect($request, $siswa);
    }

    /**
     * Seed the legacy session keys the dashboard still relies on, then send the
     * siswa to the step they left off at.
     */
    private function afterLoginRedirect(Request $request, Siswa $siswa)
    {
        $request->session()->put([
            'id_siswa' => $siswa->id,
            'nis_siswa' => $siswa->nomor_induk,
        ]);

        $tim = DB::table('member')
            ->select('member.position', 'member.id_produk', 'master_step.step_number', 'track_step.status')
            ->join('product', 'product.id', '=', 'member.id_produk')
            ->join('track_step', 'track_step.id_ceo', '=', 'product.id_ceo')
            ->join('master_step', 'master_step.id', '=', 'track_step.id_step')
            ->where('member.id_siswa', $siswa->id)
            ->latest('member.id')
            ->first();

        if (! $tim) {
            $request->session()->put(['track' => '1', 'track_status' => '0']);

            return redirect('/product_abstract');
        }

        $request->session()->put([
            'track' => $tim->step_number,
            'track_status' => $tim->status,
            'id_produk' => $tim->id_produk,
        ]);

        // Hanya CEO (position 1) yang diarahkan langsung ke tahap berjalan.
        if ((int) $tim->position !== 1) {
            return redirect('/');
        }

        $track = DB::table('track_step')
            ->select('master_step.step_number as urutan', 'master_step.route as routing', 'track_step.status')
            ->join('master_step', 'master_step.id', '=', 'track_step.id_step')
            ->where('track_step.id_ceo', $siswa->id)
            ->latest('track_step.id')
            ->first();

        if ($track && $track->urutan <= 2 && (int) $track->status === 0 && $track->routing) {
            return redirect($track->routing);
        }

        return redirect('/');
    }

    /**
     * Cari siswa berdasarkan NIS untuk ditambahkan ke tim.
     */
    public function searchByNis(Request $request)
    {
        $request->validate([
            'nis' => ['required', 'string'],
            'id_produk' => ['required', 'integer'],
        ]);

        $idSiswa = Auth::guard('siswa')->id();
        $nisSendiri = $request->session()->get('nis_siswa');

        // Pastikan pencari terdaftar sebagai CEO pada produknya sendiri.
        $isOwner = DB::table('product')
            ->where('id', $request->id_produk)
            ->where('id_ceo', $idSiswa)
            ->exists();

        if (! $isOwner) {
            return redirect('/tahap_team')->with('status', 'Anda bukan CEO dari produk ini.');
        }

        DB::table('member')->updateOrInsert(
            ['id_siswa' => $idSiswa, 'id_produk' => $request->id_produk],
            ['position' => '1']
        );

        if ($nisSendiri == $request->nis) {
            return redirect('/tahap_team')->with('status', 'Maaf itu NIS anda sendiri');
        }

        $kandidat = DB::table('siswa')->where('nomor_induk', $request->nis)->first();

        if (! $kandidat) {
            return redirect('/tahap_team')->with('status', 'NIS tidak ditemukan');
        }

        $sudahBergabung = DB::table('member')->where('id_siswa', $kandidat->id)->exists();

        if ($sudahBergabung) {
            return redirect('/tahap_team')
                ->with('status', 'Siswa dengan NIS tersebut sudah menjadi anggota di suatu tim');
        }

        return redirect('/tahap_team')->with(['data_member' => collect([$kandidat])]);
    }
}
