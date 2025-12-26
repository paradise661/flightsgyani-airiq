<?php

namespace App\Http\Controllers\Admin\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Models\Slider;
use Illuminate\Http\Request;
use Image;
use File;
use Illuminate\Support\Facades\Gate;

class SliderController extends Controller
{
    protected $data = [];

    protected $imageSavePath = '/uploads/slider/';

    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(Gate::allows('view slider'), 403);

        $sliders = Slider::latest()->paginate(10);
        activityLog('viewed sliders');

        return view('admin.v2.sliders.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(Gate::allows('create slider'), 403);

        return view('admin.v2.sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SliderRequest $request)
    {
        abort_unless(Gate::allows('create slider'), 403);

        $attr = $request->except('image', '_token');
        $attr['status'] = $request->status ?? 0;
        try {
            if ($request->has('image') && $request->image != null) {
                $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
                Image::make($request->input('image'))
                    ->encode('jpg')
                    ->save(public_path($destinationPath));
                $attr['image'] = $destinationPath;
            }
            Slider::create($attr);
            activityLog('added new slider');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('v2.admin.sliders.index')->with('success', 'Slider Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        abort_unless(Gate::allows('edit slider'), 403);

        return view('admin.v2.sliders.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider)
    {
        abort_unless(Gate::allows('edit slider'), 403);

        $attr = $request->except('image', '_token');
        $attr['status'] = $request->status ?? 0;
        if ($request->has('image') && $request->image != null) {
            $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
            Image::make($request->input('image'))
                ->encode('jpg')
                ->save(public_path($destinationPath));
            $attr['image'] = $destinationPath;
            $path = public_path() . $slider->image;
            File::delete($path);
        }

        $slider->update($attr);
        activityLog('updated slider');

        return redirect()->route('v2.admin.sliders.index')->with('success', 'Slider Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        abort_unless(Gate::allows('delete slider'), 403);

        $path = public_path() . $slider->image;
        File::delete($path);
        $slider->delete();
        activityLog('deleted slider');

        return redirect()->route('v2.admin.sliders.index')->with('success', 'Slider Deleted Successfully');
    }
}
