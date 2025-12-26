<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use File;
use Illuminate\Http\Request;
use Image;
use Input;

//use Intervention\Image\Image;
//use Intervention\Image\Facades\Image;

class CommentController extends Controller
{
    protected $data = [];


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $comments = Comment::get();
        return view('admin.comment.index', compact('comments'));
    }

    public function delete(Request $request)
    {
        $comment = Comment::findOrFail($request->id);
        if ($comment->delete()) {
            return response(200);
        } else {
            return response(500);
        }

    }

}
