<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use File;
use Illuminate\Contracts\Logging\Log;
use Illuminate\Http\Request;
use Image;
use Input;
use Yajra\Datatables\Facades\Datatables;

//use Intervention\Image\Image;
//use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    protected $data = [];

    protected $imageSavePath = '/uploads/product/';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($name)
    {
        if (request()->ajax()) {
            $product = Product::all();

            return Datatables::of($product)->addColumn('actions', '')->make(true);

        }
        return view('admin.products.index', $name);
    }

    public function add($name)
    {
        return view('admin.products.add');
    }

    public function store(ProductRequest $request, $name)
    {
        $attr = $request->except('image', '_token', 'inputCroppedPic');

        if ($request->has('inputCroppedPic')) {
            $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
            Image::make($request->input('inputCroppedPic'))
                ->encode('jpg')
                ->save(public_path($destinationPath));
            $attr['image'] = $destinationPath;
        }
        $products = Product::create($attr);

        return redirect()->route('product.index', $name)->with('success', 'Inserted Successfully');

    }

    protected function getDateFormatFileName($extension = null)
    {
        $fileName = rand();
        if ($extension) {
            $fileName = "{$fileName}.{$extension}";
        }
        return $fileName;
    }

    public function edit($name, $id)
    {
        $this->data['product'] = Product::find($id);
        $this->data['name'] = $name;
        return view('admin.products.add', $this->data);
    }

    public function show($id)
    {
        return 'show';
        $this->data['query'] = News::findOrFail($id);
        return view('admin.news.edit', $this->data);

    }

    public function update($name, $id, ProductRequest $request)
    {
        $attr = $request->except('image', '_token', 'inputCroppedPic');
        $product = Product::findOrFail($id);

        if ($request->has('inputCroppedPic')) {
            $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
            Image::make($request->input('inputCroppedPic'))
                ->encode('jpg')
                ->save(public_path($destinationPath));
            $attr['image'] = $destinationPath;
        }
        Product::where('id', $product->id)
            ->update($attr);
        return redirect()->route('product.index', $name)->with('success', 'Updated Successfully');
    }

    public function delete(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $path = public_path() . '/uploads/product/' . $product->image;
        File::delete($path);
        if ($product->delete()) {
            return response(200);
        } else {
            return response(500);
        }
        //return redirect()->back()->with('success', 'Deleted Successfully');

    }

    public function tour()
    {
        if (request()->ajax()) {
            $product = Product::where('type', 0)->get();

            return Datatables::of($product)->addColumn('actions', '')->make(true);

        }
        return view('admin.products.index');
    }

    public function trekking()
    {
        if (request()->ajax()) {
            $product = Product::where('type', 1)->get();

            return Datatables::of($product)->addColumn('actions', '')->make(true);

        }
        return view('admin.products.index');
    }

    public function adventure()
    {
        if (request()->ajax()) {
            $product = Product::where('type', 2)->get();

            return Datatables::of($product)->addColumn('actions', '')->make(true);

        }
        return view('admin.products.index');
    }

    public function packages()
    {
        if (request()->ajax()) {
            $product = Product::where('type', 3)->get();

            return Datatables::of($product)->addColumn('actions', '')->make(true);

        }
        return view('admin.products.index');
    }
}
