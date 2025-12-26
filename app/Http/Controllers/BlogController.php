<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use PDF;

class BlogController extends Controller
{

    public function blog()
    {
        $data['blogs'] = Blog::orderBy('created_at', 'desc')->paginate(9);
        $data['blog'] = Blog::orderBy('created_at', 'desc')->first();
        // return $data;

        return view('front.blogs', $data);
    }

    public function detail($slug)
    {
        $data['blog'] = Blog::where('slug', $slug)->first();
        if (!$data['blog']) {
            abort(404);
        }
        //        dd($data['blog']->title);
        $data['blogs'] = Blog::orderBy('created_at', 'desc')->paginate(8);
        return view('front.blog', $data);
    }
}
