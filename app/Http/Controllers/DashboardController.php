<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Database\Eloquent\Builder;

class DashboardController extends Controller
{
    public function index()
    {
        // $project = Project::where('status', '!=', 'selesai')->get();
        // dd(
        //     $project->toArray(),
        //     $project->first()->targets->sum('target'),
        //     $project->first()->entries->sum('capaian'),
        // );

        // dd(Project::addSelect(['pengiriman_count' => function (Builder $query) {
        //     $query->selectRaw('count(*)')
        //         ->from('pengiriman')
        //         ->join('penjualans', 'penjualans.id', '=', 'pengiriman.penjualan_id')
        //         ->whereColumn('penjualans.project_id', 'projects.id');
        // }])->get());

        return view('dashboard.index', [
            // 'projects' => Project::where('status', '!=', 'selesai')->get(),
        ]);
    }
}
