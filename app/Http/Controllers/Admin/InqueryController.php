<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquery;
use File;
use Illuminate\Http\Request;
use Image;

class InqueryController extends Controller
{

    public function inquery()
    {
        $data['inqueries'] = Inquery::whereType('inquery')->orderBy('created_at', 'desc')->get();
        return view('admin.inquery.index', $data);
    }

    public function emailed()
    {
        $data['inqueries'] = Inquery::whereType('email')->orderBy('created_at', 'desc')->get();
        return view('admin.inquery.index', $data);
    }

    public function downloaded()
    {
        $data['inqueries'] = Inquery::whereType('download')->orderBy('created_at', 'desc')->get();
        return view('admin.inquery.index', $data);
    }

    public function booking()
    {
        $data['inqueries'] = Inquery::whereType('booking')->orderBy('created_at', 'desc')->get();
        return view('admin.inquery.index', $data);
    }

    public function update($id)
    {
        $inquery = Inquery::find($id);
        $inquery->status = 1;
        $inquery->save();
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $blog = Inquery::findOrFail($request->id);
        if ($blog->delete()) {
            return response(200);
        } else {
            return response(500);
        }
    }

}
