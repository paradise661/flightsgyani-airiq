<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\ContactUs;
use File;
use Illuminate\Http\Request;
use Image;

class ContactUsController extends Controller
{
    protected $data = [];
    protected $imageSavePath = '/uploads/contact/';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['contacts'] = ContactUs::all();
        return view('admin.contact-us.index', $data);
    }

    public function store(Request $request)
    {
        try {
            $attr = $request->except('image', '_token', 'inputCroppedPic');
            if ($request->has('inputCroppedPic')) {
                $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
                Image::make($request->input('inputCroppedPic'))
                    ->encode('jpg')
                    ->save(public_path($destinationPath));
                $attr['image'] = $destinationPath;
            }
//
            ContactUs::create($attr);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Inserted Successfully');

    }


    public function update(Request $request, $id)
    {
        try {
            $attr = $request->except('image', '_token', 'inputCroppedPic');
            if ($request->has('inputCroppedPic') && $request->inputCroppedPic != null) {
                $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
                Image::make($request->input('inputCroppedPic'))
                    ->encode('jpg')
                    ->save(public_path($destinationPath));
                $attr['image'] = $destinationPath;
            }
            ContactUs::where('id', $id)
                ->update($attr);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()->back()->with('success', 'Updated Successfully');
    }

    public function delete(Request $request)
    {
        $contact = ContactUs::findOrFail($request->id);
        $path = public_path() . $this->imageSavePath . $contact->image;
        File::delete($path);
        if ($contact->delete()) {
            return response(200);
        } else {
            return response(500);
        }

    }

}
