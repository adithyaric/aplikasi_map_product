<?php

namespace App\Http\Controllers;

use App\Exports\ExportProject;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProjectController extends Controller
{
    public function olahData($data, $request)
    {
        $sundays = [];
        [$startDate, $endDate] = explode(' - ', $request->durasi);
        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate);
        $days = round(($endDate - $startDate) / (60 * 60 * 24)) + 1;
        for ($i = $startDate; $i <= $endDate; $i = strtotime('+1 day', $i)) {
            if (date('w', $i) == 0) {
                $sundays[] = date('Y-m-d', $i);
            }
        }
        $dates = explode(',', $request->dates);
        // dump($sundays, $dates);
        $data['hari_toleransi'] = array_merge($sundays, $dates);
        $days -= count($data['hari_toleransi']);
        $data['target'] = $request->jml_product / $days; //average for each days
        $target_jml_product_each_days = [];
        $remaining_jml_product = $request->jml_product - ($days * floor($data['target']));
        for ($i = $startDate; $i <= $endDate; $i = strtotime('+1 day', $i)) {
            if (in_array(date('Y-m-d', $i), $data['hari_toleransi'])) {
                $target_jml_product_each_days[] = ['day' => date('Y-m-d', $i), 'target' => 0];
            } else {
                $target = floor($data['target']);
                if ($remaining_jml_product > 0) {
                    $target++;
                    $remaining_jml_product--;
                }
                $target_jml_product_each_days[] = ['day' => date('Y-m-d', $i), 'target' => $target];
            }
        }
        $data['hari_toleransi'] = json_encode($data['hari_toleransi']);
        $data['target_jml_product_each_days'] = $target_jml_product_each_days;

        // dd($data, $target_jml_product_each_days);

        return $data;
    }

    public function index()
    {
        $projects = Project::get();

        return view('project.index', compact('projects'));
    }

    public function create()
    {
        return view('project.create', [
            'products' => Product::get(),
            'customers' => Customer::get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required',
            'customer_id' => 'required',
            'durasi' => 'required',
            'jml_product' => 'required',
            // 'hari_toleransi' => 'required',
            'keterangan' => 'required',
            'harga' => 'required',
        ]);

        $data = $this->olahData($data, $request);
        $project = Project::create($data);
        foreach ($data['target_jml_product_each_days'] as $target) {
            $project->targets()->create($target);
        }

        return redirect(route('project.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    public function target(Request $request)
    {
        $data = Project::find($request->project_id);
        $targets = $data->targets->toArray();
        foreach ($targets as &$target) {
            $target['day'] = Carbon::parse($target['day'])->format('d-m-Y');
        }

        return $targets;
    }

    public function capaian(Request $request)
    {
        $data = Project::find($request->project_id);
        $targets = $data->targets->toArray();
        $entries = $data->entries->sortBy('day')->values()->toArray();
        $merged = array_merge($targets, $entries);
        foreach ($merged as &$entry) {
            $entry['day'] = date('d-m-Y', strtotime($entry['day']));
        }
        usort($merged, function ($a, $b) {
            return strtotime($a['day']) - strtotime($b['day']);
        });

        return $merged;
    }

    public function show(Project $project)
    {
        return view('project.show', [
            'project' => $project,
        ]);
    }

    public function edit(Project $project)
    {
        return view('project.edit', [
            'project' => $project,
            'products' => Product::get(),
            'customers' => Customer::get(),
        ]);
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'product_id' => 'required',
            'customer_id' => 'required',
            'durasi' => 'required',
            'jml_product' => 'required',
            // 'hari_toleransi' => 'required',
            'keterangan' => 'required',
            'harga' => 'required',
        ]);

        $data = $this->olahData($data, $request);
        $project->update($data);
        $project->targets()->delete();
        foreach ($data['target_jml_product_each_days'] as $target) {
            $project->targets()->create($target);
        }

        // dd($project, $project->targets->toArray());

        return redirect(route('project.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    public function updateStatus(Project $project)
    {
        $newStatus = $project->status === 'proses' ? 'selesai' : 'proses';
        $project->update(['status' => $newStatus]);

        return redirect()->back();
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect(route('project.index'))->with('toast_error', 'Berhasil Menghapus Data!');
    }

    public function projectExport(Request $request)
    {
        $tanggal = explode(' - ', $request->input('tanggal'));
        $dateStart = $tanggal[0];
        $dateEnd = $tanggal[1];

        return Excel::download(new ExportProject($dateStart, $dateEnd), 'project.xlsx');
    }
}
