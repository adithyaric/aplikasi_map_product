<?php

namespace App\Http\Controllers;

use App\Exports\ExportPembelian;
use App\Exports\ExportPembelianFilterSupplier;
use App\Http\Requests\PembelianRequest;
use App\Models\BahanBaku;
use App\Models\Category;
use App\Models\Pembelian;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PembelianController extends Controller
{
    public function index()
    {
        $pembelians = Pembelian::get();

        return view('pembelian.index', compact('pembelians'));
    }

    public function indexReport()
    {
        $pembelians = Pembelian::get();
        $suppliers = Supplier::get();

        return view('pembelian.export', compact(['pembelians', 'suppliers']));
    }

    public function create()
    {
        return view('pembelian.create', [
            'bahan_bakus' => BahanBaku::get(),
            'categories' => Category::get(),
            'suppliers' => Supplier::get(),
        ]);
    }

    public function store(PembelianRequest $request)
    {
        $data = $request->validated();
        $data['harga'] = str_replace(',', '', $data['harga']);
        BahanBaku::find($request->bahan_baku_id)->name == 'Pasir' ? $data['jumlah'] = $request->konversi * $request->jumlah : $request->jumlah;
        Pembelian::create($data);
        $bahanBaku = BahanBaku::find($request->bahan_baku_id);
        $bahanBaku->stock += BahanBaku::find($request->bahan_baku_id)->name == 'Pasir' ? $data['jumlah'] = $request->konversi * $request->jumlah : $request->jumlah;
        $bahanBaku->save();

        return redirect(route('pembelian.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    public function show(Pembelian $pembelian)
    {
        dd($pembelian);
    }

    public function edit(Pembelian $pembelian)
    {
        return view('pembelian.edit', [
            'pembelian' => $pembelian,
            'bahan_bakus' => BahanBaku::get(),
            'categories' => Category::get(),
            'suppliers' => Supplier::get(),
        ]);
    }

    public function update(PembelianRequest $request, Pembelian $pembelian)
    {
        $data = $request->validated();
        $data['harga'] = str_replace(',', '', $data['harga']);
        BahanBaku::find($request->bahan_baku_id)->name == 'Pasir' ? $data['jumlah'] = $request->konversi * $request->jumlah : $request->jumlah;
        $pembelian->update($data);

        return redirect(route('pembelian.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    public function destroy(Pembelian $pembelian)
    {
        $pembelian->delete();

        return redirect(route('pembelian.index'))->with('toast_error', 'Berhasil Menghapus Data!');
    }

    public function updateStatus(Pembelian $pembelian)
    {
        $newStatus = $pembelian->status === 'blm_lunas' ? 'lunas' : 'blm_lunas';
        $pembelian->update(['status' => $newStatus]);

        return redirect()->back();
    }

    public function pembelianExport(Request $request)
    {
        $tanggal = explode(' - ', $request->input('tanggal'));
        $dateStart = $tanggal[0];
        $dateEnd = $tanggal[1];

        return Excel::download(new ExportPembelian($dateStart, $dateEnd), 'pembelian.xlsx');
    }

    public function pembelianExportFilter(Request $request)
    {
        $tanggal = explode(' - ', $request->input('tanggal'));
        $dateStart = $tanggal[0];
        $dateEnd = $tanggal[1];

        return Excel::download(new ExportPembelianFilterSupplier($dateStart, $dateEnd, $request->supplier_id), 'pembelian.xlsx');
    }
}
