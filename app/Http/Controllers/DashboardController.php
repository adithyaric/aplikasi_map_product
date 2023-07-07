<?php

namespace App\Http\Controllers;

use App\Models\Project;

class DashboardController extends Controller
{
    public function index()
    {
        $project = Project::where('status', '!=', 'selesai')->get();
        dd(
            $project->toArray(),
            $project->first()->targets->sum('target'),
            $project->first()->entries->sum('capaian'),
        );

        return view('dashboard.index', []);
    }
}
