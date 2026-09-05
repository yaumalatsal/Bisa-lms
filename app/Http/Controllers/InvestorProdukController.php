<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductDetailService;

class InvestorProdukController extends Controller
{
    public function __construct(private ProductDetailService $details) {}

    public function index()
    {
        $products = Product::with(['logoProduk', 'mentor', 'ceo'])
            ->orderByDesc('id')
            ->get();

        return view('investor.page.produk', compact('products'));
    }

    public function detail($id)
    {
        return view('investor.page.detail_produk', $this->details->forProduct($id));
    }

    public function result_bmc($id_bmc, $id_produk)
    {
        return view('investor.page.detail_result_bmc', $this->details->bmcResult($id_bmc, $id_produk));
    }
}
