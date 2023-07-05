<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectEntry;
use Illuminate\Http\Request;

class ProjectEntryController extends Controller
{
    public function index()
    {
        $projects = Project::get();

        return view('entry.index', compact('projects'));
    }

    public function create(Request $request)
    {
        return view('entry.create', [
            'project' => Project::find($request->project_id),
        ]);
    }

    public function store(Request $request)
    {
        $project = Project::find($request->project_id);
        $project->entries()->create([
            'day' => $request->tanggal,
            'capaian' => $request->capaian,
        ]);

        return redirect(route('entry.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    public function show($project)
    {
        return view('entry.show', [
            'project' => Project::find($project),
        ]);
    }

    public function edit(ProjectEntry $projectEntry)
    {
        //
    }

    public function update(Request $request, ProjectEntry $projectEntry)
    {
        //
    }

    public function destroy($projectEntry)
    {
        $projectEntry = ProjectEntry::find($projectEntry);
        $projectEntry->delete();

        return redirect(route('entry.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }
}
