<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * Builds the payload for the "detail produk" and "hasil BMC" screens.
 *
 * This block of queries used to be copy-pasted, verbatim, into
 * AdminProdukController, InvestorProdukController, MentorPameranController and
 * ProdukController (twice). Any fix had to be applied in five places, and in
 * practice they had already drifted apart. It now lives here once.
 *
 * The returned shapes are unchanged so the existing Blade views keep working.
 */
class ProductDetailService
{
    /**
     * Reference tables never change per request; cache them for an hour.
     */
    private const MASTER_CACHE_TTL = 3600;

    /**
     * @param  int|string  $productId
     * @param  int|string|null  $mentorId  When given, the product must belong to this mentor.
     * @return array<string, mixed>
     */
    public function forProduct($productId, $mentorId = null): array
    {
        return [
            'produk' => $this->product($productId, $mentorId),
            'member' => $this->members($productId),
            'track' => $this->track($productId),
            'masterstep' => $this->masterSteps(),
            'bmc' => $this->masterBmc(),
            'proto' => $this->assets('protolink', $productId),
            'logo' => $this->assets('logo_produk', $productId),
            'video' => $this->assets('video_produk', $productId),
            'poster' => $this->assets('poster_produk', $productId),
            'presentasi' => $this->assets('presentasi', $productId),
        ];
    }

    /**
     * Jawaban BMC untuk satu poin BMC pada satu produk.
     *
     * @return array<string, mixed>
     */
    public function bmcResult($bmcId, $productId): array
    {
        return [
            'getmaster' => DB::table('master_bmc')->where('id', $bmcId)->get(),
            'getResult' => DB::table('jawaban_bmc')
                ->select('jawaban_bmc.*', 'pertanyaan_bmc.pertanyaan', 'pertanyaan_bmc.keterangan')
                ->join('pertanyaan_bmc', 'pertanyaan_bmc.id', '=', 'jawaban_bmc.id_pertanyaan')
                ->where('pertanyaan_bmc.id_poin_bmc', $bmcId)
                ->where('jawaban_bmc.id_produk', $productId)
                ->get(),
        ];
    }

    private function product($productId, $mentorId)
    {
        return DB::table('product')
            ->select(
                'product.*',
                'product.id as product_id',
                'logo_produk.logo_produk',
                'mentor.nama as nama_mentor',
                'mentor.email as email_mentor',
                'mentor.nomor_telepon as telepon_mentor',
                'mentor.instansi as instansi_mentor',
                'siswa.nama as nama_siswa',
                'siswa.nomor_induk as nis_siswa'
            )
            ->leftJoin('logo_produk', 'logo_produk.id_produk', '=', 'product.id')
            ->join('mentor', 'product.id_mentor', '=', 'mentor.id')
            ->join('siswa', 'product.id_ceo', '=', 'siswa.id')
            ->where('product.id', $productId)
            ->when($mentorId !== null, fn ($query) => $query->where('product.id_mentor', $mentorId))
            ->get();
    }

    private function members($productId)
    {
        return DB::table('member')
            ->select('member.*', 'siswa.nama', 'siswa.nomor_induk', 'position.posisi')
            ->join('siswa', 'siswa.id', '=', 'member.id_siswa')
            ->leftJoin('position', 'position.id', '=', 'member.position')
            ->where('member.id_produk', $productId)
            ->orderBy('member.position')
            ->get();
    }

    private function track($productId)
    {
        return DB::table('track_step')
            ->select('master_step.*', 'track_step.*', 'track_step.id as id_track')
            ->join('master_step', 'master_step.id', '=', 'track_step.id_step')
            ->where('track_step.id_produk', $productId)
            ->get();
    }

    private function assets(string $table, $productId)
    {
        return DB::table($table)->where('id_produk', $productId)->get();
    }

    private function masterSteps()
    {
        return Cache::remember(
            'master_step.all',
            self::MASTER_CACHE_TTL,
            fn () => DB::table('master_step')->orderBy('step_number')->get()
        );
    }

    private function masterBmc()
    {
        return Cache::remember(
            'master_bmc.all',
            self::MASTER_CACHE_TTL,
            fn () => DB::table('master_bmc')->get()
        );
    }
}
