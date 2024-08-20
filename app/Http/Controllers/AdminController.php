<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\ArtikelInkubasi;

class AdminController extends Controller
{
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
