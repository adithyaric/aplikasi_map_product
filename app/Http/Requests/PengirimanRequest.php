<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PengirimanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'tgl_pengiriman' => 'required',
            'penjualan_id' => 'nullable',
            'driver_id' => 'required',
            'customer_id' => 'nullable',
            'project_id' => 'nullable',
            'jml_product' => 'required',
            'jam' => 'required',
            'jarak' => 'required',
            'waktu_tempuh' => 'required',
            'untuk_pengecoran' => 'nullable',
            'lokasi_pengecoran' => 'nullable',
            'dry_automatic' => 'nullable',
            'slump_permintaan' => 'nullable',
            'waktu_tempuh' => 'nullable',

        ];
    }
}
