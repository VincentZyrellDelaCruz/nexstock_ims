<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $categories = Category::all();
            return view('categories.index', compact('categories'));
        }
        return redirect('/login');
    }

    public function create()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return view('categories.create');
        }
        return redirect('/dashboard');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Category::create($request->all());
        return redirect()->route('categories.index')->with('success', 'Category added successfully!');
    }

    public function edit(Category $category)
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return view('categories.edit', compact('category'));
        }
        return redirect('/dashboard');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category->update($request->all());
        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
    }
}

