<?php

namespace App\Http\Controllers;

use App\Exports\ExportPengiriman;
use App\Http\Requests\PengirimanRequest;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\Pengiriman;
use App\Models\Penjualan;
use App\Models\Project;
use Carbon\Carbon;
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
        // Get the date of the pengiriman
        $date = $data['tgl_pengiriman'];

        // Get the last pengiriman created on the same date
        $lastPengiriman = Pengiriman::whereDate('tgl_pengiriman', $date)->orderBy('rit', 'desc')->first();

        // If there is a last pengiriman, set the rit to be one more than its rit
        // Otherwise, set the rit to 1
        $data['rit'] = $lastPengiriman ? $lastPengiriman->rit + 1 : 1;
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
        // $pengiriman->jarak = $request->jarak;
        // $pengiriman->waktu_tempuh = $request->waktu_tempuh;
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

        // Get the penjualan associated with the pengiriman
        $penjualan = $pengiriman->penjualan;

        // Get the project associated with the penjualan
        $project = $penjualan->project;

        // Get the product associated with the project
        $product = $project->product;

        // Get all pengirimans that have the same product
        $pengirimans = Pengiriman::whereHas('penjualan.project.product', function ($query) use ($product) {
            $query->where('id', $product->id);
        })->get();

        // Initialize a variable to store the total number of products sent
        $totalProductsSent = 0;

        // Loop through each pengiriman and add its jml_product to the total
        foreach ($pengirimans as $pengiriman) {
            $totalProductsSent += $pengiriman->jml_product;
        }

        // dd(
        //     $pengiriman->toArray(),
        //     $totalProductsSent,
        //     $penjualan->toArray(),
        //     $project->toArray(),
        //     $product->toArray(),
        //     $pengirimans->toArray(),
        // );

        $date = Carbon::parse($pengiriman->tgl_pengiriman);
        $formattedDate = $date->format('d-m-Y');

        $path = public_path('assets/nota.docx');
        $templateProcessor = new TemplateProcessor($path);
        $templateProcessor->setValue('nama_customer', $pengiriman->penjualan->customer->name);
        $templateProcessor->setValue('no_invoice', $pengiriman->penjualan->no_invoice);
        $templateProcessor->setValue('category_product', $pengiriman->penjualan->project->product->category->name);
        $templateProcessor->setValue('total_product_sent', $totalProductsSent);
        $templateProcessor->setValue('tgl_pengiriman', $formattedDate);
        $templateProcessor->setValue('rit', $pengiriman->rit);
        // $templateProcessor->setValue('category_product', $pengiriman->penjualan->product->category->name);
        $templateProcessor->setValue('no_plat', $pengiriman->driver->no_plat);
        $templateProcessor->setValue('jarak', $pengiriman->jarak);
        $templateProcessor->setValue('jam', $pengiriman->jam);
        $templateProcessor->setValue('waktu_tempuh', $pengiriman->waktu_tempuh);
        $templateProcessor->setValue('jml_product', $pengiriman->jml_product);

        $templateProcessor->setValue('untuk_pengecoran', $pengiriman->penjualan->project->untuk_pengecoran);
        $templateProcessor->setValue('lokasi_pengecoran', $pengiriman->penjualan->project->lokasi_pengecoran);
        $templateProcessor->setValue('dry_automatic', $pengiriman->dry_automatic);
        $templateProcessor->setValue('slump_permintaan', $pengiriman->penjualan->project->slump_permintaan);

        $filename = 'pengiriman-'.$pengiriman->penjualan->no_invoice.'.docx';
        $templateProcessor->saveAs($filename);

        return response()->download($filename)->deleteFileAfterSend();
    }
}
