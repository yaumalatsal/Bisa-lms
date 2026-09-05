<?php

namespace App\Http\Controllers;

class ProfilBisnisController extends Controller
{
    /**
     * `/tahap_profil` merender view `dashboard/tahap_profil` yang tidak pernah
     * ada di repositori ini, sehingga rute ini selalu berakhir 500. Tidak ada
     * satu pun halaman yang menautkannya, tetapi kolom `master_step.route`
     * berpotensi mengarah ke sini, jadi rutenya dipertahankan dan dialihkan ke
     * tahap tim daripada dihapus.
     *
     * TODO: buat halaman profil bisnis, atau hapus langkahnya dari master_step.
     */
    public function index()
    {
        return redirect('/tahap_team');
    }
}
