<?php

namespace App\Http\Controllers\B2b;

use App\Http\Controllers\Controller;
use App\Http\Requests\B2B\TicketRequest;
use App\Http\Requests\Back\CompanyTicketStoreRequest;
use App\Models\CompanyTicketDetail;
use Illuminate\Http\Request;
use File;
use Exception;
use Illuminate\Support\Facades\Auth;

class TicketDetailController extends Controller
{
    public function editTicket()
    {
        if (Auth::user()->user_type !== 'AGENT') {
            abort(403, 'Access denied');
        }

        $userID = auth()->user()->id;
        $ticket = CompanyTicketDetail::where('user_id', $userID)->first();
        return view('b2b.agent.ticket-detail', compact('ticket'));
    }

    public function updateTicket(TicketRequest $request)
    {
        try {
            $userId = auth()->user()->id;

            $ticket = CompanyTicketDetail::firstOrNew(['user_id' => $userId]);

            $old_company_logo = $ticket->company_logo ?? null;
            $input = $request->all();

            $company_logo = $this->fileUpload($request, 'company_logo');
            if ($company_logo) {
                if ($old_company_logo) {
                    $this->removeFile($old_company_logo);
                }
                $input['company_logo'] = $company_logo;
            } else {
                unset($input['company_logo']);
            }

            $ticket->fill($input);
            $ticket->save();

            $message = $ticket->wasRecentlyCreated
                ? 'Ticket Details Created Successfully.'
                : 'Ticket Details Updated Successfully.';

            return redirect()->route('b2b.agent.edit.ticket')->with('success', $message);
        } catch (Exception $e) {
            return redirect()->route('b2b.agent.edit.ticket')->with('errors', $e->getMessage())->withInput();
        }
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
