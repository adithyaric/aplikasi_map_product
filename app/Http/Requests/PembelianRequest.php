<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PembelianRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'tgl_dibuat' => 'required',
            'bahan_baku_id' => 'required',
            'supplier_id' => 'required',
            'category_id' => 'nullable',
            'harga' => 'required',
            'jumlah' => 'required',
            'keterangan' => 'required',
        ];
    }
}
