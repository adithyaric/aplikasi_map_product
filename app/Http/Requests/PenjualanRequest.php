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
            'no_invoice' => 'required',
            'tgl_penjualan' => 'required',
            // 'customer_id' => 'nullable',
            'project_id' => 'required',
            'total_barang' => 'required',
            'harga' => 'required',
            'diskon' => 'nullable',
            'total' => 'required',
            'metode_pembayaran' => 'required',
        ];
    }
}
