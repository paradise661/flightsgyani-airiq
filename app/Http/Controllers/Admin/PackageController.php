<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PackageRequest;
use App\Models\Category;
use App\Models\Package;
use File;
use Illuminate\Http\Request;
use Image;
use Input;
use PDF;
use Yajra\Datatables\Facades\Datatables;


class PackageController extends Controller
{
    protected $data = [];

    protected $imageSavePath = '/uploads/package/';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $packages = Package::with([
            'itineraries',
            'inclusions',
            'exclusions',
            'termsAndConditions',
            'priceDetails',
            'operationalTours',
            'hotels',
            'visas'
        ])->get();
        return view('admin.package.index', compact('packages'));
    }

    public function add()
    {
        $categories = Category::all();
        $packages = Package::all();
        // default package detail create Itinerary
        // Iteneray list create
        return view('admin.package.add', compact('categories', 'packages'));
    }

    public function store(PackageRequest $request)
    {
        $attr = $request->except('image', '_token', 'inputCroppedPic');
        if ($request->special_package == 1) {
            Package::whereSpecialPackage('1')->update([
                'special_package' => 0
            ]);
        }
        try {
            if ($request->has('inputCroppedPic')) {
                $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
                Image::make($request->input('inputCroppedPic'))
                    ->encode('jpg')
                    ->save(public_path($destinationPath));
                $attr['image'] = $destinationPath;
            }

            $packages = Package::create($attr);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('package.index')->with('success', 'Inserted Successfully');

    }

    public function update(PackageRequest $request, $id)
    {
        $attr = $request->except('image', '_token', 'inputCroppedPic');
        $package = Package::findOrFail($id);

        if ($request->has('inputCroppedPic') && $request->inputCroppedPic != null) {
            $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
            Image::make($request->input('inputCroppedPic'))
                ->encode('jpg')
                ->save(public_path($destinationPath));
            $attr['image'] = $destinationPath;
        }
        Package::where('id', $package->id)
            ->update($attr);
        return redirect()->route('package.index')->with('success', 'Updated Successfully');
    }

    public function edit($id)
    {
        $this->data['package'] = Package::find($id);
        $this->data['categories'] = Category::all();

        $this->data['packages'] = Package::all();

        return view('admin.package.add', $this->data);
    }

    public function show($id)
    {
        $this->data['package'] = Package::findOrFail($id);
        return view('admin.package.detail', $this->data);

    }

    public function download($id)
    {
        $package = Package::findOrFail($id);

        $pdf = PDF::loadView('frontend.download', ['package' => $package]);
        return $pdf->download('itinerary_' . $package->title . '.pdf');
    }

    public function delete(Request $request)
    {
        $package = Package::findOrFail($request->id);
        $path = public_path() . $this->imageSavePath . $package->image;
        File::delete($path);
        if ($package->delete()) {
            return response(200);
        } else {
            return response(500);
        }
        //return redirect()->back()->with('success', 'Deleted Successfully');

    }

}
