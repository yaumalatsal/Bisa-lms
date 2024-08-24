<?php
// app/Http/Controllers/GroupChatController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Message;
use App\Models\Product;
use Session;

class GroupChatController extends Controller
{
    public function index()
    {
        // Ambil ID siswa yang sedang login dari session
        $id_siswa = Session::get('id_siswa');
        $id_mentor = Session::get('id_mentor');


        // Cek apakah siswa ini adalah member dari produk ini
        $member = Member::where('id_siswa', $id_siswa)
            ->first();
        $product = Product::where('id_mentor', $id_mentor)->first();

        
        if (!$member && !$product) {
            abort(403, 'Anda tidak memiliki akses ke grup chat ini.');
        }
        $id_produk = $member['id_produk'] ?? $product['id'];

        $nama_product = Product::where('id',$id_produk)
            ->pluck('nama_produk')
            ->first();


        // Ambil semua pesan dari grup chat ini
        $messages = Message::where('id_product', $id_produk )->with('siswa','mentor')->get();
        
        // dd($messages);

        return view('dashboard.groupchat', compact('messages', 'id_produk','nama_product'));
    }

    public function mentor($id_produk)
    {
        // Ambil ID siswa yang sedang login dari session
        $id_siswa = Session::get('id_siswa');
        $id_mentor = Session::get('id_mentor');


        // Cek apakah siswa ini adalah member dari produk ini
        $member = Member::where('id_siswa', $id_siswa)
            ->first();
        $product = Product::where('id_mentor', $id_mentor)->first();

        
        if (!$member && !$product) {
            abort(403, 'Anda tidak memiliki akses ke grup chat ini.');
        }
        // $id_produk = $id_produk;

        $nama_product = Product::where('id',$id_produk)
            ->pluck('nama_produk')
            ->first();


        // Ambil semua pesan dari grup chat ini
        $messages = Message::where('id_product', $id_produk )->with('mentor')->get();
        
        // dd($messages);

        return view('mentor.page.groupchat', compact('messages', 'id_produk','nama_product'));
    }
    

    public function sendMessage(Request $request, $id_produk)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        // Ambil ID siswa yang sedang login dari session
        $id_siswa = Session::get('id_siswa');
        $id_mentor = Session::get('id_mentor');

        // Simpan pesan baru
        Message::create([
            'id_product' => $id_produk,
            'id_siswa' => $id_siswa,
            'id_mentor' => $id_mentor,
            'message' => $request->message,
        ]);

        return redirect()->route('dashboard.groupchat', $id_produk);
    }

    public function sendMessageMentor(Request $request, $id_produk)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        // Ambil ID siswa yang sedang login dari session
        $id_siswa = Session::get('id_siswa');
        $id_mentor = Session::get('id_mentor');

        // Simpan pesan baru
        Message::create([
            'id_product' => $id_produk,
            'id_siswa' => $id_siswa,
            'id_mentor' => $id_mentor,
            'message' => $request->message,
        ]);

        return redirect()->route('mentor.page.groupchat', $id_produk);
    }
}
