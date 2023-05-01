<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudyRequest;
use App\Models\Study;

class StudyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $studies = Study::get();

        return view('study.index', compact('studies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('study.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudyRequest $request)
    {
        $data = $request->validated();
        Study::create($data);

        return redirect(route('studies.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Study $study)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Study $study)
    {
        return view('study.edit', compact('study'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(StudyRequest $request, Study $study)
    {
        $data = $request->validated();
        $study->update($data);

        return redirect(route('studies.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Study $study)
    {
        $study->delete();

        return redirect(route('studies.index'))->with('toast_success', 'Berhasil Menghapus Data!');
    }
}
