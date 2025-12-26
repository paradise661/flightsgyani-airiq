<?php

namespace App\Http\Controllers\Admin\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\Back\CompanyTicketStoreRequest;
use App\Http\Requests\Back\CompanyTicketUpdateRequest;
use App\Models\CompanyTicketDetail;
use App\Models\User;
use Illuminate\Http\Request;
use File;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\Auth;

class CompanyTicketController extends Controller
{
    public function index()
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort(403);
        }

        return view('admin.v2.ticket.index');
    }

    public function create()
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort(403);
        }

        $agents = User::where('user_type', 'AGENT')->where('status', 'Active')->get();
        return view('admin.v2.ticket.create', compact('agents'));
    }


    public function store(CompanyTicketStoreRequest $request)
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort(403);
        }

        try {
            $input = $request->all();
            $input['company_logo'] = $this->fileUpload($request, 'company_logo');
            CompanyTicketDetail::create($input);
            return redirect()->route('v2.admin.tickets.index')->with('success', 'Ticket Details Added Successfully.');
        } catch (Exception $e) {
            return redirect()->route('v2.admin.tickets.index')->with('warning', $e->getMessage())->withInput();
        }
    }


    public function show($id)
    {
        //
    }


    public function edit(CompanyTicketDetail $ticket)
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort(403);
        }

        $agents = User::where('user_type', 'AGENT')->where('status', 'Active')->get();
        return view('admin.v2.ticket.edit', compact('ticket', 'agents'));
    }


    public function update(CompanyTicketUpdateRequest $request, CompanyTicketDetail $ticket)
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort(403);
        }

        try {
            $old_company_logo = $ticket->company_logo;
            $input = $request->all();
            $company_logo = $this->fileUpload($request, 'company_logo');

            if ($company_logo) {
                $this->removeFile($old_company_logo);
                $input['company_logo'] = $company_logo;
            } else {
                unset($input['company_logo']);
            }

            $ticket->update($input);

            return redirect()->route('v2.admin.tickets.index')->with('success', 'Ticket Details Updated Successfully.');
        } catch (Exception $e) {
            return redirect()->route('v2.admin.tickets.index')->with('warning', $e->getMessage())->withInput();
        }
    }


    public function destroy(CompanyTicketDetail $ticket)
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort(403);
        }

        $this->removeFile($ticket->company_logo);
        $ticket->delete();
        return redirect()->route('v2.admin.tickets.index')->with('success', 'Ticket Details Deleted Successfully');
    }

    public function fileUpload(Request $request, $name)
    {
        $imageName = '';
        if ($image = $request->file($name)) {
            $destinationPath = public_path() . '/uploads/ticket';
            $imageName = date('YmdHis') . $name . "-" . $image->getClientOriginalName();
            $image->move($destinationPath, $imageName);
            $image = $imageName;
        }
        return $imageName;
    }


    public function removeFile($file)
    {
        if ($file) {
            $path = public_path() . '/uploads/ticket/' . $file;
            if (File::exists($path)) {
                File::delete($path);
            }
        }
    }
}
