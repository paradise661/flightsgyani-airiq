<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Product;
use File;
use Illuminate\Http\Request;

class CategoryControllor extends Controller
{
    protected $data = [];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $data['categories'] = Category::get();
        $data['parentCategories'] = Category::whereParentId(null)->get();
        return view('admin.category.index', $data);
    }


    public function store(CategoryRequest $request)
    {
        $attr = $request->except('image', '_token');
        $category = Category::create($attr);
        return redirect()->route('category.index')->with('success', 'Inserted Successfully');

    }

    public function update(CategoryRequest $request, $id = null)
    {

        $attr = $request->except('image', '_token');
        $category = Category::findOrFail($id);

        Category::where('id', $category->id)
            ->update($attr);
        return redirect()->route('category.index')->with('success', 'Updated Successfully');
    }

    public function delete(Request $request)
    {
        $category = Category::findOrFail($request->id);

        if ($category->delete()) {
            return response(200);
        } else {
            return response(500);
        }

    }
}
