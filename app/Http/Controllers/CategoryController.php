<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categoires = Category::get();

        return view('category.index', compact('categoires'));
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->validated();
        Category::create($data);

        return redirect(route('category.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    public function show(Category $category)
    {
        dd($category);
    }

    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $data = $request->validated();
        $category->update($data);

        return redirect(route('category.index'))->with('toast_success', 'Berhasil Menyimpan Data!');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect(route('category.index'))->with('toast_error', 'Berhasil Menghapus Data!');
    }
}
