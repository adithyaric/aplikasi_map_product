<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Product;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::get();

        return view('project.index', compact('projects'));
    }

    public function create()
    {
        return view('project.create', [
            'products' => Product::get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required',
            'durasi' => 'required',
            'jml_product' => 'required',
            // 'hari_toleransi' => 'required',
            'keterangan' => 'required',
        ]);

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
            if (! in_array(date('Y-m-d', $i), $data['hari_toleransi'])) {
                $target = floor($data['target']);
                if ($remaining_jml_product > 0) {
                    $target++;
                    $remaining_jml_product--;
                }
                $target_jml_product_each_days[] = ['day' => date('Y-m-d', $i), 'target' => $target];
            }
        }
        $data['hari_toleransi'] = json_encode($data['hari_toleransi']);

        // dd($data, $target_jml_product_each_days);

        $project = Project::create($data);
        foreach ($target_jml_product_each_days as $target) {
            $project->targets()->create($target);
        }

        return redirect(route('project.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    public function target(Request $request)
    {
        $data = Project::find($request->project_id);

        return $data->targets->toArray();
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
        ]);
    }

    public function update(ProjectRequest $request, Project $project)
    {
        $data = $request->validated();
        $project->update($data);

        return redirect(route('project.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect(route('project.index'))->with('toast_error', 'Berhasil Menghapus Data!');
    }
}
