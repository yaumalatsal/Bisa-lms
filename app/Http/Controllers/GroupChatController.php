<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Message;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupChatController extends Controller
{
    /**
     * Grup chat tim siswa yang sedang login.
     */
    public function index(Request $request)
    {
        $member = Member::where('id_siswa', Auth::guard('siswa')->id())->first();

        if (! $member) {
            abort(403, 'Anda belum tergabung dalam tim mana pun.');
        }

        return view('dashboard.groupchat', $this->chatData($member->id_produk));
    }

    /**
     * Grup chat satu produk, dilihat mentor pembimbingnya.
     */
    public function mentor($id_produk)
    {
        // Dulu hanya dicek "apakah ada mentor/siswa yang login", bukan apakah
        // mentor ini membimbing produk tersebut — sehingga mentor mana pun bisa
        // membaca percakapan tim mana pun.
        $this->assertMentorOwns($id_produk);

        return view('mentor.page.groupchat', $this->chatData($id_produk));
    }

    public function sendMessage(Request $request, $id_produk)
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:1000'],
        ]);

        $idSiswa = Auth::guard('siswa')->id();

        $anggota = Member::where('id_siswa', $idSiswa)
            ->where('id_produk', $id_produk)
            ->exists();

        if (! $anggota) {
            abort(403, 'Anda tidak memiliki akses ke grup chat ini.');
        }

        Message::create([
            'id_product' => $id_produk,
            'id_siswa' => $idSiswa,
            'message' => $validated['message'],
        ]);

        return redirect()->route('dashboard.groupchat');
    }

    public function sendMessageMentor(Request $request, $id_produk)
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:1000'],
        ]);

        $this->assertMentorOwns($id_produk);

        Message::create([
            'id_product' => $id_produk,
            'id_mentor' => Auth::guard('mentor')->id(),
            'message' => $validated['message'],
        ]);

        return redirect()->route('mentor.page.groupchat', $id_produk);
    }

    /**
     * @return array<string, mixed>
     */
    private function chatData($idProduk): array
    {
        return [
            'id_produk' => $idProduk,
            'nama_product' => Product::where('id', $idProduk)->value('nama_produk'),
            // Keduanya di-eager-load; view menampilkan nama pengirim dari salah
            // satunya, dan versi mentor hanya memuat `mentor` sehingga setiap
            // pesan siswa memicu query tambahan.
            'messages' => Message::where('id_product', $idProduk)
                ->with(['siswa:id,nama', 'mentor:id,nama'])
                ->oldest('id')
                ->get(),
        ];
    }

    private function assertMentorOwns($idProduk): void
    {
        $membimbing = Product::where('id', $idProduk)
            ->where('id_mentor', Auth::guard('mentor')->id())
            ->exists();

        if (! $membimbing) {
            abort(403, 'Anda tidak memiliki akses ke grup chat ini.');
        }
    }
}
