<?php

namespace App\Http\Controllers\Admin\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\Back\FaqStoreRequest;
use App\Models\FAQ;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Gate;

class FaqsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(Gate::allows('view faq'), 403);
        activityLog('viewed faqs');

        return view('admin.v2.faq.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(Gate::allows('create faq'), 403);

        return view('admin.v2.faq.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FaqStoreRequest $request)
    {
        abort_unless(Gate::allows('create faq'), 403);

        try {
            $input = $request->all();
            FAQ::create($input);
            activityLog('added new faq named ' . $request->title);

            return redirect()->route('v2.admin.faqs.index')->with('success', 'FAQ added successfully.');
        } catch (Exception $e) {
            return redirect()->route('v2.admin.faqs.index')->with('warning', $e->getMessage())->withInput();
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
    public function edit(FAQ $faq)
    {
        abort_unless(Gate::allows('edit faq'), 403);

        return view('admin.v2.faq.edit', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FaqStoreRequest $request, FAQ $faq)
    {
        abort_unless(Gate::allows('edit faq'), 403);

        try {
            $input = $request->all();
            $faq->update($input);
            activityLog('updated faq named ' . $request->title);

            return redirect()->route('v2.admin.faqs.index')->with('success', 'FAQ updated successfully.');
        } catch (Exception $e) {
            return redirect()->route('v2.admin.faqs.index')->with('warning', $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(FAQ $faq)
    {
        abort_unless(Gate::allows('delete faq'), 403);

        $faq->delete();
        activityLog('deleted faq named ' . $faq->title);

        return redirect()->route('v2.admin.faqs.index')->with('success', 'FAQ deleted Successfully');
    }
}
