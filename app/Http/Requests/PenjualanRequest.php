<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PenjualanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'tgl_penjualan' => 'required',
            'customer_id' => 'required',
            'product_id' => 'required',
            'total_barang' => 'required',
            'harga' => 'required',
            'total' => 'required',
            'metode_pembayaran' => 'required',
        ];
    }
}
