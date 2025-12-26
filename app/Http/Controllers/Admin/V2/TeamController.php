<?php

namespace App\Http\Controllers\Admin\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\Back\TeamStoreRequest;
use App\Models\Team;
use Illuminate\Http\Request;
use File;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\Gate;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(Gate::allows('view team'), 403);
        activityLog('viewed teams');

        return view('admin.v2.team.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(Gate::allows('create team'), 403);

        return view('admin.v2.team.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TeamStoreRequest $request)
    {
        abort_unless(Gate::allows('create team'), 403);

        try {
            $input = $request->all();
            $input['image'] = $this->fileUpload($request, 'image');
            Team::create($input);
            activityLog('added new team named ' . $request->name);

            return redirect()->route('v2.admin.teams.index')->with('success', 'Team added successfully.');
        } catch (Exception $e) {
            return redirect()->route('v2.admin.teams.index')->with('warning', $e->getMessage())->withInput();
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
    public function edit(Team $team)
    {
        abort_unless(Gate::allows('edit team'), 403);

        return view('admin.v2.team.edit', compact('team'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TeamStoreRequest $request, Team $team)
    {
        abort_unless(Gate::allows('edit team'), 403);

        try {
            $old_image = $team->image;
            $input = $request->all();
            $image = $this->fileUpload($request, 'image');

            if ($image) {
                $this->removeFile($old_image);
                $input['image'] = $image;
            } else {
                unset($input['image']);
            }

            $team->update($input);
            activityLog('updated team named ' . $request->name);

            return redirect()->route('v2.admin.teams.index')->with('success', 'Team updated successfully.');
        } catch (Exception $e) {
            return redirect()->route('v2.admin.teams.index')->with('warning', $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        abort_unless(Gate::allows('delete team'), 403);

        $this->removeFile($team->image);
        $team->delete();
        activityLog('deleted team named ' . $team->name);

        return redirect()->route('v2.admin.teams.index')->with('success', 'Team deleted Successfully');
    }

    public function fileUpload(Request $request, $name)
    {
        $imageName = '';
        if ($image = $request->file($name)) {
            $destinationPath = public_path() . '/uploads/team';
            $imageName = date('YmdHis') . $name . "-" . $image->getClientOriginalName();
            $image->move($destinationPath, $imageName);
            $image = $imageName;
        }
        return $imageName;
    }


    public function removeFile($file)
    {
        if ($file) {
            $path = public_path() . '/uploads/team/' . $file;
            if (File::exists($path)) {
                File::delete($path);
            }
        }
    }
}
