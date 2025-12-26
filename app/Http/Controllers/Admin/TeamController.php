<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeamRequest;
use App\Models\Team;
use File;
use Illuminate\Http\Request;
use Image;
use Input;
use PDF;
use Yajra\Datatables\Facades\Datatables;

//use Intervention\Image\Image;
//use Intervention\Image\Facades\Image;

class TeamController extends Controller
{
    protected $data = [];

    protected $imageSavePath = '/uploads/team/';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $teams = Team::all();
        return view('admin.team.index', compact('teams'));
    }

    public function store(TeamRequest $request)
    {
        $attr = $request->except('image', '_token', 'inputCroppedPic');

        try {
            if ($request->has('inputCroppedPic')) {
                $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
                Image::make($request->input('inputCroppedPic'))
                    ->encode('jpg')
                    ->save(public_path($destinationPath));
                $attr['image'] = $destinationPath;
            }
//            dd($attr);
            $teams = Team::create($attr);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('team.index')->with('success', 'Inserted Successfully');

    }


    public function update(TeamRequest $request, $id)
    {
        $attr = $request->except('image', '_token', 'inputCroppedPic');
        $team = Team::findOrFail($id);

        if ($request->has('inputCroppedPic') && $request->inputCroppedPic != null) {
            $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
            Image::make($request->input('inputCroppedPic'))
                ->encode('jpg')
                ->save(public_path($destinationPath));
            $attr['image'] = $destinationPath;
        }
        Team::where('id', $team->id)
            ->update($attr);
        return redirect()->route('team.index')->with('success', 'Updated Successfully');
    }

    public function delete(Request $request)
    {
        $team = Team::findOrFail($request->id);
        $path = public_path() . $this->imageSavePath . $team->image;
        File::delete($path);
        if ($team->delete()) {
            return response(200);
        } else {
            return response(500);
        }
        //return redirect()->back()->with('success', 'Deleted Successfully');

    }

}
