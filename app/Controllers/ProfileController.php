<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;
use App\Models\ProductModel;

class ProfileController extends BaseController
{

public function index()
{
    helper('number');

    if (!session()->get('isLoggedIn')) {
        return redirect()->to(base_url('login'));
    }

    $username = session()->get('username');

    $transaksiModel = new TransactionModel();
    $detailModel = new TransactionDetailModel();
    $produkModel = new ProductModel();

    // Ambil semua transaksi milik user
    $buy = $transaksiModel->where('username', $username)->findAll();

    // Siapkan array kosong untuk isi produk per transaksi
    $product = [];

    foreach ($buy as $beli) {
        // Ambil semua detail pembelian berdasarkan ID transaksi
        $detail = $detailModel->where('transaction_id', $beli['id'])->findAll();

        // Loop detail dan lengkapi dengan info produk
        foreach ($detail as &$d) {
            $produk = $produkModel->find($d['product_id']);
            $d['nama'] = $produk['nama'];
            $d['foto'] = $produk['foto'];
            $d['harga'] = $produk['harga'];
        }

        // Simpan ke array dengan kunci ID transaksi
        $product[$beli['id']] = $detail;
    }

    $data = [
        'username'   => $username,
        'role'       => session()->get('role'),
        'email'      => session()->get('email'),
        'login_time' => session()->get('login_time'),
        'isLoggedin' => session()->get('isLoggedIn'),
        'buy'        => $buy,
        'product'    => $product
    ];

    return view('v_profile', $data);
}
}