<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\ArtikelInkubasi;
use App\Models\Member;
use Illuminate\Support\Facades\Log;
use App\Models\MasterBMC;
use App\Models\PertanyaanBMC;

class AdminController extends Controller
{
    public function kelolaSoal($id)
    {
        $bmc = MasterBMC::findOrFail($id);
        $soals = PertanyaanBMC::where('id_poin_bmc', $id)->get();
        return view('admin.bmc.soal.index', compact('bmc', 'soals'));
    }

    // Menampilkan form untuk menambah soal
    public function soalCreate($id)
    {
        $bmc = MasterBMC::findOrFail($id);
        return view('admin.bmc.soal.create', compact('bmc'));
    }

    // Menyimpan soal baru ke database
    public function soalStore(Request $request, $id)
    {
        $request->validate([
            'pertanyaan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        PertanyaanBMC::create([
            'pertanyaan' => $request->pertanyaan,
            'keterangan' => $request->keterangan,
            'id_poin_bmc' => $id,
        ]);

        return redirect()->route('admin.bmc.soal.index', $id)->with('success', 'Soal berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit soal
    public function soalEdit($id, $soalId)
    {
        $bmc = MasterBMC::findOrFail($id);
        $soal = PertanyaanBMC::findOrFail($soalId);
        return view('admin.bmc.soal.edit', compact('bmc', 'soal'));
    }

    // Memperbarui soal di database
    public function soalUpdate(Request $request, $id, $soalId)
    {
        $request->validate([
            'pertanyaan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $soal = PertanyaanBMC::findOrFail($soalId);
        $soal->update([
            'pertanyaan' => $request->pertanyaan,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('admin.bmc.soal.index', $id)->with('success', 'Soal berhasil diperbarui.');
    }

    // Menghapus soal dari database
    public function soalDestroy($id, $soalId)
    {
        $soal = PertanyaanBMC::findOrFail($soalId);
        $soal->delete();

        return redirect()->route('admin.bmc.soal.index', $id)->with('success', 'Soal berhasil dihapus.');
    }
    
    public function bmc()
    {
        $bmcs = MasterBMC::all(); // Mengambil semua data BMC dari database
        return view('admin.bmc.index', compact('bmcs'));
    }

    public function bmcCreate()
    {
        return view('admin.bmc.create');
    }

    // Menyimpan BMC baru ke database
    public function bmcStore(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'route' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
            'video' => 'nullable|string|max:255',
        ]);

        MasterBMC::create($request->all());

        return redirect()->route('admin.bmc.index')->with('success', 'BMC berhasil dibuat.');
    }

    // Menampilkan form edit BMC
    public function bmcEdit($id)
    {
        $bmc = MasterBMC::findOrFail($id);
        return view('admin.bmc.edit', compact('bmc'));
    }

    // Memperbarui data BMC di database
    public function bmcUpdate(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'route' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
            'video' => 'nullable|string|max:255',
        ]);

        $bmc = MasterBMC::findOrFail($id);
        $bmc->update($request->all());

        return redirect()->route('admin.bmc.index')->with('success', 'BMC berhasil diperbarui.');
    }

    // Menghapus data BMC dari database
    public function bmcDestroy($id)
    {
        $bmc = MasterBMC::findOrFail($id);
        $bmc->delete();

        return redirect()->route('admin.bmc.index')->with('success', 'BMC berhasil dihapus.');
    }

    // Mengelola sub soal untuk BMC tertentu
    // public function bmcSubsoal($id)
    // {
    //     $bmc = MasterBMC::findOrFail($id);
    //     // Logic untuk menampilkan dan mengelola sub soal bisa ditambahkan di sini
    //     return view('admin.bmc.subsoal', compact('bmc'));
    // }

    public function showMateri()
    {
        $materi = artikelInkubasi::all();

        // Kirim data materi ke view
        return view('admin.materi.index', compact('materi'));
    }
    public function showLoginForm()
    {
        return view('admin.page.login');
    }


    public function index()
    {
        return view('admin.page.dashboard');
    }


    public function showSiswa()
    {
        $siswa = Siswa::get();

        return view('admin.page.siswa')->with(compact('siswa'));
    }

    public function destroySiswa($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswaMember = Member::where('id_siswa', $siswa->id)->first();

        if ($siswaMember && $siswaMember->position == 1) {
            // Get all members associated with the same product
            $members = Member::where('id_produk', $siswaMember->id_produk)->get();

            // Get the associated product
            $product = $siswaMember->produk()->first();

            // Delete all members associated with the product
            foreach ($members as $member) {
                $member->delete();
            }

            // Delete the product if it exists
            if ($product) {
                $product->delete();
            }
        } else {
            // If not position 1, just delete the member
            $siswaMember->delete();
        }

        // Finally, delete the Siswa
        $siswa->delete();

        return redirect()->route('admin.siswa')->with('success', 'Siswa deleted successfully.');
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.index');
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials do not match our records.'],
        ]);
    }

    public function createMateri()
    {
        return view('admin.materi.create');
    }

    public function storeMateri(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|in:bmc,ide bisnis,cara memulai bisnis',
            'bentuk_kategori' => 'required|in:artikel,video',
            'link' => 'nullable|url',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Simpan gambar thumbnail
        if ($request->hasFile('thumbnail')) {
            $filePath = $request->file('thumbnail')->store('thumbnails', 'public');
            $validated['thumbnail'] = $filePath;
        }

        artikelInkubasi::create($validated);

        return redirect()->to('/admin/materi')->with('success', 'Materi berhasil ditambahkan!');
    }

    // Fungsi untuk menampilkan form edit materi
    public function editMateri($id)
    {
        $materi = artikelInkubasi::findOrFail($id);
        return view('admin.materi.edit', compact('materi'));
    }

    // Fungsi untuk mengupdate materi
    public function updateMateri(Request $request, $id)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|in:bmc,ide bisnis,cara memulai bisnis',
            'bentuk_kategori' => 'required|in:artikel,video',
            'link' => 'nullable|url',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $materi = artikelInkubasi::findOrFail($id);

        if ($request->hasFile('thumbnail')) {
            $filePath = $request->file('thumbnail')->store('thumbnails', 'public');
            $validated['thumbnail'] = $filePath;
        }

        $materi->update($validated);

        return redirect()->to('/admin/materi')->with('success', 'Materi berhasil diupdate!');
    }

    // Fungsi untuk menghapus materi
    public function destroyMateri($id)
    {
        $materi = artikelInkubasi::findOrFail($id);
        $materi->delete();

        return redirect()->to('/admin/materi')->with('success', 'Materi berhasil dihapus!');
    }
}
