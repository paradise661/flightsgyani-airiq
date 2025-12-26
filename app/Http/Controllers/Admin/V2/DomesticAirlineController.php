<?php

namespace App\Http\Controllers\Admin\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\Back\DomesticAirlineStoreRequest;
use App\Http\Requests\Back\DomesticAirlineUpdateRequest;
use App\Models\Domestic\DomesticAirline;
use Illuminate\Http\Request;
use File;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\Gate;

class DomesticAirlineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(Gate::allows('view domesticairline'), 403);
        activityLog('viewed domestic airlines');

        return view('admin.v2.domesticairline.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(Gate::allows('create domesticairline'), 403);

        return view('admin.v2.domesticairline.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DomesticAirlineStoreRequest $request)
    {
        abort_unless(Gate::allows('create domesticairline'), 403);

        try {
            $input = $request->all();
            $input['image'] = $this->fileUpload($request, 'image');
            DomesticAirline::create($input);
            activityLog('added new domestic airline with name ' . $request->name);

            return redirect()->route('v2.admin.domestic.airlines.index')->with('success', 'Airline Added Successfully.');
        } catch (Exception $e) {
            return redirect()->route('v2.admin.domestic.airlines.index')->with('warning', $e->getMessage())->withInput();
        }
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
    public function edit(DomesticAirline $airline)
    {
        abort_unless(Gate::allows('edit domesticairline'), 403);

        return view('admin.v2.domesticairline.edit', compact('airline'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DomesticAirlineUpdateRequest $request, DomesticAirline $airline)
    {
        abort_unless(Gate::allows('edit domesticairline'), 403);

        try {
            $old_image = $airline->image;
            $input = $request->all();
            $image = $this->fileUpload($request, 'image');

            if ($image) {
                $this->removeFile($old_image);
                $input['image'] = $image;
            } else {
                unset($input['image']);
            }

            $airline->update($input);
            activityLog('updated domestic airline with name ' . $request->name);

            return redirect()->route('v2.admin.domestic.airlines.index')->with('success', 'Airline Updated Successfully.');
        } catch (Exception $e) {
            return redirect()->route('v2.admin.domestic.airlines.index')->with('warning', $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DomesticAirline $airline)
    {
        abort_unless(Gate::allows('delete domesticairline'), 403);

        $this->removeFile($airline->image);
        $airline->delete();
        activityLog('deleted domestic airline with name ' . $airline->name);

        return redirect()->route('v2.admin.domestic.airlines.index')->with('success', 'Airline Deleted Successfully');
    }

    public function fileUpload(Request $request, $name)
    {
        $imageName = '';
        if ($image = $request->file($name)) {
            $destinationPath = public_path() . '/uploads/domestic/airlines';
            $imageName = date('YmdHis') . $name . "-" . $image->getClientOriginalName();
            $image->move($destinationPath, $imageName);
            $image = $imageName;
        }
        return $imageName;
    }


    public function removeFile($file)
    {
        if ($file) {
            $path = public_path() . '/uploads/domestic/airlines/' . $file;
            if (File::exists($path)) {
                File::delete($path);
            }
        }
    }
}
