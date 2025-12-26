<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Models\Slider;
use File;
use Illuminate\Http\Request;
use Image;
use Input;


class SliderController extends Controller
{
    protected $data = [];

    protected $imageSavePath = '/uploads/slider/';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['sliders'] = Slider::all();
        return view('admin.slider.index', $data);
    }


    public function store(SliderRequest $request)
    {

        try {
            $slider = new Slider();
            $slider->image = $request->image;
            $slider->save();

        } catch (\Exception $e) {
            return redirect()->back()->with('warning', $e->getMessage());
        }

        return redirect()->route('slider.index')->with('success', 'Inserted Successfully');

    }

    public function update(SliderRequest $request, $id)
    {
        $attr = $request->except('image', '_token', 'inputCroppedPic');
        $slider = Slider::findOrFail($id);

        if ($request->has('inputCroppedPic') && $request->inputCroppedPic != null) {
            $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
            Image::make($request->input('inputCroppedPic'))
                ->encode('jpg')
                ->save(public_path($destinationPath));
            $attr['image'] = $destinationPath;
        }
        Slider::where('id', $slider->id)
            ->update($attr);
        return redirect()->route('slider.index')->with('success', 'Updated Successfully');
    }

    public function delete(Request $request)
    {
        $slider = Slider::findOrFail($request->id);
        $path = public_path() . $this->imageSavePath . $slider->image;
        File::delete($path);
        if ($slider->delete()) {
            return response(200);
        } else {
            return response(500);
        }

    }

}
