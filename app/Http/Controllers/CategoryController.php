<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\CategoryUpdateRequest;
use App\Notifications\CategoryAddedNotification;
use App\Notifications\CategoryDeletedNotification;
use App\User;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Notification as FacadesNotification;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(10);
        return view('categories.index', compact('categories'));


        $categories = Category::all();
        return response()->json(['data' => $categories], 200);
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $categories = Category::search($keyword)->paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function paginate(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $categories = Category::paginate($perPage);
        return view('categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        return response()->json(['data' => $category], 200);
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(CategoryRequest $request)
    {
        Category::create([
            'name' => $request->name,
            'is_publish' => $request->is_publish
        ]);

        return redirect()->route('categories.index');

        // code to add new category

        $category = Category::create($request->all());

        // send notification to users
        $users = User::all();
        FacadesNotification::send($users, new CategoryAddedNotification($category));

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name',
            'description' => 'nullable',
            'is_active' => 'nullable|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $category = Category::create($request->all());
        return response()->json(['data' => $category], 201);
    }

    public function edit(Category $category)
    {
        return view('categories.edit', ['category' => $category]);
    }

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $category->update([
            'name' => $request->name,
            'is_publish' => $request->is_publish
        ]);

        return redirect()->route('categories.index')->with('success', 'Category has been updated.');

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|unique:categories,name,' . $category->id,
            'description' => 'nullable',
            'is_active' => 'nullable|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $category->update($request->all());
        return response()->json(['data' => $category], 200);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category has been delete');

        // code to delete category

        $category = Category::findOrFail($category->id);

        // send notification to users
        $users = User::all();
        FacadesNotification::send($users, new CategoryDeletedNotification($category));

        return response()->json(null, 204);
    }
}
