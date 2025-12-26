<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TravelAgencyRequest;
use App\Models\TravelAgency;
use File;
use Illuminate\Http\Request;
use Image;
use Input;

//use Intervention\Image\Image;
//use Intervention\Image\Facades\Image;

class TravelAgencyController extends Controller
{
    protected $data = [];

    protected $imageSavePath = '/uploads/travel-agency/';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $travelAgencies = TravelAgency::all();
        return view('admin.travel-agency.index', compact('travelAgencies'));
    }


    public function store(TravelAgencyRequest $request)
    {
        $attr = $request->except('image', '_token', 'inputCroppedPic');
        try {
            if ($request->has('inputCroppedPic') && $request->inputCroppedPic != null) {
                $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
                Image::make($request->input('inputCroppedPic'))
                    ->encode('jpg')
                    ->save(public_path($destinationPath));
                $attr['image'] = $destinationPath;
            }
            $travelAgency = TravelAgency::create($attr);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('travel-agency.index')->with('success', 'Inserted Successfully');

    }

    public function update(TravelAgencyRequest $request, $id)
    {
        $attr = $request->except('image', '_token', 'inputCroppedPic');
        $travelAgency = TravelAgency::findOrFail($id);

        if ($request->has('inputCroppedPic') && $request->inputCroppedPic != null) {
            $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
            Image::make($request->input('inputCroppedPic'))
                ->encode('jpg')
                ->save(public_path($destinationPath));
            $attr['image'] = $destinationPath;
        }
        TravelAgency::where('id', $travelAgency->id)
            ->update($attr);
        return redirect()->route('travel-agency.index')->with('success', 'Updated Successfully');
    }

    public function delete(Request $request)
    {
        $travelAgency = TravelAgency::findOrFail($request->id);
        $path = public_path() . $this->imageSavePath . $travelAgency->image;
        File::delete($path);
        if ($travelAgency->delete()) {
            return response(200);
        } else {
            return response(500);
        }

    }

}
