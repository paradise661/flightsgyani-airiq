<?php

namespace App\Http\Controllers\B2b;

use App\Helpers\ReportHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\B2B\AgentRequest;
use App\Mail\B2b\AgentRegister;
use App\Models\B2B\AgentGroup;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class AgentController extends Controller
{
    public function dashboard()
    {
        $agent = User::find(Auth::user()->id);
        $domesticData = ReportHelper::domesticBookingSearch(Carbon::today()->subDays(6)->format('Y-m-d'), date('Y-m-d'), $agent->id);
        $internationalData = ReportHelper::internationalBookingSearch(Carbon::today()->subDays(6)->format('Y-m-d'), date('Y-m-d'), $agent->id);
        return view('b2b.dashboard', compact('agent', 'domesticData', 'internationalData'));
    }


    public function index()
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort(403);
        }
        activityLog('viewed all agents');
        return view('b2b.agent.index');
    }


    public function create()
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort(403);
        }
        $agentGroups = AgentGroup::whereStatus(1)->oldest('order')->get();
        return view('b2b.agent.create', compact('agentGroups'));
    }


    public function store(AgentRequest $request)
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort(403);
        }
        try {
            $input = $request->all();
            $generatePassword = strtolower(Str::random(6));
            $input['password'] = Hash::make($generatePassword);
            $input['user_type'] = 'AGENT';
            User::create($input);
            $request['password'] = $generatePassword;
            activityLog('added new agent named ' . $request->name . ' and email ' . $request->email);
            Mail::to($request->email)->send(new AgentRegister($request->only(['name', 'email', 'password'])));

            return redirect()->route('v2.admin.agents.index')->with('success', 'Agent added successfully.');
        } catch (Exception $e) {
            return redirect()->route('v2.admin.agents.index')->with('warning', $e->getMessage())->withInput();
        }
    }


    public function show(User $agent)
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort(403);
        }
        activityLog('viewed agent details of ' . $agent->name . ' and email ' . $agent->email);
        $domesticData = ReportHelper::domesticBookingSearch(Carbon::today()->subDays(6)->format('Y-m-d'), date('Y-m-d'), $agent->id);
        $internationalData = ReportHelper::internationalBookingSearch(Carbon::today()->subDays(6)->format('Y-m-d'), date('Y-m-d'), $agent->id);
        return view('b2b.agent.show', compact('agent', 'domesticData', 'internationalData'));
    }


    public function edit(User $agent)
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort(403);
        }
        $agentGroups = AgentGroup::whereStatus(1)->oldest('order')->get();
        return view('b2b.agent.edit', compact('agent', 'agentGroups'));
    }

    public function update(AgentRequest $request, User $agent)
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort(403);
        }
        try {
            $input = $request->except('password');

            if ($request->password) {
                $input['password'] = Hash::make($request->password);
            }

            if ($request->has('status') && $agent->status !== $request->status) {
                $input['status'] = $request->status;
                $request['agentAccountStatus'] = $request->status;

                Mail::to($request->email)->send(
                    new AgentRegister($request->only(['name', 'email', 'agentAccountStatus']))
                );
            }

            $agent->update($input);

            activityLog('updated agent named ' . $request->name . ' and email ' . $request->email);
            return redirect()->route('v2.admin.agents.index')->with('success', 'Agent updated successfully.');
        } catch (Exception $e) {
            return redirect()->route('v2.admin.agents.index')->with('warning', $e->getMessage())->withInput();
        }
    }


    public function destroy(User $agent)
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort(403);
        }
        $agent->delete();
        activityLog('updated agent named ' . $agent->name . ' and email ' . $agent->email);
        return redirect()->route('v2.admin.agents.index')->with('success', 'Agent deleted Successfully');
    }
}
