<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Complaint;
use Illuminate\Support\Facades\Auth;
use App\Models\Trade;
use App\Models\User;
use App\Models\Announcement;

class ClientJobController extends Controller
{
    /**
     * Show job creation page.
     */
    public function create()
    {
        return view('client.jobs.create');
    }

    /**
     * Show job posting page with client jobs and trades.
     */
    public function postJob()
    {
        $jobs = Job::where('client_id', Auth::id())->latest()->get();
        $trades = Trade::all();

        return view('client.client_post_job', compact('jobs', 'trades'));
    }

    /**
     * Display the client dashboard with job statistics.
     */
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

        $totalJobs     = $jobs->count();
        $activeWorkers = $jobs->where('status', 'assigned')->count();
        $completedJobs = $jobs->where('status', 'completed')->count();
        $totalSpent    = $jobs->where('status', 'completed')->sum('budget');

        $myComplaints = Complaint::where('client_id', Auth::id())
                            ->latest()
                            ->get();

        return view('client.client_dashboard', compact(
            'trades',
            'jobs',
            'announcements',
            'user',
            'totalJobs',
            'activeWorkers',
            'completedJobs',
            'totalSpent',
            'myComplaints'
        ));
    }

    /**
     * Show the client profile page.
     */
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

    /**
     * Store a newly created job.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required',
            'trade_id'    => 'required|exists:trades,id',
            'budget'      => 'nullable|numeric',
            'location'    => 'required|string',
        ]);

        Job::create([
            'client_id'   => Auth::id(),
            'title'       => $request->title,
            'description' => $request->description,
            'trade_id'    => $request->trade_id,
            'budget'      => $request->budget,
            'location'    => $request->location,
            'status'      => 'open',
        ]);

        return redirect()->back()->with('success', 'Job posted successfully.');
    }

    // ══════════════════════════════════════════════════════════════
    // STORE COMPLAINT
    // Route : POST /client/complaints
    // Name  : client.complaints.store
    // ══════════════════════════════════════════════════════════════

    /**
     * Save a complaint filed by a client against a worker.
     *
     * Add to web.php:
     *   Route::post('/client/complaints', [ClientJobController::class, 'storeComplaint'])
     *        ->name('client.complaints.store');
     */
    public function storeComplaint(Request $request)
    {
        $request->validate([
            'worker_name' => 'required|string|max:255',
            'reason'      => 'required|in:no_show,incomplete_work,unprofessional,overcharging,damage,other',
            'subject'     => 'required|string|max:120',
            'description' => 'required|string|max:1000',
            'screenshot'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $screenshotPath = null;
        if ($request->hasFile('screenshot')) {
            $screenshotPath = $request->file('screenshot')
                                      ->store('complaints', 'public');
        }

        Complaint::create([
            'client_id'   => Auth::id(),
            'job_id'      => null,
            'worker_id'   => null,
            'worker_name' => $request->worker_name,
            'reason'      => $request->reason,
            'subject'     => $request->subject,
            'description' => $request->description,
            'screenshot'  => $screenshotPath,
            'status'      => 'pending',
        ]);

        return redirect()->back()
            ->with('success', 'Your complaint has been submitted. Our team will review it shortly.');
    }

    /**
     * Update client profile information.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'first_name'  => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name'   => 'required|string|max:255',
            'birthdate'   => 'nullable|date',
            'email'       => 'required|email|unique:users,email,' . $user->id,
            'phone'       => 'nullable|string|max:20',
            'address'     => 'nullable|string|max:255',
            'city'        => 'nullable|string|max:100',
            'password'    => 'nullable|string|min:8|confirmed',
        ]);

        $user->first_name  = $request->first_name;
        $user->middle_name = $request->middle_name;
        $user->last_name   = $request->last_name;
        $user->birthdate   = $request->birthdate;
        $user->email       = $request->email;
        $user->phone       = $request->phone;
        $user->address     = $request->address;
        $user->city        = $request->city;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Mark a job as completed.
     */
    public function complete(Job $job)
    {
        if ($job->client_id !== Auth::id()) {
            abort(403);
        }

        if ($job->status !== 'assigned') {
            return redirect()->back()
                ->with('error', 'Only assigned jobs can be completed.');
        }

        $job->status = 'completed';
        $job->save();

        return redirect()->back()
            ->with('success', 'Job marked as completed.');
    }

    /**
     * Update an existing job.
     */
    public function updateJob(Request $request, Job $job)
    {
        if ($job->client_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required',
            'trade_id'    => 'required|exists:trades,id',
            'budget'      => 'nullable|numeric',
            'location'    => 'required|string',
        ]);

        $job->update([
            'title'       => $request->title,
            'description' => $request->description,
            'trade_id'    => $request->trade_id,
            'budget'      => $request->budget,
            'location'    => $request->location,
        ]);

        return back()->with('success', 'Job updated successfully.');
    }

    /**
     * Delete a job posted by the client.
     */
    public function destroy(Job $job)
    {
        if ($job->client_id !== auth()->id()) {
            abort(403);
        }

        if ($job->status === 'assigned') {
            return back()->with('error', 'Assigned jobs cannot be deleted.');
        }

        $job->delete();

        return back()->with('success', 'Job deleted successfully.');
    }

    /**
     * Get worker details for a specific job (used by client modal).
     */
    public function getWorker($id)
    {
        \Log::info('getWorker called', ['job_id' => $id, 'auth_id' => auth()->id()]);

        $job = Job::with(['worker', 'worker.user', 'worker.trade'])->find($id);

        \Log::info('Job found', [
            'job'       => $job ? $job->toArray() : null,
            'worker_id' => $job?->worker_id,
            'worker'    => $job?->worker ? $job->worker->toArray() : null,
        ]);

        if (!$job) {
            return response()->json(['message' => 'Job not found.'], 404);
        }

        if ($job->client_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        if (!$job->worker) {
            return response()->json(['message' => 'No worker assigned to this job.'], 404);
        }

        $worker = $job->worker;
        $user   = $worker->user;

        if (!$user) {
            return response()->json(['message' => 'Worker user record not found.'], 404);
        }

        $pic = $user->profile_picture;
        if ($pic) {
            $profilePicture = str_starts_with($pic, 'http')
                ? $pic
                : asset('storage/' . $pic);
        } else {
            $profilePicture = null;
        }

        return response()->json([
            'first_name'       => $user->first_name,
            'middle_name'      => $user->middle_name,
            'last_name'        => $user->last_name,
            'email'            => $user->email,
            'phone'            => $user->phone ?? $worker->phone,
            'username'         => $user->username,
            'address'          => $user->address,
            'profile_picture'  => $profilePicture,
            'trade'            => $worker->trade->name ?? null,
            'experience_years' => $worker->experience_years,
        ]);
    }
}