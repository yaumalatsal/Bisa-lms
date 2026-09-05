<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ProductDetailService;

class MentorPameranController extends Controller
{
    public function __construct(private ProductDetailService $details)
    {
    }

    public function index()
    {
        $products = Product::with(['logoProduk', 'mentor', 'ceo'])
            ->orderByDesc('id')
            ->get();

        return view('mentor.pameran.produk', compact('products'));
    }

    public function detail($id)
    {
        return view('mentor.pameran.detail_produk', $this->details->forProduct($id));
    }

    public function result_bmc($id_bmc, $id_produk)
    {
        return view('mentor.pameran.detail_result_bmc', $this->details->bmcResult($id_bmc, $id_produk));
    }
}
