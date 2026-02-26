<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\Job;
    use Illuminate\Support\Facades\Auth;
    use App\Models\Trade;
    use App\Models\User;
    use Carbon\Carbon;
    use App\Models\Announcement;


    class ClientJobController extends Controller
    {
        public function create()
    {
        return view('client.jobs.create');
    }


    public function postJob()
    {
        $jobs = Job::where('client_id', Auth::id())->latest()->get();
        $trades = Trade::all();
    return view('client.client_post_job', compact('jobs', 'trades'));
    }

public function dashboard()
{
    $trades = Trade::all();

    $jobs = Job::with([
                'trade',
                'worker.user'
            ])
            ->where('client_id', Auth::id())
            ->latest()
            ->get();

    $announcements = Announcement::latest()
                        ->with('admin')
                        ->get();

    $user = Auth::user();

    return view('client.client_dashboard', compact(
        'trades',
        'jobs',
        'announcements',
        'user'
    ));
}

 public function profile()
{
    $user = Auth::user();

    $announcements = Announcement::latest()
                        ->with('admin')
                        ->get();

    return view('client.client_profile', compact(
        'user',
        'announcements'
    ));
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
            'trade_id' => $request->trade_id, 
            'budget' => $request->budget,
            'location' => $request->location,
            'status' => 'open'
        ]);

        return redirect()->back()->with('success', 'Job posted successfully.');
    }



    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'birthdate' => 'nullable|date',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'password' => 'nullable|string|min:8|confirmed', 
        ]);

        $user->first_name = $request->first_name;
        $user->middle_name = $request->middle_name;
        $user->last_name = $request->last_name;
        $user->birthdate = $request->birthdate;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->city = $request->city;

        
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }


    public function complete(Job $job)
{
    // Security: ensure this job belongs to logged-in client
    if ($job->client_id !== Auth::id()) {
        abort(403);
    }

    // Only allow assigned jobs to be completed
    if ($job->status !== 'assigned') {
        return redirect()->back()
            ->with('error', 'Only assigned jobs can be completed.');
    }

    $job->status = 'completed';
    $job->save();

    return redirect()->back()
        ->with('success', 'Job marked as completed.');
}


public function updateJob(Request $request, Job $job)
{
    if ($job->client_id !== Auth::id()) {
        abort(403);
    }

    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required',
        'trade_id' => 'required|exists:trades,id',
        'budget' => 'nullable|numeric',
        'location' => 'required|string',
    ]);

    $job->update([
        'title' => $request->title,
        'description' => $request->description,
        'trade_id' => $request->trade_id,
        'budget' => $request->budget,
        'location' => $request->location,
    ]);

    return back()->with('success', 'Job updated successfully.');
}

public function destroy(Job $job)
{
    if ($job->client_id !== auth()->id()) {
        abort(403);
    }

    // 🚫 Prevent deleting assigned jobs
    if ($job->status === 'assigned') {
        return back()->with('error', 'Assigned jobs cannot be deleted.');
    }

    $job->delete();

    return back()->with('success', 'Job deleted successfully.');
}
    }
