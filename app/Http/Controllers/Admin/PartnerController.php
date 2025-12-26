<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PartnerRequest;
use App\Models\Partner;
use File;
use Illuminate\Http\Request;
use Image;
use Input;


class PartnerController extends Controller
{
    protected $data = [];

    protected $imageSavePath = '/uploads/partner/';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $partners = Partner::get();
        return view('admin.partner.index', compact('partners'));
    }


    public function store(PartnerRequest $request)
    {
//        dd($request->toArray());
        $attr = $request->except('image', '_token', 'inputCroppedPic');
        try {
            if ($request->has('inputCroppedPic') && $request->inputCroppedPic != null) {
                $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
                Image::make($request->input('inputCroppedPic'))
                    ->encode('jpg')
                    ->save(public_path($destinationPath));
                $attr['image'] = $destinationPath;
            }
            $partners = Partner::create($attr);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('partner.index')->with('success', 'Inserted Successfully');

    }

    public function update(PartnerRequest $request, $id)
    {
        $attr = $request->except('image', '_token', 'inputCroppedPic');
        $partner = Partner::findOrFail($id);

        if ($request->has('inputCroppedPic') && $request->inputCroppedPic != null) {
            $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
            Image::make($request->input('inputCroppedPic'))
                ->encode('jpg')
                ->save(public_path($destinationPath));
            $attr['image'] = $destinationPath;
        }
        Partner::where('id', $partner->id)
            ->update($attr);
        return redirect()->route('partner.index')->with('success', 'Updated Successfully');
    }

    public function delete(Request $request)
    {
        $partner = Partner::findOrFail($request->id);
        $path = public_path() . $this->imageSavePath . $partner->image;
        File::delete($path);
        if ($partner->delete()) {
            return response(200);
        } else {
            return response(500);
        }

    }

}
