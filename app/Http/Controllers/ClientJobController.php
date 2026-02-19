<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use App\Models\Trade;

class ClientJobController extends Controller
{
    public function create()
{
    return view('client.jobs.create');
}


public function postJob()
{
    // Fetch only jobs of this client
    $jobs = Job::where('client_id', Auth::id())->latest()->get();
       $trades = Trade::all();
return view('client.client_post_job', compact('jobs', 'trades'));

}

public function dashboard()
{
    $trades = Trade::all();
    $jobs = Job::where('client_id', Auth::id())->latest()->get();

    return view('client.client_dashboard', compact('trades', 'jobs'));
}


public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required',
        'trade_id' => 'required|exists:trades,id',
        'budget' => 'nullable|numeric',
        'location' => 'required|string'
    ]);

    Job::create([
        'client_id' => Auth::id(),
        'title' => $request->title,
        'description' => $request->description,
        'trade_id' => $request->trade_id, // ✅ correct column
        'budget' => $request->budget,
        'location' => $request->location,
        'status' => 'open'
    ]);

    return redirect()->back()->with('success', 'Job posted successfully.');
}


}
