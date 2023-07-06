<?php

namespace App\Http\Controllers;

use App\Exports\ExportPengiriman;
use App\Http\Requests\PengirimanRequest;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\Pengiriman;
use App\Models\Penjualan;
use App\Models\Project;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpWord\TemplateProcessor;

class PengirimanController extends Controller
{
    public function index()
    {
        $pengirimans = Pengiriman::get();

        return view('pengiriman.index', compact('pengirimans'));
    }

    public function create()
    {
        return view('pengiriman.create', [
            'customers' => Customer::get(),
            'drivers' => Driver::get(),
            'projects' => Project::get(),
            'penjualans' => Penjualan::get(),
        ]);
    }

    public function store(PengirimanRequest $request)
    {
        $data = $request->validated();
        Pengiriman::create($data);

        return redirect(route('pengiriman.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    public function show(Pengiriman $pengiriman)
    {
        dd($pengiriman);
    }

    public function edit(Pengiriman $pengiriman)
    {
        return view('pengiriman.edit', [
            'pengiriman' => $pengiriman,
            'customers' => Customer::get(),
            'drivers' => Driver::get(),
            'projects' => Project::get(),
            'penjualans' => Penjualan::get(),
        ]);
    }

    public function update(PengirimanRequest $request, Pengiriman $pengiriman)
    {
        $data = $request->validated();
        $pengiriman->update($data);

        return redirect(route('pengiriman.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    public function destroy(Pengiriman $pengiriman)
    {
        $pengiriman->delete();

        return redirect(route('pengiriman.index'))->with('toast_error', 'Berhasil Menghapus Data!');
    }

    public function solar(Request $request)
    {
        return view('pengiriman.solar', [
            'pengiriman' => Pengiriman::find($request->pengiriman_id),
        ]);
    }

    public function solarUpdate(Request $request, Pengiriman $pengiriman)
    {
        $pengiriman->solar = $request->solar;
        $pengiriman->jarak = $request->jarak;
        $pengiriman->status = 'selesai';
        $pengiriman->save();

        return redirect(route('pengiriman.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    public function pengirimanExport(Request $request)
    {
        $tanggal = explode(' - ', $request->input('tanggal'));
        $dateStart = $tanggal[0];
        $dateEnd = $tanggal[1];

        return Excel::download(new ExportPengiriman($dateStart, $dateEnd), 'pengiriman.xlsx');
    }

    public function pengirimanNota(Request $request)
    {
        $pengiriman = Pengiriman::with(['driver', 'penjualan'])->find($request->pengiriman_id);

        $templateProcessor = new TemplateProcessor('assets\nota.docx');
        $templateProcessor->setValue('nama_customer', $pengiriman->penjualan->customer->name);
        $templateProcessor->setValue('no_invoice', $pengiriman->penjualan->no_invoice);
        $templateProcessor->setValue('tgl_pengiriman', $pengiriman->tgl_pengiriman);
        // $templateProcessor->setValue('category_product', $pengiriman->penjualan->product->category->name);
        $templateProcessor->setValue('no_plat', $pengiriman->driver->no_plat);
        $templateProcessor->setValue('jarak', $pengiriman->jarak);
        $templateProcessor->setValue('jam', $pengiriman->jam);

        $filename = 'pengiriman-'.$pengiriman->penjualan->no_invoice.'.docx';
        $templateProcessor->saveAs($filename);

        return response()->download($filename)->deleteFileAfterSend();
    }
}
