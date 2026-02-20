<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\Job;
    use Illuminate\Support\Facades\Auth;
    use App\Models\Trade;
    use App\Models\User;
    use Carbon\Carbon;



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

    // Get today’s date
    $today = Carbon::today();

    // Fetch only jobs created today by this client
    $jobs = Job::where('client_id', Auth::id())
                ->whereDate('created_at', $today)
                ->latest()
                ->get();

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
            'trade_id' => $request->trade_id, 
            'budget' => $request->budget,
            'location' => $request->location,
            'status' => 'open'
        ]);

        return redirect()->back()->with('success', 'Job posted successfully.');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('client.client_profile', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validate inputs including optional password
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'birthdate' => 'nullable|date',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'password' => 'nullable|string|min:8|confirmed', // ensures password_confirmation matches
        ]);

        $user->first_name = $request->first_name;
        $user->middle_name = $request->middle_name;
        $user->last_name = $request->last_name;
        $user->birthdate = $request->birthdate;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->city = $request->city;

        // Update password only if filled
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }


    }
