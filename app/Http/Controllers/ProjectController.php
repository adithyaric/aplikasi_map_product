<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Product;
use App\Models\Project;

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

    public function store(ProjectRequest $request)
    {
        $data = $request->validated();
        Project::create($data);

        return redirect(route('project.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    public function show(Project $project)
    {
        dd($project);
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
